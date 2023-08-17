<?php

function get_countries() {
    global $db;
    $query = "SELECT * FROM countries ORDER BY countryName";
    try {
        // Retrieve list of countries
        $query = $statement = $db->prepare($query);
        $statement->execute();
        $countries = $statement->fetchAll();
        $statement->closeCursor();
        return $countries;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_country($countryName) {
    global $db;
    $query = 'SELECT *
              FROM countries
              WHERE countryName = :countryName';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':countryName', $countryName);
        $statement->execute();
        $countries = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_country_by_code($countryCode) {
    global $db;
    $query = 'SELECT countryName
              FROM countries
              WHERE countryCode = :countryCode';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':countryCode', $countryCode);
        $statement->execute();
        $result = $statement->fetchColumn();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_code_by_country($countryName) {
    global $db;
    $query = 'SELECT countryCode
              FROM countries
              WHERE countryName = :countryName';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':countryName', $countryName);
        $statement->execute();
        $result = $statement->fetchColumn();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

