<?php
require_once 'Page.php';
/**
 * Created by IntelliJ IDEA.
 * User: Topicus
 * Date: 28-6-2017
 * Time: 16:09
 */
class OtpVert extends Page
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'otp';
    }

    /**
     * @return array
     */
    public function getResources()
    {
        return array(
            array('type'=>'script','url'=>'script/otp.js')
        );
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return <<<EOT
        <h1>Vertificatie</h1>
<p>Voer de vertificatiecode die u in de FreeOTP-app ziet in:</p>
<input type="text" id="input_otpcode"/>
<button onclick="sendOtpCode()">Versturen</button>
<p id="otp_error"></p>
EOT;

    }
}