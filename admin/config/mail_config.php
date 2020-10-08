<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$mail = new PHPMailer(TRUE);

// Mail configuration
$mail->isSMTP();

// Debug
$mail->SMTPDebug = 3;
$mail->Debugoutput = 'json';

// Settings
$mail->Host = 'localhost';

$mail->SMTPAuth = TRUE;

$mail->Username = 'postmaster@localhost';

$mail->Password = 'H@2Plat3nHu1s';

$mail->SMTPSecure = 'tls';

$mail->Port = 3306;
