<?php
require_once 'init.php';
$myDb = new Database();
$DAO = new UserDAO($myDb);


if (!empty($_POST['login']) && !empty($_POST['pass']))
{
    // sprawdzamy pole login i pass sa niepuste
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $user= $DAO->getUser($login);

    if ($user->login == $login) {
            //login sie zgadza informujemy uzytkownika
            echo 'uzytkownik o takim loginie istnieje w bazie ' . $login;
            die;

    }

    $userToAdd = new User();
    $userToAdd -> login = $login;
    $userToAdd -> pass = $pass;

    $result = $DAO->add($userToAdd);
    if ($result)
    {
        echo "Uzytkownik {$userToAdd->login} dodany prawidlowo";
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
    }
    else
    {
        echo ' wystąipł blad zapytania '. $myDb->getError();
        var_dump($myDb->getError());
    }
}
else
{
    echo 'nie podano danych';
}

