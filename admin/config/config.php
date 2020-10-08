<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

// Get the strings from the external file
include_once 'database_strings.php';
/* Attempt to connect to MySQL database */

//This ConnectionLink is for the database from Het Platenhuis
//$ConnectionLink = mysqli_connect(EXTERNAL_HOST, EXTERNAL_USER, EXTERNAL_PASSWORD, EXTERNAL_DATABASE);

//This ConnectionLink is for the local host
$ConnectionLink = mysqli_connect(LOCAL_HOST, LOCAL_USER, LOCAL_PASSWORD, LOCAL_DATABASE );

// Check connection
if (!$ConnectionLink) {
    die("<script> console.error('An error occurred while trying to connect to database: " . mysqli_connect_error() . ". Please contact the owner of the page: administrator@hetplatenhuis.nl.')</script>");
}
