<?php
echo("Le partenariat a bien été enregistré. ");
$tab = ModelPartenariat::selectAll(0);
$photo = ModelPhoto::selectAll(0);
require File::build_path(array('view','validation.php'));