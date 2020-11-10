<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelCommande extends Model
{
    private $login;
    private $isbn;
    private $quantite;
    private $date;

    protected static $object = 'book';
    protected static $primary = 'isbn';
    protected static $primary1 = 'login';

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

    public function __construct($login = NULL, $isbn = NULL, $quantite = NULL, $date = NULL) {
        if (!is_null($login) && !is_null($isbn) && !is_null($quantite) && !is_null($date)) {
            $this->login = $login;
            $this->isbn = $isbn;
            $this->quantite = $quantite;
            $this->date = $date;
        }
    }

    public static function saveCommande($data)
    {
        try {
            $sql = "INSERT INTO commande VALUES (0, :login, :date)";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "login"=>$data['login'],
                "date"=>$data['date'],
            );
            $req_prep->execute($values);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else if ($e->getCode() == 23000){
                echo "Ce login utilisateur existe déjà !";
                return false;
            }
            else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function saveBookCommande($data)
    {
        $id = self::getNextId() - 1;
        try {
            $sql = "INSERT INTO bookCommande VALUES ($id, :isbn, :quantite)";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "isbn"=>$data['isbn'],
                "quantite"=>$data['quantite'],
            );
            $req_prep->execute($values);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else if ($e->getCode() == 23000){
                echo "Ce login utilisateur existe déjà !";
                return false;
            }
            else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function update($data) {
        $table_name = static::$object;
        $primary_key = static::$primary;
        $primary_key_value = $_POST["$primary_key"];
        $result = '';

        try {
            foreach ($data as $key => $value) {
                $result = $result .  $key . "='" . $value . "',";
            }
            $result = rtrim($result, ',');

            $sql = "UPDATE $table_name SET $result WHERE $primary_key = :primary_key;";
            $req = Model::$pdo->prepare($sql);

            $values = array('primary_key' => $primary_key_value);
            $req -> execute($values);

        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage(); // affiche un message d'erreur
            } else {
                echo 'Une erreur est survenue <a href="index.php"> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function getNextId()
    {
        $req = Model::$pdo->query("SHOW TABLE STATUS FROM michelm LIKE 'commande' ");
        $donnees = $req->fetch();
        return $donnees['Auto_increment'];
    }

}