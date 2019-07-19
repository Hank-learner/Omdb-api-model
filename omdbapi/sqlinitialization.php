<?php
$servername = "localhost";
$sqluser = "root";
$sqlpassword = "yourpasswordhere";
$conn = mysqli_connect($servername, $sqluser, $sqlpassword);


$sqlstmt = "CREATE DATABASE omdbapi;";
mysqli_query($conn, $sqlstmt);

$sqlstmt = "USE omdbapi;";
mysqli_query($conn, $sqlstmt);

$sqlstmt = "CREATE TABLE userdetails (username varchar(255) not null, email varchar(255) not null,password varchar(255) not null);";
mysqli_query($conn, $sqlstmt);

$sqlstmt = "CREATE USER 'useromdbapi'@'localhost' IDENTIFIED BY 'useromdbapi1!Q';";
mysqli_query($conn, $sqlstmt);

$sqlstmt = "GRANT ALL PRIVILEGES ON omdbapi . * TO 'useromdbapi'@'localhost';";
mysqli_query($conn, $sqlstmt);

$sqlstmt = "FLUSH PRIVILEGES;";
mysqli_query($conn, $sqlstmt);
