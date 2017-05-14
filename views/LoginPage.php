<?php
require_once 'Page.php';

class LoginPage extends Page
{
    public function name()
    {
        return 'login';
    }

    function resource() {
        return array(
            array('type'=>'style','url'=>'style/forms.css'),
            array('type'=>'script','url'=>'script/login.js'),
            array('type'=>'script','url'=>'https://www.google.com/recaptcha/api.js')
        );
    }

    function html()
    {
        $html = <<<EOT
          <script src=""></script>
  <h1>Loginsysteem</h1>
  <table id="formulier">
  <tr><td>Gebruikersnaam:</td><td><input type="text" name="gebruikersnaam"/></td></tr>
  <tr><td>Wachtwoord:</td><td><input type="password" name="wachtwoord"/></td></tr>
  </table>
  	<div id="foutmelding"></div>
  <div id="captcha">
<div class="g-recaptcha" data-sitekey="6LeLixgUAAAAAMQBOtwf_ujVXetPHtBY-tW66AhA"></div>
	</div>
	<button id="inlogknop">Inloggen</button>
	<br/><br/>
<a href="?registreer">Registreren</a>
EOT;
        return $html;
    }
}
?>