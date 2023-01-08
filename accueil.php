<?php session_start();

/* ini_set('display_errors', 'off');*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    <?php include 'css/style.css'; ?>
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
        crossorigin=""></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="js/PrefectureFrance.js"></script>
    <script src="js/GareFrance.js"></script>
    <script src="js/accueil.js"></script>
</head>
<body>
    <div class="main">
        <div class="header">
            <h3 id="MessageLogin">
            <?php
            if (isset($_SESSION['LOGGED_USERNAME'])){
                $connecte = "Heureux de vous revoir ". $_SESSION['LOGGED_USERNAME'] . " !";
                echo $connecte;
            }else{
                echo "Connectez vous via le bouton de login pour accéder au jeu et à votre liste d'amis !";
            }
            ?>
            </h3>
            <div class="header-bouton">
            <button id="Reset">Reset la carte</button>
            
                <?php 
                if (isset($_SESSION['LOGGED_USERNAME'])){
                    include_once "template/VoirAmisBoutton.tpl";
                    include_once "template/jeu.tpl";
                    include_once "template/logoutButton.tpl";
                } else{
                    include_once "template/loginButton.tpl";
                }
                ?>
            </div>
        </div>
        <div class="wrapper">
            <div class="contact">
                <h1>Paramètres de la carte</h1>
                <div class="items-wrapper">
                    <div class="item">
                        <form class="villeForm" method="POST">
                            <label for="adresse">Recherchez une adresse et ajoutez la : </label>
                            <input id="addr" placeholder="Saisissez une ville" name="adresse" value="">
                            <div class="boutonItem1">
                                <button id="boutonSearch" type="button">Chercher</button>
                            </div>
                            <div id="pNew">
                                <p id="p1"></p>
                                <input class="submit" id="Chercher" type="submit" value="Ajouter cette adresse">
                                <p id="p1 2"></p>
                            </div>
                        </form>
                    </div>
                    <div id="results"></div>
                    <div class="item">
                        <form>
                            <label for="prefecture2">Rechercher une prefecture française :</label>
                            <input id="prefecture2" type="text" placeholder="Saisissez une prefecture" name="prefecture2" value="">
                            <div class="boutonItem2">
                                <button id="boutonSearch" type="button">Chercher</button>
                            </div>
                        </form>
                    </div>
                    <div class="item">
                        <form class="AmiForm" method="POST">
                            <label for="amis">Rechercher et ajouter un ami !</label>
                            <input id="ami" type="text" placeholder="Nom d'utilisateur" name="amis" value="">
                            <input id="boutonSearch" type="submit" value="Chercher un utilisateur">
                            <div class="infoAmi">

                            </div>
                            <input id='ajouterAmi' type='button' value=''>
                            <div class="infoAmiButton">
                            </div>
                        </form>
                    </div>
                    <div class="item">
                        <form class="VoirAdressesForm" method="POST">
                            <label for="adresse">Afficher vos adresses précedemment enregistrées !</label>
                            <input id="adresseSubmit" type="submit" name="adresseSubmit" value="Afficher mes adresses">
                            <input id="adresseNoSubmit" type="button" name="adresseSubmit" value="Annuler l'action">
                            <div class="infoAdress">
                                <label>Avant d'afficher vos adresses, voulez-vous réinitialiser la carte ?</label>
                                <div class="bouttonMarker">
                                    <button id="deleteMarkerOui">Oui</button>
                                    <button id="deleteMarkerNon">Non</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="itemsCheckbox-wrapper">
                    <div class="item">
                        <div class="itemCheckbox">
                            <label for="prefecture">Afficher les prefectures : </label>
                            <input id="checkboxPrefecture" type="checkbox" name="prefecture" value="AfficherPrefecture">
                        </div>
                    </div>
                    <div class="item">
                        <div class="itemCheckbox">
                            <label for="velib">Afficher les stations de velib : </label>
                            <input id="checkboxVelib" type="checkbox" name="velib" value="AfficherVelib">
                        </div>
                    </div>
                    <div class="item">
                        <div class="itemCheckbox">
                            <label for="gares">Afficher les 800 premières gares : </label>
                            <input id="checkboxGares" type="checkbox" name="gares" value="AfficherGares">
                        </div>
                    </div>
                </div>
            </div>
            <div id="map"></div>
        </div>
        <div class=AmisDiv>
        </div>
    </div>
</body>
</html>