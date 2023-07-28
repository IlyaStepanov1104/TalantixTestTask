<?php
require_once "DB.php";
if (empty($_GET['delete'])) {
    echo json_encode(array('type' => 'error', 'message' => 'Ошибка: нет ID!'));
} elseif (!isset($pdo)){
    echo json_encode(array('type' => 'error', 'message' => 'Ошибка: нет связи с базой данных!'));
} else {
    $id = $_GET['delete'];
    $sth = $pdo->prepare("DELETE FROM phone_book WHERE `id`=".$id);
    $sth->execute();
    echo json_encode(array('type' => 'yes'));
}
