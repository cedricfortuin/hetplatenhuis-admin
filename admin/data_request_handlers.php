<?php
include 'config/config.php';

// Set permission
if(user_role === 'visitor')
{
    $isDisabledForVisitors = true;
} else {
    $isDisabledForVisitors = false;
}

if (user_role === 'visitor' || user_role === 'subadmin')
{
    $isDisabledForVisitorsAndSubadmins = true;
} else {
    $isDisabledForVisitorsAndSubadmins = false;
}

// Admin requests
$getAdminBySessionIdArray = $ConnectionLink->query("SELECT * FROM users WHERE USER_ID ='" . $_SESSION['id'] . "'")->fetch_array();
$getAdminArray = $ConnectionLink->query("SELECT * FROM users")->fetch_array();
$getAdminBySessionId = $ConnectionLink->query("SELECT * FROM users WHERE USER_ID ='" . $_SESSION['id'] . "'");
$getAdminArrayDesc = $ConnectionLink->query("SELECT * FROM users ORDER BY USER_ID ASC");


// Song requests
$getSongArrayDesc = $ConnectionLink->query("SELECT * FROM songofday ORDER BY SONG_ID DESC")->fetch_array();
$total_pages = $ConnectionLink->query("SELECT * FROM songofday")->num_rows;

// Update requests
$getUpdateArrayDesc = $ConnectionLink->query("SELECT * FROM updates ORDER BY UPDATE_ID DESC")->fetch_array();

// Config requests
$getConfigDataSOTDList = $ConnectionLink->query("SELECT * FROM configuration WHERE CONFIG_KEY = 'CONFIG_ITEMS_SONG_OF_DAY_LIST'")->fetch_array();
$getConfigDataArtistList = $ConnectionLink->query("SELECT * FROM configuration WHERE CONFIG_KEY = 'CONFIG_ITEMS_ROW_ARTISTS'")->fetch_array();
$getConfigDataAlertText = $ConnectionLink->query("SELECT * FROM configuration WHERE CONFIG_KEY = 'CONFIG_NEW_WEBSITE_FEATURE_ALERT_TEXT'")->fetch_array();
$getConfigDataAlertEnable = $ConnectionLink->query("SELECT * FROM configuration WHERE CONFIG_KEY = 'CONFIG_ENABLE_WEBSITE_NEW_FEATURE_ALERT'")->fetch_array();
$getConfigDataUUIDList = $ConnectionLink->query("SELECT * FROM configuration WHERE CONFIG_KEY = 'CONFIG_ENABLE_UUID_LIST'")->fetch_array();
$getConfigDataSotdEnable = $ConnectionLink->query("SELECT * FROM configuration WHERE CONFIG_KEY = 'CONFIG_ENABLE_SONG_OF_DAY'")->fetch_array();
$getConfigDataNewsletterEnable = $ConnectionLink->query("SELECT * FROM configuration WHERE CONFIG_KEY = 'CONFIG_ENABLE_NEWSLETTER'")->fetch_array();
$getConfigDataMyPHEnable = $ConnectionLink->query("SELECT * FROM configuration WHERE CONFIG_KEY = 'CONFIG_ENABLE_MY_PH'")->fetch_array();

// Artist requests
$getPageDataArray = $ConnectionLink->query("SELECT * FROM artist_info ORDER BY ARTIST_NAME");


// List requests

