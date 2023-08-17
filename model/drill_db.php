<?php

function get_drills_by_category($category_id) {
    global $db;
    $query = 'SELECT * FROM drills
              WHERE categoryID = :category_id
              ORDER BY drillID';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_drills_by_coach($coach_id) {
    global $db;
    $query = 'SELECT * FROM drills
              WHERE coachID = :coach_id
              ORDER BY drillID';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':coach_id', $coach_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_recent_drills() {
    global $db;
    $query = 'SELECT * FROM drills '
            . 'WHERE dateAdded IS NOT NULL '
            . 'ORDER BY dateAdded '
            . 'DESC LIMIT 5';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $drills = $statement->fetchAll();
        $statement->closeCursor();
        return $drills;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_approved_drills() {
    global $db;
    $query = 'SELECT * FROM drills '
            . 'WHERE dateAdded IS NOT NULL'
            . ' ORDER BY drillID';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $drills = $statement->fetchAll();
        $statement->closeCursor();
        return $drills;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_unapproved_drills() {
    global $db;
    $query = 'SELECT * FROM drills '
            . 'WHERE dateAdded IS NULL'
            . ' ORDER BY drillID';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $drills = $statement->fetchAll();
        $statement->closeCursor();
        return $drills;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_drills() {
    global $db;
    $query = 'SELECT * FROM drills ORDER BY drillID';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $drills = $statement->fetchAll();
        $statement->closeCursor();
        return $drills;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_drill($drill_id) {
    global $db;
    $query = 'SELECT *
              FROM drills
              WHERE drillID = :drill_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':drill_id', $drill_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_drill_image($drill_id) {
    global $db;
    $query = 'SELECT drill_img FROM drills WHERE drillID = :drill_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':drill_id', $drill_id);
        $statement->execute();
        $imageData = $statement->fetchColumn();
        $statement->closeCursor();

        return $imageData;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_drill($categoryID, $categoryName, $playersNeeded, $description,
        $drill_img, $coachID, $dateAdded, $adminID) {
    global $db;
    $query = 'INSERT INTO drills
                 (categoryID, categoryName, playersNeeded, description,
                  drill_img, coachID, dateCreated, dateAdded, adminID)
              VALUES
                 (:categoryID, :categoryName, :playersNeeded, :description, :drill_img,
                  :coachID, NOW(), :dateAdded, :adminID)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryID', $categoryID);
        $statement->bindValue(':categoryName', $categoryName);
        $statement->bindValue(':playersNeeded', $playersNeeded);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':drill_img', $drill_img, PDO::PARAM_LOB);
        $statement->bindValue(':coachID', $coachID);
        $statement->bindValue(':dateAdded', $dateAdded);
        $statement->bindValue(':adminID', $adminID);
        $statement->execute();
        $statement->closeCursor();

        // Get the last drill ID that was automatically generated
        //$drill_id = $db->lastInsertId();
        //return $drill_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_drill($categoryID, $categoryName, $playersNeeded, $description, $drillID, $drill_img) {
    global $db;
    $query = 'UPDATE drills
              SET categoryID = :categoryID,
                  categoryName = :categoryName,
                  playersNeeded = :playersNeeded,
                  description = :description,
                  drill_img = :drill_img
              WHERE drillID = :drillID';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryID', $categoryID);
        $statement->bindValue(':categoryName', $categoryName);
        $statement->bindValue(':playersNeeded', $playersNeeded);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':drill_img', $drill_img, PDO::PARAM_LOB); // Specify BLOB parameter
        $statement->bindValue(':drillID', $drillID);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}


function delete_drill($drill_id) {
    global $db;
    $query = 'DELETE FROM drills WHERE drillID = :drill_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':drill_id', $drill_id);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function approve_drill($drillID) {
    global $db;
    $query = 'UPDATE drills
              SET dateAdded = NOW()
              WHERE drillID = :drillID';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':drillID', $drillID);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

?>