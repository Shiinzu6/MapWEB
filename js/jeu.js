$(document).ready(init);

function init(){

    var layerGroupPrefecture = L.layerGroup([]);
    var num = 0;
    let temps = 30;
    var points = 0;


    var prefectureIcon = L.icon({
        iconUrl : 'icon/prefecture.png',

        iconSize: [30,30],
        iconAnchor: [15,30],
        popupAnchor: [0,-30]
    });

    var map = L.map('map').setView([47.079452, 2.704009], 7);
    var OpenStreetMap = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    function updateTimer(){
        const timerElement = document.getElementById("numTimer")

        const interval = setInterval(() => {
            let secondes = parseInt(temps % 60, 10);

            secondes = secondes < 10 ? "0" + secondes : secondes;

            timerElement.innerText = `${secondes}`;
            temps = temps <= 0 ? 0 : temps - 1;

            if(temps == 0){
                $('#skip, #indice, #abandon,#reponse').css('display','none');
                $('#textTimer,#numTimer,#valider,#reponse').css('display','none');
                $('#restart,#accueil').css('display','block');
                addScore();
                clearInterval(interval)
            }
        }, 1000);
    }

    

    function randomDepartement(){
        randomNumber();
        markerDepartement();
    }

    $('#start,#restart').click(function(){
        removeMap();
        temps = 60;
        points = 0;
        afficherJeu();
        calculScore();
        updateTimer();
        randomDepartement();
    });

    $('#skip').click(function(){
        skipReponse();
        calculScore();
    });

    $('#abandon').click(function(){
        temps=0;
        $('#restart').css('display','block');
    });

    $('#tableauScore').click(function(){
        window.location.href = "tableauscore.php";
    });

    $('#indice').click(function(){
        points = points - 0.25;
        removeMap();
        L.marker([prefecture[num].properties.LatDD,prefecture[num].properties.LonDD],{icon: prefectureIcon}).addTo(map)
        .bindPopup("Commune : " + prefecture[num].properties.Commune).openPopup();
        calculScore();
    });

    $('.submitReponse').submit(function(){

        var maReponse = $('#reponse').val();
        verifReponse(maReponse);
        calculScore();
        clearInput();
        

    return false;
    });

    function addScore(){
        $.post('ajouterScore.php',{points:points},function(donnees){
            $('.infoAjout').html(donnees);
        });
    }

    function afficherJeu(){
        $('#start,#accueil,#restart,#infoAjoutScore').css('display','none');
        $('#skip, #indice, #abandon,#reponse').css('display','block');
        $('#textTimer,#numTimer,#numScore,#textScore,#valider').css('display','flex');
    }

    function calculScore(){
        document.getElementById("numScore").innerHTML = points;
    }

    function randomNumber(){
        num = Math.floor(Math.random() * (95 - 2 + 1) + 2)
        return num;
    }

    function markerDepartement(){
        layerGroupPrefecture.addLayer(L.marker([prefecture[num].properties.LatDD,prefecture[num].properties.LonDD],{icon: prefectureIcon})
        .bindPopup("Préfecture : " + prefecture[num].properties.Commune + "<br/> Departement : " +prefecture[num].properties.DeptNom + ", "  + prefecture[num].properties.DeptNum));
        L.marker([prefecture[num].properties.LatDD,prefecture[num].properties.LonDD],{icon: prefectureIcon})
        .addTo(map);
    }

    function verifReponse(reponse){
        if( reponse == prefecture[num].properties.DeptNum){
            points = points +1;
            removeMap();
            randomDepartement();
        }
    }

    function clearInput(){
        var getValue= document.getElementById("reponse");
        if (getValue.value !="") {
            getValue.value = "";
        }
    }


    function skipReponse(){
        points = points - 0.5;
        removeMap();
        randomDepartement();
    }

    function removeMap(){
        map.eachLayer(function(layer) {
            if (!!layer.toGeoJSON) {
            map.removeLayer(layer);
            }
        });
    }
}