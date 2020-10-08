<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
include "database_strings.php";

$mail = new PHPMailer(true);

// Mail configuration
$mail->isSMTP();

// Debug
$mail->SMTPDebug = 3;
$mail->Debugoutput = 'json';

// Settings
$mail->Host = SMTP_HOST;

$mail->SMTPAuth = true;

$mail->Username = SMTP_USERNAME;

$mail->Password = SMTP_PASSWORD;

$mail->SMTPSecure = 'tls';

$mail->Port = 25;
