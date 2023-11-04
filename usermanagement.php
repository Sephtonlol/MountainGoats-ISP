<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    echo '<script>alert("Je hebt geen toegang tot deze pagina.");</script>';
    echo '<script>window.location.href = "home.php";</script>';
    exit;
}

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}

$conn = new mysqli("localhost", "root", "", "phlogin");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submissions
    if (isset($_POST['create_user'])) {
        // Handle form submission to create a new user account
        // ...
    } elseif (isset($_POST['change_admin'])) {
        // Handle form submission to change the user's admin state
        $username = $_POST['username'];
        $newAdmin = isset($_POST['Admin']) ? $_POST['Admin'] : 0;
        $sql = "UPDATE accounts SET admin = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $newAdmin, $username);

        if ($stmt->execute()) {
            echo '<script>alert("Admin succesvol aangepast voor gebruiker(s)");</script>';
        } else {
            echo "Error changing admin state for user: $username - " . $stmt->error;
        }
    } elseif (isset($_POST['change_darkmode'])) {
        // Handle form submission to change dark mode state
        $username = $_POST['username'];
        $newDarkmode = isset($_POST['darkmode']) ? $_POST['darkmode'] : 0;
        $sql = "UPDATE accounts SET darkmode = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $newDarkmode, $username);

        if ($stmt->execute()) {
            echo '<script>alert("Dark Mode succesvol aangepast voor gebruiker(s)");</script>';
        } else {
            echo "Error changing dark mode state for user: $username - " . $stmt->error;
        }
    } elseif (isset($_POST['delete_user'])) {
        // Handle form submission to delete a user account
        $username = $_POST['username'];
        $sql = "DELETE FROM accounts WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            echo '<script>alert("Gebruiker succesvol verwijderd");</script>';
        } else {
            echo "Error deleting user: $username - " . $stmt->error;
        }
    }
}

// Query to retrieve a list of all users
$sql = "SELECT username, email, admin, darkmode FROM accounts";
$result = $conn->query($sql);
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
        <button onclick="window.location.href='home.php'" class="button1" id="mountainGoats">Mountain Goats</button>
        <button onclick="window.location.href='usermanagement.php'" class="button1">Admin</button>
        <button onclick="window.location.href='logout.php'" id="logout" class="button1">Logout</button>
        <button onclick="window.location.href='createacc.php'" class="button1">Maak account</button>
    </div>
</div>
<h1>Gebruikers beheer</h1>

<!-- User List -->
<table>
    <tr>
        <th>naam</th>
        <th>Email</th>
        <th>Admin</th>
        <th>Dark Mode</th>
        <th>Acties</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>" . ($row['admin'] == 1 ? "ja" : "nee") . "</td>";
            echo "<td>" . ($row['darkmode'] == 1 ? "ja" : "nee") . "</td>";

            echo "<td>
                    <form method='post'>
                        <input type='hidden' name='username' value='{$row['username']}'>
                        
                        <label for='new_admin'>Admin:</label>
                        <select name='Admin' id='Admin'>
                            <option value='1' " . ($row['admin'] == 1 ? "selected" : "") . ">Ja</option>
                            <option value='0' " . ($row['admin'] == 0 ? "selected" : "") . ">Nee</option>
                        </select>   
                        <input type='submit' name='change_admin' value='Verander'>

                        <label for='darkmode'>Dark Mode:</label>
                        <select name='darkmode' id='darkmode'>
                            <option value='1' " . ($row['darkmode'] == 1 ? "selected" : "") . ">Ja</option>
                            <option value='0' " . ($row['darkmode'] == 0 ? "selected" : "") . ">Nee</option>
                        </select>
                        <input type='submit' name='change_darkmode' value='Verander Dark Mode'>
                        
                        <input type='submit' name='delete_user' value='Verwijder gebruiker'>
                    </form>
                </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No users found.</td></tr>";
    }
    ?>
</table>
</body>
</html>
