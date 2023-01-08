<?php
    session_start();
    $email = $_POST['email'];
    $password = $_POST['password'];

    //DataBase Connection

    $con = new mysqli('localhost', 'root', 'root','test');
    if($con->connect_error){
        die("Connection Failed : ".$con->connect_error);
    }else{
        $stmt = $con->prepare("select * from registration where email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt_result= $stmt->get_result();
        if($stmt_result->num_rows > 0){
            $data = $stmt_result->fetch_assoc();
            if($data['psw'] === $password){
                $_SESSION['LOGGED_USERNAME'] = $data['uname'];
                $_SESSION['LOGGED_EMAIL'] = $data['email'];
                echo "<script>location.href = 'accueil.php'</script>";
            }else{
                echo "<p>Mauvais mot de passe. Veuillez le saisir à nouveau !</p>";
            }
        }else{
            echo "<p>Il n'existe aucun compte utilisant l'adresse mail " . $email . ".</p>";
        }
        
    }
?>