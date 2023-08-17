<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once('../../util/main.php');
include '../../view/header.php';
require_once('../../model/database.php');
require_once('../../model/coach_db.php');

$coaches = get_coaches();
?>

<main>

    <!-- display a table of coaches -->

    <h2>Coaches</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Country</th>
            <th>Team</th>
            <th class="right">Playing Style</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($coaches as $coach) : ?>
            <tr>
                <td><?php echo $coach['firstName'] . ' ' . $coach['lastName']; ?></td>
                <td><?php echo $coach['countryName']; ?></td>
                <td><?php echo $coach['team']; ?></td>
                <td class="right"><?php echo $coach['playingStyle']; ?></td>
                <td>
                    <form action="update_coach_form.php" method="post">
                        <input type="hidden" name="coachID" value="<?php echo $coach['coachID']; ?>">
                        <input type="submit" value="Select">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>



    <h2>Add New Coach</h2>
    <input type="button" onclick="window.location.href = 'add_coach_form.php';" value="Add Coach" />

    <?php include '../../view/footer.php'; ?>
