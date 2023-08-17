<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once('../util/main.php');
include '../view/header.php';
require_once('../model/database.php');
require_once('../model/drill_db.php');

$email = $_SESSION['coach_email'];
$password = $_SESSION['coach_password'];
$coach_id = $_SESSION['coach_id'];
$drills = get_drills_by_coach($coach_id);
?>

<main>

    <!-- display a table of drills -->
    <?php
    if (empty($drills)) { // no drills shown if empty
        echo "<h2>There are no drills under review.</h2><br>";
    } else {
        ?>
        <h2>Results</h2>
        <table>
            <tr>
                <th>Drill Type</th>
                <th>Players Needed</th>
                <th>Date Created</th>
                <th class="right">Date Added</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($drills as $drill) : ?>
                <tr>
                    <td><?php echo $drill['categoryName'] ?></td>
                    <td><?php echo $drill['playersNeeded']; ?></td>
                    <td><?php echo $drill['dateCreated']; ?></td>
                    <td class="right"><?php
                if ($drill['dateAdded'] == NULL) {
                    echo "Pending";
                } else {
                    echo 'Approved';
                }
                ?></td>
                    <td>
                        <form action="drill_display.php" method="post">
                            <input type="hidden" name="drillID" value="<?php echo $drill['drillID']; ?>">
                            <input type="submit" value="Select">
                        </form>
                    </td>
                </tr>
            <?php endforeach;
        }
        ?>
    </table>



    <h2>Add New Drill</h2>
    <input type="button" onclick="window.location.href = 'submit_drill_form.php';" value="Add Drill" />

    <?php include '../view/footer.php'; ?>
