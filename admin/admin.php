<?php
require_once('../util/main.php');
include '../view/header.php';
require_once('../model/database.php');
require_once('../model/admin_db.php');

//sets the username and password to the session username/password
$username = $_SESSION['username'];
$password = $_SESSION['password'];

//checks if the username input is not empty to set the session username
if (empty($username)) {
    $username = filter_input(INPUT_POST, 'admin_username');
    $_SESSION['username'] = $username;
}

//checks if the password input is not empty to set the session password
if (empty($password)) {
    $password = filter_input(INPUT_POST, 'admin_password');
    $_SESSION['password'] = $password;
}

if (empty($username) || $username === null) {
    $error = "Username field cannot be empty. Please enter your username.";
} elseif (empty($password) || $password === null) {
    $error = "Password field cannot be empty. Please enter your password.";
} else {
    $admin = get_admin_login($username, $password);

    if ($admin == null) {
        $error = "Incorrect username or password. Please try again.";
    }
}

// if an error message exists, go to the index page
if (!empty($error)) {
    header("Location: index.php?error=" . urlencode($error));
    exit();
}

//session logout
if (isset($_POST['logout'])) {
    session_start();
    unset($_SESSION);
    session_destroy();
    session_write_close();
    header('Location: ../index.php');
    die;
}
?>
<main>
    <nav>

        <h2>Admin Menu</h2>
        <ul>
            <li><a href="../admin/coaches">Manage Coaches</a></li>
            <li><a href="../admin/drills">Manage Drills</a></li>
            <li><a href="../admin/categories">Manage Categories</a></li>
            <li><a href="../admin/drills/approve_drill_list.php">Approve Drills</a></li>
        </ul><br>
        <h2>Login Status</h2>
        <form action="" method="post" id="logout">
            <span>You are logged in as <?php echo $username; ?></span><br>
            <input type="submit" name="logout" value="Logout"><br>
        </form>
    </nav>
</section>

<?php
include '../view/footer.php';
?>