<?php
session_start();

$servername = "localhost";
$sqluser = "useromdbapi";
$sqlpassword = "useromdbapi1!Q";
$databasename = "omdbapi";
$conn = mysqli_connect($servername, $sqluser, $sqlpassword, $databasename);
if (!$conn) {
    die("<div style='
                        background-color: rgb(172, 53, 53);
                        padding: 5px;
                        border: 2px solid red' border-radius:5px>
    Connection failed: " . mysqli_connect_error()
        . "</div><br>");
}
