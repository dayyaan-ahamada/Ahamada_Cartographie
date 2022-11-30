<?php
require_once File::build_path(array('model', 'ModelPartenariat.php'));
if(isset($_SESSION['login']))
    echo "<h4>".'Bienvenue ' .htmlspecialchars($_SESSION['login']).'!'."</h4>";
$tab = ModelPartenariat::selectAll(1);
require File::build_path(array('view', 'overview.php'));