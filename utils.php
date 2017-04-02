<?php
function read_post($name) {
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    return null;
}

function read_get($name) {
    if (isset($_GET[$name])) {
        return $_GET[$name];
    }
    return null;
}

function read_post_string($name) {
    return trim(read_post($name));
}

function read_get_string($name) {
    return trim(read_get($name));
}

function read_post_int($name) {
    return (int)read_post($name);
}

function read_get_int($name) {
    return (int)read_get($name);
}

function read_array($name,$array) {
    if (isset($array[$name])) {
        return $array[$name];
    }
    return null;
}

function isnoRobot($captcha) {
    if (!empty($captcha)) {
        $post = array(
            'secret' => '6LeLixgUAAAAAMV3v7faHPgUAEX7WS5uzasgThMe',
            'response' => $captcha,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Moet true
        $response = json_decode(curl_exec($ch));
        if (isset($response->success)) {
            return $response->success;
        }
    }
    return false;
}
?>