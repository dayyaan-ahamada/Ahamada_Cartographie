<?php
require_once File::build_path(array('model', 'ModelPartenariat.php'));
require_once File::build_path(array('model', 'ModelPhoto.php'));
require_once File::build_path(array('lib', 'Session.php'));
class Controller
{
    public static function overview()
    {
        $tab = ModelPartenariat::selectAll(1);
        if (isset($_SESSION['2D']) && $_SESSION['2D']) {
            $_SESSION['proj'] = 'new am4maps.projections.Miller()';
            $_SESSION['panB'] = '"move"';
        } else {
            $_SESSION['proj'] = 'new am4maps.projections.Orthographic()';
            $_SESSION['panB'] = '"rotateLongLat"';
        }
        $view = 'overview';
        $pagetitle = 'Cartographie des partenariats';
        require File::build_path(array('view', 'view.php'));
    }

    public static function create()
    {
        $p = new ModelPartenariat();
        $p->set('id', myGet('id'));
        $view = 'update';
        $pagetitle = 'Ajout d\'un partenariat';
        require File::build_path(array('view', 'view.php'));
    }

    public static function created()
    {
        if(Session::est_admin()) {
            $values = array(
                "id" => myGet('id'),
                "Ville" => myGet('Ville'),
                "NomStructure" => myGet('NomStructure'),
                "Departement" => myGet('Departement'),
                "NbEtudiants" => myGet('NbEtudiants'),
                "Messages" => urlencode(myGet('Messages')),
                "latitude" => myGet("latitude"),
                "longitude" => myGet("longitude"),
                "verified" => 1);
        }
        else{
        $values = array(
            "id" => myGet('id'),
            "Ville" => myGet('Ville'),
            "NomStructure" => myGet('NomStructure'),
            "Departement" => myGet('Departement'),
            "NbEtudiants" => myGet('NbEtudiants'),
            "Messages" => urlencode(myGet('Messages')),
            "latitude" => myGet("latitude"),
            "longitude" => myGet("longitude"),
            "verified" => myGet('verified'));
        }
        $ok = ModelPartenariat::insert($values);
        $tab = ModelPartenariat::selectAll(1);
        if (!$ok) {
            $view = 'error';
            $pagetitle = 'ERREUR';
        } else {
            $view = 'created';
            $pagetitle = 'Partenariat ajouté';
        }
        require File::build_path(array('view', 'view.php'));
    }

    public static function update()
    {
        $p = ModelPartenariat::select(myGet('idPartenariat'));
        if (is_null($p)) {
            $view = 'error';
            $pagetitle = 'Erreur!';
        } else {
            $view = 'update';
            $pagetitle = 'Modification du partenariat';
        }
        require File::build_path(array('view', 'view.php'));
    }

    public static function updated()
    {
        $p = myGet('idPartenariat');

        $values = array(
            "id" => myGet('id'),
            "Ville" => myGet('Ville'),
            "NomStructure" => myGet('NomStructure'),
            "Departement" => myGet('Departement'),
            "NbEtudiants" => myGet('NbEtudiants'),
            "Messages" => urlencode(myGet('Messages')),
            "latitude" => myGet("latitude"),
            "longitude" => myGet("longitude"),
            "verified" => 1);

        $ok = ModelPartenariat::update($values, $p);
        $tab = ModelPartenariat::selectAll(1);
        if (!$ok) {
            $view = 'error';
            $pagetitle = 'Erreur!';
        } else {
            $view = 'updated';
            $pagetitle = 'Partenariat modifié';
        }
        require File::build_path(array('view', 'view.php'));
    }

    public static function read()
    {
        $p = ModelPartenariat::select(myGet('idPartenariat'));
        $photo = ModelPhoto::selectAll(1);
        if (myGet('idPartenariat')) {
            $idP = htmlspecialchars(myGet('idPartenariat'));
            $id = htmlspecialchars($p->get('id'));
            $ville = htmlspecialchars($p->get('Ville'));
            $ns = htmlspecialchars($p->get('NomStructure'));
            $dep = htmlspecialchars($p->get('Departement'));
            $NbEtudiants = htmlspecialchars($p->get('NbEtudiants'));
            $Messages = urldecode($p->get('Messages'));
            $verified = htmlspecialchars($p->get('verified'));
            $view = 'details';
            $pagetitle = 'Partenariat à ' . $ville;
        } else {
            $view = 'error';
            $pagetitle = 'Partenariat introuvable';
        }
        require File::build_path(array('view', 'view.php'));
    }

