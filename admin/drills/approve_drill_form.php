<?php
require_once('../../util/main.php');
include '../../view/header.php';
require_once('../../model/database.php');
require_once('../../model/drill_db.php');
require_once('../../model/category_db.php');
//$lastName = filter_input(INPUT_POST, 'lastName');
$drillID = filter_input(INPUT_POST, 'drillID');

$drill = get_drill($drillID);
$imageData = base64_encode($drill['drill_img']);
$imageSrc = 'data:image/png;base64,' . $imageData;

if (isset($_POST['approve'])) {

    approve_drill($drillID);
    header('Location: approve_drill_list.php');
}

?>

<main>
    <h1>View Drill</h1>
    <div id="aligned">
        <label>Drill Type:</label>
        <span><?php echo $drill['categoryName']; ?></span><br>

        <label>Players Needed:</label>
        <span><?php echo $drill['playersNeeded']; ?></span><br>

        <label>Description:</label>
<?php echo '<span>' . $drill['description'] . '</span>'; ?></span>

        <br><br>

<?php if (!empty($imageData)) { ?>
            <label>Image:</label>
            <?php echo '<img src="' . $imageSrc . '"width="500">' ?><br>
        <?php } ?>

        <form action="" method="post">
            <input type="hidden" name="drillID" value="<?php echo $drill['drillID']; ?>">
            <input type="submit" name="approve" value="Approve">
        </form>

        <span class='error'>&nbsp;<?php //echo $errors['city']        ?></span>
        <br>
    </div>

    <span><a href="drill_search.php">Search Drill</a></span>

<?php include '../../view/footer.php'; ?>
