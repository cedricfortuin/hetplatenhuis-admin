<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */
include 'config/config.php';
// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php");
exit;