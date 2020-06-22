<?php
require_once 'init.php';

$host = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbname = 'phpcamp';

$db = new mysqli($host, $dbUser, $dbPass, $dbname);

if ($db->connect_error) {
    // blad polaczenia
    var_dump($db->connect_error);
}

if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    // sprawdzamy pole login i pass sa niepuste
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $query = 'SELECT * FROM users WHERE login = "' . $login . '"';

    // zapytanie sprawdzajace czy dany uzytkowni

    $result = $db->query($query);
    if ($result) {
        //znaleziono w bazie danych uzytkownika o podanym loginie


        $user = $result->fetch_assoc();
        if (!empty($user) && $user['login'] == 'admin' && $user['pass'] == 'admin')
        {

            $query2 = "SELECT * FROM 'users' ";
            $result2 = $db->query($query2);

var_dump($result2->fetch_assoc());
            while($wynik = $result2->fetch_assoc()) {
                echo 'Login: ' . $wynik['login'] . ' ' . 'E-mail: ' . $wynik['email']. ' ' . 'Wiek: ' . $wynik['age']. ' '.'Miejscowość: ' . $wynik['miejscowosc'] . '<br>';
                echo '
<a href="editAdmin.php?login=' . $wynik['login'] . '">Edytuj</a><br>
<a href="deleteAdmin.php?login=' . $wynik['login'] . '">Usuń</a><br>



                    ';

            }
            echo '<br>
             <form action="editAdmin.php">
             <input type="submit" value="Edytuj">
             </form>
             <form action="deleteAdmin.php">
             <input type="submit" value="Usuń">
             </form>
             ';


        }

        elseif (!empty($user) && $user['login'] == $login && $user['pass'] == $pass)
        {
            //login sie zgadza informujemy uzytkownika


            $_SESSION['login'] = $login;

            $key = md5( $login . hash('sha256', $pass ));
            $_SESSION['key'] = $key;
            //echo $key;
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
                echo 'uzytkownik zalogowany z api '. $zm['login'].'<br>';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/chat/getActive");
                curl_setopt($ch, CURLOPT_POST,1);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

                curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."&key=".$key);
                $out = curl_exec($ch);

                $zm = json_decode($out,true);
                print_r($zm);
                curl_close($ch);




                echo '<br><br>Podaj nazwe rozmowy, którą chcesz utworzyć<br>
<form action="create.php" method="POST">
    <input type="text" name="login">
    <input type="submit" value="Create">
</form><br>';

                echo '<br>Podaj nazwe uzytkownika ktorego chcesz dodac do rozomowy<form action="join.php" method="POST">
    <input type="text" name="loginUser"><br>
    Podaj indetyfikator pokoju<br>
    <input type="text" name="id">
    <input type="submit" value="Join">
</form><br>';
                echo 'Podaj indetyfikator pokoju który chcesz opuścić<form action="leave.php" method="POST">
    <input type="text" name="id">
    <input type="submit" value="Leave">
</form>';


                echo '<br>Wyślij wiadomość<form action="send.php" method="POST">
    <input type="text" name="text"><br>
    Podaj indetyfikator pokoju<br>
    <input type="text" name="id">
    <input type="submit" value="Send">
</form><br>';
                echo '<br>Sprawdz wiadomość<form action="get.php" method="POST">
    <input type="submit" value="Get">
</form><br>';

                echo '<br>Tutaj mozesz edytowac swoje dane<form action="edit.php" method="POST">
    Password<input type="password" name="new_pass"><br>
   icon<input type="text" name="url_icon">
    <input type="submit" value="Edit">
</form><br>';



                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://tank.iai-system.com/api/user/getAll");
                curl_setopt($ch, CURLOPT_POST,1);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

                curl_setopt($ch, CURLOPT_POSTFIELDS, "login=".$login."");
                $out = curl_exec($ch);

                $zm = json_decode($out,true);
                print_r($zm);
                curl_close($ch);






            }
            else
            {
                echo ' nie zalogowany z api';
            }

                }


    }
    else{
        echo "Blad ".$db->error;
    }
}


