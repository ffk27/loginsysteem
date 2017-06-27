<?php
if (!isLoggedIn()) {
    require_once '../views/Form.php';
    $registreerForm = new Form('registreerform', array(
        array('text' => 'Naam', 'name' => 'naam', 'required' => true, 'minlength' => 2, 'maxlength' => 45),
        array('text' => 'Gebruikersnaam', 'name' => 'gebnaam', 'required' => true, 'minlength' => 3, 'maxlength' => 30, 'pattern' => '\w+'),
        array('text' => 'E-mailadres', 'name' => 'email', 'type' => 'email', 'required' => true, 'minlength' => 3, 'maxlength' => 254, 'pattern' => '\S+@\S+'),
        array('text' => 'Wachtwoord', 'name' => 'wachtwoord', 'type' => 'password', 'required' => true, 'minlength' => 8, 'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}', 'onkeypress' => 'document.getElementsByName(\'wachtwoordh\')[0].pattern = \'(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\''),
        array('text' => 'Wachtwoord herhalen', 'name' => 'wachtwoordh', 'type' => 'password', 'required' => true, 'minlength' => 8, 'onkeypress' => 'this.pattern = \'\\\b\'+document.getElementsByName(\'wachtwoord\')[0].value+\'\\\b\'')
    ), 'Registreer', 'POST', $controller);

    switch ($a) {
        case 'POST': {
            $naam = read_array('naam', $_POST);
            $gebnaam = read_array('gebnaam', $_POST);
            $email = read_array('email', $_POST);
            $ww = read_array('wachtwoord', $_POST);

            if ($registreerForm->isValidData($_POST)) {
                if (usernameExists($gebnaam)) {
                    respond(2);
                } else {
                    if (signup($naam, $gebnaam, $email, $ww)) {
                        respond(1);
                    } else {
                        respond(4);
                    }
                }
            } else {
                respond(3);
            }
            break;
        }
        default: {
            require_once '../views/RegistreerPage.php';
            $registreerPage = new RegistreerPage();
            $registreerPage->formhtml = $registreerForm->html();
            $registreerPage->echoJSON();
        }
    }
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
    echo json_encode(array("code"=>$code,"error"=>$melding));
}

function usernameExists($username) {
    require_once '../dbinfo.php';
    try {
        $conn = getConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT Id FROM Gebruikers WHERE gebruikersnaam=?;");
        $stmt->execute(array($username));
        $result = $stmt->fetch();
        if ($result) {
            return true;
        }
        $stmt=null;
        $conn=null;
    }
    catch (PDOException $e) {
        echo $e;
        return false;
    }
    return false;
}

function createSalt() {
    $salt='';
    for ($i=0; $i<10; $i++) {
        $salt .= chr(rand(33,126));
    }
    return $salt;
}

function signup($name,$username,$email,$password) {
    require_once '../dbinfo.php';
    try {
        $conn = getConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $salt = createSalt();
        $hash = hash('sha256', $password.$salt);
        $stmt = $conn->prepare("INSERT INTO Gebruikers (naam,gebruikersnaam,role,email,salt,hash) VALUES (?,?,?,?,?,?);");
        $stmt->execute(array($name,$username,3,$email,$salt,$hash));

        $stmt=null;
        $conn=null;

        return true;
    }
    catch (PDOException $e) {
        echo $e;

        return false;
    }
}
?>