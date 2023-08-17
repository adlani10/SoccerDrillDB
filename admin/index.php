<?php
require_once('../util/main.php');
include '../view/header.php';

// Clear session variables
unset($_SESSION['username']);
unset($_SESSION['password']);

// Get the value of 'username' from the session
$username = $_SESSION['username'];

// If 'username' is not empty, redirect to the admin page
if (!empty($username)) {
    header('Location: admin.php');
    exit;
}
?>

<main>

    <?php if (!empty($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <h2>Admin Login</h2>
    <div id="aligned">
        <form action="admin.php" method="post" id="admin">
            <label>Username:</label>
            <input type="text" name="admin_username"><br>
            <label>Password:</label>
            <input type="password" name="admin_password"><br>
            <label>&nbsp;</label>
            <input type="submit" name="submit" value="Login"><br>
        </form>
    </div>

    <?php include '../view/footer.php'; ?>
