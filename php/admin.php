<?php
session_start();
include '../php/database.php';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id;

    $stmt = $conn->prepare("SELECT * FROM `admin` WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $admin_id = $result['id']; // Fetch the user_id from the query result

    if ($stmt->rowCount() > 0) {
        $_SESSION['logged'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_id'] = $admin_id;
        header("Location: ../admin/admin_dashboard.php"); // Redirect to dashboard page
        exit(); // Ensure no further code is executed after the redirect
    } else {
        $_SESSION['error'] = "Invalid username or password"; // Set error message in session
        header("Location: ../admin/index.php?invalid_credentials"); // Redirect to dashboard page
        exit(); // Ensure no further code is executed after the alert
    }
} else {
    echo "<script>alert(Invalid login attempt.)</script>";
    header("Location: ../admin/index.php"); // Redirect to dashboard page
    exit(); // Ensure no further code is executed if the request method is not POST
}
?>