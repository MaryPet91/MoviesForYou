<?php
include 'DBConnection.php';
include_once 'utility.php';
include_once 'film.php';

$search = "";
$url_upComingFilm = "http://localhost:8000/ProgettoIDW_BackEnd/wTheMovieOrgDB.php";
$url_searchFilmCS = "http://localhost:8000/ProgettoIDW_BackEnd/wComingSoonSearch.php";
$url_searchFilmTMDB = "http://localhost:8000/ProgettoIDW_BackEnd/wTheMovieOrgDB.php";
$url_searchFilmTv = "http://localhost:8000/ProgettoIDW_BackEnd/wFilmTv.php";
$url_searchYoutube = "http://localhost:8000/ProgettoIDW_BackEnd/wYouTubeAPI.php";

if(isset($_GET['s'])){
    $search = $_GET['s'];

    $url_searchFilmCS .= "?s=".$search;
    $url_searchFilmTMDB .= "?s=".$search;
    $url_searchFilmTv .= "?s=".$search;
    $url_searchYoutube .= "?q=".$search."&maxResults=15";

    $xml_searchFilmCS = getDataFromSource($url_searchFilmCS);
    $xml_searchFilmTMDB = getDataFromSource($url_searchFilmTMDB);
    $xml_searchFilmTv = getDataFromSource($url_searchFilmTv);
    $xml_searchTrailer = getDataFromSource($url_searchYoutube);

    match($xml_searchFilmCS,$xml_searchFilmTMDB);

}else if(isset($_GET['w'])){
        $w = "upComing";
        if(strcmp($_GET['w'],$w) == 0){
            $sql = getSQL();
            if(isAfterWeek($sql) || isEmpty($sql)){
                delAll($sql);
                updateDB($sql,getDataFromWTMDB($w,$url_upComingFilm));
            }else{ 
                $films = getValues($sql);
                prepareXMLresponse($films);
            }

        }else{
            echo "URL without params for research\n";
        }
    }

function match($xml_searchFilmCS,$xml_searchFilmTMDB){
    $size_CS = count($xml_searchFilmCS);
    $size_TMDB = count($xml_searchFilmTMDB);
    $films = array();
    $film = null;
    $z = 0;

    for($i=0; $i<$size_CS;$i++){
        for($j=0; $j<$size_TMDB; $j++){
            $title_CS = $xml_searchFilmCS->film[$i]->title;
            $title_TMDB = $xml_searchFilmTMDB->film[$j]->title;
            $date_CS = $xml_searchFilmCS->film[$i]->year;
            $date_TMDB = $xml_searchFilmTMDB->film[$j]->year;
            if(similar(format_title($title_CS),format_title($title_TMDB),$date_CS,$date_TMDB,$films)){
                $img = $xml_searchFilmTMDB->film[$j]->poster;
                $rating = $xml_searchFilmTMDB->film[$j]->rating;
                $description = $xml_searchFilmTMDB->film[$j]->description;
                $lan = $xml_searchFilmTMDB->film[$j]->lan;
                $genre = $xml_searchFilmTMDB->film[$j]->genre;
                $year = $xml_searchFilmTMDB->film[$j]->year;
                $regista = $xml_searchFilmCS->film[$i]->regia;
                $link_streaming = $xml_searchFilmCS->film[$i]->link_streaming;

                $title_CS = control_character($title_CS);
                $img = control_character($img);
                $description=control_character($description);
                $genre = control_character($genre);
                $link_streaming = control_character($link_streaming);

                $film = new Film("",$title_CS,$img,$rating,$description,$lan,$genre,$year,"",$link_streaming,$regista);
                $films[$z] = $film;
                $z += 1;
            }
        }
    }
    prepareXMLresponse($films);
}

function similar($s1,$s2,$d1,$d2,$films){
    $first = explode("-",$s1);
    $second = explode("-",$s2);
    if(isset($s1) && isset($s2)){
        if(strcmp($s1,$s2)== 0){
            return true;
        }else {
            $p = 0;
            similar_text($s1,$s2,$p);
            if($p>80 && strcmp($d1,$d2)==0){
                return true;
            }else if(strcmp($d1,$d2)==0 && strcmp($first[0],$second[0])==0){
                return true;
            }else return false;
        }
    }
}

function prepareXMLresponse($films){
    if(count($films)>0){
        header('Access-Control-Allow-Origin:*');
		header("Content-type:text/xml");
		echo "<?xml version='1.0' encoding='UTF-8'?>";
		echo "<films>";
		for($i=0; $i< count($films); $i++){
            echo "<film>";
			echo "<title>".$films[$i]->getTitle()."</title>";
            echo "<img>".$films[$i]->getImg()."</img>";
            echo "<rating>".$films[$i]->getRating()."</rating>";
            echo "<description>".$films[$i]->getDescription()."</description>";
            echo "<lan>".$films[$i]->getLan()."</lan>";
			echo "<genre>".$films[$i]->getGenre()."</genre>";
            echo "<year>".$films[$i]->getYear()."</year>";
			echo "<regia>".$films[$i]->getDirection()."</regia>";
			//echo "<link>".$films[$i]->getLink()."</link>";
			echo "</film>";
		}
        echo "</films>";
    }else echo "Nessun risultato trovato";
}

function getDataFromWTMDB($w,$url_upComingFilm){
    $url_upComingFilm .= "?w=".$w;
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
    return $films;
}

?>