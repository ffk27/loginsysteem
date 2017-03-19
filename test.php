<?php
/*
$salt='';
for ($i=0; $i<10; $i++) {
    $salt .= chr(rand(33,126));
}
echo $salt;
echo "\n\n";
echo hash('sha256', 'admin'.$salt);
*/
//var_dump(preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/','abcDEF12'));

require_once 'views/Form.php';

$form = new Form('abc',array(
    array('text'=>'Hallo','name'=>'hal','type'=>'text')
));
var_dump($form->html());
?>