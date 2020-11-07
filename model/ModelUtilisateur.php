<?php
require_once File::build_path(array('model', 'Model.php'));

class modelUtilisateur extends Model {

    private $login;
    private $nom;
    private $prenom;
    private $password;
    private $email;
    private $isAdmin;

    protected static $object = 'utilisateur';
    protected static $primary = 'login';

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

    public function __construct($login = NULL, $nom = NULL, $prenom = NULL, $password = NULL, $email = NULL, $isAdmin = NULL) {
        if (!is_null($login) && !is_null($nom) && !is_null($prenom) && !is_null($password) && !is_null($email) && !is_null($isAdmin)) {
            $this->login = $login;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->password = $password;
            $this->email = $email;
            $this->isAdmin = $isAdmin;
        }
    }

    public static function testLogin($login)
    {
        try {
        $sql="SELECT * from utilisateur WHERE login =:login";
        $req_prep = Model::$pdo->prepare($sql);
        $values = array("login"=>$login);
        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, "modelUtilisateur");
        $tab_voit=$req_prep->fetchAll();

        if(empty($tab_voit))return false;
        return$tab_voit[0];
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
?>