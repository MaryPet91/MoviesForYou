<?php
include_once 'DBConnection.php';
include_once 'utility.php';
include_once 'film.php';
include_once 'libro.php';
include_once 'cinema.php';
include_once 'trailer.php';
include_once 'article.php';

if(isset($_GET['s']) && isset($_GET['c']) && strcmp($_GET['c'],'book')==0){
    $search = $_GET['s'];
    $url_books= "http://localhost:8000/ProgettoIDW_BackEnd/wAmazonBook.php?s=".$search."&c=book";

    $books = getBook($url_books);
    
    header('Access-Control-Allow-Origin: *');
    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<books>';
    for($i=0; $i< count($books); $i++){
        echo "<book>";
        echo "<title>".control_character($books[$i]->getTitle())."</title>";
        echo "<data>".control_character($books[$i]->getData())."</data>";
        echo "<img>".control_character($books[$i]->getImg())."</img>";
        echo "<price>".control_character($books[$i]->getPrice())."</price>";
        echo "<link>".control_character($books[$i]->getLink())."</link>";
        echo "<author>".control_character($books[$i]->getAuthor())."</author>";
        echo "</book>";
    }
    echo '</books>';
}

if(isset($_GET['s']) && isset($_GET['c']) && strcmp($_GET['c'],'dvd')==0){
    $search = $_GET['s'];
    $url_dvds= "http://localhost:8000/ProgettoIDW_BackEnd/wAmazonDvd.php?s=".$search."&c=dvd";

    $dvds = getDvd($url_dvds);

    header('Access-Control-Allow-Origin: *');
    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<dvds>';
    for($i=0; $i< count($dvds); $i++){
        echo "<dvd>";
        echo "<title>".control_character($dvds[$i]->getTitle())."</title>";
        echo "<data>".control_character($dvds[$i]->getData())."</data>";
        echo "<img>".control_character($dvds[$i]->getImg())."</img>";
        echo "<price>".control_character($dvds[$i]->getPrice())."</price>";
        echo "<link>".control_character($dvds[$i]->getLink())."</link>";
        echo "<type>".control_character($dvds[$i]->getAuthor())."</type>";
        echo "</dvd>";
    }
    echo '</dvds>';
}

if(isset($_GET['s']) && isset($_GET['c']) && strcmp($_GET['c'],'cinema')==0){
    $search = $_GET['s'];
    $url_cinema= "http://localhost:8000/ProgettoIDW_BackEnd/wCinema.php?s=".$search;

    $cinemas = getCinema($url_cinema);

    header('Access-Control-Allow-Origin: *');
    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<cinemas>';
    for($i=0; $i< count($cinemas); $i++){
        echo "<cinema>";
        echo "<nome>".$cinemas[$i]->getNome()."</nome>";
        echo "<regione>".$cinemas[$i]->getRegione()."</regione>";
        echo "<provincia>".$cinemas[$i]->getProvincia()."</provincia>";
        echo "<latitudine>".$cinemas[$i]->getLatitudine()."</latitudine>";
        echo "<longitudine>".$cinemas[$i]->getLongitudine()."</longitudine>";
        echo "</cinema>";
    }
    echo '</cinemas>';
}

if(isset($_GET['s']) && isset($_GET['c']) && strcmp($_GET['c'],'trailer')==0){
    $search = $_GET['s'];
    $url_yt = "http://localhost:8000/ProgettoIDW_BackEnd/wYouTubeAPI.php?q=".$search."&maxResults=15";
    $xml_yt = getDataFromSource($url_yt);
    
    $size_response = count($xml_yt);

    $trailers = array();
    $trailer = null;

    for($i=0; $i<$size_response;$i++){
        $title = $xml_yt->trailer[$i]->title;
        $videoId = $xml_yt->trailer[$i]->videoId;

        $trailer = new Trailer($title,$videoId);
        $trailers[$i] = $trailer;
    }

    for($i=0; $i<$size_response;$i++){
        $title = $xml_yt->trailer[$i]->title;
        $videoId = $xml_yt->trailer[$i]->videoId;

        $trailer = new Trailer($title,$videoId);
        $trailers[$i] = $trailer;
    }

    header('Access-Control-Allow-Origin: *');
    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<trailers>';
    for($i=0; $i<$size_response;$i++){
        echo '<trailer>';
        echo '<title>'.control_character($trailers[$i]->getTitle()).'</title>';
        echo '<videoId>'.control_character($trailers[$i]->getVideoId()).'</videoId>';
        echo '</trailer>';
    }
    echo '</trailers>';
}

