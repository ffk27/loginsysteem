<?php
session_start();

if (isset($_GET['p'])) {
  $html = '';
    $page = $_GET['p'];
    if ($page=="login") {
        if (!isset($_SESSION['Id'])) {
            require_once 'views/LoginForm.php';
            $loginform = new LoginForm();
            $html .= $loginform->html();
        }
        else {
            $html .= '<a href="#" onclick="setContent(\'loguit\')">Uitloggen</a>';
        }
    }
    if ($page=="loguit") {
        session_destroy();
        session_start();
        require_once 'views/LoginForm.php';
        $loginform = new LoginForm();
        $html .= $loginform->html();
    }
    if ($page=="welkom") {
        $html.="<h2>Welkom</h2>";
    }
    if ($page=="registreer") {
        require_once 'views/RegistreerForm.php';
        $regform = new RegistreerForm();
        $html.= $regform->html();
    }
    echo $html;
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
?>
