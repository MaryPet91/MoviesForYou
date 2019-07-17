var search = window.location.search.substr(8);
var XMLHTTP = new XMLHttpRequest();
var XMLHTTPBOOK = new XMLHttpRequest();
if(search.length>0){
    var url = "http://localhost:8000/ProgettoIDW_BackEnd/unionmatching.php?s="+search+"&c=search";
    console.log(url);
    XMLHTTP.open("GET", url, true);
    XMLHTTP.send("");
    var movies = [];
    XMLHTTP.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var ris = XMLHTTP.responseXML;
                var n_films = ris.getElementsByTagName('film').length;
                movies = getFilms(ris,n_films);
                putFilms(movies);
                sessionStorage.setItem('movies',JSON.stringify(movies));
                console.log(movies);
            }
    }
}

function putFilms(movies){
    html = "";
    
    var el = document.getElementsByClassName('row');
    var size = movies.length;
    var row = 4;
    var type = window.location.search.substr(3);
    z = 0;
    for(i=0; i<size; i++){
        html += "<div id='riga' class='row match-to-row'>";
        for(j=0; j<size; j++){
            if(z<size){
            html += "<div class='col-lg-4 col-sm-6'>";
            html += "<a href='single.html?i="+z+"'>";
            html += "<div class='thumbnail'><img id='copertina' src='"+movies[z].poster+"' alt=''>";
            html += "<div class='content'><h1>"+movies[z].titolo+"</h1></div></div><a/></div>";
            z++
            }
        }
        html += "</div>";
    }
el[0].innerHTML = html;

}