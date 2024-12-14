<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";
    $email = $_POST["email"];

    // Check if the email exists in the database
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Generate a unique token for the password reset
        $token = bin2hex(random_bytes(50));
        $stmt = $mysqli->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Send the password reset email
        $resetLink = "http://localhost/helpahelperwebsite/reset-password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: " . $resetLink;
        $headers = "From: no-reply@helpahelperwebsite.com";

        // Send the email
        mail($email, $subject, $message, $headers);


        echo "A password reset link has been sent to your email.";
    } else {
        echo "Email not found in our records.";
    }
}
?>

<!-- Forgot Password Form -->
<form method="POST" action="forgot-password.php">
    <label for="email">Enter your email:</label>
    <input type="email" id="email" name="email" placeholder="Your email" required>
    <button type="submit">Submit</button>
</form>