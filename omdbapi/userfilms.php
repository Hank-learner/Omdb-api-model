<?php
session_start();
$servername = "localhost";
$sqluser = "useromdbapi";
$sqlpassword = "useromdbapi1!Q";
$databasename = "omdbapi";
$conn = mysqli_connect($servername, $sqluser, $sqlpassword, $databasename);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user = $_SESSION['username'];
$usersetstable = "user_" . $user;

$title = $_GET['title'];
$mark = $_GET['mark'];
if (!$title && !$mark) {
    header("Location:explore.php");
}
if ($title != '') {
    try {
        if ($mark == "watched") {
            $sql = "SELECT * FROM $usersetstable where imdbid='$title';";
            $tabledata = mysqli_query($conn, $sql);
            $tablerows = mysqli_num_rows($tabledata);
            if ($tablerows == 0) {
                $sql = "INSERT INTO $usersetstable VALUES ('$title',0,1,0);";
            } else {
                $sql = "UPDATE $usersetstable SET watched=1 where imdbid='$title';";
            }
        }
        if ($mark == "unwatched") {
            $sql = "UPDATE $usersetstable SET watched=0 where imdbid='$title';";
        }
        if ($mark == "watchlater") {
            $sql = "SELECT * FROM $usersetstable where imdbid='$title';";
            $tabledata = mysqli_query($conn, $sql);
            $tablerows = mysqli_num_rows($tabledata);
            if ($tablerows == 0) {
                $sql = "INSERT INTO $usersetstable VALUES ('$title',0,0,1);";
            } else {
                $sql = "UPDATE $usersetstable SET watchlater=1 where imdbid='$title';";
            }
        }
        if ($mark == "unwatchlater") {
            $sql = "UPDATE $usersetstable SET watchlater=0 where imdbid='$title';";
        }
        if ($mark == "favourite") {
            $sql = "SELECT * FROM $usersetstable where imdbid='$title';";
            $tabledata = mysqli_query($conn, $sql);
            $tablerows = mysqli_num_rows($tabledata);
            if ($tablerows == 0) {
                $sql = "INSERT INTO $usersetstable VALUES ('$title',1,0,0);";
            } else {
                $sql = "UPDATE $usersetstable SET favourite=1 where imdbid='$title';";
            }
        }
        if ($mark == "unfavourite") {
            $sql = "UPDATE $usersetstable SET favourite=0 where imdbid='$title';";
        }
        if (mysqli_query($conn, $sql)) {
            header("Location: home.php");
        } else {
            echo "unable to perform query";
        }
    } catch (Exception $e) {
        echo "<script>alert('some error has occured in the database please reload the page \n $e');</script>";
    }
} else {
    echo "something is wrong Please reload the page";
}
