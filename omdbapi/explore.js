document.getElementById('smallnav').addEventListener('click', smallnav);

function smallnav() {
    var x = document.getElementById('nav-right');
    if (x.style.display === 'block') {
        x.style.display = 'none';
    } else {
        x.style.display = 'block';
    }
}

var displaymovies = document.getElementById('displaymoviedetails');

var requestform = document.getElementById('getmovies');
var formstatus = document.getElementById('formstatus');
var movienamefield = document.getElementById('moviename');
var movieimdbidfield = document.getElementById('movieimdbid');
requestform.addEventListener('submit', loadrequestedmovies);
function loadrequestedmovies(e) {
    e.preventDefault();
    var moviename = movienamefield.value;
    var movieimdbid = movieimdbidfield.value;
    if (moviename || movieimdbid) {
        var xmlhttp = new XMLHttpRequest();
        var formData = new FormData();
        formData.append('action', 'requestmovie');
        formData.append('moviename', moviename);
        formData.append('movieimdbid', movieimdbid);
        displaymovies.innerHTML = "Please wait loading";
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                displaymovies.innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open('POST', 'explorephp.php');
        xmlhttp.send(formData);
    } else {
        formstatus.innerText = "Please fill atleast one field";
    }
}
displaypopularmovies = document.getElementById('displaypopularmovies');
function loadpopularmovies() {
    var xmlhttp = new XMLHttpRequest();
    var formData = new FormData();
    formData.append('action', 'requestpopularmovies');
    displaypopularmovies.innerHTML = "Please wait loading......";
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            displaypopularmovies.innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open('POST', 'explorephp.php');
    xmlhttp.send(formData);
}
loadpopularmovies();