<?php
session_start();

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $pageaobj=null;
    switch ($page) {
        case "index":
            if (isLoggedIn()) {
                require_once '../views/Index.php';
                $pageaobj = new Index();
            } else {
                $pageaobj = loginPage();
            }
            break;
        case "login":
            if (isLoggedIn()) {
                require_once '../views/Index.php';
                $pageaobj = new Index();
            } else {
                $pageaobj = loginPage();
            }
            break;
        case "loguit":
            session_destroy();
            session_start();
            $pageaobj = loginPage();
            break;
        case "registreer":
            if (!isLoggedIn()) {
                require_once '../views/RegistreerForm.php';
                $pageaobj = new RegistreerForm();
            } else {
                require_once '../views/Index.php';
                $pageaobj = new Index();
            }
            break;
    }
    echo json_encode(array('page'=>$pageaobj->name(), 'html'=>$pageaobj->html(), 'resource'=>$pageaobj->resource()));
}
elseif (isset($_GET['html'])) {
    $html = $_GET['html'];
    if ($html=="captcha") {
        echo getCaptcha();
    }
}
elseif (isset($_GET['post'])) {
    $post = $_GET['post'];
    if (isLoggedIn()) {

    }
    else {
        //only allow login and signup when not logged in.
        if ($post=='registreerform') {
            require_once '../controllers/registreer.php';
        }
        if ($post=='login') {
            require_once '../controllers/login.php';
        }
    }
}

function getCaptcha() {
    return <<<EOT
  <script src='https://www.google.com/recaptcha/api.js'></script>
<div class="g-recaptcha" data-sitekey="6LeLixgUAAAAAMQBOtwf_ujVXetPHtBY-tW66AhA"></div>
EOT;
}

function isLoggedIn() {
    if (isset($_SESSION['Id'])) {
        return true;
    }
    return false;
}

function loginPage() {
    require_once '../views/LoginForm.php';
    return new LoginForm();
}
?>
