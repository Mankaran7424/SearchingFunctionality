<?php
$servername = "localhost";
$username = "root";
$password = "root13";
$database = "vplak";
$port = 3307;

// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
