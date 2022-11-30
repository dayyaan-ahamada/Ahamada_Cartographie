<?php
if (myGet('action') == 'add') {
    $action = 'index.php?&action=added';
    $legend = 'Ajout d\'une photo';
}
?>

<form method="post" enctype="multipart/form-data" action="index.php?&action=added" >
    <fieldset>
        <legend><?php echo $legend;?></legend>
        <p>
            <label for="fileToUpload" > Photo : </label >
            <input type = "file" name = "fileToUpload" id = "fileToUpload" >
            <input type = "hidden" name = "idPartenariat" id = "id_P" value = " <?php echo htmlspecialchars($p->get('idPartenariat')); ?>'">
        </p>
        <p>
            <input type="hidden" name="idPartenariat" id="id_P"
                   value="<?php echo htmlspecialchars($p->get('idPartenariat')); ?>"readonly="true"/>
        </p>
        <input type="submit" value="Envoyer" />
    </fieldset>
    </form><?php
