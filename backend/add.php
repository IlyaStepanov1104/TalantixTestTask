<?php
require_once 'DB.php';
if (empty($_POST['name'])) {
	echo json_encode(array('type' => 'error', 'message' => 'Ошибка: Укажите имя!'));
} elseif (empty($_POST['phone'])) {
    echo json_encode(array('type' => 'error', 'message' => 'Ошибка: Укажите телефон!'));
} elseif(!isset($pdo)) {
    echo json_encode(array('type' => 'error', 'message' => 'Ошибка: нет связи с базой данных!'));
} else {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $sth = $pdo->prepare("INSERT INTO phone_book (id, name, phone) VALUES (NULL, '".$name."', '".$phone."')");
    try {
        $sth->execute();
    } catch (Exception $exception){
        json_encode(array('type' => 'error', 'message' => 'Ошибка: ошибка при добавлении!'));
        return;
    }
    $find = $pdo->lastInsertId();
    if ($find == 0){
        echo json_encode(array('type' => 'error', 'message' => 'Ошибка: ошибка при добавлении!'));
    } else {
        echo json_encode(array('type' => 'yes', 'id' => $find));
    }
}