<?php
// Include database connection file


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
include('db_connection.php'); 

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from both forms
    $topic = $_POST['topic']; // from first form
    $location = $_POST['location']; // from first form
    $beneficiary = $_POST['fundraise-option']; // from second form
    $goal = $_POST['goal']; // from second form
    $title = $_POST['title']; // from second form
    $description = $_POST['description']; // from second form

    // Handle image upload
    if (isset($_FILES['photo'])) {
        $photo = file_get_contents($_FILES['photo']['tmp_name']); // Get the image as binary data
    }

    // Get the user_id from the session or pass it as hidden in the form
    session_start();
    $user_id = $_SESSION['user_id']; // Assuming the user is logged in

    // Insert data into the database
    $sql = "INSERT INTO campaignDetails (user_id, topic, location, beneficiary, goal, title, description, photo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssiss", $user_id, $topic, $location, $beneficiary, $goal, $title, $description, $photo);

    // Execute the query
    if ($stmt->execute()) {
        echo "Campaign submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
}
?>
