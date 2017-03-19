<?php
function read_post($name) {
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    return null;
}

function read_post_string($name) {
    return trim(read_post($name));
}

function read_array($name,$array) {
    if (isset($array[$name])) {
        return $array[$name];
    }
    return null;
}

function createSalt() {
    $salt='';
    for ($i=0; $i<10; $i++) {
        $salt .= chr(rand(33,126));
    }
    return $salt;
}
?>