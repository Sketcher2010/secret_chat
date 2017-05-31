<?php
header('Content-Type: application/json');
session_start();

include "db.php";
include "functions.php";

if (!isset($_SESSION["login"])) {
    echo json_encode(array("type" => "error", "message" => "Необходима авторизация"));
    return;
}
if (!isset($_SESSION["lastId"])) {
    $_SESSION["lastId"] = (int)$db->fetch($db->query("SELECT `id` FROM `chat` ORDER BY `id` DESC LIMIT 1"))["id"];
}
$lastId = $_SESSION["lastId"];
$currentLast = (int)$db->fetch($db->query("SELECT `id` FROM `chat` ORDER BY `id` DESC LIMIT 1"))["id"];

if($lastId != $currentLast) {
    $query = $db->query("SELECT * FROM `chat`WHERE `id` > '$lastId' ORDER BY `id` ASC");
    $msgs = [];
    while($msg_fetch = $db->fetch($query)) {
        $msg = [];
        $msg["from"] = $msg_fetch["login"];
        $msg["text"] = FilterText(htmlspecialchars($msg_fetch["text"]));
        $msg["time"] = new_time($msg_fetch["time"]);
        $msgs[] = $msg;
    }

    $_SESSION["lastId"] = $currentLast;
    echo json_encode(array("type"=>"success", "messages"=> $msgs));
} else {
    echo json_encode(array("type"=>"fail"));
}
