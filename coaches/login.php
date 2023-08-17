<?php
require_once('../util/main.php');
include '../view/header.php';
require_once('../model/database.php');
require_once('../model/coach_db.php');

// Clear session variables
unset($_SESSION['coach_email']);
unset($_SESSION['coach_password']);

//sets the username and password to the session username/password
$email = $_SESSION['coach_email'];
$password = $_SESSION['coach_password'];

//checks if the email input is not empty to set the session username
if (empty($email)) {
    $email = filter_input(INPUT_POST, 'coach_email');
    $_SESSION['coach_email'] = $email;
}

//checks if the password input is not empty to set the session password
if (empty($password)) {
    $password = filter_input(INPUT_POST, 'coach_password');
    $_SESSION['coach_password'] = $password;
}

if (isset($_POST['submit'])) {
    if (empty($email) || $email === null) {
        $error = "Email field cannot be empty. Please enter your email.";
    } elseif (empty($password) || $password === null) {
        $error = "Password field cannot be empty. Please enter your password.";
    } else {
        $coach = get_coach_login($email, $password);

        if ($coach == null) {
            $error = "Incorrect email or password. Please try again.";
        } else {
            // Set the username and password sessions
            $_SESSION['username'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['coach_id'] = $coach[0]['coachID'];

            // Redirect to the index page
            header("Location: index.php");
            exit();
        }
    }

    // if an error message exists, go to the index page
    if (!empty($error)) {
        header("Location: login.php?error=" . urlencode($error));
        exit();
    }
}
?>

<main>
    <?php if (!empty($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <h2>Coach Login</h2>
    <div id="aligned">
        <form action="" method="post" id="admin">
            <label>Email:</label>
            <input type="text" name="coach_email"><br>
            <label>Password:</label>
            <input type="password" name="coach_password"><br>
            <label>&nbsp;</label>
            <input type="submit" name="submit" value="Login"><br>
        </form>
    </div>

    <?php include '../view/footer.php'; ?>
