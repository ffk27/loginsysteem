<?php
switch ($a) {
    default:
        require_once '../views/Index.php';
        $index = new Index();
        $index->echoJSON();
}
?>