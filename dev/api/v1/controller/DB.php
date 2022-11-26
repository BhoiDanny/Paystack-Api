<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "sannytech";

$connection = mysqli_connect($host, $user, $pass, $db);

if($connection){
    echo "We are connected";
} else {
    die("Database connection failed");
}

//PDO connection

$host = "localhost";
$db = "sannytech";
$user = "root";
$pass = "";

$dsn = "mysql:host=$host;dbname=$db";

$connection = new PDO($dsn, $user, $pass);