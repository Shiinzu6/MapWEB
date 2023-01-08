<?php
    session_start();

    $usernameAmi = $_POST['monAmi'];

        // CONNEXION DATABASE

        $con = new mysqli('localhost', 'root', 'root','test');
        if($con->connect_error){
            die("Connection Failed : ".$con->connect_error);
        }else{

            // REQUETE SQL

            $result = $con->query("SELECT * FROM registration WHERE uname = '$usernameAmi' ");
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $datas[] = $row["uname"];
                }
                foreach($datas as $value){
                    if($value == $usernameAmi){ // SUCCES
                        echo "<p id='pUtilisateurTrouve'>L'utilisateur " . $usernameAmi . " existe. Veuillez confirmer l'action</p>";
                        echo "<style type='text/css'> #ajouterAmi {display: block;}</style>";
                    }
                }
            }else{ // ECHEC
                echo "<p id='pUtilisateurNonTrouve'>L'utilisateur " . $usernameAmi . " n'existe pas. Vérifiez l'orthographe ou cherchez quelqu'un d'autre </p>";
            }
            
        }

?>