<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "barbershop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>