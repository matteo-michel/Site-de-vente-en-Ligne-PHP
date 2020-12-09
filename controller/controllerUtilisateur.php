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
        if(!isset($_POST['login']) || !$_POST['password']) {
            controllerBook::readAll();
            return;
        }
        $login = $_POST['login'];
        $mdp = $_POST['password'];
        $user = ModelUtilisateur::testLogin($login);
        if (!$user || !password_verify($mdp, $user->get('password'))) {
            session_destroy();
            echo '<p class="alert alert-danger">Aucun mot de passe ne correspond à cet utilisateur !</p>';
            self::login();
        }
        elseif (!is_null($user->get('nonce'))) {
            session_destroy();
            echo '<p class="alert alert-danger">L\'email n\'est pas vérifié !</p>';
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
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $data = array('nom' => $nom, 'prenom' => $prenom, 'email' => $email);
            modelUtilisateur::update($data);

            echo "<div class='alert alert-success'>Le profil a bien été modifié ! </div>";
            self::profile();
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            self::readAll();
        } else {
            ControllerUtilisateur::login();
        }

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
                echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
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


