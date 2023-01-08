<?php
    session_start();

    //DataBase Connection

    $con = new mysqli('localhost', 'root', 'root','test');
    if($con->connect_error){
        die("Connection Failed : ".$con->connect_error);
    }else{
        $result = $con->query("SELECT * from score ORDER BY points DESC");
        if($result->num_rows > 0){
            $i = 0;
            while($row = $result->fetch_assoc()){
                echo "<div class='infoScore'><p id='username'>" . $row["uname"] . "</p> <p id='score'>" . $row["points"] . "</p></div>";
                $i = $i + 1;
            }
        }else{
            echo "<p>Il n'existe aucun compte utilisant l'adresse mail.</p>";
        }
        
    }
?>