<?php
require_once 'init.php';
$id = $_POST['id'];
$login = $_SESSION['login'];
$key = $_SESSION['key'];
$text = $_POST['text'];
settype($id,"integer");

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/chat/getActive");
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."&key=".$key);
$out = curl_exec($ch);

$zm = json_decode($out,true);
//echo'id= '.$id;
//print_r( $zm);
$idiki = array();
for ($i = 0; $i <= count($zm)-1; $i++) {
    $idiki[$i]= $zm[$i]['id'];
    //  print_r($zm[$i]['id']);
}
//print_r($idiki);
if(in_array($id,$idiki))
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/chat/send");
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."&key=".$key."&chat_id=".$id."&message=".$text);
    $out = curl_exec($ch);

    $zm = json_decode($out,true);
    print_r($zm);
    //echo $zm['id'];
    $_SESSION['last_id'] = $zm['id'];
}
else{
    echo 'nie nalezysz do tej rozmowy';
}