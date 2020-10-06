<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */
include_once 'database_connection.php';
/* Attempt to connect to MySQL database */

//This link is for the database from Het Platenhuis
//$link = mysqli_connect(EXTERNAL_HOST, EXTERNAL_USER, EXTERNAL_PASSWORD, EXTERNAL_DATABASE);

//This link is for the local host
$link = mysqli_connect(LOCAL_HOST, LOCAL_USER, LOCAL_PASSWORD, LOCAL_DATABASE );

// Check connection
if (!$link) {
    die("<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' /><i class='alert alert-danger'>ERROR: Could not connect: " . mysqli_connect_error() . "</i>");
}
