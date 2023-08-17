<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once('../../util/main.php');
include '../../view/header.php';
require_once('../../model/database.php');
require_once('../../model/coach_db.php');
require_once('../../model/country_db.php');
$coachID = filter_input(INPUT_POST, 'coachID');
$countries = get_countries();
$coach = get_coach($coachID);

if (isset($_POST['submit'])) {
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $team = filter_input(INPUT_POST, 'team');
    $leagueName = filter_input(INPUT_POST, 'leagueName');
    $countryCode = filter_input(INPUT_POST, 'countryCode');
    $countryName = get_country_by_code($countryCode);
    $playingStyle = filter_input(INPUT_POST, 'playingStyle');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');

    // Validate inputs
    if (empty($firstName)) {
        $errors['firstName'] = "Required.";
    } elseif (strlen($firstName) >= 51) {
        $errors['firstName'] = "Too long.";
    }

    if (empty($lastName)) {
        $errors['lastName'] = "Required.";
    } elseif (strlen($lastName) >= 51) {
        $errors['lastName'] = "Too long.";
    }

    if (empty($team)) {
        $errors['team'] = "Required.";
    } elseif (strlen($team) >= 51) {
        $errors['team'] = "Too long.";
    }

    if (empty($leagueName)) {
        $errors['leagueName'] = "Required.";
    } elseif (strlen($leagueName) > 51) {
        $errors['leagueName'] = "Too long.";
    }

    if (empty($playingStyle)) {
        $errors['playingStyle'] = "Required.";
    } elseif (strlen($state) >= 51) {
        $errors['playingStyle'] = "Too long.";
    }

    if (empty($email)) {
        $errors['email'] = "Required.";
    } elseif (strlen($email) >= 51) {
        $errors['email'] = "Too long.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid domain name part";
    }

    if (empty($countryCode)) {
        $errors['countryCode'] = "Required.";
    }

    if (empty($password)) {
        $errors['password'] = "Required.";
    } elseif (strlen($password) >= 21) {
        $errors['password'] = "Too long.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Too short.";
    }
    if (empty($errors)) {
        update_coach($coachID, $firstName, $lastName, $team,
                $leagueName, $countryCode, $countryName, $playingStyle,
                $email, $password);

        $_SESSION['coach_email'] = $email;
        $_SESSION['coach_password'] = $password;

        header('Location: index.php');
    }
}
?>

<main>
    <h1>View/Update Coach</h1>
    <form action="" method="post" id="update_coach_form">
        <div id="aligned">
            <label>First Name:</label>
            <input type="text" name="firstName" value="<?php echo $coach['firstName']; ?>">
            <span class='error'>&nbsp;<?php echo $errors['firstName']    ?></span>
            <br>

            <label>Last Name:</label>
            <input type="text" name="lastName" value="<?php echo $coach['lastName']; ?>">
            <input type="hidden" name="coachID" value="<?php echo $coach['coachID']; ?>">
            <span class='error'>&nbsp;<?php echo $errors['lastName']    ?></span>
            <br>

            <label>Team:</label>
            <input type="text" name="team" value="<?php echo $coach['team']; ?>">
            <span class='error'>&nbsp;<?php echo $errors['team']    ?></span>
            <br>

            <label>League:</label>
            <input type="text" name="leagueName" value="<?php echo $coach['leagueName']; ?>">
            <span class='error'>&nbsp;<?php echo $errors['leagueName']    ?></span>
            <br>

            <label>Country:</label>
            <select name="countryCode">
                <option value='<?php echo $coach['countryCode'] ?>' selected='selected'><?php echo $coach['countryName'] ?></option>
                <?php foreach ($countries as $country) : ?>
                    <option value="<?php echo $country['countryCode']; ?>" >
                        <?php echo $country['countryName']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label>Playing Style:</label>
            <input type="text" name="playingStyle" value="<?php echo $coach['playingStyle']; ?>">
            <span class='error'>&nbsp;<?php echo $errors['playingStyle']    ?></span>
            <br>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $coach['email']; ?>">
            <span class='error'>&nbsp;<?php echo $errors['email']    ?></span>
            <br>

            <label>Password:</label>
            <input type="password" name="password" value="<?php echo $coach['password']; ?>">
            <span class='error'>&nbsp;<?php echo $errors['password']    ?></span>
            <br>

            <label>&nbsp;</label>
            <input type="submit" name='submit' value="Update Coach"><br>
        </div>
    </form>
    <p><a href="index.php">Search Coach</a></p>

    <?php include '../../view/footer.php'; ?>