if((isset($_GET['c']) && strcmp($_GET['c'],'news')==0)){

    $url = "http://localhost:8000/ProgettoIDW_BackEnd/wNews.php?q=news";
    $xml_news = getDataFromSource($url);
    
    $size_response = count($xml_news);

    $news = array();
    
    $news = getNews($url);

    header('Access-Control-Allow-Origin: *');
    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<news>';
    for($i=0; $i< count($news); $i++){
        echo "<article>";
        echo "<title>".control_character($news[$i]->getTitle())."</title>";
        echo "<img>".control_character($news[$i]->getImg())."</img>";
        echo "<link>".control_character($news[$i]->getLink())."</link>";
        echo "<art>".control_character($news[$i]->getArt())."</art>";
        echo "<review>".control_character($news[$i]->getReview())."</review>";
        echo "</article>";
    }
    echo '</news>';
}

if(isset($_GET['s'])&&strcmp($_GET['s'],'upComing')==0){
    $url_searchUpComing = "http://localhost:8000/ProgettoIDW_BackEnd/wTheMovieOrgDB.php?w=upComing";
    $url_news = "http://localhost:8000/ProgettoIDW_BackEnd/wNews.php?q=news";
    
    $films = array();
    $w = "upComing";
    $sql = getSQL();
    if(isAfterWeek($sql) || isEmpty($sql)){
        delAll($sql);
        $films = getDataFromWTMDB($w,$url_searchUpComing);
        updateDB($sql,$films);
    }else{ 
        $films = getValues($sql);
    }

    header('Access-Control-Allow-Origin: *');
    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<UpComing>';
    for($i=0; $i< count($films); $i++){
        echo '<film>';
        echo '<title>'.$films[$i]->getTitle().'</title>';
        echo '<title_original>'.$films[$i]->getTitleOriginal().'</title_original>';
        echo '<poster>'.$films[$i]->getImg().'</poster>';
        echo '<rating>'.$films[$i]->getRating().'</rating>';
        echo '<description>'.$films[$i]->getDescription().'</description>';
        echo '<lan>'.$films[$i]->getLan().'</lan>';
        echo '<genre>'.$films[$i]->getGenre().'</genre>';
        echo "<year>".$films[$i]->getYear()."</year>";
        echo "<trailer>".$films[$i]->getLink()."</trailer>";
        echo "<direction>".$films[$i]->getDirection()."</direction>";
        echo '</film>';
    }
    echo '</UpComing>';
}

if(isset($_GET['s']) && isset($_GET['c']) && strcmp($_GET['c'],'search')==0){
    $url_searchFilmCS = "http://localhost:8000/ProgettoIDW_BackEnd/wComingSoonSearch.php?s=".$_GET['s'];
    $url_searchFilmTMDB = "http://localhost:8000/ProgettoIDW_BackEnd/wTheMovieOrgDB.php?s=".$_GET['s'];

    $xml_searchFilmCS = getDataFromSource($url_searchFilmCS);
    $xml_searchFilmTMDB = getDataFromSource($url_searchFilmTMDB);

    $size_CS = count($xml_searchFilmCS);
    $size_TMDB = count($xml_searchFilmTMDB);
    $films = array();
    $film = null;
    $z = 0;

    for($i=0; $i<$size_CS;$i++){
        for($j=0; $j<$size_TMDB; $j++){
            $title_CS = $xml_searchFilmCS->film[$i]->title;
            $title_TMDB = $xml_searchFilmTMDB->film[$j]->title_original;
            $date_CS = $xml_searchFilmCS->film[$i]->year;
            $date_TMDB = $xml_searchFilmTMDB->film[$j]->year;
            if(similar(format_title($title_CS),format_title($title_TMDB),$date_CS,$date_TMDB)){
                $id = $xml_searchFilmTMDB->film[$j]->id;
                $img = $xml_searchFilmTMDB->film[$j]->poster;
                $rating = $xml_searchFilmTMDB->film[$j]->rating;
                $description = $xml_searchFilmTMDB->film[$j]->description;
                $lan = $xml_searchFilmTMDB->film[$j]->lan;
                $genre = $xml_searchFilmTMDB->film[$j]->genre;
                $year = $xml_searchFilmTMDB->film[$j]->year;
                $direction = $xml_searchFilmCS->film[$i]->direction;

                $film = new Film($title_CS, $title_TMDB, $img, $rating, $description, $id, $lan, "", $genre, $year,
                "", "", $direction, "", "", "", "", "");
                $films[$z] = $film;
                $z += 1;
            }
        }
    }
    getTrailersForFilm($films);
    prepareXMLresponse($films);
}

function getBook($url){
    $xml_books = getDataFromSource($url);
    
    $size_response = count($xml_books);

    $books = array();
    $book = null;

    for($i=0; $i<$size_response;$i++){
        $title = $xml_books->book[$i]->title;
        $data = $xml_books->book[$i]->data;
        $img = $xml_books->book[$i]->img;
        $price = $xml_books->book[$i]->price;
        $link = $xml_books->book[$i]->link;
        $author = $xml_books->book[$i]->author;

        $book = new Libro($title,$data,$img,$price,$link,$author);
        $books[$i] = $book;
    }
    return $books;    
}

