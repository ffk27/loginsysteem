<?php
switch ($action) {
    default:
        require_once '../views/Index.php';
        $index = new Index();
        $index->pagejson();
}
?>