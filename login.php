<?php
session_start();

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error']; // Retrieve error message from session
    unset($_SESSION['error']); // Clear the error message after displaying it
} else {
    $error = null; // Initialize error variable if not set
}
?>
<!DOCTYPE html>
<html lang="en" >
<body>
<head>
    <title>Nalipiri Eco Resort - Login</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="php/login.php" method="POST">
        <!-- display error message -->
        <?php if(!empty($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <h3>Login Here</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Email or Phone" name="username">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" name="password">

        <button type="submit" name="submit">Login</button>
        <div class="home-link">
            <a href="index.php">Exit</a>
        </div>
        
        <!-- <div class="social">
          <div class="go"><i class="fab fa-google"></i>  Google</div>
          <div class="fb"><i class="fab fa-facebook"></i>  Facebook</div>
        </div> -->
    </form>
</body>
</html>
