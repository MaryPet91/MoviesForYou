var XMLHTTP = new XMLHttpRequest();
var search = window.location.search.substr(3);
if(search.length > 1){
   search = window.location.search.substr(8);
   film = search;
   console.log(search); 
}else{
    var movies = JSON.parse(sessionStorage.getItem('movies'));
    film = movies[search].titolo;
    console.log(film);
}
url_s = "http://localhost:8000/ProgettoIDW_BackEnd/unionmatching.php?s="+film+"&c=dvd";
XMLHTTP.open("GET", url_s, true);
XMLHTTP.send("");
var s = [];
XMLHTTP.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
        var ris= XMLHTTP.responseXML;
        var n_s = ris.getElementsByTagName('dvd').length;
        s = getDvds(ris,n_s);
        console.log(s);
        putsDvds(s);
    }
}

function getDvds(ris,n_s){
    var  dvd = null;
    var dvds = new Array();
    for(i=0; i < n_s; i++){
         dvd = new Object();
        if(typeof(ris.getElementsByTagName('title')[i].childNodes[0])== "undefined"){
            dvd.titolo = "Nessun titolo definito";
        }else dvd.titolo = ris.getElementsByTagName('title')[i].childNodes[0].nodeValue;
        
         if(typeof(ris.getElementsByTagName('img')[i].childNodes[0])== "undefined"){
            dvd.poster = "Nessuna copertina disponibile";
        }else dvd.poster = ris.getElementsByTagName('img')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('link')[i].childNodes[0])== "undefined"){
            dvd.link = "Nessuna descrizione disponibile";
        }else dvd.link = ris.getElementsByTagName('link')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('price')[i].childNodes[0])== "undefined"){
            dvd.price = "Nessuna descrizione disponibile";
        }else   dvd.price = ris.getElementsByTagName('price')[i].childNodes[0].nodeValue;

        if(typeof(ris.getElementsByTagName('data')[i].childNodes[0])== "undefined"){
            dvd.data = "Nessuna descrizione disponibile";
        }else   dvd.data = ris.getElementsByTagName('data')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('type')[i].childNodes[0])== "undefined"){
            dvd.author = "Nessuna descrizione disponibile";
        }else   dvd.author= ris.getElementsByTagName('type')[i].childNodes[0].nodeValue;

        dvds = appendObjTo(dvds,dvd);
    }
    return dvds;
}

function appendObjTo(array,obj){
    const frozenObj = Object.freeze(obj);
    return Object.freeze(array.concat(frozenObj));
}

function putsDvds(articles){
    html = "";
    console.log('ok');
    var el = document.getElementsByClassName('movie-list');
    for(i=0; i < 4; i++){
        html += "<div class='movie'>";
        html += "<figure class='movie-poster'><img src='"+articles[i].poster+"' alt='#'></figure>";
        html += "<div class='movie-title'>"+articles[i].titolo+"</div>";
        html += "<p>"+articles[i].data+"</p>";
        html += "<p><strong>Price: </strong>"+articles[i].price+"€</p>";
        html += "<p>"+articles[i].author+"</p>";
        html += "<p><li class='button'><a href='"+articles[i].link+"'>Get Amazon</a></li></p>";
        html += "</div>";
    }
    el[0].innerHTML = html;
}