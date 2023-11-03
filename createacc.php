<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Mountain Goats - Admin</title>
    <link rel="stylesheet" type="text/css" href="styleadmin.css">
</head>
<body>
<div class="topbar">
        
        <div>
            <button onclick="window.location.href='home.php'" class="button1">Mountain Goats</button>
            <button onclick="window.location.href='usermanagement.php'" class="button1">terug</button>
        </div>
</div>
<?php
    // Check if the user is an admin (You should have a better way to authenticate admins).
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle form submission
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $email = $_POST['email'];
            $admin = isset($_POST['admin']) ? 1 : 0; // Check if the admin checkbox is checked
            
            // Perform database query to insert the user account
            $conn = new mysqli("localhost", "root", "", "phlogin");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO accounts (username, password, email, admin) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $username, $password, $email, $admin);

            if ($stmt->execute()) {
                echo '<script>alert("Account aangemaakt");</script>';
            } else {
                echo '<script>alert("Account maken mislukt");</script>' . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        echo '<script>"U bent niet bevoegd om accounts toe te voegen");</script>';
        echo '<script>window.location.href = "home.php";</script>';
    }
    ?>
    <div class="user-form-container">
        <h1 class="page-title">Maak account</h1>
        <form class="user-form" method="post">
            <label for="username">Gebruikersnaam:</label>
            <input type="text" name="username" id="username" required><br>

            <label for="password">Wachtwoord:</label>
            <input type="password" name="password" id="password" required><br>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br>

            <label for="admin">Admin:</label>
            <input type="checkbox" name="admin" id="admin" value="1"><br>

            <input type="submit" class="submit-button" value="Maak account">
        </form>
    </div>
</body>
</html>
