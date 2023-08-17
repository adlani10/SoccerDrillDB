<?php
require_once('../../util/main.php');
include '../../view/header.php';
require_once('../../model/database.php');
require_once('../../model/drill_db.php');
require_once('../../model/category_db.php');

$drillID = filter_input(INPUT_POST, 'drillID');
$drill = get_drill($drillID);
$imageData = base64_encode($drill['drill_img']);
$imageSrc = 'data:image/png;base64,' . $imageData;
$categories = get_categories();
$errors = [];

if (isset($_POST['addDrill'])) {
    $categoryID = filter_input(INPUT_POST, 'categoryID');
    $categoryName = get_category_name($categoryID); // Retrieve the category name based on the selected categoryID
    $playersNeeded = filter_input(INPUT_POST, 'playersNeeded');
    $description = filter_input(INPUT_POST, 'description');
    $drill_img = $_FILES['image']['tmp_name'];
    $coachID = null;
    $dateAdded = date("Y/m/d");
    $adminID = 1;

    // Validate inputs
    if (empty($categoryID)) {
        $errors['categoryName'] = "Required.";
    }

    if (empty($playersNeeded)) {
        $errors['playersNeeded'] = "Required.";
    } elseif ($playersNeeded >= 23) {
        $errors['playersNeeded'] = "Too many players.";
    } elseif ($playersNeeded < 2) {
        $errors['playersNeeded'] = "Too few players.";
    }

    if (empty($description)) {
        $errors['description'] = "Required.";
    } elseif (strlen($description) > 400) {
        $errors['description'] = "Too long.";
    }


    if (empty($errors)) {
        
        // Check if a new image file is uploaded
        if ($_FILES['image']['size'] > 0) {
            $drill_img = file_get_contents($_FILES['image']['tmp_name']); // Read the file content
        } else {
            // No new image uploaded, retain the existing image
            $drill = get_drill($drillID);
            $drill_img = $drill['drill_img'];
        }
        
        add_drill($categoryID, $categoryName, $playersNeeded, $description, $drill_img, $coachID, $dateAdded, $adminID);
        header('Location: index.php');
    }
}
?>

<main>
    <h1>Add Drill</h1>
    <form action="" method="post" id="update_drill_form" enctype="multipart/form-data">
        <div id="aligned">
            <label>Drill Type:</label>
            <select name="categoryID" id="categorySelect">
                <option selected='selected' disabled>Select a category</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['categoryID']; ?>">
                        <?php echo $category['categoryName']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span class='error'>&nbsp;<?php echo $errors['categoryName'] ?></span>
            <br>

            <label>Players Needed:</label>
            <input type="text" name="playersNeeded" value="<?php echo $drill['playersNeeded']; ?>">
            <input type="hidden" name="drillID" value="<?php echo $drill['drillID']; ?>">
            <span class='error'>&nbsp;<?php echo $errors['playersNeeded']; ?></span>
            <br>

            <label>Description:</label>
            <textarea name="description" rows="4"><?php echo $drill['description']; ?></textarea><br>
            <label>&nbsp;</label>
            <span class='error'>&nbsp;<?php echo $errors['description']; ?></span>
            <br>

            <label>Image:</label>
            <input type="file" name="image" value=""><br>
            <label>&nbsp;</label>
            <span class='error'>&nbsp;<?php echo $errors['image']; ?></span>
            <br>

            <label>&nbsp;</label>
            <input type="submit" name="addDrill" value="Add Drill"><br>
        </div>
    </form>
