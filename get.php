<?php
require_once 'init.php';
$login = $_SESSION['login'];
$key = $_SESSION['key'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/chat/get");
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$last_id=$_SESSION['last_id'];
echo $last_id;
settype($last_id,"integer");
curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."&key=".$key."&last_id=".$last_id); //."&last_id=".$last_id
$out = curl_exec($ch);
//echo $out;
$zm = json_decode($out,true);
print_r($zm);