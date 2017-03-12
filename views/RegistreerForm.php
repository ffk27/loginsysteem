<?php
class RegistreerForm
{
    function html() {
        $html = <<<EOT
<h1>Registreer</h1>
<table id="formulier">
<tr><td>Naam:</td><td><input type="text" name="naam" maxlength="45"/></td</tr>
<tr><td>Gebruikersnaam:</td><td><input type="text" name="gebnaam" maxlength="30"/></td></tr>
<tr><td>E-mailadres:</td><td><input type="text" name="email" maxlength="254"/></td></tr>
<tr><td>Wachtwoord:</td><td><input type="text" name="wachtwoord"/></td></tr>
<tr><td>Wachtwoord herhalen:</td><td><input type="text" name="wachtwoordh"/></td></tr>
</table>
<p>Wachtwoord moet minimaal 8 tekens, waarvan minimaal één cijfers en één speciaal teken hebben.</p>
  	<div id="foutmelding"></div>
<button id="registreerknop">Registreer</button>
EOT;
        return $html;
    }
}