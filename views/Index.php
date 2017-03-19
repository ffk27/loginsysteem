<?php
require_once 'Page.php';
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 3/12/2017
 * Time: 6:01 PM
 */
class Index implements Page
{
    public function name()
    {
        return 'index';
    }

    public function resource()
    {
        return array();
    }

    function html() {
        $html =  <<<EOT
<h1>Index</h1>
EOT;
        $html .= '<a href="#" onclick="setContent(\'loguit\')">Uitloggen</a>';
        return $html;
    }
}