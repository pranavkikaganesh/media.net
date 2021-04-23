<?php
define('_DB_HOST_', '127.0.0.1');
define('_DB_USERNAME_', 'root');
define('_DB_PASSWORD_', '');
define('_DB_NAME_', 'media');
define('_DB_PORT_', '3306');

$dbConnection = mysqli_connect(_DB_HOST_, _DB_USERNAME_, _DB_PASSWORD_, _DB_NAME_, _DB_PORT_) or die("Failed to connect to MySQL: (".mysqli_connect_error().") ");
mysqli_set_charset($dbConnection, "utf8");