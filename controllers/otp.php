<?php
if (!isLoggedIn() && (isset($_SESSION['otp']) && !$_SESSION['otp'])) {
    switch ($a) {
        case 'vert': {
            $otpcode = $i;
            if (vertCode($otpcode)) {
                $_SESSION['otp'] = true;
                echo json_encode(array('success'=>true));
            } else {
                echo json_encode(array('success'=>false));
            }
            break;
        }
        default: {
            require_once '../views/OtpVert.php';
            $otpvert = new OtpVert();
            echo $otpvert->echoJSON();
            break;
        }
    };
}

function vertCode($code) {
    require_once '../dbinfo.php';
    $username = $_SESSION['username'];
    $correct=false;
    $mysqli = getConnection();
    $stmt = $mysqli->prepare("SELECT secret FROM Twofactor WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($secret);
    while ($stmt->fetch()) {
        require_once '../libs/TOTP.php';
        $totp = new TOTP();
        $totp->setIssuer("Security");
        $username = $_SESSION['username'];
        $totp->setLabel($username);
        $totp->setSecret($secret);
        if ($totp->now() === $code) {
            $correct = true;
            break;
        }
    }
    $stmt->close();
    $mysqli->close();
    return $correct;
}