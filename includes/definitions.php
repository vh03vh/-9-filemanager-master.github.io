<?php

//Settings
define('SITE_NAME', 'File Manager');
define('DEVELOPER_NAME', 'Sulata iSoft');
define('TAGLINE', 'by ' . DEVELOPER_NAME);
define('DEVELOPER_URL', 'http://www.sulata.com.pk');

/* * ************************************ */
/* * ** DO NOT DELETE BELOW THIS LINE *** */
/* * ************************************ */
//php ini settings
ini_set('display_errors', 0);
ini_set('magic_quotes_gpc', 0);

//Messages
define('FILE_ALREADY_EXISTS', 'File already exists.');
define('FILE_NAME_REQUIRED', 'File name is required.');
define('FOLDER_NAME_REQUIRED', 'Folder name is required.');
define('FOLDER_ALREADY_EXISTS', 'Folder already exists.');
define('FILE_DOES_NOT_EXIST', 'File does not exist.');
define('ERROR_CREATING_FILE', 'Error creating file.');
define('ERROR_CREATING_FOLDER', 'Error creating folder.');
define('ZIP_EXTRACT_ERROR', 'Error unzipping file.');
define('ZIP_CLASS_ERROR', 'ZipArchive class not supported.');
define('UNSUPPORTED_FUNCTION', 'Function not supported on this server.');
define('NO_SOURCE_FILE', 'No source file selected.');
define('PASTE_ERROR', 'File already exists.');
define('SURE', 'Are you sure?');
define('OVERWRITE', 'Are you sure? This will overwrite files and folders.');
define('INVALID_LOGIN', 'Invalid login.');
define('FTP_CONNECTION_ERROR', 'Login failed, correct FTP credentials are required to login in.');
//Remote URL
define('NOTIFICATION_URL', 'https://sulata-file-manager.github.io/notification.html');

//Start session
session_start();
set_time_limit(0);



