<?php
session_start();

$action = $_POST['action'];

$omdbapikey = "your8digitkeyhere";
$youtubeapikey = "your40digitkeyhere";

if (!$action) {
    header("Location: explore.php");
}


if ($action == 'requestmovie') {
    try {
        $imdbmovieid = $_POST['movieimdbid'];
        $moviename = $_POST['moviename'];

        if ($moviename == '' && $imdbmovieid == '')
            die(header("Location: explore.php"));


        if ($imdbmovieid != '') {
            $url = file_get_contents("http://www.omdbapi.com/?i=$imdbmovieid&apikey=$omdbapikey");
        }

        if ($moviename != '') {
            $imdbmoviename = str_replace(" ", "-", $moviename);
            $url = file_get_contents("http://www.omdbapi.com/?t=$imdbmoviename&apikey=$omdbapikey");
        }

        $omdbapidata = json_decode($url, true);
        $movie_title = $omdbapidata['Title'];
        $movie_plot = $omdbapidata['Plot'];
        $movie_poster = $omdbapidata['Poster'];
        $movie_imdbid = $omdbapidata['imdbID'];
        $movie_year = $omdbapidata['Year'];
        $movie_runtime = $omdbapidata['Runtime'];
        $movie_rated = $omdbapidata['Rated'];
        $movie_genre = $omdbapidata['Genre'];
        $movie_director = $omdbapidata['Director'];
        $movie_writer = $omdbapidata['Writer'];
        $movie_actors = $omdbapidata['Actors'];
        $movie_imdbRating = $omdbapidata['imdbRating'];


        if ($movie_title != "") {
            echo "<table><tr>";
            $string = "document.getElementById('$movie_title').style.display='block'";
            echo "<td><center><div class='contain'>";
            echo "<img src='$movie_poster' class='image' style='width:100%;height:100%;'></img>";
            echo "<div class='middle'><div class='text'><br><strong>$movie_title</strong><br><br>" . substr($movie_plot, 0, 60);
            if (strlen($movie_plot) > 60)
                echo "...";
            echo "<br><br>" . substr($movie_genre, 0, 20);
            if (strlen($movie_genre) > 20)
                echo "...";
            echo '<br><br><button onclick="' . $string . '">View</button>';
            echo "</div></div></div><center></td>";
            echo "<div id='$movie_title' class='modal'>";
            echo "<span onclick=\"document.getElementById('$movie_title').style.display='none'\" class='close' title='Close Modal'>&times;</span>
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
            <a href='userfilms.php?mark=favourite&title=$movie_imdbid'><button style='color:black;'>add to favourites</button></a></center></div></div>";
            echo "</tr></table>";
        } else if ($moviename != '' || $imdbmovieid != '') {
            echo "No results found for the movie check below for info <br><a href='http://www.o mdbapi.com/?t=$imdbmov iename&apikey=$omdbapikey'>See  raw result</a>";
        }
    } catch (Exception $e) {
        echo "there was a error in the process of g et ting info about the movie $e";
    }
} else if ($action == 'requestpopularmovies') {
    $movietitlestart = array('toy', 'annabelle', 'aladdin', 'john', 'men', 'godzilla', 'avengers', 'hell', 'b', 'd', 't', 'pet', 'monsters', 'spider', 'wonder', 'escape', 'sherlock', 'game', 'friends');
    $imdb_ids = array();
    $totalno = 0;
    echo "<table><tr>";
    for ($i = 0; $i < count($movietitlestart); $i++) {
        $movienamestart = $movietitlestart[$i];
        $count = 0;
        $url = file_get_contents("http://www.omdbapi.com/?apikey=$omdbapikey&y=2019&t=$movienamestart*");
        $omdbapidata = json_decode($url, true);
        $movie_title = $omdbapidata['Title'];
        $movie_poster = $omdbapidata['Poster'];
        $movie_year = $omdbapidata['Year'];
        $movie_runtime = $omdbapidata['Runtime'];
        $movie_rated = $omdbapidata['Rated'];
        $movie_genre = $omdbapidata['Genre'];
        $movie_imdbid = $omdbapidata['imdbID'];
        $movie_plot = $omdbapidata['Plot'];
        $movie_director = $omdbapidata['Director'];
        $movie_writer = $omdbapidata['Writer'];
        $movie_actors = $omdbapidata['Actors'];
        $movie_imdbRating = $omdbapidata['imdbRating'];


        for ($j = 0; $j < count($imdb_ids); $j++) {
            if ($movie_imdbid == $imdb_ids[$j])
                $count++;
        }
        if ($count == 0) {
            $imdb_ids[$totalno] = $movie_imdbid;
            $string = "document.getElementById('$movie_title').style.display='block'";
            echo "<td><center><div class='contain'>";
            echo "<img src='$movie_poster' class='image' style='width:100%;height:100%;'></img>";
            echo "<div class='middle'><div class='text'><br><strong>$movie_title</strong><br><br>" . substr($movie_plot, 0, 60);
            if (strlen($movie_plot) > 60)
                echo "...";
            echo "<br><br>" . substr($movie_genre, 0, 20);
            if (strlen($movie_genre) > 20)
                echo "...";
            echo '<br><br><button onclick="' . $string . '">View</button>';
            echo "</div></div></div><center></td>";
            $totalno++;
        }
        if ($totalno % 3 == 0)
            echo "</tr><tr>";


        echo "<div id='$movie_title' class='modal'>";
        echo "<span onclick=\"document.getElementById('$movie_title').style.display='none'\" class='close' title='Close Modal'>&times;</span>
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
        $youtubeapi_url = "https://www.googleapis.com/youtube/v3/search?key=$youtubeapikey&part=snippet&maxResults=1&type=video&q=$movietitle&controls=1";
        $youtubeapidata = json_decode(file_get_contents($youtubeapi_url, true));
        $videoid = $youtubeapidata->items[0]->id->videoId;
        echo "<center><iframe width='420' height='345' src='https://www.youtube.com/embed/$videoid?controls=1'></iframe><br><br>Add to:<br>
            <a href='userfilms.php?mark=watchlater&title=$movie_imdbid'><button style='color:black;'>add to watch later</button></a>
            <a href='userfilms.php?mark=watched&title=$movie_imdbid'><button style='color:black;'>add to watched</button></a>
            <a href='userfilms.php?mark=favourite&title=$movie_imdbid'><button style='color:black;'>add to favourites</button></a></center>
            </div>
					</div>";
    }
    echo "</tr></table>";
} else {
    echo "no action specified";
}
