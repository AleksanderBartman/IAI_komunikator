<?php
require_once 'init.php';
$login = $_SESSION['login'];
$key = $_SESSION['key'];
$new_password = $_POST['new_pass'];
$icon = $_POST['url_icon'];
if(!empty($new_password) && !empty($icon))
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/user/edit");
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    echo 'To i to';
curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."&key=".$key."&new_password=".$new_password."&icon=".$icon);
    $key = md5( $login . hash('sha256', $new_password ));
    $_SESSION['key'] = $key;
    $out = curl_exec($ch);
    echo $out;
    $zm = json_decode($out,true);
    print_r($zm);

}
elseif(empty($new_password) && !empty($icon))
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/user/edit");
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    echo 'tylko iconka';
    curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."&key=".$key."&icon=".$icon);
    $out = curl_exec($ch);
    echo $out;
    $zm = json_decode($out,true);
    print_r($zm);
}
elseif(!empty($new_password) && empty($icon))
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/user/edit");
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    echo 'tylko pass';
    curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."&key=".$key."&new_password=".$new_password);

    $key = md5( $login . hash('sha256', $new_password ));
   // $_SESSION['key'] = $key;
    $out = curl_exec($ch);
    echo $out;
    $zm = json_decode($out,true);
    print_r($zm);
}
else
{
    echo ' Nie podałeś żadnych danych';
}
