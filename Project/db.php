<?php
$servername = "localhost";
$username = "root"; // change if your MySQL username is different
$password = ""; // change if your MySQL password is different
$dbname = "school_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
