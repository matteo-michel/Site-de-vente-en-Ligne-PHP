<?php
require_once File::build_path(array('model', 'ModelBook.php'));
require_once File::build_path(array('model', 'ModelAuteur.php'));
require_once File::build_path(array('model', 'ModelEditeur.php'));
require_once File::build_path(array('model', 'ModelCategorie.php'));
require_once File::build_path(array('model', 'ModelListeEnvie.php'));

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
        $isbn = '';
        $type = '';
        require File::build_path(array('view', 'view.php'));
    }

    public static function created()
    {
        $data = array(
            'titre' => $_POST['titre'],
            'numEditeur' => $_POST['numEditeur'],
            'prix' => $_POST['prix'],
            'dateParution' => $_POST['date'],
            'resume' => $_POST['resume'],
            'image' => addslashes(file_get_contents($_FILES['image']['tmp_name'])));
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

    public static function update() {
            $view = 'formCreate';
            $name = 'updated';
            $isbn = $_GET['isbn'];
            $type = 'readonly';
            require File::build_path(array('view', 'view.php'));
    }

    public static function updated() {
        $isbn = $_POST['isbn'];
        $titre = $_POST['titre'];
        $prix = $_POST['prix'];
        $dateParution = $_POST['date'];
        $resume = $_POST['resume'];
        $numEditeur = $_POST['numEditeur'];
        $listeAuteur = $_POST['numAuteur'];
        $listeCategorie = $_POST['numCategorie'];

        modelBook::updateBookAuteur($isbn,$listeAuteur);
        modelBook::updateBookCategorie($isbn,$listeCategorie);

        $data = array('isbn' => $isbn,
            'titre' => $titre,
            'numEditeur' => $numEditeur,
            'prix' => $prix,
            'dateParution' => $dateParution,
            'resume' => $resume);
        modelBook::update($data);
        self::readAll();
        echo "Le livre a bien été modifié !";
    }

    public static function ajouterListeEnvie(){
        $isbn = $_GET['isbn'];
        $login = $_SESSION['login'];
        ModelListeEnvie::ajouter($login, $isbn);
        header('Location: index.php');
    }

    public static function listeEnvie()
    {
        $tab = ModelListeEnvie::select($_SESSION['login']);
        $view = 'listEnvie';
        require File::build_path(array('view', 'view.php'));

    }
}