<?php
$salt='';
for ($i=0; $i<10; $i++) {
    $salt .= chr(rand(33,126));
}
echo $salt;
echo "\n\n";
echo hash('sha256', 'admin'.$salt);
?>