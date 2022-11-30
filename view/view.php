<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="view/css/style.css" />
    <link rel="shortcut icon" href="view/Images/logoIUT.png" type="image/x-icon" />
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!--Import materialize.css-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $pagetitle; ?></title>
</head>
<body>
<header>
    <a href="./index.php"><img src="view/Images/logoIUT.png" alt="LogoIUT"></a>
    <?php if(!Session::est_connecte()){?>
        <a  href="?action=connect">CONNEXION</a>
    <?php }else{?>
        <a  href="?action=deconnect">DÉCONNEXION</a>
        <a href="?action=validation">VALIDATION</a>
    <?php }?>
    <Br>
    <a href="?" class="filtre">TOUS</a>
    <a href="?Dep=GEII" class="filtre" id="GEII">GEII</a>
    <a href="?Dep=GEA" class="filtre" id="GEA">GEA</a>
    <a href="?Dep=TC" class="filtre" id="TC">TC</a>
    <a href="?Dep=INFO" class="filtre" id="INFO">INFO</a>
    <a href="?Dep=MP" class="filtre" id="MP">MP</a>
    <a href="?Dep=GB" class="filtre" id="GB">GB</a>
    <a href="?Dep=CHIMIE" class="filtre" id="CHIMIE">CHIMIE</a>

</header>
<?php
$filepath = File::build_path(array("view", "$view.php"));
require $filepath;
?>
</body>
</html>