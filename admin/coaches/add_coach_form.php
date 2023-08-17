<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
require_once('../../util/main.php');
include '../../view/header.php';
require_once('../../model/database.php');
require_once('../../model/coach_db.php');
require_once('../../model/country_db.php');

$countries = get_countries();

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
        add_coach($firstName, $lastName, $team,
                $leagueName, $countryCode, $countryName, $playingStyle,
                $email, $password);

        header('Location: index.php');
    }
}
?>

<main>
    <h1>Add/Update Coach</h1>
    <form action="" method="post"
          id="add_coach_form">
        <div id="aligned">

            <label>First Name:</label>
            <input type="text" name="firstName" value="<?php echo $firstName; ?>">
            <span class='error'>&nbsp;<?php //echo $errors['firstName']     ?></span>
            <br>

            <label>Last Name:</label>
            <input type="text" name="lastName" value="<?php echo $lastName; ?>">
            <span class='error'>&nbsp;<?php //echo $errors['lastName']     ?></span>
            <br>

            <label>Team:</label>
            <input type="text" name="team" value="<?php echo $team; ?>">
            <span class='error'>&nbsp;<?php //echo $errors['address']     ?></span>
            <br>

            <label>League:</label>
            <input type="text" name="leagueName" value="<?php echo $leagueName; ?>">
            <span class='error'>&nbsp;<?php //echo $errors['city']     ?></span>
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
            <span class='error'>&nbsp;<?php //echo $errors['countryCode']     ?></span>
            <br>

            <label>Playing Style:</label>
            <input type="text" name="playingStyle" value="<?php echo $playingStyle; ?>">
            <span class='error'>&nbsp;<?php //echo $errors['postalCode']     ?></span>
            <br>


            <label>Email:</label>
            <input type="text" name="email" value="<?php echo $email; ?>">
            <span class='error'>&nbsp;<?php //echo $errors['email']     ?></span>
            <br>

            <label>Password:</label>
            <input type="text" name="password" value="<?php echo $password; ?>">
            <span class='error'>&nbsp;<?php //echo $errors['password']     ?></span>
            <br>

            <label>&nbsp;</label>
            <input type="submit" name='submit' value="Add Coach"><br>
        </div>
    </form>
    <p><a href="index.php">Search Coach</a></p>

    <?php include '../../view/footer.php'; ?>
