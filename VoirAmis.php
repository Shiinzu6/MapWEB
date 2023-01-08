<?php
    session_start();

    // VERIFIER LA CONNEXION A UN COMPTE
    if(isset($_SESSION['LOGGED_USERNAME'])){
        $user = $_SESSION['LOGGED_USERNAME'];

        // DATABASE CONNEXION

        $con = new mysqli('localhost', 'root', 'root','test');
        if($con->connect_error){
            die("Connection Failed : ".$con->connect_error);
        }else{

            // REQUETE SQL

            $result = $con->query("SELECT * FROM amis WHERE uname = '$user' ");
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<button class='amiBox'>" . $row["usernameAmi"] . "</button>";
                }
            }
        }
    } else{
        echo "<script>location.href = 'NeedConnection.html'</script>";
        include_once "NeedConnection.tpl";
        header( "refresh:6; url=connexion.html" );
    }
    
?>