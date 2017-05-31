<?php

session_start();

include "db.php";
include "functions.php";

if (isset($_SESSION["login"])) {
    header("Location: /chat/");
}

if(isset($_POST["login"])) {
    $_SESSION["login"] = $db->escape(htmlspecialchars($_POST["login"]));
    header("Location: /chat/");
} else {
    ?>
    <form method="post">
        <input type="text" placeholder="Enter login!" name="login">
        <input type="submit">
    </form>
    <?
}
