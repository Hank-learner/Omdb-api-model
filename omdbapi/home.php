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
    <title>Home</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Saira+Semi+Condensed&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="common.css">

</head>

<body>
    <nav id="navigation">
        <a class="logo">Omdb-api</a>
        <div id="nav-right">
            <a href="home.php" class="active"><i class="fa fa-fw fa-home"></i> Home</a>
            <a href="explore.php"><i class="fa fa-files-o"></i> Explore</a>
            <a href="home.php?logout=true" id="logoutlink">logout</a>
        </div>
        <div id="smallnav-right">
            <a id="smallnav"><i class="fa fa-bars"></i></a>
        </div>
    </nav>
    <div id="bodypart">
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

        $omdbapikey = "your8digitkeyhere";
        $youtubeapikey = "your40digitkeyhere";

        echo "<h2>Your activity</h2>";

        echo "<h2>Favourites</h2>";
        $sql = "select imdbid FROM $usersetstable where favourite=1;";
        $res = mysqli_query($conn, $sql);
        echo "<table><tr>";
        $favourites = 0;
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $favourites++;
            if ($favourites == 4) {
                echo "</tr><tr>";
                $favourites = 1;
            }
            $url = file_get_contents("http://www.omdbapi.com/?i=" . $row['imdbid'] . "&apikey=$omdbapikey");
            $json = json_decode($url, true);
            $movie_title = $json['Title'];
            $movie_poster = $json['Poster'];
            $movie_year = $json['Year'];
            $movie_runtime = $json['Runtime'];
            $movie_rated = $json['Rated'];
            $movie_genre = $json['Genre'];
            $movie_imdbid = $json['imdbID'];
            $movie_plot = $json['Plot'];
            $movie_director = $json['Director'];
            $movie_writer = $json['Writer'];
            $movie_actors = $json['Actors'];
            $movie_imdbRating = $json['imdbRating'];
            echo "<td><center><div class='contain'>";
            echo "<img src='$movie_poster' class='image' style='width:100%;'></img>";
            echo "<div class='middle'><div class='text'>";
            $string = "document.getElementById('favourite$movie_title').style.display='block'";
            echo '<br><br><button onclick="' . $string . '">View</button>';
            echo "</div></div></div></center>";
            echo "</td>";
            echo "<div id='favourite$movie_title' class='modal'>";
            echo "<span onclick=\"document.getElementById('favourite$movie_title').style.display='none'\" class='close' title='Close Modal'>&times;</span>
                            <div class='container' style='text-align: left;background-color: #252525;'>
                                <h3>$movie_title</h3>
                                <p>$movie_plot</p><pre>
                                <p>IMDB ID       $movie_imdbid</p>
                                <p>Year          $movie_year </p>
                                <p>Runtime       $movie_runtime </p>
                                <p>Rated         $movie_rated </p>
                                <p>Genre         $movie_genre </p>
                                <p>Director      $movie_director </p>
                                <p>Writer        $movie_writer </p>
                                <p>Actors        $movie_actors </p>
                                <p>imdbRating    $movie_imdbRating </p></pre>";

            $movietitle = str_replace(" ", "-", $movie_title);
            $youtubeapi_url = "https://www.googleapis.com/youtube/v3/search?key=$youtubeapikey&part=snippet&maxResults=1&type=video&q=$movietitle";
            $youtubeapidata = json_decode(file_get_contents($youtubeapi_url, true));
            $videoid = $youtubeapidata->items[0]->id->videoId;
            echo "<center><iframe width='420' height='345' src='https://www.youtube.com/embed/$videoid?controls=1'></iframe><br><br>Add to:<br>
            <a href='userfilms.php?mark=watchlater&title=$movie_imdbid'><button style='color:black;'>add to watch later</button></a>
            <a href='userfilms.php?mark=watched&title=$movie_imdbid'><button style='color:black;'>add to watched</button></a>
            <a href='userfilms.php?mark=unfavourite&title=$movie_imdbid'><button style='color:black;'>remove from favourites</button></a></center></div></div>";
        }
        echo "</tr></table>";
        echo "<h2>Watched</h2>";
        $sql = "select imdbid FROM $usersetstable where watched=1;";
        $res = mysqli_query($conn, $sql);
        echo "<table><tr>";
        $watched = 0;
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $watched++;
            if ($watched == 4) {
                echo "</tr><tr>";
                $watched = 1;
            }
            $url = file_get_contents("http://www.omdbapi.com/?i=" . $row['imdbid'] . "&apikey=$omdbapikey");
            $json = json_decode($url, true);
            $movie_title = $json['Title'];
            $movie_poster = $json['Poster'];
            $movie_year = $json['Year'];
            $movie_runtime = $json['Runtime'];
            $movie_rated = $json['Rated'];
            $movie_genre = $json['Genre'];
            $movie_imdbid = $json['imdbID'];
            $movie_plot = $json['Plot'];
            $movie_director = $json['Director'];
            $movie_writer = $json['Writer'];
            $movie_actors = $json['Actors'];
            $movie_imdbRating = $json['imdbRating'];

            echo "<td><center><div class='contain'>";
            echo "<img src='$movie_poster' class='image' style='width:100%;'></img>";
            echo "<div class='middle'><div class='text'>";
            $string = "document.getElementById('watched$movie_title').style.display='block'";
            echo '<br><br><button onclick="' . $string . '">View</button>';
            echo "</div></div></div></center>";
            echo "</td>";
            echo "<div id='watched$movie_title' class='modal'>";
            echo "<span onclick=\"document.getElementById('watched$movie_title').style.display='none'\" class='close' title='Close Modal'>&times;</span>
                            <div class='container' style='text-align: left;background-color: #252525;'>
                                <h3>$movie_title</h3>
                                <p>$movie_plot</p><pre>
                                <p>IMDB ID       $movie_imdbid</p>
                                <p>Year          $movie_year </p>
                                <p>Runtime       $movie_runtime </p>
                                <p>Rated         $movie_rated </p>
                                <p>Genre         $movie_genre </p>
                                <p>Director      $movie_director </p>
                                <p>Writer        $movie_writer </p>
                                <p>Actors        $movie_actors </p>
                                <p>imdbRating    $movie_imdbRating </p></pre>";

            $movietitle = str_replace(" ", "-", $movie_title);
            $youtubeapi_url = "https://www.googleapis.com/youtube/v3/search?key=$youtubeapikey&part=snippet&maxResults=1&type=video&q=$movietitle";
            $youtubeapidata = json_decode(file_get_contents($youtubeapi_url, true));
            $videoid = $youtubeapidata->items[0]->id->videoId;
            echo "<center><iframe width='420' height='345' src='https://www.youtube.com/embed/$videoid?controls=1'></iframe><br><br>Add to:<br>
            <a href='userfilms.php?mark=watchlater&title=$movie_imdbid'><button style='color:black;'>add to watch later</button></a>
            <a href='userfilms.php?mark=unwatched&title=$movie_imdbid'><button style='color:black;'>remove from watched</button></a>
            <a href='userfilms.php?mark=favourite&title=$movie_imdbid'><button style='color:black;'>add to favourites</button></a></center></div></div>";
        }
        echo "</tr></table>";
        echo "<h2>Watch later</h2>";
        $sql = "select imdbid FROM $usersetstable where watchlater=1;";
        $res = mysqli_query($conn, $sql);
        echo "<table><tr>";
        $watchlater = 0;
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $watchlater++;
            if ($watchlater == 4) {
                echo "</tr><tr>";
                $watchlater = 1;
            }
            $url = file_get_contents("http://www.omdbapi.com/?i=" . $row['imdbid'] . "&apikey=$omdbapikey");
            $json = json_decode($url, true);
            $movie_title = $json['Title'];
            $movie_poster = $json['Poster'];
            $movie_year = $json['Year'];
            $movie_runtime = $json['Runtime'];
            $movie_rated = $json['Rated'];
            $movie_genre = $json['Genre'];
            $movie_imdbid = $json['imdbID'];
            $movie_plot = $json['Plot'];
            $movie_director = $json['Director'];
            $movie_writer = $json['Writer'];
            $movie_actors = $json['Actors'];
            $movie_imdbRating = $json['imdbRating'];

            echo "<td><center><div class='contain'>";
            echo "<img src='$movie_poster' class='image' style='width:100%;'></img>";
            echo "<div class='middle'><div class='text'>";
            $string = "document.getElementById('watchlater$movie_title').style.display='block'";
            echo '<br><br><button onclick="' . $string . '">View</button>';
            echo "</div></div></div></center>";
            echo "</td>";

            echo "<div id='watchlater$movie_title' class='modal'>";
            echo "<span onclick=\"document.getElementById('watchlater$movie_title').style.display='none' \" class='close' title='Close Modal'>&times;</span>
                <div class='container' style='text-align: left;background-color: #252525;'>
                    <h3>$movie_title</h3>
                    <p>$movie_plot</p>
                    <pre>
                                    <p>IMDB ID       $movie_imdbid</p>
                                    <p>Year          $movie_year </p>
                                    <p>Runtime       $movie_runtime </p>
                                    <p>Rated         $movie_rated </p>
                                    <p>Genre         $movie_genre </p>
                                    <p>Director      $movie_director </p>
                                    <p>Writer        $movie_writer </p>
                                    <p>Actors        $movie_actors </p>
                                    <p>imdbRating    $movie_imdbRating </p></pre>";

            $movietitle = str_replace(" ", "-", $movie_title);
            $youtubeapi_url = "https://www.googleapis.com/youtube/v3/search?key=$youtubeapikey&part=snippet&maxResults=1&type=video&q=$movietitle";
            $youtubeapidata = json_decode(file_get_contents($youtubeapi_url, true));
            $videoid = $youtubeapidata->items[0]->id->videoId;
            echo "<center><iframe width='420' height='345' src='https://www.youtube.com/embed/$videoid?controls=1'></iframe><br><br>Add to:<br>
                        <a href='userfilms.php?mark=unwatchlater&title=$movie_imdbid'><button style='color:black;'>remove from watch later</button></a>
                        <a href='userfilms.php?mark=watched&title=$movie_imdbid'><button style='color:black;'>add to watched</button></a>
                        <a href='userfilms.php?mark=favourite&title=$movie_imdbid'><button style='color:black;'>add to favourites</button></a></center>
                </div>
            </div>";
        }
        echo "</tr></table>";
        ?>

    </div>
    <script>
        document.getElementById('smallnav').addEventListener('click', smallnav);

        function smallnav() {
            var x = document.getElementById('nav-right');
            if (x.style.display === 'block') {
                x.style.display = 'none';
            } else {
                x.style.display = 'block';
            }
        }
    </script>
</body>

</html>