function getNews($url){
    $xml_news = getDataFromSource($url);
    $size_response = count($xml_news);

    $news = array();
    $article = null;
    for($i=0; $i<$size_response;$i++){
        $title = $xml_news->article[$i]->title;
        $img = $xml_news->article[$i]->img;
        $link = $xml_news->article[$i]->link;
        $art = $xml_news->article[$i]->art;
        $review = $xml_news->article[$i]->review;

        $article = new Article($title,$img,$link,$art,$review);
        $news[$i] = $article;
    }
    return $news;
}

function getDvd($url){
    $xml_dvds = getDataFromSource($url);
    
    $size_response = count($xml_dvds);

    $dvds = array();
    $dvd = null;

    for($i=0; $i<$size_response;$i++){
        $title = $xml_dvds->dvd[$i]->title;
        $data = $xml_dvds->dvd[$i]->data;
        $img = $xml_dvds->dvd[$i]->img;
        $price = $xml_dvds->dvd[$i]->price;
        $link = $xml_dvds->dvd[$i]->link;
        $type = $xml_dvds->dvd[$i]->type;

        $dvd = new Libro($title,$data,$img,$price,$link,$type);
        $dvds[$i] = $dvd;
    }
    return $dvds;
}

function getCinema($url){
    $xml_cinema = getDataFromSource($url);
    
    $size_response = count($xml_cinema);

    $cinemas = array();
    $cinema = null;

    for($i=0; $i<$size_response;$i++){
        $nome = $xml_cinema->place[$i]->nome;
        $regione = $xml_cinema->place[$i]->regione;
        $provincia = $xml_cinema->place[$i]->provincia;
        $latitudine = $xml_cinema->place[$i]->latitudine;
        $longitudine = $xml_cinema->place[$i]->longitudine;

        $cinema = new Cinema($nome,$regione,$provincia,$latitudine,$longitudine);
        $cinemas[$i] = $cinema;
    }
    return $cinemas;
}

function prepareXMLresponse($films){
    header('Access-Control-Allow-Origin: *');
    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<films>';
    for($i=0; $i< count($films); $i++){
        echo '<film>';
        echo '<title>'.$films[$i]->getTitle().'</title>';
        echo '<title_original>'.$films[$i]->getTitleOriginal().'</title_original>';
        echo '<poster>'.$films[$i]->getImg().'</poster>';
        echo '<rating>'.$films[$i]->getRating().'</rating>';
        echo '<description>'.$films[$i]->getDescription().'</description>';
        echo '<lan>'.$films[$i]->getLan().'</lan>';
        echo '<genre>'.$films[$i]->getGenre().'</genre>';
        echo "<year>".$films[$i]->getYear()."</year>";
        echo "<trailer>".$films[$i]->getLink()."</trailer>";
        echo "<direction>".$films[$i]->getDirection()."</direction>";
        echo '</film>';
    }
    echo '</films>';
}

function getTrailersForFilm($films){
    $q = "";
    if(count($films)>0){
        for($i=0;$i<count($films);$i++){
            $q = $films[$i]->getTitle()." trailer official ita";
            $url_trailer = "http://localhost:8000/ProgettoIDW_BackEnd/wYouTubeAPI.php?q=".$q."&maxResults=5";
            $xml_yt = getDataFromSource($url_trailer);
            if(isset($xml_yt)){
                if(strpos($xml_yt->trailer[0]->title,'Trailer') > 0)
                    $films[$i]->setLink($xml_yt->trailer[0]->videoId);
                else $films[$i]->setLink('Non disponibile');
            }
        }
    }
    return $films;
}

function getDataFromWTMDB($w,$url_upComingFilm){
    $xml_upComingFilm = getDataFromSource($url_upComingFilm);
    for($i=0; $i<count($xml_upComingFilm);$i++){
        $id = $xml_upComingFilm->film[$i]->id;
        $title = $xml_upComingFilm->film[$i]->title;
        $title_original = $xml_upComingFilm->film[$i]->title_original;
        $img = $xml_upComingFilm->film[$i]->poster;
        $rating = $xml_upComingFilm->film[$i]->rating;
        $description = $xml_upComingFilm->film[$i]->description;
        $lan = $xml_upComingFilm->film[$i]->lan;
        $genre = $xml_upComingFilm->film[$i]->genre;
        $year = $xml_upComingFilm->film[$i]->year;
        
        $film = new Film($title, $title_original, $img, $rating, $description, $id, $lan, "", $genre, $year,
        "", "", "", "", "", "", "", "");
        $films[$i] = $film;
    }
    getTrailersForFilm($films);
    return $films;
}

?>