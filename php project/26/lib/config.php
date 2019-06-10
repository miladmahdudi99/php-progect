<?php
// config for Image Store Project
// Website information
define('IS_TITLE', 'فروشگاه تصویر سون لرن');
define('IS_HOME_URL', 'http://localhost/7L%20PHP/26/');

// URL vs PATH
define('IS_THUMB_BASE_URL', IS_HOME_URL . 'upload/thumb/');
define('IS_THUMB_UPLOAD_PATH', dirname(__DIR__) . '/upload/thumb/');
define('IS_IMAGE_UPLOAD_PATH', dirname(__DIR__) . '/upload/original/');

define('IS_THUMB_WIDTH', 150);
define('IS_THUMB_HEIGHT', 121);
define('IS_ORDERS_PER_PAGE', 10);
define('IS_IMAGE_PER_PAGE', 16);
define('IS_DATE_FORMAT', "d F y - H:i");

// turn off error reporting after project completion
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// database information
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'project_is';

$db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

/* check connection */
if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}

// for farsi data transfer to/from database
$db->query("SET NAMES UTF8;");

// define our tables for usage in code
$db->categoriesTable = "categories";
$db->imagesTable = "images";
$db->ordersTable = "orders";
$db->usersTable = "users";
$db->passResetTable = "pass_reset_requests";