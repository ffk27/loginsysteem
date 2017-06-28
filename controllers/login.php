<?php
if (!isLoggedIn()) {
    switch ($a) {
        case 'POST': {
            $input_gebnaam = trim($_POST['gebruiker']);
            $input_ww = trim($_POST['ww']);

            if (!empty($input_gebnaam) && !empty($input_ww)) {
                $norobot = isnoRobot($_POST['g-recaptcha-response']);
                if ($norobot) {
                    $success = login($input_gebnaam, $input_ww);
                    if ($success === true) {
                        if (!isset($_SESSION['otp'])) {
                            geefAntwoord(1);
                        } else {
                            geefAntwoord(5);
                        }
                    } else {
                        geefAntwoord(2);
                    }
                } else {
                    geefAntwoord(4);
                }
            }
            break;
        }
        default: {
            require_once '../views/LoginPage.php';
            $loginpage = new LoginPage();
            $loginpage->echoJSON();
        }
    }
}

function geefAntwoord($code) {
	$melding='';
	switch ($code) {
		case 1:
			$melding='Success';
			break;
		case 2:
			$melding='Verkeerde gebruikersnaam of wachtwoord.';
			break;
		case 4:
			$melding='U bent een robot.';
			break;
	}
	echo json_encode(array("antwoordcode"=>$code,"melding"=>$melding));
}

function login($gebruikersnaam,$wachtwoord) {
    require_once '../dbinfo.php';
    $success=false;
    $mysqli = getConnection();
    $stmt = $mysqli->prepare("SELECT gebruikersnaam, role, salt, hash,(SELECT count(*) FROM twofactor WHERE username=?) AS otp FROM Gebruikers WHERE gebruikersnaam=?;");
    $stmt->bind_param("ss", $gebruikersnaam, $gebruikersnaam);
    if ($stmt->execute()) {
        $stmt->bind_result($username,$role,$salt,$hash,$otp);
        while ($stmt->fetch()) {
            if (hash('sha256', $wachtwoord . $salt) == $hash) {
                $_SESSION['username'] = $gebruikersnaam;
                $_SESSION['role'] = $role;
                if (boolval($otp)) {
                    $_SESSION['otp'] = false;
                }
                $success = true;
            }
        }
    }
    $stmt->close();
    $mysqli->close();
    return $success;
}
?>
