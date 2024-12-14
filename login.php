<?php
session_start(); // Make sure session starts before any output

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    // Prepare the SQL query using a prepared statement
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_assoc();

    // Check if the user exists and if password is correct
    if ($users) {
        if (password_verify($_POST["password"], $users["hashed_password"])) {
            session_regenerate_id(); // Create a new session ID to avoid session fixation attacks
            $_SESSION["user_id"] = $users["id"];
            header("Location: index.html"); // Redirect to the homepage after successful login
            exit;
        } else {
            $is_invalid = true; // Password does not match
        }
    } else {
        $is_invalid = true; // User does not exist
    }
}

// Error message (if login fails)
if ($is_invalid) {
    echo "Invalid login credentials. Please try again.";
}
?>
