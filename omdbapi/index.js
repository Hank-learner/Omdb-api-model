document.getElementById ('smallnav').addEventListener ('click', smallnav);
function smallnav () {
  var x = document.getElementById ('nav-right');
  if (x.style.display === 'block') {
    x.style.display = 'none';
  } else {
    x.style.display = 'block';
  }
}

var signinform = document.getElementById ('signin');
signinform.addEventListener ('submit', signinfunction);

function signinfunction (event) {
  var validity = signinform.checkValidity ();
  if (validity) {
    var usernamevalue = document.getElementById ('usernamesignin').value;
    var passwordvalue = document.getElementById ('passwordsignin').value;
    var elements = ['username', 'password'];
    var elementsvalue = [usernamevalue, passwordvalue];
    var formData = new FormData ();
    for (var i = 0; i < elements.length; i++) {
      formData.append (elements[i], elementsvalue[i]);
    }
    var xmlHttp = new XMLHttpRequest ();
    xmlHttp.onreadystatechange = function () {
      if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        var demo1 = document.getElementById ('demo1');
        demo1.innerHTML = xmlHttp.responseText;
        var loginmessage = document.getElementById ('loginmessage');
        if (loginmessage.innerText === 'logging in please wait') {
          window.location.href = 'home.php';
        }
      }
    };
    xmlHttp.open ('post', 'login.php');
    xmlHttp.send (formData);
  } else {
    document.getElementById ('demo1').innerHTML = validity.validationMessage;
  }
  event.preventDefault ();
}

var signupform = document.getElementById ('signup');
signupform.addEventListener ('submit', signupfunction);

function signupfunction (event) {
  var validity = signupform.checkValidity ();
  if (validity) {
    var usernamevalue = document.getElementById ('usernamesignup').value;
    var useremailvalue = document.getElementById ('emailsignup').value;
    var userpasswordvalue = document.getElementById ('passwordsignup').value;
    var elements = ['username', 'email', 'password'];
    var elementsvalue = [usernamevalue, useremailvalue, userpasswordvalue];
    var formData = new FormData ();
    for (var i = 0; i < elements.length; i++) {
      formData.append (elements[i], elementsvalue[i]);
    }
    var xmlHttp = new XMLHttpRequest ();
    xmlHttp.onreadystatechange = function () {
      if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        var demo2 = document.getElementById ('demo2');
        demo2.innerHTML = xmlHttp.responseText;
        document.getElementById ('usernamesignup').value = '';
        document.getElementById ('emailsignup').value = '';
        document.getElementById ('passwordsignup').value = '';
      }
    };
    xmlHttp.open ('post', 'login.php');
    xmlHttp.send (formData);
  } else {
    document.getElementById ('demo2').innerHTML = validity.validationMessage;
  }
  event.preventDefault ();
}
