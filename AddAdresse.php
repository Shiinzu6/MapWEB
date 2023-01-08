<?php
session_start();
    
    $adresse = $_POST['adresse'];
    
    if(isset($_SESSION['LOGGED_USERNAME'])){
        $email = $_SESSION['LOGGED_EMAIL'];
        $uname = $_SESSION['LOGGED_USERNAME'];

        //DataBase Connection
        $conn = new mysqli('localhost', 'root', 'root','test');
        if($conn->connect_error){
            die('Connection Failed : '.$conn->connect_error);
        }else{
            $stmt = $conn->prepare("insert into adresseregister(email,uname,adress)
                values('$email','$uname','$adresse')");
            $stmt->execute();
            echo 'Votre adresse a parfaitement été enregistré !';
            $stmt->close();
            $conn->close();
        }
    } else{
        echo "<script>location.href = 'Redirection/NeedConnectionAddAdresse.html'</script>";
    }
        

?>