<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

// Mail configuration
$mail->isSMTP();

// Debug
$mail->SMTPDebug = 3;
$mail->Debugoutput = 'json';

// Settings
$mail->Host = 'hetplatenhuis.nl';

$mail->SMTPAuth = true;

$mail->Username = 'info@hetplatenhuis.nl';

$mail->Password = 'H@2Plat3nHu1s';

$mail->SMTPSecure = 'tls';

$mail->Port = 25;
