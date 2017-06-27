<?php
require_once 'Page.php';
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 3/12/2017
 * Time: 6:01 PM
 */
class Index extends Page
{
    public function getName()
    {
        return 'index';
    }

    public function getResources()
    {
        return array();
    }

    function getHtml() {
        $html = <<<EOT
<h1>Index</h1>
<ul>
<li><a href="#" onclick="setContent('twofactor')">Twee-factor-authenticatie instellen</a></li>
<li><a href="#" onclick="setContent('loguit')">Uitloggen</a></li>
</ul>

EOT;
        return $html;
    }
}