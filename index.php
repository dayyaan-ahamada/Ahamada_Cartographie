<?php
session_start();
$DS = DIRECTORY_SEPARATOR;
$dir = __DIR__;
$ROOT_FOLDER = $dir . $DS . 'lib'. $DS. 'File.php';
require_once ($ROOT_FOLDER);
require_once File::build_path(array('controller', 'Routeur.php'));