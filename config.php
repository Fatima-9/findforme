<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id19882304_findforme_user');
define('DB_PASSWORD', '|2)&1Hr]RwXE36iO');
define('DB_NAME', 'id19882304_findforme');
 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$link->query('SET NAMES utf8');

?>