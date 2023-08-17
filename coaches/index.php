<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once('../util/main.php');
include '../view/header.php';
require_once('../model/database.php');
require_once('../model/drill_db.php');
require_once('../model/coach_db.php');


$drills = get_recent_drills();
//sets the username and password to the session username/password
$email = $_SESSION['coach_email'];
$password = $_SESSION['coach_password'];
$coach_id = $_SESSION['coach_id'];

$coach = get_coach_login($email, $password);
$coachName = $coach[0]['firstName']." ".$coach[0]['lastName'];


//session logout
if (isset($_POST['logout'])) {
    session_start();
    unset($_SESSION);
    session_destroy();
    session_write_close();
    header('Location: index.php');
    die;
}
?>

<main>
    <nav>

        <h2>Main Menu</h2>
        <ul>
            <?php if (!isset($_SESSION["coach_email"])) { ?>
                <li><a href="drill_search.php">Drill Search</a></li>
                <li><a href="coach_signup_form.php">Create Account</a></li>
                <li><a href="login.php">Login</a></li>

            <?php } else { ?>
                <li><a href="update_profile_form.php">Manage Account</a></li>
                <li><a href="drill_search.php">Drill Search</a></li>
                <li><a href="drill_status.php">Drill Status</a></li>
            <?php } ?>
        </ul><br>
    </nav>

    <!-- display a table of drills -->

    <h2>Newest Drills</h2>
    <table>
        <tr>
            <th>Drill Type</th>
            <th>Players Needed</th>
            <th class="right">Date Added</th> 
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($drills as $drill) : ?>
            <tr>
                <td><?php echo $drill['categoryName'] ?></td>
                <td><?php echo $drill['playersNeeded']; ?></td>
                <td class="right"><?php echo $drill['dateAdded']; ?></td>
                <td>
                    <form action="drill_display.php" method="post">
                        <input type="hidden" name="drillID" value="<?php echo $drill['drillID']; ?>">
                        <input type="submit" value="View">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table> <br>

    <?php if (isset($_SESSION["coach_email"])) { ?>

        <h2>Account</h2>
        <form action="" method="post" id="logout">
            <span>You are logged in as <?php echo $coachName; ?></span><br>
            <input type="submit" name="logout" value="Logout"><br>
        </form>

    <?php } ?>

    <?php include '../view/footer.php'; ?>
