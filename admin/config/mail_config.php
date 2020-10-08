<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$mail = new PHPMailer();

// Mail configuration
$mail->isSMTP();
$mail->Host = 'smtp.strato.de';
$mail->SMTPAuth = true;
$mail->Username = 'info@hetplatenhuis.nl';
$mail->Password = 'H@2Plat3nHu1s';
$mail->SMTPSecure = 'tls';
$mail->Port = 465;
