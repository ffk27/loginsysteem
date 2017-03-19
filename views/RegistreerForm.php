<?php
require_once 'Page.php';

class RegistreerForm implements Page
{
    public function name()
    {
        return 'registreer';
    }

    function resource() {
        return array(
            array('type'=>'style','url'=>'style/forms.css'),
            array('type'=>'script','url'=>'script/registreer.js')
        );
    }

    function html() {
        $html = <<<EOT
<h1>Registreer</h1>
<form id="registreerform">

<table id="formulier">
    <tr><td>Naam:</td><td><input type="text" required name="naam" minlength="2" maxlength="45"/></td></tr>
    <tr><td>Gebruikersnaam:</td><td><input type="text" required pattern="\w+" name="gebnaam" minlength="3" maxlength="30"/></td></tr>
    <tr><td>E-mailadres:</td><td><input type="email" required name="email" minlength="3" maxlength="254"/></td></tr>
    <tr><td>Wachtwoord:</td><td><input type="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" name="wachtwoord"/></td></tr>
    <tr><td>Wachtwoord herhalen:</td><td><input type="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" name="wachtwoordh"/></td></tr>
</table>
<p>Wachtwoord moet minimaal 8 tekens hebben, waarvan minimaal één cijfers en één speciaal teken.</p>
  	<div id="foutmelding"></div>
<input type="submit" value="Registreer">
</form>
EOT;
        return $html;
    }
}