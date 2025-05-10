<?php
session_start();
include 'database.php';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id;

    $stmt = $conn->prepare("SELECT * FROM customer WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $customer_id = $result['id']; // Fetch the user_id from the query result

    if ($stmt->rowCount() > 0) {
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['customer_id'] = $customer_id;
        header("Location: ../user_dashboard.php"); // Redirect to dashboard page
        exit(); // Ensure no further code is executed after the redirect
    } else {
        $_SESSION['error'] = "Invalid username or password"; // Set error message in session
        header("Location: ../login.php"); // Redirect to dashboard page
        exit(); // Ensure no further code is executed after the alert
    }
} else {
    $_SESSION['error'] = "Invalid login attempt"; // Set error message in session
    header("Location: ../user_dashboard.php"); // Redirect to dashboard page
    exit(); // Ensure no further code is executed if the request method is not POST
}
?>