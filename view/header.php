<?php
session_set_cookie_params(0);
session_start();

$error = htmlspecialchars($_GET['error']);
?>
<!DOCTYPE html>
<html>

    <!-- the head section -->
    <head>
        <title>Soccer Drill Centre</title>
        <link rel="stylesheet" type="text/css" href="<?php echo $app_path ?>main.css" />
    </head>

    <!-- the body section -->
    <body>
        <header>
            <h1>Soccer Drill Centre</h1>
            <p>The TOP Soccer Drill Database for Coaches.</p>
            <ul><li><a href="<?php echo $app_path ?>index.php">Home</a></li></ul>

        </header>
