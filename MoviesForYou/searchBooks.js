var XMLHTTPBOOK = new XMLHttpRequest();
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
url_books = "http://localhost:8000/ProgettoIDW_BackEnd/unionmatching.php?s="+film+"&c=book";
XMLHTTPBOOK.open("GET", url_books, true);
XMLHTTPBOOK.send("");
var books = [];
XMLHTTPBOOK.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
        var ris_book = XMLHTTPBOOK.responseXML;
        var n_books = ris_book.getElementsByTagName('book').length;
        books = getBooks(ris_book,n_books);
        putBooks(books);
    }
}

function getBooks(ris,n_books){
    var book = null;
    var books = new Array();
    for(i=0; i < n_books; i++){
        book = new Object();
        if(typeof(ris.getElementsByTagName('title')[i].childNodes[0])== "undefined"){
            book.titolo = "Nessun titolo definito";
        }else book.titolo = ris.getElementsByTagName('title')[i].childNodes[0].nodeValue;
        
         if(typeof(ris.getElementsByTagName('img')[i].childNodes[0])== "undefined"){
            book.poster = "Nessuna copertina disponibile";
        }else book.poster = ris.getElementsByTagName('img')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('link')[i].childNodes[0])== "undefined"){
            book.link = "Nessuna descrizione disponibile";
        }else book.link = ris.getElementsByTagName('link')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('price')[i].childNodes[0])== "undefined"){
            book.price = "Nessuna descrizione disponibile";
        }else   book.price = ris.getElementsByTagName('price')[i].childNodes[0].nodeValue;

        if(typeof(ris.getElementsByTagName('data')[i].childNodes[0])== "undefined"){
            book.data = "Nessuna descrizione disponibile";
        }else   book.data = ris.getElementsByTagName('data')[i].childNodes[0].nodeValue;
        
        if(typeof(ris.getElementsByTagName('author')[i].childNodes[0])== "undefined"){
            book.author = "Nessuna descrizione disponibile";
        }else   book.author= ris.getElementsByTagName('author')[i].childNodes[0].nodeValue;

        books = appendObjTo(books,book);
    }
    return books;
}

function appendObjTo(array,obj){
    const frozenObj = Object.freeze(obj);
    return Object.freeze(array.concat(frozenObj));
}

function putBooks(articles){
    html = "";
    var size = null;
    if(search.length > 1){
        size = articles.length;
    }else size = 4;
    var el = document.getElementsByClassName('movie-list');
    
    for(i=0; i < size; i++){
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