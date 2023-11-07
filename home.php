<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$conn = new mysqli("localhost", "root", "", "phlogin");

if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == 0) {

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
<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="AjaxPush.js"></script>
</head>

<body>
<div class="popup-overlay">
  <div class="popup-image">
    <img id="popupImage" src="" alt="Popup Image">
    <span class="popup-imsgespan">Sluiten</span>
  </div>
</div>
    <div class="topbar">
        
        
        <div>
            <button class="button1" id="mountainGoats">Mountain Goats</button>
            <button onclick="window.location.href='usermanagement.php'" class="button1">Admin</button>
            <button id="helpButton" class="button1">Help</button>
        </div>
        <input type="text" class="searchBox" id="searchBox" placeholder="zoeken..." onkeydown="search(event)">
        <img src="./Assets/profile.png" id="icon" onclick="window.location.href='profile.php'">
    </div>
    <div class="nottopbar">
        <div>
            <div>
    <button class="button2-1" onclick="window.open('https://outlook.office.com/mail/?actSwt=true', '_blank');" id="button2">E-mail</button>
    <button class="button2" onclick="window.open('https://www.stichtingpraktijkleren.nl/inloggen/');" id="button3">SPL</button>
    <button class="button2" id="button4">Translate</button>

    <br>

    <button style="margin-top: 20px;" class="button2-2" onclick="window.open('https://www.office.com', '_blank');" id="button5">Office</button>
    <button style="margin-top: 20px;" class="button2" onclick="window.open('https://vistacollege-student.educus.nl/?2', '_blank');" id="button6">Eduarte</button></a>
    <button style="margin-top: 20px;" class="button2" id="button7">Bing AI</button>
</div class="nottopbar">
	<script type="text/javascript">
		var comet = new AjaxPush('listener.php', 'sender.php');
		var n = new Function("return (Math.random()*190).toFixed(0)");

		// create anonymous users
		var c = "rgb(" + n() + ", " + n() + "," + n() + ")";
		var template = "<strong style='color: " + c + "'>" + <?php echo json_encode($_SESSION['name']); ?> + "</strong>: ";

		// listener

		// sender
		var send = function() {
			comet.doRequest({ message: template + $("#message").val() + "<br>" }, function(){
				$("#message").val('').focus();
			})
		}
        comet.connect(function(data) {
    $("#history").append(data.message + "<br>");
    // Automatisch naar beneden scrollen
    $("#history").scrollTop($("#history")[0].scrollHeight);
});

        
	</script>
	<div class="chatBox" id="history"></div>
    <div class="inputChatBox">
    <input type="text" autofocus id="message" placeholder="Jouw bericht">
	<button onclick="send()">Stuur</button><br><br>
    </div>
</div>
        <iframe src = "" class="search-container" id="searchFrame" frameborder="5"></iframe>
    </div>
</body>
</html>
