<?php
require_once File::build_path(array('model', 'ModelUtilisateur.php'));

class ControllerUtilisateur {

	protected static $object = 'utilisateur';

    public static function readAll() {
        $tab = ModelUtilisateur::selectAll(';');
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
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
        } else {
            $_SESSION['login'] = $login;
            $user = ModelUtilisateur::select($login);
            $_SESSION['isAdmin'] = $user->get('isAdmin');
            header('Location: index.php');
        }
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
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $data = array(
            'password' => $password,
            'email' => $_POST['email'],
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'isAdmin' => $admin);
        ModelUtilisateur::saveGen($data);
        self::readAll();

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
            $view = 'profile';
            require File::build_path(array('view','view.php'));
        } else {
            self::login();
        }
    }

    public static function update() {
        if(isset($_SESSION['login'])) {
            $view = 'update';
            $name = 'updated';
            $user = modelUtilisateur::select($_SESSION['login']);
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

        echo "Votre profile a bien été modifié !";
        self::profile();

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

    public static function addPanier() {
        $data = array($_GET['isbn']);
        if(!isset($_COOKIE['panier'])) {
            setcookie('panier', serialize($data), time()+3600);
        } else {
            $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => false]);
            unset($_COOKIE['panier']);
            $result = array_merge($panier, $data);
            setcookie('panier', serialize($result), time() + 3600);
        }
        header('Location: index.php');
    }

    public static function removeFromPanier() {
        $isbn = $_GET['isbn'];
        $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => false]);
        $index = array_search($isbn, $panier);
        unset($panier[$index]);
        unset($_COOKIE['panier']);
        setcookie('panier', serialize($panier), time() + 3600);
        header('Location: index.php?controller=utilisateur&action=panier');
    }

    public static function panier() {
        $tab =  unserialize($_COOKIE['panier'], ["allowed_classes" => false]);
        $view = 'panier';
        require File::build_path(array('view', 'view.php'));
    }

}
?>

