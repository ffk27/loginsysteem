<?php
use Base32\Base32;
require_once 'Page.php';

/**
 * Created by IntelliJ IDEA.
 * User: ffk27
 * Date: 27-6-2017
 * Time: 13:49
 */

class Tweefactor extends Page {
    public $enabled;
    /**
     * @return string
     */
    public function getName()
    {
        return 'twofactor';
    }

    /**
     * @return array
     */
    public function getResources()
    {
        return array(
            array('type'=>'script','url'=>'script/twofactor.js')
        );
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        $html = '<h1>Twee-factor-authenticatie</h1>';
        if ($this->enabled) {
            $html .= <<<EOT
<button onclick="disable()">Uitschakelen</button>
EOT;

        } else {
            $html .= <<<EOT
<div id="uriimg"></div>
<button onclick="enable()">Inschakelen</button>
EOT;
        }
        return $html;
    }
}