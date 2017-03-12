<?php
class LoginForm
{
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
<a href="#" onclick="setContent('registreer')">Registreren</a>
EOT;
        return $html;
    }
}
?>