    public static function delete()
    {
        $p = ModelPartenariat::select(myGet('idPartenariat'));
        $photo = ModelPhoto::select(myGet('idPhoto'));
        if (is_null($p) and is_null($photo)) {
            $view = 'error';
            $pagetitle = 'Erreur';
        } else {
            if (!is_null($p)) {
                $p->delete(myGet('idPartenariat'));
                $tab = ModelPartenariat::selectAll(1);
                $view = 'deleted';
                $pagetitle = 'Partenariat supprimé';
            }
            if (!is_null($photo)) {
                $photo->delete(myGet('idPhoto'));
                $tabphoto = ModelPhoto::selectAll(1);
                $view = 'deleted';
                $pagetitle = 'Photo supprimée';
            }
        }
        require File::build_path(array('view', 'view.php'));
    }

    public static function add()
    {
        $p = ModelPartenariat::select(myGet('idPartenariat'));
        $view = 'addPhoto';
        $pagetitle = 'Ajout d\'une photo';
        require File::build_path(array('view', 'view.php'));
    }

    public static function added()
    {
        $name = $_FILES['fileToUpload']['name'];
        $pic_path = "Images/$name";

        if (is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
            $controller = "Partenariats";
        }
        //if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $pic_path)) {
        //    $name = myGet('ImageUrl');
        //}
        if(Session::est_admin()) {
            $values = array(
                "idPartenariat" => myGet('idPartenariat'),
                "ImageUrl" => $name,
                "verified" => 1
            );
        }
        else{
            $values = array(
                "idPartenariat" => myGet('idPartenariat'),
                "ImageUrl" => $name,
                "verified" => myGet("verified")
            );
        }
        $ok = ModelPhoto::insert($values);
        $tab = ModelPhoto::selectAll(1);
        if (!$ok) {
            $view = 'error';
            $pagetitle = 'ERREUR';
        } else {
            $view = 'created';
            $pagetitle = 'Partenariat ajouté';
        }
        require File::build_path(array('view', 'view.php'));
    }

    public static function connect()
    {
        $view = 'connect';
        $pagetitle = 'Bienvenue';
        require_once File::build_path(array('view', 'view.php'));
    }

    public static function connected()
    {
        $user = myGet('login');
        $mdp = myGet('password');

        if ($user == 'admin' && $mdp == 'cartoadmin342020') {
            $_SESSION['login'] = myGet('login');
            $_SESSION['connnectedOnServ'] = true;
            $_SESSION['statut'] = 3;
            header('Location: ./index.php?action=isConnected');
            exit();

        } else {
            header('Location: ./index.php?action=notValided');
            exit();
        }
    }

    public static function isConnected()
    {
        $view = 'bienvenue';
        $pagetitle = 'Cartographie des partenariats';
        require_once File::build_path(array('view', 'view.php'));
    } 

    public static function notValided()
    {
        $view = 'notValided';
        $pagetitle = 'Erreur d\'authentification';
        require_once File::build_path(array('view', 'view.php'));
    }

    public static function deconnect()
    {
        if (Session::est_connecte()) {
            Session::destroySession();
            header('Location: ./index.php');
            exit();
        } else { // On lui dit qu'il n'est pas connecté et lui propose de le faire
            $view = 'connect';
            $pagetitle = 'Vous n\'êtes pas connecté';
        }
        require_once File::build_path(array('view', 'view.php'));
    }

    public static function validation()
    {

        $p = ModelPartenariat::selectVerified0(myGet('idPartenariat'));
        $tab = ModelPartenariat::selectAll(0);
        $photo = ModelPhoto::selectAll(0);
            $view = 'validation';
            $pagetitle = 'Cartographie des partenariats';
            require_once File::build_path(array('view', 'view.php'));

        }

    public static function validate()
    {
        $p = ModelPartenariat::updateVerified(myGet('idPartenariat'));
        $photo=ModelPhoto::updateVerified(myGet('idPhoto'));
        $view = 'validated';

        require File::build_path(array('view', 'view.php'));
    }

}
