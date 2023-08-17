<?php

function get_admins() {
    global $db;
    $query = 'SELECT * FROM administrators ORDER BY adminID';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $admins = $statement->fetchAll();
        $statement->closeCursor();
        return $admins;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_admin($admin_id) {
    global $db;
    $query = 'SELECT *
              FROM administrators
              WHERE adminID = :admin_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':admin_id', $admin_id);
        $statement->execute();
        $admins = $statement->fetch();
        $statement->closeCursor();
        return $admins;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_admin_login($username, $password) {
    global $db;
    $query = 'SELECT * FROM administrators WHERE username = :username '
            . 'AND password = :password;';
    try {
        $statement = $db->prepare($query);
        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', $password);
        $statement->execute();
        $adminLog = $statement->fetchAll();
        $statement->closeCursor();
        return $adminLog;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_admin($username, $password) {
    global $db;
    $query = 'INSERT INTO administrators
                 (username, password)
              VALUES
                 (:username, :password)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $statement->closeCursor();

        // Get the last admin ID that was automatically generated
        $admin_id = $db->lastInsertId();
        return $admin_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_admin($username, $password) {
    global $db;
    $query = 'UPDATE administrators
              SET username = :username,
                  password = :password,
              WHERE $username = :$username';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function delete_admin($admin_id) {
    global $db;
    $query = 'DELETE FROM administrators WHERE adminID = :admin_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':admin_id', $admin_id);
        $row_count = $statement->execute();
        $statement->closeCursor();
        return $row_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

?>