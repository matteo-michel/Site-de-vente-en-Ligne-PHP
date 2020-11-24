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
        $numAuteur = '';
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

    public static function update() {
        $view = 'formCreate';
        $name = 'updated';
        $numAuteur = $_GET['numAuteur'];
        require File::build_path(array('view', 'view.php'));
    }

    public static function updated() {
        $numAuteur = $_POST['numAuteur'];
        $nomAuteur = $_POST['nomAuteur'];
        $prenomAuteur = $_POST['prenomAuteur'];
        $data = array('numAuteur' => $numAuteur,
            'nomAuteur' => $nomAuteur,
            'prenomAuteur' => $prenomAuteur);
        modelAuteur::update($data);

        self::readAll();
        echo "L'auteur a bien été modifié !";
    }
}
