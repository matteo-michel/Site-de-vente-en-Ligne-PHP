<?php
require_once File::build_path(array('model', 'ModelBook.php'));
require_once File::build_path(array('model', 'ModelAuteur.php'));
require_once File::build_path(array('model', 'ModelEditeur.php'));
require_once File::build_path(array('model', 'ModelCategorie.php'));

class controllerEditeur
{
    protected static $object = 'editeur';

    public static function readAll() {
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
    }

    public static function read()
    {
        $auteur = ModelEditeur::select($_GET['numEditeur']);
        $view = 'detail';
        require File::build_path(array('view', 'view.php'));
    }

    public static function create()
    {
        $view = 'formCreate';
        $name = 'created';
        $numEditeur = '';
        require File::build_path(array('view', 'view.php'));
    }

    public static function delete()
    {
        ModelEditeur::delete();
        self::readAll();
    }

    public static function created()
    {
        $data = array('nomEditeur' => $_POST['nomEditeur']);
        ModelEditeur::saveGen($data);
        self::readAll();
    }

    public static function update() {
        $view = 'formCreate';
        $name = 'updated';
        $numEditeur = $_GET['numEditeur'];
        require File::build_path(array('view', 'view.php'));
    }

    public static function updated() {
        $numEditeur = $_POST['numEditeur'];
        $nomEditeur = $_POST['nomEditeur'];
        $data = array('numEditeur' => $numEditeur,
            'nomEditeur' => $nomEditeur);
        modelEditeur::update($data);

        self::readAll();
        echo "L'editeur a bien été modifié !";
    }
}
