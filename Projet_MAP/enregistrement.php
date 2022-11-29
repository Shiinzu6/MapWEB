<?php
    $email = $_POST['email'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $num = $_POST['num'];
    $uname = $_POST['uname'];
    $psw = $_POST['psw'];
    $gender = $_POST['gender'];

    //DataBase Connection

    $conn = new mysqli('localhost', 'root', 'root','test');
    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);
    }else{
        $stmt = $conn->prepare("insert into registration(prenom,nom,gender,email,psw,num,uname)
            values(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis",$prenom,$nom,$gender,$email,$psw,$num,$uname);
        $stmt->execute();
        echo"registration Successfully...";
        $stmt->close();
        $conn->close();
        header('Location: accueil.html');
    }
?>