<?php
require_once 'Page.php';

class RegistreerPage extends Page
{
    public $formhtml;

    public function name()
    {
        return 'registreer';
    }

    function resource() {
        return array(
            array('type'=>'style','url'=>'style/forms.css')
        );
    }

    function html() {
        $html = '<h1>Registreren</h1>';
        $html .= $this->formhtml;
        $html .= '<p>Wachtwoord moet minimaal 8 tekens hebben, waarvan minimaal één cijfers en één speciaal teken.</p>';
        return $html;
    }
}