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


}