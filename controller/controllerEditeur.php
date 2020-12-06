<?php
require_once File::build_path(array('model', 'ModelEditeur.php'));

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
        $view = 'form';
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
        $view = 'form';
        $name = 'updated';
        $numEditeur = $_GET['numEditeur'];
        $editeur = ModelEditeur::select($numEditeur)[0];
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
