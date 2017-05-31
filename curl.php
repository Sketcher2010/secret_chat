<?php
// From fulltools.ru
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.instagram.com/v1/users/" . $instaId . "/relationship?access_token=" . $user_instaToken);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU; rv:1.7.12) Gecko/20050919 Firefox/1.0.7");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$udata = curl_exec($ch);
curl_close($ch);