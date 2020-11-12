<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelBook extends Model
{
    private $isbn;
    private $titre;
    private $numEditeur;
    private $prix;
    private $dateParution;
    private $stock;

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

    public function __construct($isbn = NULL, $titre = NULL, $numEditeur = NULL, $prix = NULL, $dateParution = NULL, $stock = NULL) {
        if (!is_null($isbn) && !is_null($titre) && !is_null($numEditeur) && !is_null($prix) && !is_null($dateParution) && !is_null($stock)) {
            $this->isbn = $isbn;
            $this->titre = $titre;
            $this->numEditeur = $numEditeur;
            $this->prix = $prix;
            $this->dateParution = $dateParution;
            $this->stock = $stock;
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
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href="index.php"> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function saveBookCategorie($data)
    {
        try {
            $sql = "INSERT INTO bookCategorie VALUES (:primary_key, :second_primary_key)";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "primary_key"=>$data['isbn'],
                "second_primary_key"=> $data['numCategorie']
            );
            $req_prep->execute($values);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else if ($e->getCode() == 23000){
                echo "Erreur";
                return false;
            }
            else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function saveBookAuteur($data)
    {
        try {
            $sql = "INSERT INTO bookAuteur VALUES (:primary_key, :second_primary_key)";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "primary_key"=>$data['isbn'],
                "second_primary_key"=> $data['numAuteur']
            );
            $req_prep->execute($values);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else if ($e->getCode() == 23000){
                echo "Erreur";
                return false;
            }
            else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function updateStock($isbn, $quantite)
    {
        try {
            $sql = "UPDATE book SET stock = stock - $quantite WHERE isbn = :primary_key;";
            $req = Model::$pdo->prepare($sql);
            $values = array('primary_key' => $isbn);
            $req -> execute($values);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href="index.php"> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function getAmount() {
        try {
            $sql = "SELECT COUNT(*) FROM book";
            $req = Model::$pdo -> query($sql);
            $data = $req->fetchAll();
            return $data[0][0];
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href="index.php"> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function selectAmount($order_by, $start,$amount)
    {
        $table_name = static::$object;
        $class_name = 'Model' . ucfirst($table_name);
        try {
            $rep = Model::$pdo -> query("SELECT * FROM (SELECT * FROM $table_name $order_by) AS trie LIMIT $start,$amount;");
            $rep->setFetchMode(PDO::FETCH_CLASS, "$class_name");
            $tab_obj = $rep->fetchAll();
            return $tab_obj;
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }
}