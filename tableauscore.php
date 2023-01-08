<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/tableauscore.css">

  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="js/connexion.js"></script>

</head>
<body>
  <div class="wrapper">
    <h1>Tableau des scores</h1>
    <div class="scores">
      <div class="headerScore">
        <p>NOM D'UTILISATEUR</p>
        <p>POINTS</p>
      </div>
      <?php include "tableauscoreCalcul.php" ?> 
    </div>
    <form class="submitLoginForm" method="post">
    </form>
    <div class="containerBoutton">
      <button type="button" onclick="window.location.href='jeu.php';" class="registerbtn">Retour</button>
      <button type="button" onclick="window.location.href='accueil.php';" class="cancelbtn">Accueil</button>
    </div>
  </div>
</body>
</html>