<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Check if the confirm_password field exists in the POST data
if (!isset($_POST["confirm_password"])) {
    die("Confirm password not set. Make sure the form is submitting correctly.");
}


// Sanitize the first name, last name, and email, trim spaces, and ensure proper format
$first_name = trim($_POST["first_name"]);
$last_name = trim($_POST["last_name"]);
$email = trim($_POST["email"]);
$password = $_POST["password"]; // Password doesn't need sanitization
$confirmPassword = $_POST["confirm_password"]; // Get the confirm password



// Check if password and confirm password match
if ($password !== $confirmPassword) {
    die("Passwords do not match! Please try again.");
}


// Check if input fields are empty   
if (empty($first_name)) {
    die("First name is required");
}

if (empty($last_name)) {
    die("Last name is required");
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address");
}

// Check password strength
if (strlen($password) < 8) {
    die("Password must be at least 8 characters long");
}

if (!preg_match("/[a-z]/i", $password)) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $password)) {
    die("Password must contain at least one number");
}

// Further sanitize the user inputs to prevent XSS attacks
$first_name = htmlspecialchars($first_name);
$last_name = htmlspecialchars($last_name);
$email = htmlspecialchars($email);

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Database Connection
$mysqli = require __DIR__ . "/database.php";


// Check if email already exists in the database
$email_check_query = "SELECT * FROM users WHERE email = ?";
$stmt_check = $mysqli->prepare($email_check_query);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    die("Email is already taken.");
}

// Insert query
$sql = "INSERT INTO users (first_name, last_name, email, hashed_password) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

// Bind parameters to the prepared statement
$stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

if ($stmt->execute()) {
    header("Location: signup-successful.html");
    exit;
} else {
    if ($mysqli->errno === 1062) {
        die("Email is already taken");
    } else {
        die("Error executing query: " . $mysqli->error . " (" . $mysqli->errno . ")");
    }
}


// Debugging: Print out all the POST data
echo "<pre>";
print_r($_POST);
echo "</pre>";
exit;

?>
