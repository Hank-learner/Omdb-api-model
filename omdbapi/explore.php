<?php
session_start();

if (!isset($_SESSION['username'])) {
	header("Location: index.php");
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION);
	header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Explore</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Saira+Semi+Condensed&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="common.css">

</head>

<body>
	<nav id="navigation">
		<a class="logo">Omdb-api</a>
		<div id="nav-right">
			<a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
			<a href="explore.php" class="active"><i class="fa fa-files-o"></i> Explore</a>
			<a href="explore.php?logout=true" id="logoutlink">logout</a>
		</div>
		<div id="smallnav-right">
			<a id="smallnav"><i class="fa fa-bars"></i></a>
		</div>
	</nav>
	<div id="bodypart">
		<form class="search" id="getmovies" method="get">
			Search for a movie:
			<br><br>
			Search by title :&nbsp;&nbsp;&nbsp;
			<input type="text" id='moviename' name='moviename'></input>
			<br><br>or<br><br>
			Search by imdbID:&nbsp;&nbsp;&nbsp;
			<input type="text" id='movieimdbid' name='movieimdbid'></input>
			<br>Enter imdb-id along with tt in the prefix
			<br><br>
			<button type="submit">Search</button>
			<div id="formstatus">
			</div>
		</form>
		<div id='displaymoviedetails'></div>

		<br><br><br><br>

		<center>
			<h2>Recent Movies</h2>
			<div id='displaypopularmovies'> </div>
		</center>

	</div>
	<script src="explore.js"></script>
</body>

</html>