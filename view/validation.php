
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css' rel='stylesheet' />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<?php
if($tab==NULL){
    echo 'Aucun nouvel élément à approuver';
}
echo '<div class="container row">';
foreach ($tab as $part) {
    $v = $part["Ville"];
    $idP = $part["idPartenariat"];
    $dep = $part["Departement"];

    if ($dep == NULL){
        $dep = "Champs non renseigné";
    }
    if ($v == NULL){
        $v = "Champs non renseigné";
    }

    echo <<< EOT
<div class="col s12 m6 l4">
        <div class="card small" id="carte">
            <div>
                <div class="card-image" id="image-carte">
                    <a href="?action=read&action2=validation&idPartenariat=$idP">Voir les détails du partenariat</a>
                    </a>
                </div>
            </div>

            <div>
                <div class="card-content">
        <a> Ville :   $v </a></Br>
        <a> Departement:   $dep </a>
        

                </div>
            </div>
        </div>
    </div>
EOT;
}

foreach ($photo as $p){
        $photo1 = htmlspecialchars($p["ImageUrl"]);
        $idPhoto = $p["idPhoto"];
    echo <<< EOT
    <div class="col s12 m6 l4">
        <div class="card small" id="carte">
            <div>
                <div class="card-image" id="image-carte">
                    <img width="300px" src="view/Images/$photo1">
                    </a>
                </div>
            </div>

            <div>
                <div class="card-content">
        <a href="index.php?action=delete&idPhoto=$idPhoto">Supprimer<i class="material-icons">delete</i></a></Br>
        <a href="index.php?action=validate&idPhoto=$idPhoto">Ajouter<i class="material-icons">add</i></a>
        

                </div>
            </div>
        </div>
    </div>
EOT;
       }
echo '</div>';