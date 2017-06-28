<?php
require_once '../vendor/autoload.php';
require_once '../utils.php';
session_start();

$c = read_get_string('c');

getController($c);

function getController($controller)
{
    $controllers = array('index', 'login', 'registreer', 'twofactor', 'otp');
    $a = read_get_string('a');
    $i = read_get_string('i');
    if (in_array($controller, $controllers)) {
        require_once '../controllers/' . $controller . '.php';
    }
    else {
        if ($controller === 'loguit') {
            session_destroy();
            session_start();
            require_once '../controllers/login.php';
        } else if ($controller === '') {
            if (isLoggedIn()) {
                require_once '../controllers/index.php';
            } else {
                require_once '../controllers/login.php';
            }
        }
        else {
            header("HTTP/1.0 404 Niet gevonden");
        }
    }
}

function isLoggedIn() {
    if (isset($_SESSION['username']) && ((isset($_SESSION['otp']) && $_SESSION['otp']) || !isset($_SESSION['otp']))) {
        return true;
    }
    return false;
}
?>
