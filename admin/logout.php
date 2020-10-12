<?php
// Initialize the session

/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

session_start();
include 'config/config.php';

// Unset all of the session variables
$_SESSION = array();

$offlineUser = $_GET['USERNAME'];
$addOnline = "DELETE FROM online_users WHERE ONLINE_USERNAME = '" . $offlineUser . "'";
mysqli_query($ConnectionLink, $addOnline);

print_r ($offlineUser);
// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php");
exit;