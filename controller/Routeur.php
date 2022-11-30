<?php
    require_once (File::build_path(array('controller','Controller.php')));

    function myGet($nomVar){
        if (isset($_GET[$nomVar]))
            return $_GET[$nomVar];
        else if (isset($_POST[$nomVar]))
            return $_POST[$nomVar];
        else
            return null;
    }

    if (!is_null(myGet('action')))
        $action = myGet('action');
    else
        $action = 'overview';

    $controller_class = 'Controller';
    if (in_array($action,  get_class_methods($controller_class)))
        $controller_class::$action();

    else {
    $view = 'error';
    $pagetitle = 'Erreur';
    require File::build_path(array('view', 'view.php'));
    }