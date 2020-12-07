<?php
require_once File::build_path(array('model', 'ModelUtilisateur.php'));

class ControllerUtilisateur {

	protected static $object = 'utilisateur';

    public static function readAll() {
        $tab = ModelUtilisateur::selectAll(';');
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
    }

    public static function register()
    {
        $view = 'formRegister';
        $name = 'register_end';
        require File::build_path(array('view', 'view.php'));
    }

    public static function register_end()
    {
        if(isset($_POST['isAdmin'])) $admin = 1;
        else $admin = 0;
        $nonce = Security::generateRandomHex();
        $login = $_POST['login'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $data = array(
            'password' => $password,
            'email' => $_POST['email'],
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'isAdmin' => $admin,
            'nonce' => $nonce);
        ModelUtilisateur::saveGen($data);
        ModelUtilisateur::sendMail($login,$_POST['email'],$nonce);
        self::readAll();

    }

    public static function login()
    {
        $view = 'form';
        $name = 'login_end';
        require File::build_path(array('view', 'view.php'));
    }

    public static function login_end()
    {
        $login = $_POST['login'];
        $mdp = $_POST['password'];
        $user = ModelUtilisateur::testLogin($login);
        if (!$user || !password_verify($mdp, $user->get('password'))) {
            session_destroy();
            echo "Mauvais mot de passe";
            self::login();
        }
        elseif (!is_null($user->get('nonce'))) {
            session_destroy();
            echo "Email non vérifié";
            self::login();
        }else {
            $_SESSION['login'] = $login;
            $user = ModelUtilisateur::select($login);
            $_SESSION['isAdmin'] = $user[0]->get('isAdmin');
            header('Location: index.php');
        }
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php');
    }

    public static function profile()
    {
        if(isset($_SESSION['login'])) {
            if ($_SESSION['isAdmin'] == 1 && isset($_GET['login']))
            {
                $login = $_GET['login'];
                $testAdmin = true;
            } else
            {
                $login = $_SESSION['login'];
                $testAdmin = false;
            }
            $view = 'profile';
            require File::build_path(array('view','view.php'));
        } else {
            self::login();
        }
    }

    public static function update() {
        if(isset($_SESSION['login'])) {
            if (isset($_GET['login']) && $_SESSION['isAdmin'] == 1) {
                $login = $_GET['login'];
            } else {
                $login = $_SESSION['login'];
            }
            $view = 'update';
            $name = 'updated';
            $user = modelUtilisateur::select($login)[0];
            require File::build_path(array('view','view.php'));
        } else {
            self::login();
        }
    }

    public static function updated() {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $data = array('nom' => $nom, 'prenom' => $prenom, 'email' => $email);
        modelUtilisateur::update($data);

        echo "Le profile a bien été modifié !";
        self::profile();

    }

    public static function promote() {
        if(isset($_SESSION['login']) && $_SESSION['isAdmin'] == 1 && isset($_GET['login'])) {
            $login = $_GET['login'];
            modelUtilisateur::promote($login);
        }
        self::readAll();
    }

    public static function delete() {
        if (isset($_SESSION['login'])) {
            if($_GET['login'] == $_SESSION['login'] || $_SESSION['isAdmin'] == '1') {
                modelUtilisateur::delete();
                if($_GET['login'] == $_SESSION['login'])
                    self::logout();
                else
                    self::readAll();
            } else {
                echo "Vous n'avez pas le droit de réaliser cela !";
                self::readAll();
            }
        } else {
            self::login();
        }
    }

    public static function validate(){
        $user = modelUtilisateur::testLogin($_GET['login']);
        if($user != false && ($_GET['nonce'] == $user->get('nonce')))
        {
            $login_utilisateur = $user->get('login');
            Model::$pdo->query("UPDATE utilisateur SET nonce = NULL WHERE login = '$login_utilisateur'");
        }
        self::login();
    }

}


