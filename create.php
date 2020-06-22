<?php
require_once 'init.php';
$chatName = $_POST['login'];
$login = $_SESSION['login'];
$key = $_SESSION['key'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/user/verify");
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."&key=".$key);
$out = curl_exec($ch);
echo $out;
$zm = json_decode($out,true);

if(is_array($zm))
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/chat/create");
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."&key=".$key."&name=".$chatName);
    $out = curl_exec($ch);

    echo $out;
    $zm = json_decode($out,true);
print_r($zm);






}