function searchProvincia(provincia){
    var XMLHTTP = new XMLHttpRequest();
    provincia = provincia.toUpperCase()
    var url = "http://localhost:8000/ProgettoIDW_BackEnd/unionmatching.php?s="+provincia+"&c=cinema";
    
    XMLHTTP.open("GET", url, true);
    XMLHTTP.send("");
    var cinemas = [];
    XMLHTTP.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var ris = XMLHTTP.responseXML;
                var n_cinema = ris.getElementsByTagName('cinema').length;
                cinemas = getCinema(ris,n_cinema);
                drawPlaces(cinemas);
            }
    }
}

function searchRegione(regione){
    var XMLHTTP = new XMLHttpRequest();
    var url = "http://localhost:8000/ProgettoIDW_BackEnd/unionmatching.php?s="+regione+"&c=cinema";
    XMLHTTP.open("GET", url, true);
    XMLHTTP.send("");
    var cinemas = [];
    XMLHTTP.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var ris = XMLHTTP.responseXML;
                var n_cinema = ris.getElementsByTagName('cinema').length;
                cinemas = getCinema(ris,n_cinema);
                drawPlaces(cinemas);
              
            }
    }
}

function getCinema(ris,n_cinema){
        var cinema = null;
        var cinemas = new Array();
        for(i=0; i < n_cinema; i++){
            cinema = new Object();
            if(typeof(ris.getElementsByTagName('nome')[i].childNodes[0])== "undefined"){
                cinema.nome = "Nessun titolo definito";
            }else cinema.nome = ris.getElementsByTagName('nome')[i].childNodes[0].nodeValue;
            
             if(typeof(ris.getElementsByTagName('regione')[i].childNodes[0])== "undefined"){
                cinema.regione = "Nessuna copertina disponibile";
            }else cinema.regione     = ris.getElementsByTagName('regione')[i].childNodes[0].nodeValue;
            
            if(typeof(ris.getElementsByTagName('provincia')[i].childNodes[0])== "undefined"){
                cinema.provincia = "Nessuna descrizione disponibile";
            }else cinema.provincia = ris.getElementsByTagName('provincia')[i].childNodes[0].nodeValue;
            
            if(typeof(ris.getElementsByTagName('latitudine')[i].childNodes[0])== "undefined"){
                cinema.latitudine = "Nessuna descrizione disponibile";
            }else cinema.latitudine = ris.getElementsByTagName('latitudine')[i].childNodes[0].nodeValue;

            if(typeof(ris.getElementsByTagName('longitudine')[i].childNodes[0])== "undefined"){
                cinema.longitudine = "Nessuna descrizione disponibile";
            }else cinema.longitudine = ris.getElementsByTagName('longitudine')[i].childNodes[0].nodeValue;

            cinemas = appendObjTo(cinemas,cinema);
        }
        
        return cinemas;
}

function appendObjTo(array,obj){
    const frozenObj = Object.freeze(obj);
    return Object.freeze(array.concat(frozenObj));
}

function drawPlaces(cinema){
    var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var labelIndex = 0;
    
        var naples = { lat: 40.853294, lng: 14.305573 };
         map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center:naples
        });

        for(i=0; i < cinema.length; i++){
            console.log(cinema[i].latitudine, cinema[i].longitudine);
            var place = {lat: parseFloat(cinema[i].latitudine), lng:parseFloat(cinema[i].longitudine)};
            add(place);
        }

    // Adds a marker to the map.
    function addMarker(location, map) {
        // Add the marker at the clicked location, and add the next-available label
        // from the array of alphabetical characters.
        var marker = new google.maps.Marker({
            position: location,
            //label: labels[labelIndex++ % labels.length],
            map: map
        });
        console.log(map)
    }

    function add(location) {
        addMarker(location, map);
    }

    google.maps.event.addDomListener(window, 'load', initialize);
}
