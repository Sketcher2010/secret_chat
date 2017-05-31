<?php
header('Content-Type: application/json');
session_start();

include "db.php";

if (!isset($_SESSION["login"])) {
    echo json_encode(array("type" => "error", "message" => "Необходима авторизация"));
    return;
}
if (!isset($_POST["text"])) {
    echo json_encode(array("type" => "error", "message" => "Не переданы необходимые параметры"));
    return;
}
if (strlen($_POST["text"]) < 1) {
    echo json_encode(array("type" => "error", "message" => "Текст сообщения не может быть пустым"));
    return;
}

$text = $db->escape(htmlspecialchars($_POST["text"]));

$db->query("INSERT INTO `ajaxchat`.`chat` (`id`, `login`, `text`, `time`) VALUES (NULL, '" . $_SESSION["login"] . "', '" . $text . "', '" . time() . "');");

echo json_encode(array("type" => "success"));
