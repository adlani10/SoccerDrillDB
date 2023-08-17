<?php

function get_coaches_by_category($category_id) {
    global $db;
    $query = 'SELECT * FROM coaches
              WHERE categoryID = :category_id
              ORDER BY coachID';
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

function get_coaches() {
    global $db;
    $query = 'SELECT * FROM coaches ORDER BY coachID';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $coaches = $statement->fetchAll();
        $statement->closeCursor();
        return $coaches;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_coach_login($email, $password) {
    global $db;
    $query = 'SELECT * FROM coaches WHERE email = :email AND password = :password';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $coaches = $statement->fetchAll();
        $statement->closeCursor();
        return $coaches;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_coach($coach_id) {
    global $db;
    $query = 'SELECT *
              FROM coaches
              WHERE coachID = :coach_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':coach_id', $coach_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_coach($firstName, $lastName, $team,
            $leagueName, $countryCode, $countryName, $playingStyle,
            $email, $password) {
    global $db;
    $query = 'INSERT INTO coaches
                 (firstName, lastName, team, leagueName,
                  countryName,countryCode, playingStyle, 
                  email, password)
              VALUES
                 (:firstName, :lastName, :team, :leagueName,
                 :countryName, :countryCode, :playingStyle, :email, :password)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':team', $team);
        $statement->bindValue(':leagueName', $leagueName);
        $statement->bindValue(':countryName', $countryName);
        $statement->bindValue(':countryCode', $countryCode);
        $statement->bindValue(':playingStyle', $playingStyle);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $statement->closeCursor();

        // Get the last coach ID that was automatically generated
        //$coach_id = $db->lastInsertId();
        //return $coach_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_coach($coachID, $firstName, $lastName, $team,
        $leagueName, $countryCode, $countryName, $playingStyle,
        $email, $password) {
    global $db;
    $query = 'UPDATE coaches
              SET firstName = :firstName,
                  lastName = :lastName,
                  team = :team,
                  leagueName = :leagueName,
                  countryName = :countryName,
                  countryCode = :countryCode,
                  playingStyle = :playingStyle,
                  email = :email,
                  password = :password
              WHERE coachID = :coachID';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':team', $team);
        $statement->bindValue(':leagueName', $leagueName);
        $statement->bindValue(':countryCode', $countryCode);
        $statement->bindValue(':countryName', $countryName);
        $statement->bindValue(':playingStyle', $playingStyle);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':coachID', $coachID, PDO::PARAM_INT);
        $statement->execute();
        $statement->closeCursor();
        //return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function delete_coach($coach_id) {
    global $db;
    $query = 'DELETE FROM coaches WHERE coachID = :coach_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':coach_id', $coach_id);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

?>