<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$mail = new PHPMailer;

// Mail configuration
$mail->isSMTP();

// Debug
$mail->SMTPDebug = 3;
$mail->Debugoutput = 'html';

// Settings
$mail->Host = '127.0.0.1';
$mail->SMTPAuth = true;
$mail->Username = 'postmaster@localhost';
$mail->Password = 'H@2Plat3nHu1s';
$mail->SMTPSecure = 'tls';
$mail->isSendmail();
$mail->Port = 25;
