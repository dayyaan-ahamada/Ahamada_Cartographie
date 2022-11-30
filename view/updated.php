<?php
echo("Le partenariat à " . htmlspecialchars($values['Ville']) .
    " a bien été modifié et enregistré. ");
require File::build_path(array('view','overview.php'));