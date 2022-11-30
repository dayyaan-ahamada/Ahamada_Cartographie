<?php
require_once File::build_path(array('model','Model.php'));

class ModelPartenariat extends Model{

    protected static $nomTable = 'carto-partenariats';
    protected static $nomClasse = 'ModelPartenariat';
    protected static $primary= 'idPartenariat';

    protected $idPartenariat;
    protected $id;
    protected $Ville;
    protected $NomStructure;
    protected $Departement;
    protected $NbEtudiants;
    protected $Messages;
    protected $latitude;
    protected $longitude;
    protected $verified;


    public static function selectAll($verified){
        return parent::selectAll($verified);
    }
    public static function select($primary){
        return parent::select($primary);
    }
    public static function insert($primary){
        return parent::insert($primary);
    }
    public static function update($data,$primary){
        return parent::update($data,$primary);
    }
    public static function updateVerified($primary){
        return parent::updateVerified($primary);
    }
    public static function delete($primary){
        return parent::delete($primary);
    }
}