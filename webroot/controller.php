<?php
require_once '../utils.php';
session_start();

$c = read_get_string('c');

getController($c);

function getController($controller)
{
    $controllers = array('index', 'login', 'registreer');
    $a = read_get_string('a');
    $i = read_get_int('id');
    if (in_array($controller, $controllers)) {
        require_once '../controllers/' . $controller . '.php';
    }
    else {
        if ($controller === 'loguit') {
            session_destroy();
            require_once '../controllers/login.php';
        } elseif (isLoggedIn()) {
            require_once '../controllers/index.php';
        } else {
            require_once '../controllers/login.php';
        }
    }
}

function isLoggedIn() {
    if (isset($_SESSION['Id'])) {
        return true;
    }
    return false;
}
?>
