<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once('../../util/main.php');
include '../../view/header.php';
require_once('../../model/database.php');
require_once('../../model/category_db.php');

$categories = get_categories();

if (isset($_POST['addCategory'])) {
    $newCategory = filter_input(INPUT_POST, 'newCategory');

    add_category($newCategory);

    header('Location: index.php');
}

if (isset($_POST['deleteCategory'])) {
    $category_id = filter_input(INPUT_POST, 'categoryID');

    delete_category($category_id);
    header('Location: index.php');
}
?>

<main>

    <!-- display a table of drills -->

    <h2>Results</h2>
    <table>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($categories as $category) : ?>
            <tr>
                <td><?php echo $category['categoryID'] ?></td>
                <td><?php echo $category['categoryName']; ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="categoryID" value="<?php echo $category['categoryID']; ?>">
                        <input type="submit" name='deleteCategory' value="delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table><br>



    <h2>Add Category</h2>
    <form action="" method="post">
        <input type="text" name="newCategory" >
        <input type="submit" name='addCategory' value="Add">

    </form>

    <?php include '../../view/footer.php'; ?>
