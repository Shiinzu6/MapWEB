<?php
    session_start();


    // VERIFIER LA CONNEXION A UN COMPTE
    if(isset($_SESSION['LOGGED_USERNAME'])){
        $user = $_SESSION['LOGGED_USERNAME'];
        $usernameAmi = $_POST['ami'];

        // DATABASE CONNEXION

        $con = new mysqli('localhost', 'root', 'root','test');
        if($con->connect_error){
            die("Connection Failed : ".$con->connect_error);
        }else{

            // REQUETE SQL
            if($usernameAmi != ''){
                $result = $con->query("SELECT adress FROM adresseregister WHERE uname = '$usernameAmi' ");
            } else{
                $result = $con->query("SELECT adress FROM adresseregister WHERE uname = '$user' ");
            }
            if($result->num_rows > 0){
                $i = 0;
                while($row = $result->fetch_assoc()){
                    $datas[] = $row["adress"];
                    
                }
                $newtest = implode("|",$datas);
                echo $newtest;
            }
        }
    } else{
        echo "<script>location.href = 'Redirection/NeedConnectionVoirAdresse.html'</script>";
    }
    
?>