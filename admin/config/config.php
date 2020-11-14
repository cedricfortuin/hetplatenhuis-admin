<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */
include 'constants.php';
//This ConnectionLink is for the database from Het Platenhuis
$ConnectionLink = mysqli_connect(external_host, external_user, external_password, external_db);

//This ConnectionLink is for the local host
//$ConnectionLink = mysqli_connect(local_host, local_user, local_password, local_db);

// Get file from url
$basename = basename($_SERVER['PHP_SELF'], ".php");

// Check connection
if (!$ConnectionLink) {
    die("<script> console.error('An error occurred while trying to connect to database: " . mysqli_connect_error() . ". Please contact the owner of the page: administrator@hetplatenhuis.nl.')</script>");
} else if ($basename !== 'login'){
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }
}
