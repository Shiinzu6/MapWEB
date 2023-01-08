<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/NeedConnection.css">
</head>
<body>
    <div class="wrapper">
        <h2>Bienvenue parmis nous <?php echo $_SESSION['LOGGED_USERNAME'] ?> !</h2>
        <h3>Vous allez être redirigé vers la page d'accueil dans 5 secondes...</h3>
        <script>function gonews() {
            window.location.href = "../accueil.php";
        }
         
        (function() {
            setTimeout(gonews, 6000);
        })();;</script>
    </div>
</body>
</html>