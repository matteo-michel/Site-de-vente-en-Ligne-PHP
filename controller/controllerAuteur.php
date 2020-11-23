<?php
require_once File::build_path(array('model', 'ModelBook.php'));
require_once File::build_path(array('model', 'ModelAuteur.php'));
require_once File::build_path(array('model', 'ModelEditeur.php'));
require_once File::build_path(array('model', 'ModelCategorie.php'));

class controllerAuteur
{
    protected static $object = 'auteur';

    public static function readAll() {
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
    }

    public static function read()
    {
        $auteur = ModelAuteur::select($_GET['numAuteur']);
        $view = 'detail';
        require File::build_path(array('view', 'view.php'));
    }

    public static function delete()
    {
        ModelAuteur::delete();
        self::readAll();
    }

    public static function create()
    {
        $view = 'formCreate';
        $name = 'created';
        require File::build_path(array('view', 'view.php'));
    }

    public static function created()
    {
        $data = array(
            'prenomAuteur' => $_POST['prenomAuteur'],
            'nomAuteur' => $_POST['nomAuteur']);
        ModelAuteur::saveGen($data);
        self::readAll();
    }

    public static function update()
    {
        $a = 'yousk2';
    }
}
