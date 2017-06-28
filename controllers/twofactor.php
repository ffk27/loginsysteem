<?php
use Base32\Base32;
/**
 * Created by IntelliJ IDEA.
 * User: ffk27
 * Date: 27-6-2017
 * Time: 13:49
 */
if (isLoggedIn()) {
    switch ($a) {
        case 'enable': {
            if (!isEnabled()) {
                $secret = createSecret();
                if (add($secret)) {
                    require_once '../libs/TOTP.php';
                    $totp = new TOTP();
                    $totp->setIssuer("Security");
                    $username = $_SESSION['username'];
                    $totp->setLabel($username);
                    $totp->setSecret($secret);
                    echo json_encode(array('uri'=>$totp->getProvisioningUri()));
                }
            }
            break;
        }
        case 'disable': {
            if (isEnabled()) {
                disable();
                echo json_encode(array('disabled'=>true));
            }
            break;
        }
        default: {
            require_once '../views/Tweefactor.php';
            $tweefactor = new Tweefactor();
            $tweefactor->enabled = isEnabled();
            $tweefactor->echoJSON();
            break;
        }
    }
}

function createSecret() {
    $secret = openssl_random_pseudo_bytes(128);
    return Base32::encode($secret);
}

function isEnabled() {
    require_once '../dbinfo.php';
    $username = $_SESSION['username'];
    $enabled=false;
    $mysqli = getConnection();
    $stmt = $mysqli->prepare("SELECT count(*) FROM Twofactor WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    if ($count> 0) {
        $enabled=true;
    }
    $stmt->close();
    $mysqli->close();
    return $enabled;
}

function add($secret) {
    $username = $_SESSION['username'];

    require_once '../dbinfo.php';
    $success=false;
    $mysqli = getConnection();
    $stmt = $mysqli->prepare("INSERT INTO Twofactor (username, secret) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $secret);
    if ($stmt->execute()) {
        $success = true;
    }
    $stmt->close();
    $mysqli->close();
    return $success;
}

function disable() {
    $username = $_SESSION['username'];

    require_once '../dbinfo.php';
    $success=false;
    $mysqli = getConnection();
    $stmt = $mysqli->prepare("DELETE FROM Twofactor WHERE username=?");
    $stmt->bind_param("s", $username);
    if ($stmt->execute()) {
        $success = true;
    }
    $stmt->close();
    $mysqli->close();
    return $success;
}
?>