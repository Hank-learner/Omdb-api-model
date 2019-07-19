<?php
include_once('sqlinitialisation.php');
include_once('config.php');

$usernameget = $_POST["username"];
$emailget = $_POST["email"];
$passwordget = $_POST["password"];

if (!$usernameget || !$passwordget) {
    header("Location: index.php");
}

$username = mysqli_real_escape_string($conn, $_POST["username"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);


if ($username != $usernameget || preg_match('/\s/', $usernameget)) {
    die("<div style='
                background-color: rgb(172, 53, 53);
                padding: 5px;
                border: 2px solid red';
                border-radius:5px>
                Unable to create user <br>
                username should not contain special charachters and spaces
                </div><br>");
} elseif ($email != $emailget || preg_match('/\s/', $emailget)) {
    die("<div style='
                background-color: rgb(172, 53, 53);
                padding: 5px;
                border: 2px solid red';
                border-radius:5px>
                Unable to create user <br>
                email should not contain special charachters and spaces
                </div><br>");
} elseif ($password != $passwordget || preg_match('/\s/', $passwordget)) {
    die("<div style='
                background-color: rgb(172, 53, 53);
                padding: 5px;
                border: 2px solid red';
                border-radius:5px>
                Unable to create user <br>
                password should not contain special charachters and spaces
                </div><br>");
}

if ($email) {
    $hashpassword = password_hash($password, PASSWORD_BCRYPT);
    $sqlins = "INSERT INTO userdetails VALUES ('$username','$email','$hashpassword');";
    try {
        if (strlen($username) > 4 && strlen($email) > 4 && strlen($password) > 7) {
            if ($conn) {
                $sql = "CREATE TABLE user_$username (imdbid varchar(10) not null,favourite int,watched int,watchlater int);";
                if (mysqli_query($conn, $sql)) {
                    mysqli_query($conn, $sqlins);
                    echo "
                    <div style=' background-color: rgb(58, 148, 58);
                    padding:  5px;
                    border:  2px solid green';
                    border-radius:5px>
                    User successfully created
                    </div><br>";
                } else {
                    echo "<div style ='
                                background-color: rgb(172, 53, 53);
                                padding: 5px;
                                border: 2px solid red';
                                border-radius:5px>
                                <li>unable to create user </li> 
                                <br>
                                <li>user already exists</li>
                                <br>
                                <li>Try any other username</li>
                                </div><br>";
                }
            } else {
                echo "unable to create user  <br>" . mysqli_error($conn);
            }
        } else {
            echo "<div style ='
                        background-color: rgb(172, 53, 53);
                        padding: 5px;
                        border: 2px solid red';
                        border-radius:5px>
                        Fill all the fields with required lengths
                        </div><br>";
        }
    } catch (Exception $e) {
        echo "<div style ='
                        background-color: rgb(172, 53, 53);
                        padding: 5px;
                        border: 2px solid red';
                        border-radius:5px>
                        please fill all fields <br>" . $e->getMessage()
            . "</div><br>";
    }
} else {

    $sql = "SELECT username,email,password FROM userdetails;";
    try {
        if (strlen($username) > 4 && strlen($password) > 7) {
            $userdetailstable = mysqli_query($conn, $sql);
            $userdetailsrows = mysqli_num_rows($userdetailstable);
            $loginsuccess = 0;

            for ($i = 0; $i < $userdetailsrows; $i++) {
                $userdetailsrowdata = mysqli_fetch_assoc($userdetailstable);
                $userdetailsusername[$i] = $userdetailsrowdata['username'];
                $userdetailsemail[$i] = $userdetailsrowdata['email'];
                $userdetailspassword[$i] = $userdetailsrowdata['password'];
                if (($username == $userdetailsusername[$i] || $username == $userdetailsemail[$i]) && password_verify($password, $userdetailspassword[$i])) {
                    $_SESSION['username'] = $userdetailsusername[$i];
                    $loginsuccess = 1;
                }
            }
            if ($loginsuccess == 1) {
                echo "<div id='loginmessage' style='
                    background-color: rgb(58, 148, 58);
                    padding:  5px;
                    border:  2px solid green';
                    border-radius:5px>logging in please wait</div><br>";
            } else {
                echo "<div style='
                background-color: rgb(172, 53, 53);
                padding: 5px;
                border: 2px solid red';
                border-radius:5px>
                invalid user credentials
                </div><br>";
            }
        } else {
            echo "<div style='
                background-color: rgb(172, 53, 53);
                padding: 5px;
                border: 2px solid red';
                border-radius:5px>
                invalid user credentials
                </div><br>";
        }
    } catch (Exception $e) {
        echo "<div style='
                background-color: rgb(172, 53, 53);
                padding: 5px;
                border: 2px solid red';
                border-radius:5px>
                please fill all the fields correctly <br> " . $e->getMessage()
            . "</div><br>";
    }
}
