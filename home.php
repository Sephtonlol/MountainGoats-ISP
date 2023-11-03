<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$conn = new mysqli("localhost", "root", "", "phlogin");

if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == 1) {

    echo('<script>
    function toggleDarkTheme() {
        document.body.classList.toggle("dark-theme");
    }

    window.onload = function() {
        toggleDarkTheme();
    };
    </script>');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mountain Goats Page</title>
<link rel="stylesheet" href="style.css">
<script src="main.js" defer></script>
</head>

<body>

    <div class="topbar">
        
        <div>
            <button class="button1" id="mountainGoats">Mountain Goats</button>
            <button onclick="window.location.href='usermanagement.php'" class="button1">Admin</button>
            <button id="helpButton" class="button1">Help</button>

        </div>
        <input type="text" class="searchBox" id="searchBox" placeholder="zoeken..." onkeydown="search(event)">
        <img src="./Assets/moon.png" id="icon">
        <button onclick="window.location.href='logout.php'" class="button1">Uitloggen</button>
        <button onclick="window.location.href='profile.php'" class="button1">Profiel</button>
    </div>
    <div class="nottopbar">
        <div>
    <button class="button2-1" onclick="window.open('https://outlook.office.com/mail/?actSwt=true', '_blank');" id="button2">e-mail</button>
    <button class="button2" onclick="window.open('https://www.stichtingpraktijkleren.nl/inloggen/');" id="button3">spl</button>
    <button class="button2" id="button4">translate</button>

    <br>

    <button style="margin-top: 20px;" class="button2-2" onclick="window.open('https://www.office.com', '_blank');" id="button5">office</button>
    <button style="margin-top: 20px;" class="button2" onclick="window.open('https://vistacollege-student.educus.nl/?2', '_blank');" id="button6">eduarte</button></a>
    <button style="margin-top: 20px;" class="button2" id="button7">bing AI</button>
        </div>
        <iframe src = "" class="search-container" id="searchFrame" frameborder="5"></iframe>
    </div>
</body>
</html>