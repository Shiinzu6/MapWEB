<?php
session_start();
    $email = $_POST['email'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $num = $_POST['num'];
    $uname = $_POST['uname'];
    $psw = $_POST['psw'];

    //DataBase Connection

    $conn = new mysqli('localhost', 'root', 'root','test');
    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);
    }else{
        $result = $conn->query("SELECT * FROM registration WHERE email = '$email' ");
        $result2 = $conn->query("SELECT * FROM registration WHERE uname = '$uname' ");
        if($result->num_rows > 0 OR $result2->num_rows > 0){
            echo "Cette adresse mail ou ce pseudonyme est déjà utilisé(e).";
        } else {
            $stmt = $conn->prepare("insert into registration(prenom,nom,email,psw,num,uname)
            values(?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssis",$prenom,$nom,$email,$psw,$num,$uname);
            $stmt->execute();
            $_SESSION['LOGGED_USERNAME'] = $uname;
            $_SESSION['LOGGED_EMAIL'] = $email;
            $stmt->close();
            $conn->close();
            echo "<script>location.href = 'template/EnregistrementEffectue.php'</script>";
        }
    }
?>