<?php

$host = "localhost";
$dbname = "help_a_hand_db";
$username = "root";
$password = "";


$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    echo "Database connected successfully!";
}

return $mysqli;


