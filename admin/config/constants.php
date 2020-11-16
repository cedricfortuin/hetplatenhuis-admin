<?php
/*
 * Copyright © 2020 bij Het Platenhuis en Cedric Fortuin. Niks uit deze website mag zonder toestemming gebruikt, gekopieerd en/of verwijderd worden. Als je de website gebruikt ga je akkoord met onze gebruiksvoorwaarden en privacy.
 */

//These strings are for the external database
define ('external_host', 'hetplatenhuis.nl:3306');
define ('external_user', 'DatabaseLogin-Platenhuis');
define ('external_password', 'Du2wfBtfqUq00FZgso8C');
define ('external_db', 'DATABASE_PLATENHUIS');

//These strings are for the local database
define ('local_host', 'localhost:3307');
define ('local_user', 'root');
define ('local_password', 'root');
define ('local_db', 'hetplatenhuis');

//These strings are for the SMTP configuration
define ('SMTP_HOST', 'hetplatenhuis.nl');
define ('SMTP_USERNAME', 'info@hetplatenhuis.nl');
define ('SMTP_PASSWORD', 'H@2Plat3nHu1s');

// Database tables
define ('table_admins', 'admins');
define ('table_users', 'users');
define ('table_sotd', 'songofday');
define ('table_collection', 'collection');
define ('table_updates', 'updates');
define ('table_artist_info', 'artist_info');
define ('table_reset_password', 'reset_password');
define ('table_configuration', 'configuration');
define ('table_discography', 'discography');
define ('table_mail_settings', 'mail_settings');

// Users table
define ('admin_id', 'ADMIN_ID');
define ('admin_uuid', 'ADMIN_UUID');
define ('admin_username', 'USERNAME');
define ('admin_role', 'ADMIN_ROLE');
define ('admin_mail', 'ADMIN_EMAIL');
define ('admin_firstname', 'ADMIN_FIRSTNAME');
define ('admin_lastname', 'ADMIN_LASTNAME');
define ('admin_password', 'ADMIN_PASSWORD');
define ('admin_created_at', 'ADMIN_CREATED_AT');
define ('admin_image', 'ADMIN_IMAGE');

// Users table
define ('user_id', 'USER_ID');
define ('user_uuid', 'USER_UUID');
define ('user_username', 'USERNAME');
define ('user_role', 'USER_ROLE');
define ('user_mail', 'USER_EMAIL');
define ('user_firstname', 'USER_FIRSTNAME');
define ('user_lastname', 'USER_LASTNAME');
define ('user_password', 'USER_PASSWORD');
define ('user_created_at', 'USER_CREATED_AT');
define ('user_image', 'USER_IMAGE');

// Song of the day table
define ('song_id', 'SONG_ID');
define ('song_name', 'SONG_NAME');
define ('song_artist', 'SONG_ARTIST');
define ('spotify_link', 'SPOTIFY_LINK');
define ('song_upload_date', 'UPLOAD_DATE');

// Collection table
define ('record_id', 'RECORD_ID');
define ('record_name', 'RECORD_NAME');
define ('record_artist', 'RECORD_ARTIST');
define ('record_owner', 'RECORD_OWNER');
define ('record_store', 'RECORD_STORE');

// Updates table
define ('update_id', 'UPDATE_ID');
define ('update_title', 'UPDATE_TITLE');
define ('update_author', 'UPDATE_AUTHOR');
define ('update_text', 'UPDATE_TEXT');
define ('update_created_at', 'UPDATE_CREATED_AT');

// Artist info table

//