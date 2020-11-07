<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelCategorie extends Model
{
    private $numCategorie;
    private $nomCategorie;


    protected static $object = 'categorie';
    protected static $primary = 'numCategorie';

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

    public function __construct($numCategorie = NULL, $nomCategorie = NULL) {
        if (!is_null($numCategorie) && !is_null($nomCategorie)) {
            $this->numCategorie = $numCategorie;
            $this->nomCategorie = $nomCategorie;
        }
    }
}