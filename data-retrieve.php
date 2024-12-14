<?php
include('database.php');

$sql = "SELECT id, first_name, last_name, hashed_password, email FROM users";
$result = $mysqli->query($sql);


if ($result->num_rows > 0) {
   
    while($row = $result->fetch_assoc()) {
        
        echo "<br> Data retrieved successfully <br> id: " . $row["id"] . " - First Name: " . $row["first_name"] . " - Last Name: " . $row["last_name"] . "- Password" . $row["hashed_password"] . " - Email: " . $row["email"] . "<br>";
    }
} else {
    echo "0 results";
}

// Close the connection
$mysqli->close();

?>
