<?php
require_once File::build_path(array('model', 'ModelBook.php'));
require_once File::build_path(array('model', 'ModelAuteur.php'));
require_once File::build_path(array('model', 'ModelEditeur.php'));
require_once File::build_path(array('model', 'ModelCategorie.php'));

class controllerBook
{
    protected static $object = 'book';

    public static function readAll() {
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
    }

    public static function read()
    {
        $book = ModelBook::select($_GET['isbn']);
        $view = 'detail';
        require File::build_path(array('view', 'view.php'));
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
            'titre' => $_POST['titre'],
            'numEditeur' => $_POST['numEditeur'],
            'prix' => $_POST['prix'],
            'dateParution' => $_POST['date'],
            'resume' => $_POST['resume'],);
        ModelBook::saveGen($data);
        $listAuteurs = $_POST['numAuteur'];
        foreach ($listAuteurs as $la)
        {
            $data = array(
                'isbn' => $_POST['isbn'],
                'numAuteur' => $la
            );
            ModelBook::saveBookAuteur($data);
        }
        $listCategorie = $_POST['numCategorie'];
        foreach ($listCategorie as $item) {
            $data = array(
                'isbn' => $_POST['isbn'],
                'numCategorie' => $item
            );
            ModelBook::saveBookCategorie($data);
        }
        self::readAll();
    }
}