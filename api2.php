<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/user/verify");

curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_HEADER,0);
curl_setopt($ch, CURLOPT_POST,1);

$login=$_POST['login'];
$password=$_POST['pass'];
$key = md5( $login . hash('sha256', $password ));


if()


curl_close($ch);