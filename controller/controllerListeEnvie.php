<?php
require_once File::build_path(array('model', 'ModelListeEnvie.php'));

class controllerListeEnvie
{
    protected static $object = 'listeEnvie';

    public static function readAll()
    {
        $tab = ModelListeEnvie::selectListeEnvie($_SESSION['login']);
        $view = 'listEnvie';
        require File::build_path(array('view', 'view.php'));
    }

    public static function create(){
        $isbn = $_GET['isbn'];
        $login = $_SESSION['login'];
        ModelListeEnvie::ajouter($login, $isbn);
        header('Location: index.php');
    }

    public static function delete(){
        $isbn = $_GET['isbn'];
        $login = $_SESSION['login'];
        ModelListeEnvie::supprimer($login, $isbn);
        header('Location: index.php?controller=book&action=listeEnvie');
    }

}