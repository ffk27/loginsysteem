<?php
require_once 'Page.php';

class RegistreerPage extends Page
{
    public $formhtml;

    public function getName()
    {
        return 'registreer';
    }

    function getResources() {
        return array(
            array('type'=>'style','url'=>'style/forms.css')
        );
    }

    function getHtml() {
        return <<<EOT
        <a href="#" onclick="setContent('login')">Terug</a>
<h1>Registreren</h1>
{$this->formhtml}
<p>Wachtwoord moet minimaal 8 tekens hebben, waarvan minimaal één cijfers en één speciaal teken.</p>
EOT;
    }
}