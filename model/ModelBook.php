<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelBook extends Model
{
    private $isbn;
    private $titre;
    private $numEditeur;
    private $prix;
    private $dateParution;

    protected static $object = 'book';
    protected static $primary = 'isbn';

    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    public function set($nom_attribut, $valeur) {
        if (property_exists($this, $nom_attribut))
            $this->$nom_attribut = $valeur;
        return false;
    }

    public function __construct($isbn = NULL, $titre = NULL, $numEditeur = NULL, $prix = NULL, $dateParution = NULL) {
        if (!is_null($isbn) && !is_null($titre) && !is_null($numEditeur) && !is_null($prix) && !is_null($dateParution)) {
            $this->isbn = $isbn;
            $this->titre = $titre;
            $this->numEditeur = $numEditeur;
            $this->prix = $prix;
            $this->dateParution = $dateParution;
        }
    }

    public static function getSearch($search) {
        try {
            $sql= "SELECT * 
            FROM book b
            JOIN bookAuteur ba ON ba.isbn = b.isbn
            JOIN auteur a ON a.numAuteur = ba.numAuteur
            WHERE :search";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array("search" => $search);
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelAuteur");
            $tab=$req_prep->fetchAll();

            if(empty($tab))return false;
            return $tab;

        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Une erreur est survenue <a href="index.php"> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function getBookByAutors($query)
    {
        try {
            $book = Model::$pdo->query('
            SELECT * 
            FROM book b 
            JOIN bookAuteur bA ON b.isbn = bA.isbn 
            JOIN auteur a ON a.numAuteur = bA.numAuteur
            WHERE prenomAuteur LIKE "%'.$query.'%" 
            OR nomAuteur LIKE "%'.$query.'%"');
            $book->setFetchMode(PDO::FETCH_CLASS, "modelBook");
            $books = $book->fetchAll();
            if(empty($books))return false;
            return $books;
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Une erreur est survenue <a href="index.php"> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

}