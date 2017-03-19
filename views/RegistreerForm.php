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
            array('type'=>'style','url'=>'style/forms.css')
        );
    }

    function html() {
        $html = '<h1>Registreren</h1>';
        require_once 'Form.php';
        $form = new Form('registreerform',array(
            array('text'=>'Naam','name'=>'naam','required'=>true,'minlength'=>2,'maxlength'=>45),
            array('text'=>'Gebruikersnaam','name'=>'gebnaam','required'=>true,'minlength'=>3,'maxlength'=>30,'pattern'=>'\w+'),
            array('text'=>'E-mailadres','name'=>'email','type'=>'email','required'=>true,'minlength'=>3,'maxlength'=>254),
            array('text'=>'Wachtwoord','name'=>'wachtwoord','type'=>'password','required'=>true,'minlength'=>8,'pattern'=>'(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}'),
            array('text'=>'Wachtwoord herhalen','name'=>'wachtwoordh','type'=>'password','required'=>true,'minlength'=>8,'pattern'=>'(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}')
        ),'Registreer');
        $html .= $form->html();
        $html .= '<p>Wachtwoord moet minimaal 8 tekens hebben, waarvan minimaal één cijfers en één speciaal teken.</p>';
        return $html;
    }
}