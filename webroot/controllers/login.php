<?php
session_start();
if (!isset($_SESSION["inlogpoginen"])) {
	$_SESSION["inlogpoginen"]=0;
}
$input_gebnaam = trim($_POST['gebruiker']);
$input_ww = trim($_POST['ww']);

if (!empty($input_gebnaam) && !empty($input_ww)) {
	$norobot=true;
	if ($_SESSION["inlogpoginen"]>3) {
		$norobot = isnoRobot($_POST['g-recaptcha-response']);
	}
	if ($norobot) {
        $success = login($input_gebnaam,$input_ww);
		if ($success===true) {
			$_SESSION["inlogpoginen"]=0;
			geefAntwoord(1);
		}
		else {
			$_SESSION["inlogpoginen"]++;
			if ($_SESSION["inlogpoginen"]<3) {
				geefAntwoord(2);
			}
			else {
				geefAntwoord(3);
			}
		}
	}
	else {
		geefAntwoord(4);
		$_SESSION["inlogpoginen"]++;
	}
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

function geefAntwoord($code) {
	$melding='';
	switch ($code) {
		case 1:
			$melding='Success';
			break;
		case 2:
			$melding='Verkeerde gebruikersnaam of wachtwoord.';
			break;
		case 3:
			$melding='Verkeerde gebruikersnaam of wachtwoord. Verifieer uzelf.';
			break;
		case 4:
			$melding='U bent een robot.';
			break;
	}
	echo json_encode(array("antwoordcode"=>$code,"melding"=>$melding));
}

function login($gebruikersnaam,$wachtwoord) {
	$success=false;
    try {
        include '../../dbinfo.php';
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
        //print("Error connecting to SQL Server.");
        //die(print_r($e));
    }
    return $success;
}
?>
