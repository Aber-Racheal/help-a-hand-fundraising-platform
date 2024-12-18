<?php

$host = "localhost";
$dbname = "fundraiser";
$username = "root";
$password = "";


$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    echo "Database connected successfully!";
}

return $mysqli;


