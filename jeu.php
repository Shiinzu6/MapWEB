<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/jeu.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
     crossorigin=""/>

     <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
     integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
     crossorigin=""></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="js/PrefectureFrance.js"></script>
    <script src="js/jeu.js"></script>
</head>
<body>
    <div class="main">
        <h1>Jeu du département</h1>
        <div class="game">
            <button id="tableauScore">Tableau des scores</button>
            <div class="timer">
                <h1 id="textTimer">Timer :</h1>
                <h1 id="numTimer"></h1>
            </div>
            <div class="score">
                <h1 id="textScore"><?php echo $_SESSION['LOGGED_USERNAME'] ?> Score :</h1>
                <h1 id="numScore">0</h1>
            </div>
        </div>
        <div class="wrapper">
            <div class="description">
                <div class="regles">
                    <h2>LES REGLES</h2>
                    <p><strong style="color: #f71414">Le but du jeu est assez simple :</strong> une icone va apparaître sur la carte et il vous suffira de donner le numéro du département correspondant</p>
                    <br>
                    <p>Le but du jeu est d'obtenir le plus grand score en <strong style="color: #f71414">60 secondes</strong> !</p>
                    <br>
                    <p>Chaque <strong style="color: #04AA6D">BONNE REPONSE</strong> vous rapportera <strong style="color: #04AA6D">1 POINT</strong> <br><br>
                        Cependant  <strong style="color: #eba524">PASSER</strong> vous fera perdre <strong style="color: #eba524">0.5 POINT</strong> <br><br>
                        <strong style="color: rgb(39, 96, 255)">L'INDICE</strong> vous permet de savoir le nom d'une grande commune de ce département mais vous perdrez <strong style="color: rgb(39, 96, 255)">0.25 POINT</strong><br><br>
                        <br><br> <strong>Conseil :</strong> vous pouvez appuyer sur votre touche <strong>"Entrée" </strong>pour aller plus vite qu'en cliquant sur <strong style="color: #04AA6D">VALIDER</strong>
                    </p>
                </div>
                <div class="reponses">
                    <h2>JOUER ICI !</h2>
                    <?php 
                        if(isset($_SESSION['LOGGED_USERNAME'])){
                            include 'template/JeuButton.tpl';
                        } else{
                            echo "Connectez-vous afin de pouvoir jouer ! Cela permet d'ajouter automatiquement votre score au tableau !";
                        }
                    ?>
                    <button id="accueil" onclick="window.location.href='accueil.php';">Retour à l'accueil</button>
                    <button id="restart">Rejouer ?</button>
                    <div class="infoAjout">
                    </div>
                    <form class="submitReponse" method="POST">
                        <input id="reponse" placeholder="Hauts-de-Seine ou 92">
                        <input id="valider" type="submit" value="Valider ma réponse">
                    </form>
                    <div class="interaction">
                        <button id="skip">Passer</button>
                        <button id="indice">Indice ?</button>
                    </div>
                    <button id="abandon">Abandonner</button>
                </div>
            </div>
            <div id="map">

            </div>
        </div>
    </div>
</body>
</html>