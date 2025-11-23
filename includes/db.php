<?php
// Database connection for Hospital Management System

$host = "localhost";   
$user = "root";       
$pass = "";        
$dbname = "hospital_db";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
