function loadNews(){
    var XMLHTTPBOOK = new XMLHttpRequest();
    var url_news = "http://localhost:8000/ProgettoIDW_BackEnd/unionmatching.php?c=news";
    XMLHTTPBOOK.open("GET",url_news,true);
    XMLHTTPBOOK.send("");
    articles = [];
    console.log('aspe');
    XMLHTTPBOOK.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
            var ris = XMLHTTPBOOK.responseXML;
            var n_article = ris.getElementsByTagName('article').length;
            articles = getArticles(ris,n_article);
            //putArticles(articles);
            sessionStorage.setItem('articles',JSON.stringify(articles));
            }
        }
}

function open(cat){
    var XMLHTTP = new XMLHttpRequest();
    if(cat=='news'){
        var url_news = "http://localhost:8000/ProgettoIDW_BackEnd/unionmatching.php?c=news";
        XMLHTTP.open("GET",url_news,true);
        XMLHTTP.send("");
        articles = [];
        console.log('aspe');
        XMLHTTP.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                var ris = XMLHTTP.responseXML;
                    var n_article = ris.getElementsByTagName('article').length;
                    articles = getArticles(ris,n_article);
                    putArticles(articles);
                    sessionStorage.setItem('articles',JSON.stringify(articles));
            }
        }

    }
    if(cat=='upComing'){
        var url = "http://localhost:8000/ProgettoIDW_BackEnd/unionmatching.php?s=upComing";
        console.log(url);
        XMLHTTP.open("GET", url, true);
        XMLHTTP.send("");
        var movies = [] ;
        XMLHTTP.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var ris = XMLHTTP.responseXML;
                    var n_films = ris.getElementsByTagName('film').length;
                    movies = getFilms(ris,n_films);
                    putData(movies);
                    sessionStorage.setItem('movies',JSON.stringify(movies));
                    
                    loadNews();
                }
        }
    }
}
function getArticles(ris,n_article){
    var article = null;
    var articles = new Array();
    for(i=0; i < n_article; i++){
        article = new Object();
        if(typeof(ris.getElementsByTagName('title')[i].childNodes[0])== "undefined"){
            article.titolo = "Nessun titolo definito";
        }else article.titolo = ris.getElementsByTagName('title')[i].childNodes[0].nodeValue;
        
         if(typeof(ris.getElementsByTagName('img')[i].childNodes[0])== "undefined"){
            article.poster = "Nessuna copertina disponibile";
        }else article.poster = ris.getElementsByTagName('img')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('link')[i].childNodes[0])== "undefined"){
            article.link = "Nessuna descrizione disponibile";
        }else article.link = ris.getElementsByTagName('link')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('art')[i].childNodes[0])== "undefined"){
            article.art = "Nessuna descrizione disponibile";
        }else article.art = ris.getElementsByTagName('art')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('review')[i].childNodes[0])== "undefined"){
            article.review = "Nessuna lingua disponibile";
        }else article.review = ris.getElementsByTagName('review')[i].childNodes[0].nodeValue;

        articles = appendObjTo(articles,article);
    }
    return articles;
}

function getFilms(ris,n_films){
    var film = null;
    var movies = new Array();
    for(i=0; i < n_films; i++){
        film = new Object();
        if(typeof(ris.getElementsByTagName('title')[i].childNodes[0])== "undefined"){
            film.titolo = "Nessun titolo definito";
        }else film.titolo = ris.getElementsByTagName('title')[i].childNodes[0].nodeValue;
        
         if(typeof(ris.getElementsByTagName('poster')[i].childNodes[0])== "undefined"){
            film.poster = "Nessuna copertina disponibile";
        }else film.poster = ris.getElementsByTagName('poster')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('rating')[i].childNodes[0])== "undefined"){
            film.rating = "Nessuna descrizione disponibile";
        }else film.rating = ris.getElementsByTagName('rating')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('description')[i].childNodes[0])== "undefined"){
            film.description = "Nessuna descrizione disponibile";
        }else film.description = ris.getElementsByTagName('description')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('lan')[i].childNodes[0])== "undefined"){
            film.lan = "Nessuna lingua disponibile";
        }else film.lan = ris.getElementsByTagName('lan')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('genre')[i].childNodes[0])== "undefined"){
            film.genre = "Nessun genere disponibile";
        }else film.genre = ris.getElementsByTagName('genre')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('year')[i].childNodes[0])== "undefined"){
            film.year = "Nessun anno disponibile";
        }else film.year = ris.getElementsByTagName('year')[i].childNodes[0].nodeValue;

        if(typeof(ris.getElementsByTagName('trailer')[i].childNodes[0])== "undefined"){
            film.trailer = "Nessun anno disponibile";
        }else film.trailer = ris.getElementsByTagName('trailer')[i].childNodes[0].nodeValue;

        movies = appendObjTo(movies,film);
    }
    
    return movies;
}

function appendObjTo(array,obj){
    const frozenObj = Object.freeze(obj);
    return Object.freeze(array.concat(frozenObj));
}

function putData(movies){
    html = "";
    
    var el = document.getElementsByClassName('row');
    var size = movies.length;
    var row = 4;
    var type = window.location.search.substr(3);
    if(type.length>2)
        return;
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

function putArticles(articles){
    html = "";
    
    var el = document.getElementsByClassName('movie-list');
    var size = articles.length;
    var row = 4;
    for(i=0; i < size; i++){
        html += "<div class='movie'>";
        html += "<a href='article.html?i="+i+"'>";
        html += "<figure class='movie-poster'><img src='"+articles[i].poster+"' alt='#'></figure>";
        html += "<div class='movie-title'><a href='article.html?i="+i+"'>"+articles[i].titolo+"</a></div>";
        html += "<p>"+articles[i].art+"</p>";
        html += "</div>";
    }
    el[0].innerHTML = html;
}

function getNews(){
    var articles = JSON.parse(sessionStorage.getItem('articles'));
    putArticles(articles);
}