<?php
require_once 'Page.php';

class LoginForm implements Page
{
    public function name()
    {
        return 'login';
    }

    function resource() {
        return array(array('type'=>'style','url'=>'style/forms.css'),array('type'=>'script','url'=>'script/login.js'));
    }

    function html()
    {
        $html = <<<EOT
  <h1>Loginsysteem</h1>
  <table id="formulier">
  <tr><td>Gebruikersnaam:</td><td><input type="text" name="gebruikersnaam"/></td></tr>
  <tr><td>Wachtwoord:</td><td><input type="password" name="wachtwoord"/></td></tr>
  </table>
  	<div id="foutmelding"></div>
  <div id="captcha">
EOT;
        if (isset($_SESSION['inlogpoginen']) && $_SESSION['inlogpoginen'] > 3) {
            $html .= getCaptcha();
        }

        $html .= <<<EOT
	</div>
	<button id="inlogknop">Inloggen</button>
	<br/><br/>
<a href="?registreer">Registreren</a>
EOT;
        return $html;
    }
}
?>