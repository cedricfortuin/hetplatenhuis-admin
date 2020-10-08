<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$mail = new PHPMailer();

// Mail configuration
$mail->isSMTP();
$mail->Host = '127.0.0.1';
$mail->SMTPAuth = true;
$mail->Username = 'postmaster@localhost';
$mail->Password = 'Mail@HetPlatenhuis';
$mail->SMTPSecure = 'tls';
$mail->Port = 25;
