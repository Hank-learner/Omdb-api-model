<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Saira+Semi+Condensed&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">

</head>

<body>

    <nav id="navigation">
        <a class="logo active">Omdb-api</a>
        <div id="nav-right">
            <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <a href="explore.php"><i class="fa fa-files-o"></i> Explore</a>
        </div>
        <div id="smallnav-right">
            <a id="smallnav"><i class="fa fa-bars"></i></a>
        </div>
    </nav>
    <div id="forms">
        <div>
            <form id="signin">
                <h2>Sign - in</h2>
                <div id="demo1"></div>
                <div class="input-container">
                    <i class="fa fa-user icon"></i>
                    <input type="text" value="" id="usernamesignin" placeholder="Username or Email" required="true" class="input-field">
                </div>
                <div class="input-container">
                    <i class="fa fa-key icon"></i>
                    <input type="password" value="" id="passwordsignin" placeholder="Password" required="true" class="input-field">
                </div>
                <button type="submit" class="submitbtn" id="signinsubmit"> Login</button>
                <br><br>
                Don't have an account?
                <br>
                Then register by Signing up
            </form>
        </div>
        <div>
            <form id="signup">
                <h2>Sign - up</h2>
                <div id="demo2"></div>
                <div class="input-container">
                    <i class="fa fa-user icon"></i>
                    <input class="input-field" type="text" id="usernamesignup" minlength="5" placeholder="Username" value="" required="true">
                </div>

                <div class="input-container">
                    <i class="fa fa-envelope icon"></i>
                    <input class="input-field" type="email" id="emailsignup" placeholder="Email" value="" required="true">
                </div>

                <div class="input-container">
                    <i class="fa fa-key icon"></i>
                    <input class="input-field" type="password" id="passwordsignup" minlength="8" placeholder="Password" value="" required="true">
                </div>

                <button type="submit" class="submitbtn" id="signupsubmit">Register</button>
            </form>
        </div>
    </div>
    <script src="index.js"></script>

</body>

</html>