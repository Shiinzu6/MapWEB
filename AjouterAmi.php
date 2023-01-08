<?php
    session_start();

    // VERIFICATION CONNEXION 
    if(isset($_SESSION['LOGGED_USERNAME'])){
        $user = $_SESSION['LOGGED_USERNAME'];

        $usernameAmi = $_POST['monAmi'];

        //DataBase Connection
        $conn = new mysqli('localhost', 'root', 'root','test');
        if($conn->connect_error){
            die('Connection Failed : '.$conn->connect_error);
        }else{

            //REQUETE SQL
            if($user == $usernameAmi){
                echo "<p id='pUtilisateurNonTrouve'>Vous ne pouvez pas vous ajouté vous même !</p>";
                exit();
            }
            $result = $conn->query("SELECT * FROM amis WHERE uname = '$user' AND usernameAmi ='$usernameAmi' ");
            if($result->num_rows > 0){
                echo "<p id='pUtilisateurNonTrouve'>$usernameAmi existe déjà dans votre liste d'amis !</p>";
            } else{
                $stmt = $conn->prepare("INSERT INTO amis(idAmitie,uname,usernameAmi)
                VALUES(NULL,'$user','$usernameAmi')");
                $stmt->execute();
                echo "<p id='pUtilisateurTrouve'>$usernameAmi a parfaitement été enregistré dans votre liste d'ami !</p>";
                $stmt->close();
                $conn->close();
            }
        }
    } else{
        echo "<script>location.href = 'Redirection/NeedConnectionAddAmi.html'</script>";
    }

?>