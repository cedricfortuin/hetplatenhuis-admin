<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
include_once "constants.php";

$mail = new PHPMailer(true);

// Mail configuration
$mail->isSMTP();

// Debug
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'json';

// Settings
$mail->Host = SMTP_HOST;

$mail->SMTPAuth = true;

$mail->Username = SMTP_USERNAME;

$mail->Password = SMTP_PASSWORD;

$mail->SMTPSecure = 'tls';

$mail->Port = 25;
