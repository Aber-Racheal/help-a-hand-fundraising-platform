<?php

session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    
    // Use a prepared statement to fetch user data
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $user = $result->fetch_assoc();
}

// print_r($_SESSION);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if (isset($users)): ?>
        <p>Hello <?= htmlspecialchars($user["first_name"]) ?></p>

        <p><a href="logout.php">Logout</a></p>
        <?php else: ?>
            <p><a href="login.php">Login</a> or <a href="signu-up.html">sign up</a></p>
        <?php endif; ?>
</body>
</html>