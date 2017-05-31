<?php

session_start();
if (!isset($_SESSION["login"])) {
    header("Location: /chat/reg.php");
}

?>
<!DOCTYPE>
<html>
<head>
    <title>Мой супер пупер чат</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="all.js?1"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="main.css?1" media="all" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="chat_container">
    <div class="chat_inner">
    </div>
    <div class="chat_input">
        <textarea id="text" class="textarea" autofocus placeholder="Введите своё сообщение"></textarea>
    </div>
</div>
<script>
    $('#text').keydown(function(event) {
        var keyCode = event.which;

        if(keyCode == 13) {
            chat.sendMsg();
            return false;
        }
    });
</script>
</body>
</html>