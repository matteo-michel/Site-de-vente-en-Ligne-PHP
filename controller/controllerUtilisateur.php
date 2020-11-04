<?php
require_once File::build_path(array('model', 'ModelUtilisateur.php'));

class ControllerUtilisateur {

	protected static $object = 'utilisateur';

    public static function readAll() {
        //if (!isset($_SESSION['login'])) ControllerUtilisateur::login();
        $tab_v = ModelUtilisateur::selectAll();
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
            self::readAll();
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
        ControllerUtilisateur::readAll();
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
}
?>

