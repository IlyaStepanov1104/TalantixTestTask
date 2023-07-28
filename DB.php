<?php
$DB_SERVER = "localhost";
$DB_USER = "root";
$DB_PASS = "root";
$DB_NAME = "talantix";

try {
    $pdo = new PDO('mysql:dbname=' . $DB_NAME . ';host=' . $DB_SERVER, $DB_USER, $DB_PASS);
} catch (PDOException $e) {
    $pdo = null;
}