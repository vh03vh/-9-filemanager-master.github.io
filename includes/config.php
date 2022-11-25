<?php

//Set errors display to off
ini_set('display_errors', 0);
//Set timeout to 0 so that large files can be uploaded
set_time_limit(0);
//Root path
define('ROOT_PATH', '..'); //Do not use a slash at the end
//Any folders to exclude from filemanager
$exclude = array('filemanager', 'phpMyAdmin', 'phpmyadmin','filemanager-master');
//Login credentials
include('includes/login.php');