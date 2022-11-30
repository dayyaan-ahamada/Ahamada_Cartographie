<?php
require_once File::build_path(array('model','Model.php'));

class ModelPhoto extends Model{

    protected static $nomTable = 'carto-images';
    protected static $nomClasse = 'ModelPhoto';
    protected static $primary= 'idPhoto';

    protected $idPartenariat;
    protected $idPhoto;
    protected $ImageUrl;
    protected $verified;


    public function __construct($data = array()){
        if (!empty($data)) {
            $this->idPartenariat = $data["idPartenariat"];
            $this->idPhoto = $data["idPhoto"];
            $this->ImageUrl = $data["ImageUrl"];
        }
    }
    public function get($nom_attribut){
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    public function set($nom_attribut, $valeur) {
        if (property_exists($this, $nom_attribut))
            $this->$nom_attribut = $valeur;
        return false;
    }
    public static function selectAll($verified){
        return parent::selectAll($verified);
    }
    public static function insert($data){
        return parent::insert($data);
    }
    public static function selectVerified0($primary_value){
        return parent::selectVerified0($primary_value);
    }

}