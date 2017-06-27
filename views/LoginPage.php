<?php
require_once 'Page.php';
require_once '../libs/TOTP.php';

class LoginPage extends Page
{
    public function getName()
    {
        return 'login';
    }

    function getResources() {
        return array(
            array('type'=>'style','url'=>'style/forms.css'),
            array('type'=>'script','url'=>'script/login.js'),
            array('type'=>'script','url'=>'https://www.google.com/recaptcha/api.js')
        );
    }

    function getHtml()
    {
        $html = <<<EOT
  <h1>Loginsysteem</h1>
  <table id="form">
  <tr><td>Gebruikersnaam:</td><td><input type="text" name="gebruikersnaam"/></td></tr>
  <tr><td>Wachtwoord:</td><td><input type="password" name="wachtwoord"/></td></tr>
  </table>
  	<p id="errors"></p>
  <div id="captcha">
<div class="g-recaptcha" data-sitekey="6LeLixgUAAAAAMQBOtwf_ujVXetPHtBY-tW66AhA"></div>
	</div>
	<br/>
	<button id="inlogknop">Inloggen</button>
	<br/><br/>
<a href="#" onclick="setContent('registreer')">Registreren</a>
EOT;
        return $html;
    }
}
?>