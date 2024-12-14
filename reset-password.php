<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    $token = $_GET["token"];

    // Check if the token exists in the database
    $mysqli = require __DIR__ . "/database.php";
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verify the new passwords match
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the user's password and remove the reset token
            $stmt = $mysqli->prepare("UPDATE users SET hashed_password = ?, reset_token = NULL WHERE reset_token = ?");
            $stmt->bind_param("ss", $hashed_password, $token);
            $stmt->execute();

            echo "Your password has been successfully reset. You can now <a href='login.php'>login</a> with your new password.";
        } else {
            echo "Passwords do not match.";
        }
    } else {
        echo "Invalid token.";
    }
}
?>

<!-- Reset Password Form -->
<form method="POST" action="reset-password.php?token=<?php echo $_GET['token']; ?>">
    <label for="new_password">New Password:</label>
    <input type="password" id="new_password" name="new_password" required>

    <label for="confirm_password">Confirm New Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>

    <button type="submit">Reset Password</button>
</form>
