<?php
require_once File::build_path(array('model', 'ModelCategorie.php'));

class controllerCategorie
{
    protected static $object = 'categorie';

    public static function readAll() {
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
    }

    public static function read()
    {
        $auteur = ModelCategorie::select($_GET['numCategorie']);
        $view = 'detail';
        require File::build_path(array('view', 'view.php'));
    }

    public static function create()
    {
        $view = 'form';
        $name = 'created';
        $numCategorie = '';
        require File::build_path(array('view', 'view.php'));
    }

    public static function delete()
    {
        ModelCategorie::delete();
        self::readAll();
    }

    public static function created()
    {
        $data = array('nomCategorie' => $_POST['nomCategorie']);
        ModelCategorie::saveGen($data);
        self::readAll();
    }

    public static function update() {
        $view = 'form';
        $name = 'updated';
        $numCategorie = $_GET['numCategorie'];
        $categorie = ModelCategorie::select($numCategorie)[0];
        require File::build_path(array('view', 'view.php'));
    }

    public static function updated() {
        $numCategorie = $_POST['numCategorie'];
        $nomCategorie = $_POST['nomCategorie'];
        $data = array('numCategorie' => $numCategorie,
            'nomCategorie' => $nomCategorie);
        modelCategorie::update($data);

        self::readAll();
        echo "La categorie a bien été modifié !";
    }
}
