<?php
switch ($a) {
	case 'POST':
	{
        $input_gebnaam = trim($_POST['gebruiker']);
        $input_ww = trim($_POST['ww']);

        if (!empty($input_gebnaam) && !empty($input_ww)) {
            $norobot = isnoRobot($_POST['g-recaptcha-response']);
            if ($norobot) {
                $success = login($input_gebnaam,$input_ww);
                if ($success===true) {
                    geefAntwoord(1);
                }
                else {
                    geefAntwoord(2);
                }
            }
            else {
                geefAntwoord(4);
                $_SESSION["inlogpoginen"]++;
            }
        }
        break;
    }
	default:
	{
		require_once '../views/LoginPage.php';
		$loginpage = new LoginPage();
		$loginpage->pagejson();
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
    try {
        $conn = getConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT Id, niveau, salt, hash FROM Gebruikers WHERE gebruikersnaam=?;");
        $stmt->execute(array($gebruikersnaam));
        $result = $stmt->fetch();
        if ($result) {
            if (hash('sha256',$wachtwoord.$result['salt'])==$result['hash']) {
                $_SESSION['Id']=$result['Id'];
                $_SESSION['niveau']=$result['niveau'];
                $success=true;
            }
        }
        $stmt=null;
        $conn=null;
    }
    catch (PDOException $e) {
        return false;
    }
    return $success;
}
?>
