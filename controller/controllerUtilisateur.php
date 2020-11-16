<?php
require_once File::build_path(array('model', 'ModelUtilisateur.php'));
require_once File::build_path(array('model', 'ModelItemPanier.php'));
require_once File::build_path(array('model', 'ModelCommande.php'));
require_once File::build_path(array('model', 'ModelBook.php'));


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
        }
        elseif (!is_null($user->get('nonce'))) {
            session_destroy();
            echo "Email non vérifié";
            self::login();
        }else {
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

    public static function validate(){
        $user = modelUtilisateur::testLogin($_GET['login']);
        if($user != false && ($_GET['nonce'] == $user->get('nonce')))
        {
            $login_utilisateur = $user->get('login');
            Model::$pdo->query("UPDATE utilisateur SET nonce = NULL WHERE login = '$login_utilisateur'");
        }
    }

    public static function addPanier() {
        if(isset($_COOKIE['panier'])) {
            $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
            unset($_COOKIE['panier']);
            $item = self::findObjectById($_GET['isbn'], $panier);
            if (!$item) {
                $itemPanier = new ModelItemPanier($_GET['isbn'], 1);
                $data = array($itemPanier);
                $data = array_merge($panier, $data);
                setcookie('panier', serialize($data), time() + 3600);
            } else {
                $item->addQuantite();
                setcookie('panier', serialize($panier), time() + 3600);
            }
        } else {
            $itemPanier = new ModelItemPanier($_GET['isbn'], 1);
            $data = array($itemPanier);
            setcookie('panier', serialize($data), time() + 3600);
        }
        header('Location: index.php');
    }

    public static function removeFromPanier() {
        $isbn = $_GET['isbn'];
        $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
        $index = array_search($isbn, $panier);
        $panier[$index]->removeQuantite();
        if($panier[$index]->get('quantite') == 0) {
            unset($panier[$index]);
        }
        unset($_COOKIE['panier']);
        setcookie('panier', serialize($panier), time() + 3600);
        header('Location: index.php?controller=utilisateur&action=panier');
    }

    public static function clearPanier() {
        if(isset($_COOKIE['panier'])) {
            setcookie("panier", "", time() - 3600);
        }
        header('Location: index.php?controller=utilisateur&action=panier');
    }

    public static function panier()
    {
        $tab = array();
        if (isset($_COOKIE['panier']))
            $tab = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
        $view = 'panier';
        require File::build_path(array('view', 'view.php'));
    }

    public static function acheterPanier()
    {
        if (!isset($_SESSION['login']))
        {
            echo "Vous devez d'abord vous connecter !";
            self::login();
        } else
        {
            $view = 'valideAchat';
            require File::build_path(array('view', 'view.php'));
        }
    }

    public static function acheterPanier_end()
    {
        if (!isset($_SESSION['login']))
        {
            echo "Vous devez d'abord vous connecter !";
            self::login();
        } else
        {
            if (!empty(unserialize($_COOKIE['panier'], ["allowed_classes" => true])))
            {
                $data = array(
                    'login' => $_SESSION['login'],
                    'date' => date("y-m-j")
                );
                ModelCommande::saveCommande($data);
            }
            $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
            foreach ($panier as $item)
            {
                $data = array(
                    'isbn' => $item->get('isbn'),
                    'quantite' => $item->get('quantite'),
                );
                ModelCommande::saveBookCommande($data);
                ModelBook::updateStock($item->get('isbn'), $item->get('quantite'));
            }
            self::clearPanier();
        }
    }

    public static function findObjectById($id, $array){
        foreach ($array as $element ) {
            if ( $id == $element->get('isbn')) {
                return $element;
            }
        }
        return false;
    }
}
?>

