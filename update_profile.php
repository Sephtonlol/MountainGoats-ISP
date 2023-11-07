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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // krijgt de data
    $email = $_POST['email'];
    $darkmode = isset($_POST['darkmode']) ? 1 : 0;

    // checked of een nieuw wachtwoord is ingediend
    if (!empty($_POST['password'])) {
        // checked the form als er een nieuw wachtwoord is
        $newPassword = $_POST['password'];
        // incrypt het wachtwoord voor security
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // update het wachtwoord in de database
        $stmt = $conn->prepare('UPDATE accounts SET password = ?, email = ?, darkmode = ? WHERE id = ?');
        $stmt->bind_param('ssii', $hashedPassword, $email, $darkmode, $_SESSION['id']);
    } else {
        // Update de email en darkmode status
        $stmt = $conn->prepare('UPDATE accounts SET email = ?, darkmode = ? WHERE id = ?');
        $stmt->bind_param('sii', $email, $darkmode, $_SESSION['id']);
    }

    $stmt->execute();
    $stmt->close();
}

$conn->close();

header('Location: profile.php');
exit;
?>
