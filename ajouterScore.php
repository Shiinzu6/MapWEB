<?php
    session_start();

    // VERIFICATION CONNEXION 
    if(isset($_SESSION['LOGGED_USERNAME'])){
        $user = $_SESSION['LOGGED_USERNAME'];
        $points = $_POST['points'];

        //DataBase Connection
        $conn = new mysqli('localhost', 'root', 'root','test');
        if($conn->connect_error){
            die('Connection Failed : '.$conn->connect_error);
        }else{
            $exist = $conn->query("SELECT points FROM score WHERE uname = '$user' ");
            if($exist->num_rows > 0){
                $row = $exist->fetch_assoc();
                $ancienScore = $row["points"];
                if($ancienScore >= $points){
                    echo "<p id='infoAjoutScore'>Votre précédent score était de <strong>" . $ancienScore . "</strong> Faites mieux pour mettre à jour votre score !</p>";
                }else{
                    $conn->query("DELETE FROM score WHERE uname='$user'");
                    $result = $conn->query("INSERT INTO score(uname,points) VALUES('$user','$points')");
                    echo "<p id='infoAjoutScore'>Votre précédent score était de <strong>" . $ancienScore . "</strong> Votre nouveau score de <strong>" . $points . "</strong> a donc été mis à jour !</p>";
                }
            } else{
                $result = $conn->query("INSERT INTO score(uname,points) VALUES('$user','$points')");
                echo "<p id='infoAjoutScore'>Votre score de " . $points . " a bien été ajouté au tableau !</p>";
                $conn->close();
            }
        }
    } else{
        echo "<script>location.href = 'Redirection/NeedConnectionAddAmi.html'</script>";
    }

?>