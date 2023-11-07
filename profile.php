<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phlogin';

$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare('SELECT password, email, darkmode FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $darkmode);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<?php
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
    <meta charset="utf-8">
    <title>Profile Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="loggedin">
    <nav class="navtop">
        <!-- topbar knoppen -->
        <div class="topbar">
            <button onclick="window.location.href='home.php'" class="button1" id="mountainGoats">Mountain Goats</button>
            <button onclick="window.location.href='usermanagement.php'" class="button1">Admin</button>
            <button onclick="window.location.href='logout.php'" id="logout" class="button1">uitloggen</button>
			<img src="./Assets/profile.png" id="icon" onclick="window.location.href='profile.php'">
        </div>
    </nav>
    <!-- edit profiel knoppen -->
    <div class="content2">
        <div class="nottopbar">
            <form action="update_profile.php" method="POST">
				<div>
                <table class="profileBox">
                    <tr> 
                        <td>Naam</td>
                        <td><?=$_SESSION['name']?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="email" name="email" value="<?=$email?>"></td>
                    </tr>
					<tr>
                        <td>Wachtwoord</td>
                        <td><input type="password" name="password" placeholder="<?=$password?>"></td>
                    </tr>
                    <tr>
                        <td>Darkmode</td>
                        <td><input type="checkbox" name="darkmode" <?=$darkmode == 1 ? 'checked' : ''?>></td>
                    </tr>
                </table >
                <!-- submit knop -->
                <input type="submit" value="wijzigingen opslaan" class="profilesubmit">
</div>
            </form>
        </div>
    </div>
</body>
</html>
