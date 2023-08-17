<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once('../util/main.php');
include '../view/header.php';
require_once('../model/database.php');
require_once('../model/drill_db.php');

$drills = get_approved_drills();

?>

<main>

    <!-- display a table of drills -->

    <h2>Drills</h2>
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
                <td class="right"><?php echo $drill['dateAdded']; ?></td>
                <td>
                    <form action="drill_display.php" method="post">
                        <input type="hidden" name="drillID" value="<?php echo $drill['drillID']; ?>">
                        <input type="submit" value="Select">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>


    <?php if (isset($_SESSION["myusername"])) { ?>
        <h2>Add New Drill</h2>
        <input type="button" onclick="window.location.href = 'add_drill_form.php';" value="Add Drill" />
    <?php } ?>
    <?php include '../view/footer.php'; ?>
