<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$mail = new PHPMailer();

// Mail configuration
$mail->isSMTP();
$mail->Host = '127.0.0.1';
$mail->SMTPAuth = true;
$mail->Username = 'postmaster@localhost';
$mail->Password = 'H@2Plat3nHu1s';
$mail->SMTPSecure = 'tls';
$mail->Port = 25;