<?php
session_start();

if (isset($_GET['p'])) {
  $html = '';
    $page = $_GET['p'];
    $pageaobj=null;
    if ($page=="index") {
        if (isLoggedIn()) {
            require_once 'views/Index.php';
            $pageaobj = new Index();
        }
        else {
            $pageaobj = loginPage();
        }
    }
    if ($page=="login") {
        if (isLoggedIn()) {
            require_once 'views/Index.php';
            $pageaobj = new Index();
        }
        else {
            $pageaobj = loginPage();
        }
    }
    if ($page=="loguit") {
        session_destroy();
        session_start();
        $pageaobj=loginPage();
    }
    if ($page=="welkom") {
        $html="<h2>Welkom</h2>";
    }
    if ($page=="registreer") {
        if (!isLoggedIn()) {
            require_once 'views/RegistreerForm.php';
            $pageaobj = new RegistreerForm();
        }
        else {
            require_once 'views/Index.php';
            $pageaobj = new Index();
        }
    }
    echo json_encode(array('page'=>$pageaobj->name(), 'html'=>$pageaobj->html(), 'resource'=>$pageaobj->resource()));
}
elseif (isset($_GET['part'])) {
  $part = $_GET['part'];
  if ($part=="captcha") {
    echo getCaptcha();
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
    require_once 'views/LoginForm.php';
    return new LoginForm();
}
?>
