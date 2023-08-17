<?php
require_once('../../util/main.php');
include '../../view/header.php';
require_once('../../model/database.php');
require_once('../../model/drill_db.php');

$drills = get_unapproved_drills();
?>

<main>

    <?php
    if (empty($drills)) { // no drills shown if empty
        echo "<h2>There are no drills to review.</h2>";
    } else {
        
        ?>
        <!-- display a table of drills -->
        <h2>Drills Needed Review</h2>
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
                            echo "Requires Approval";
                        } else {
                            echo $drill['dateAdded'];
                        }
                        ?>
                    <td>
                        <form action="approve_drill_form.php" method="post">
                            <input type="hidden" name="drillID" value="<?php echo $drill['drillID']; ?>">
                            <input type="submit" value="Select">
                        </form>
                    </td>
                </tr>
            <?php endforeach;
        } ?>
    </table>

    <?php include '../../view/footer.php'; ?>
