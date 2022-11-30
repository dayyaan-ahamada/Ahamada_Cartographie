<meta charset="utf-8">
<?php
if (myGet('action') == 'update') {
    $champ = 'readonly';
    $action = 'index.php?&action=updated';
    $legend = 'Modification du parteriat';
}else {
    $champ = 'required';
    $action = 'index.php?action=created';
    $legend = 'Création du partenariat';

}
?>

<script  type="text/javascript">
    function chercher(){
        var ville = $("#Ville").val();
        if(ville != ""){
            $.ajax({
                url: "https://nominatim.openstreetmap.org/search", // URL de Nominatim
                type: 'get', // Requête de type GET
                data: "q="+ville+"&format=json&addressdetails=1&limit=1&polygon_svg=1" // Données envoyées (q -> adresse complète, format -> format attendu pour la réponse, limit -> nombre de réponses attendu, polygon_svg -> fournit les données de polygone de la réponse en svg)
            }).done(function (response) {
                if(response != ""){
                    userlat = response[0]['lat'];
                    userlon = response[0]['lon'];
                    document.getElementById('longitude').setAttribute('value', userlon);
                    document.getElementById('latitude').setAttribute('value', userlat);
                }
            }).fail(function (error) {
                alert(error);
            });
        }
    }



</script>

<form method="post" enctype="multipart/form-data" action=<?php echo $action;?> >
    <fieldset>
        <legend><?php echo $legend;?></legend>
        <p>
            <input type="hidden" name="id" id="id_id"
                   value="<?php echo htmlspecialchars($p->get('id')); ?>"readonly="true"/>
        </p>
        <p>
            <input type="hidden" name="idPartenariat" id="id_P"
                   value="<?php echo htmlspecialchars($p->get('idPartenariat')); ?>"readonly="true"/>
        </p>
        <p>
            <label>Ville</label>
            <input type="text" name="Ville" id="Ville" onblur="chercher()" onChange="chercher()"
                   value="<?php echo htmlspecialchars($p->get('Ville')); ?>"/>
        </p>
        <p>
            <label>Nom de la structure d'acceuil</label>
            <input type="text" name="NomStructure" id="NomStructure_id"
                   value="<?php echo htmlspecialchars($p->get('NomStructure')); ?>"/>
        </p>
        <p>
            <label>Département de L'IUT</label>
            <input type="text" name="Departement" id="Departement_id"
                   value="<?php $departement = htmlspecialchars($p->get('Departement')); $departement = strtoupper($departement); echo $departement;?>"/>
        </p>
            <label>Nombre d'étudiants</label>
            <input type="text" name="NbEtudiants" id="NbEtudiants_id"
                   value="<?php echo htmlspecialchars($p->get('NbEtudiants')); ?>"/>
        </p>

        <p>
            <label for="Messages_id">Informations complémentaires</label>
            <textarea cols="20" rows="5" wrap="hard" name="Messages" id="Messages_id"><?php echo htmlspecialchars($p->get('Messages')); ?></textarea>
        </p>

        <p>
            <input type="hidden" name="latitude" id="latitude"/>
        </p>
        <p>
            <input type="hidden" name="longitude" id="longitude"/>
        </p>

        <input type="submit" value="Envoyer" onmouseover="chercher()"/>
    </fieldset>
</form>