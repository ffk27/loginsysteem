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
                $username = $_SESSION['username'];
                $secret = createSecret();
                if (add($username,$secret)) {
                    require_once '../libs/TOTP.php';
                    $totp = new TOTP();
                    $totp->setIssuer("Security");
                    $totp->setLabel($username);
                    $totp->setSecret($secret);
                    echo json_encode(array('uri'=>$totp->getProvisioningUri()));
                }
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
    try {
        $conn = getConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT id FROM Twofactor WHERE username=?");
        $stmt->execute(array($username));
        $result = $stmt->fetch();
        if ($result) {
            $enabled = true;
        }
        $stmt=null;
        $conn=null;
    }
    catch (PDOException $e) {
        return false;
    }
    return $enabled;
}

function add($username, $secret) {
    require_once '../dbinfo.php';
    $success=false;
    try {
        $conn = getConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("INSERT INTO Twofactor (username, secret) VALUES (?, ?)");
        $stmt->execute(array($username, $secret));
        $stmt=null;
        $conn=null;
        return true;
    }
    catch (PDOException $e) {
        return false;
    }
    return $success;
}
?>