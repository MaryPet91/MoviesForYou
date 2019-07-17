var search = window.location.search.substr(8);
var XMLHTTP = new XMLHttpRequest();

if(search.length>0){
    var url = "http://localhost:8000/ProgettoIDW_BackEnd/unionmatching.php?s="+search+"&c=trailer";
    console.log(url);
    XMLHTTP.open("GET", url, true);
    XMLHTTP.send("");
    var trailers = [];
    XMLHTTP.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var ris = XMLHTTP.responseXML;
                var n_trailer = ris.getElementsByTagName('trailer').length;
                trailers = getTrailers(ris,n_trailer);
                putTrailers(trailers);
                console.log(trailers);
            }
    }
}

function getTrailers(ris,n_trailers){
    var trailer = null;
    var trailers = new Array();
    for(i=0; i < n_trailers; i++){
        trailer = new Object();
        if(typeof(ris.getElementsByTagName('title')[i].childNodes[0])== "undefined"){
            trailer.titolo = "Nessun titolo definito";
        }else trailer.titolo = ris.getElementsByTagName('title')[i].childNodes[0].nodeValue;
        
         if(typeof(ris.getElementsByTagName('videoId')[i].childNodes[0])== "undefined"){
            trailer.videoId = "Nessuna copertina disponibile";
        }else trailer.videoId = ris.getElementsByTagName('videoId')[i].childNodes[0].nodeValue;

        trailers = appendObjTo(trailers,trailer);
    }
    return trailers;
}

function appendObjTo(array,obj){
    const frozenObj = Object.freeze(obj);
    return Object.freeze(array.concat(frozenObj));
}

function putTrailers(trailers){
    html = "";
    var el = document.getElementsByClassName('movie-list');
    var size = trailers.length;
    for(i=0; i < size; i++){
        trailer = trailers[i].videoId;
        trailer = trailer.replace("watch?v=", "embed/");
        html += "<div class='col'>";
        html += "<div class='movie-title'><p>"+trailers[i].titolo+"</p></div>";
        html += "<center><figure class='movie-poster'>";
        html += "<iframe width='1000' height='500' src='"+trailer+"'frameborder='0' allowfullscreen></iframe>";
        html += "</figure></center>";
        html += "</div>";
    }
    el[0].innerHTML = html;
}