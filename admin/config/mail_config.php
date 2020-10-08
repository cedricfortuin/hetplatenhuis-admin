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
$mail->Host = '127.0.0.1';

$mail->SMTPAuth = TRUE;

$mail->Username = 'info@hetplatenhuis.nl';

$mail->Password = 'H@2Plat3nHu1s';

$mail->SMTPSecure = 'tls';

$mail->Port = 3306;
