<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/24/18
 * Time: 10:49 PM
 */

$DB_HOST = "localhost"; // MySQL server hostname
$DB_PORT = "3306";      // MySQL server port number (default 3306)
$DB_NAME = "pizza"; // MySQL database name

//$DB_USER = "petrology"; // MySQL username
$DB_USER = "root";
//$DB_PASS = "petrology"; // password
$DB_PASS = "";

$sql_connection = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br/>";
}

$GLOBALS['sql'] = $sql_connection;
$GLOBALS['conn'] = $sql_connection;

//allow french characters
mysqli_set_charset($sql_connection, "utf8");


?>


