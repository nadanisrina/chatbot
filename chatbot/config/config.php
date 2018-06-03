<?php 
$hostname = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "chatbot"; 
 
 
$conn = mysqli_connect($hostname, $username, $password, $dbname); 
 
if (!$conn) {
     die("KOneksi Gagal: " . mysqli_connect_error()); 
 } 