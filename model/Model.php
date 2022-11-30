<?php

require_once File::build_path(array('config','Conf.php'));

class Model {

    public static $pdo;

    public static function init_pdo() {
        $host   = Conf::getHostname();
        $dbname = Conf::getDatabase();
        $login  = Conf::getLogin();
        $pass   = Conf::getPassword();
        try {
            // connexion à la base de données
            // le dernier argument sert à ce que toutes les chaines de charactères
            // en entrée et sortie de MySql soit dans le codage UTF-8
            self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $login, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            // on active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            die("Problème lors de la connexion à la base de données.");
        }
    }
    // getter
    public function get($nom_attribut){
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    // setter
    public function set($nom_attribut, $valeur) {
        if (property_exists($this, $nom_attribut))
            $this->$nom_attribut = $valeur;
        return false;
    }

    // constructeur
    public function __construct($data = NULL) {
        if (!is_null($data)) {
            foreach($data as $k => $v){
                $this->$k = $v;
            }
        }
    }

    public static function selectAll($verified){
        try {
            $pdo = self::$pdo;
            $nomTable = static::$nomTable;
            $nomClasse = static::$nomClasse;

            $sql = "SELECT *
                    FROM `{$nomTable}`c WHERE c.verified=$verified ";
            $requete = $pdo->query($sql);
            $requete->setFetchMode(PDO::FETCH_ASSOC);
            return $requete->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function select($primary_value){
        try {
            $pdo = self::$pdo;
            $nomTable = static::$nomTable;
            $nomClasse = static::$nomClasse;
            $clePrimaire = static::$primary;

            $sql = "SELECT * 
                    FROM `{$nomTable}` 
                    WHERE `{$clePrimaire}`=:sql_pk";
            $requete = $pdo->prepare($sql);
            $valeur = array(
                "sql_pk" => $primary_value);
            $requete->execute($valeur);
            $requete->setFetchMode(PDO::FETCH_CLASS, $nomClasse);
            $objet = $requete->fetchAll();
            if (isset($objet[0]))
                return $objet[0];
            else
                return null;

        } catch (PDOException $e) {
            return false;
        }
    }
    public static function selectVerified0($primary_value){
        try {
            $pdo = self::$pdo;
            $nomTable = static::$nomTable;
            $nomClasse = static::$nomClasse;
            $clePrimaire = static::$primary;

            $sql = "SELECT * 
                    FROM `{$nomTable}`c 
                    WHERE `{$clePrimaire}`=:sql_pk AND c.verified=0";
            $requete = $pdo->prepare($sql);
            $valeur = array(
                "sql_pk" => $primary_value);
            $requete->execute($valeur);
            $requete->setFetchMode(PDO::FETCH_CLASS, $nomClasse);
            $objet = $requete->fetchAll();
            if (isset($objet[0]))
                return $objet[0];
            else
                return null;

        } catch (PDOException $e) {
            return false;
        }
    }

    public static function insert($data){
        try {
            $pdo = self::$pdo;
            $nomTable = static::$nomTable;
            foreach ($data as $attribut => $tuple){
                $tabColonne[] = "`{$attribut}`";
                $tabValeur[] = "'{$tuple}'";}
            $sql = "INSERT INTO `{$nomTable}` (".implode(', ', $tabColonne).")"."
                    VALUES (".implode(', ', $tabValeur).")";
            $requete = $pdo->prepare($sql);
            $requete->execute();
            return true;
        }catch(PDOException $e){
            return false;
        }
    }
    public static function update($data,$primary){
        try {
            $pdo = self::$pdo;
            $nomTable = static::$nomTable;
            $clePrimaire = static::$primary;

            foreach ($data as $attribut => $tuple){
                $setColumn[] = "`{$attribut}` = '{$tuple}'";}
            $sql = "UPDATE `{$nomTable}` 
                    SET ".implode(', ', $setColumn)."
                    WHERE `{$clePrimaire}`=:sql_pk";
            $requete = $pdo->prepare($sql);
            $valeur = array(
                "sql_pk" => $primary);
            $requete->execute($valeur);
            return true;
        }catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public static function updateVerified($primary){
        try {
            $pdo = self::$pdo;
            $nomTable = static::$nomTable;
            $clePrimaire = static::$primary;

            $sql = "UPDATE `{$nomTable}` 
                    SET verified=1
                    WHERE `{$clePrimaire}`=:sql_pk";
            $requete = $pdo->prepare($sql);
            $valeur = array(
                "sql_pk" => $primary);
            $requete->execute($valeur);
            return true;
        }catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    public static function delete($idP){
        try {
            $pdo = self::$pdo;
            $nomTable = static::$nomTable;
            $clePrimaire = static::$primary;
            $sql = "DELETE FROM `{$nomTable}` 
                    WHERE `{$clePrimaire}` =:sql_id";
            $requete = $pdo->prepare($sql);
            $valeur = array(
                "sql_id" => $idP);
            $requete->execute($valeur);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
}
// on initialise la connexion $pdo
Model::init_pdo();
