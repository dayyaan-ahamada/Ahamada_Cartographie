<?php
if ($id == NULL )
    $id = "Champ non renseigné";

if ($ville == NULL )
    $ville = "Champ non renseigné";

if ($ns == NULL )
    $ns = "Champ non renseigné";

if ($dep == NULL )
    $dep = "Champ non renseigné";

if($NbEtudiants == NULL){
    $NbEtudiants = "Champ non renseigné";
}
if($Messages == NULL){
    $Messages = "Champ non renseigné";
}
?>
<script src='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.js'></script>
<script>function confirmer(identifiant){
        var res = confirm("Êtes-vous sûr de vouloir supprimer?");
        if(res){
            document.location.href = "index.php?action=delete&idPhoto="+identifiant ;
        }
    }</script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css' rel='stylesheet' />

<div class="col s12 m3">
    <div class="card-image">
        <img src="" width="100%">
    </div>
</div>

<div class="container" id="centrer">
    <img class="card-image" id="gauche">
    <p> <b>Ville :</b>   <?php echo $ville; ?></p>
    <p> <b>Nom de la structure d'acceuil : </b>  <?php echo $ns; ?></p>
        <p> <b>Département :  </b> <?php $dep = strtoupper($dep);echo $dep; ?></p>
        <p> <b>Nombre d'étudiants : </b><?php echo $NbEtudiants; ?> </p>
    <p> <b>Informations complémentaires :</b><Br> <?php $Messages = str_replace("\n", "<br/>", $Messages); echo $Messages;?></p>

    <div id="listes">
            <fieldset>
                <legend><b>Quelques photos</b></legend>

                <?php foreach ($photo as $p){
                    if($idP == $p["idPartenariat"]) {
                        $photo1 = htmlspecialchars($p["ImageUrl"]);
                        if (Session::est_admin()) {
                            echo '<a onclick="confirmer('.$p['idPhoto'].')"><img id="img" width="400px" src="view/Images/' . $photo1 . '"></a><a> &nbsp</a>';
                        }
                        else{
                            echo '<a><img id="img" width="400px" src="view/Images/' . $photo1 . '"></a><a> &nbsp</a>';
                        }
                    }
                }?>
                <!--- <img style="width:50%"src="Images/<php echo $image; ?>"> -->
            </fieldset>
        </div>

    </div>
    <p><a href="index.php?action=add&idPartenariat=<?php echo $idP;?>">Ajouter une Photo</a></p>
<?php
if(Session::est_admin() and !isset($_GET["action2"])) {
    echo '<p><a href="index.php?action=delete&idPartenariat=' . $idP . '">Supprimer le partenariat</a></p>';
    echo '<p><a href="index.php?action=update&idPartenariat=' . $idP . '">Modifier le partenariat</a></p>';
}
    if (isset($_GET["action2"]) and $_GET["action2"]=="validation"){
        echo '<p><a href="index.php?action=validate&idPartenariat='.$idP.'">Enregistrer le partenariat</a></p>';
        echo '<p><a href="index.php?action=delete&idPartenariat='.$idP.'">Supprimer le partenariat</a></p>';
        echo '<p><a href="index.php?action=update&idPartenariat=' . $idP . '">Modifier le partenariat</a></p>';

}

