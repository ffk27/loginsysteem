<?php
require_once '../utils.php';

$naam = read_post_string('naam');
$gebnaam = read_post_string('gebnaam');
$email = read_post_string('email');
$ww = read_post('ww');

$ok = true;

if (strlen($naam)<2 || strlen($naam)>45) {
    $ok=false;
}
else if (strlen($gebnaam)<3 || strlen($gebnaam)>30 || !preg_match('/\w+/',$gebnaam)) {
    $ok=false;
}
else if (strlen($gebnaam)<3 || strlen($gebnaam)>254 || !preg_match('/\S+@\S+/',$email)) {
    $ok=false;
}
else if (strlen($gebnaam)<8 || !preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/',$ww)) {
    $ok=false;
}

if ($ok) {
    if (usernameExists($gebnaam)) {
        respond(2);
    }
    else {
        signup($naam,$gebnaam,$email,$ww);
        respond(1);
    }
}
else {
    respond(3);
}

function respond($code) {
    $melding='';
    switch ($code) {
        case 1:
            $melding='Success';
            break;
        case 2:
            $melding='Gebruikersnaam al in gebruik.';
            break;
        case 3:
            $melding='Formulier gemanipuleerd.';
            break;
        case 4:
            $melding='Database-fout. Probeer het opnieuw.';
            break;
    }
    echo json_encode(array("antwoordcode"=>$code,"melding"=>$melding));
}

function usernameExists($username) {
    try {
        include '../dbinfo.php';
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT id FROM Gebruikers WHERE gebruikersnaam=?;");
        $stmt->execute(array($username));
        $result = $stmt->fetch();
        if ($result) {
            return true;
        }
        $stmt=null;
        $conn=null;
    }
    catch (PDOException $e) {
        //print("Error connecting to SQL Server.");
        //die(print_r($e));
    }
    return false;
}

function signup($name,$username,$email,$password) {
    try {
        include '../dbinfo.php';
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $salt = createSalt();
        $hash = hash('sha256', $password.$salt);
        $stmt = $conn->prepare("INSERT INTO Gebruikers (naam,gebruikersnaam,niveau,email,salt,hash) VALUES (?,?,?,?,?,?);");
        $stmt->execute(array($name,$username,3,$email,$salt,$hash));

        $stmt=null;
        $conn=null;
    }
    catch (PDOException $e) {
        //print("Error connecting to SQL Server.");
        //die(print_r($e));
    }
    return false;
}
?>