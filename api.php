<?php
try {


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/user/add");

    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_POST,1);

    $login=$_POST['login'];
    $password=$_POST['pass'];
    curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."&password=".$password);

    $out = curl_exec($ch);
    $zmienna = json_decode($out,true);
    if(is_array($zmienna))
    {
        echo 'dodano uzytkownika o loginie: ';
        echo $zmienna['login'];
    }
    else{
        echo 'nie udalo sie';
    }




    curl_close($ch);

}
catch(Exception $e){

}








