$(document).ready(init);


function init(){

    //
    // Initialisation de certaines variables
    //
    var latitude;
    var longitude;
    var textP;
    var color;
    var layerGroupPrefecture = L.layerGroup([]);
    var layerGroupPrefecture2 = L.layerGroup([]);
    var layerGroupVelib = L.layerGroup([]);
    var layerGroupGare = L.layerGroup([]);
    const EtatLocalisation = ["Localisation parfaitement trouvée","Localisation parfaitement trouvée mais il n'existe aucun polygon pour cette localisation.","Impossible de trouver cette localisation"];


    //
    // Icon personnalisée
    //
    var velib = L.icon({
        iconUrl : 'icon/Velib.png',

        iconSize: [80,80],
        iconAnchor: [40,80],
        popupAnchor: [0,-58]
    });

    var maison = L.icon({
        iconUrl : 'icon/home-address.png',

        iconSize: [60,60],
        iconAnchor: [30,60],
        popupAnchor: [0,-60]
    });

    var prefectureIcon = L.icon({
        iconUrl : 'icon/prefecture.png',

        iconSize: [30,30],
        iconAnchor: [15,30],
        popupAnchor: [0,-30]
    });

    var gareIcon = L.icon({
        iconUrl : 'icon/gare1.png',

        iconSize: [20,20],
        iconAnchor: [10,20],
        popupAnchor: [0,-20]
    });
    

    var map = L.map('map').setView([48.8417855,2.2682168], 5);
    var OpenStreetMap = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    //
    // Permet d'afficher toutes les prefectures de france si la checkbox est cochée, ou de les effacer si elle est décochée
    //
    $("#checkboxPrefecture").change(function(){
        if ($(this).prop("checked")) {
            for(i = 0; i < prefecture.length; i++){
                layerGroupPrefecture.addLayer(L.marker([prefecture[i].properties.LatDD,prefecture[i].properties.LonDD],{icon: prefectureIcon})
                .bindPopup("Préfecture : " + prefecture[i].properties.Commune + "<br/> Departement : " +prefecture[i].properties.DeptNom + ", "  + prefecture[i].properties.DeptNum));
                layerGroupPrefecture.addTo(map);
            }
        } else{
            map.removeLayer(layerGroupPrefecture);
        }
    });

    //
    // FONCTION PERMETTANT DE CHERCHER UNE PREFECTURE EN FRANCE GRACE AU FICHIER JSON ( PrefectureFrance.js )
    //
    function validerPrefecture(){
        if (layerGroupPrefecture2.getLayers().length > 0){
            layerGroupPrefecture2.clearLayers();
        }
        for(i = 0; i < prefecture.length; i++){
            if($("#prefecture2").val() == prefecture[i].properties.Commune){
                map.flyTo([prefecture[i].properties.LatDD,prefecture[i].properties.LonDD], 10);
                layerGroupPrefecture2.addLayer(L.marker([prefecture[i].properties.LatDD,prefecture[i].properties.LonDD],{icon: prefectureIcon}).addTo(map)
                    .bindPopup("Préfecture : " + prefecture[i].properties.Commune + "<br/> Departement : " +prefecture[i].properties.DeptNom + ", "  + prefecture[i].properties.DeptNum)
                    .openPopup());
                layerGroupPrefecture2.addTo(map);
            }
        }
    }

    //
    // Fonction permettant de chercher n'importe quelle adresse et d'afficher son marker + son polygon grâce à nominatim
    // 
    // La fonction comporte 2 conditions vérifiant si le JSON de Nominatim retourne un Polygon ou un MultiPolygon car la manière d'y accéder n'est pas la même
    // Cela permet donc d'afficher le Polygon ou MultiPolygon de n'importe quelle ville
    //
    function addr_search() {
        var inp = document.getElementById("addr");
        randomColor();
        $.getJSON('http://nominatim.openstreetmap.org/search?format=json&polygon_geojson=1&limit=1&q=' + inp.value, function(data){
            if(data.length > 0){
                if(data[0].geojson.type == "Polygon"){
                    textP = document.createTextNode(EtatLocalisation[0]);
                    modifyText();
                    var latlngs= L.GeoJSON.coordsToLatLngs(data[0].geojson.coordinates[0], 0, false)
                    var polygon = L.polygon(latlngs, {color: color, opacity: 1, weight: 3}).addTo(map);
                    map.flyTo([data[0].lat,data[0].lon], 11);
                }else if(data[0].geojson.type == "MultiPolygon"){
                    textP = document.createTextNode(EtatLocalisation[0]);
                    modifyText();
                    for(i = 0; i < data[0].geojson.coordinates.length; i++){
                        var latlngs= L.GeoJSON.coordsToLatLngs(data[0].geojson.coordinates[i][0], 0, false);
                        var polygon = L.polygon(latlngs, {color: color, opacity: 1, weight: 5, fill: true, fillOpacity: 0.3}).addTo(map);
                        map.flyTo([data[0].lat,data[0].lon], 8);
                        /* map.fitBounds(polygon.getBounds()); */
                    }
                }else if(data[0].geojson.type == "Point"){
                    textP = document.createTextNode(EtatLocalisation[1]);
                    modifyText();
                    map.flyTo([data[0].lat,data[0].lon], 15);
                }
            } else{
                textP = document.createTextNode(EtatLocalisation[2]);
                modifyText();
            }
            L.marker([data[0].lat,data[0].lon], {icon: maison}).addTo(map)
            .bindPopup("Adresse complète : "+ [data[0].display_name])
            .openPopup();
        });
    } 


    $("#checkboxVelib").change(function(){
        $.getJSON('https://velib-metropole-opendata.smoove.pro/opendata/Velib_Metropole/station_information.json', function(data){
            if ($("#checkboxVelib").prop("checked")) {
                for(i=0; i < 300; i++){
                    L.marker([data.data.stations[i].lat, data.data.stations[i].lon], {icon: velib}).addTo(layerGroupVelib)
                    .bindPopup("Station : " + data.data.stations[i].name);
                    layerGroupVelib.addTo(map);
                }
                map.flyTo([48.8588897,2.3200410217200766], 11.5);
            } else{
                map.removeLayer(layerGroupVelib);
                map.flyTo([48.8417855,2.2682168], 5);
            }
        });
    });

    $("#checkboxGares").change(function(){
        if ($(this).prop("checked")) {
            for(i = 0; i < 800; i++){
                layerGroupGare.addLayer(L.marker(gares[i].fields.geo_point_2d,{icon: gareIcon})
                .bindPopup("Gare de " + gares[i].fields.libelle));
                layerGroupGare.addTo(map);
            }
        } else{
            map.removeLayer(layerGroupGare);
        }
    });

    //
    // Selector JQUERY permettant d'agir sur la carte via des fonctions lors d'un event.
    //
    $("#bouttonSearch").on("click",addr_search);
    $("#inputValider").on("click",validerPrefecture);

    //
    // Fonction permettant de modifier l'état de la recherche de la Localisation
    //
    function modifyText(){
        modifyColorText();
        $("p").html(textP);
    }

    //
    // Fonction permettant de modifier la couleur du texte avant de le modifier
    // Des conditions sont vérifiés afin de savoir quelle couleur mettre selon l'état de la recherche.
    //
    function modifyColorText(){
        if(textP.length === EtatLocalisation[0].length){
            $("p").css('color', 'green');
        }else if(textP.length === EtatLocalisation[1].length){
            $("p").css('color', 'orange');
        }else if(textP.length === EtatLocalisation[2].length){
            $("p").css('color', 'red');
        }
    }

    //
    // Fonction permettant de générer une couleur aléatoire
    //
    function randomColor(){
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        color= "rgb("+r+" ,"+g+","+ b+")";
    }

}



