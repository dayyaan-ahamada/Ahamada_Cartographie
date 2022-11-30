<?php
class Session
{

    public static function is_user($login) {
        return (!empty($_SESSION['login']) && ($_SESSION['login'] == $login));
    }
    public static function destroySession(){
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        setcookie(session_name(),'',time()-1); // deletes the session cookie containing the session ID
    }

    /**
     * @return bool vrai s'il est connecté
     * Faux sinon
     */
    public static function est_connecte () {
        //Vérifie que l'utilisateur est connecté au site
        //Pour que ce soit vrai il faut que la variable ne soit pas vide et qu'elle soit vrai
        return (!empty($_SESSION['connnectedOnServ'])) && $_SESSION['connnectedOnServ'];
    }
    /**
     * @return bool vrai si il est admin
     * fauyx sinon
     */
    public static function est_admin() { // Permet de vérifier si un utilisateur est admin (CAD qu'il a tous les droits )
        if (self::est_connecte()) { // On vérifie d'abord qu'il soit connecté
            //Pour que ce soit vrai il faut que la variable ne soit pas vide et qu'elle soit égal à 3 -> Convention choisie au développement
            return (!empty($_SESSION['statut'])) && $_SESSION['statut'] == 3;
        } else {
            return false; //Il n'est pas connecté donc pas admin
        }
    }
}