<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phlogin';
// connect met de bovenstaande info
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // check voor errors
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// check of de data is gesumbit
if (!isset($_POST['username'], $_POST['password'])) {
    // kon niet de data krijgen
    exit('Please fill both the username and password fields!');
}
// Bereid onze SQL voor, het voorbereiden van de SQL-instructie voorkomt SQL-injectie.
if ($stmt = $con->prepare('SELECT id, password, admin, darkmode FROM accounts WHERE username = ?')) {
    // Bindparameters (s = string, i = int, b = blob, enz.), in ons geval is de gebruikersnaam een string, dus we gebruiken "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // bewaar resultaat en stuur het naar de database
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $admin, $darkmode);
        $stmt->fetch();
        // als account bestaat
        if (password_verify($_POST['password'], $password)) {
            // Verifieer login
            // Crieere sessie
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            $_SESSION['admin'] = $admin; // beware admin status
            $_SESSION['darkmode'] = $darkmode;
            $_SESSION['username'] = $username;
            header('Location: home.php');
        } else {
            // fout wachtwoord
            echo '<script>alert("Gebruikersnaam en/of wachtwoord zijn incorrect");</script>';
            echo '<script>window.location.href = "index.html";</script>';
        }
    } else {
        // fout username
        echo '<script>alert("Gebruikersnaam en/of wachtwoord zijn incorrect");</script>';
        echo '<script>window.location.href = "index.html";</script>';
    }

    $stmt->close();
}
?>
