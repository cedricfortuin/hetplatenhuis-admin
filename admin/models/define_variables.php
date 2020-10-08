<?php
include 'config/config.php';

// Get the user information by session id
$getUserBySessionId = mysqli_fetch_array($ConnectionLink->query("SELECT * FROM users WHERE USER_ID ='" . $_SESSION['id'] . "'"));
define ('userId', $getUserBySessionId['USER_ID']);
define ('username', $getUserBySessionId['USERNAME']);
define ('userFirstname', $getUserBySessionId['USER_FIRSTNAME']);
define ('userLastname', $getUserBySessionId['USER_LASTNAME']);
define ('userRole', $getUserBySessionId['USER_ROLE']);
define ('userEmail', $getUserBySessionId['USER_EMAIL']);
define ('userCreatedAt', $getUserBySessionId['USER_CREATED_AT']);

// Get the song information DESC
$getSongDesc = mysqli_fetch_array($ConnectionLink->query("SELECT * FROM songofday ORDER BY SONG_ID DESC"));
define ('songNameDesc', $getSongDesc['SONG_NAME']);
define ('songIdDesc', $getSongDesc['SONG_ID']);
define ('songArtistDesc', $getSongDesc['SONG_ARTIST']);
define ('spotifyLinkDesc', $getSongDesc['SPOTIFY_LINK']);
define ('songAddedAtDesc', $getSongDesc['UPLOAD_DATE']);

// Get the update information DESC
$getUpdate = $ConnectionLink->query("SELECT * FROM updates ORDER BY UPDATE_ID DESC");
$getUpdateDesc = mysqli_fetch_array($getUpdate);
define ('updateIDDesc', $getUpdateDesc['UPDATE_ID']);
define ('updateTitleDesc', $getUpdateDesc['UPDATE_TITLE']);
define ('updateAuthorDesc', $getUpdateDesc['UPDATE_AUTHOR']);
define ('updateTextDesc', $getUpdateDesc['UPDATE_TEXT']);
define ('updateAddedAtDesc', $getUpdateDesc['UPDATE_DATE']);