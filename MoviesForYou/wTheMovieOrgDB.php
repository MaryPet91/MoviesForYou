<?php
include('film.php');
include('utility.php');

//@key rappresenta la chiave di accesso
//@lan lingua
$key = '5de0089801ae82c5365a9e89eef9d1c1';
$lan = 'it-IT';

$imgUrl = 'https://image.tmdb.org/t/p/w500';

if(isset($_GET['w']) && (strcmp($_GET['w'],'upComing') == 0)){
    $url = "https://api.themoviedb.org/3/movie/upcoming?api_key=".$key."&language=".$lan;
}else if(isset($_GET['s'])){
    $search = $_GET['s'];
    $search = format_url("",$search);
    $url = "https://api.themoviedb.org/3/search/movie?api_key=".$key."&language=".$lan."&query=".$search;
}

$results = array();
$films = array();
$genres = array();

$results = getData($url);
$genres = takeGenres($key,$lan);

for($x=0; $x<count($results['results']); $x++){
    
     $id = $results['results'][$x]['id'];
     $title = $results['results'][$x]['title'];
     $title_original = $results['results'][$x]['original_title'];
     $rating = $results['results'][$x]['vote_average'];
     $description = $results['results'][$x]['overview'];
     $lan = $results['results'][$x]['original_language'];
     $genre = $results['results'][$x]['genre_ids'];
     $img = $results['results'][$x]['poster_path'];
     $date = $results['results'][$x]['release_date'];
     $year = format_date($date);
     
     $title = control_character($title);
     $title_original = control_character($title);
     $description = control_character($description);
     $genre =  getGenres($genre,$genres);

     $film = new Film($title, $title_original, $imgUrl.$img, $rating, $description, $id, $lan,"", $genre, $year,
     "", "", "", "", "", "", "", "");
     $films[$x]=$film;   
 }

prepareXMLresponse($films);
//END

//FUNCTION
function getData($url){
    $json = file_get_contents($url);
    $results = json_decode($json,true);
    return $results;
}

function takeGenres($key,$lan){

    $url = 'https://api.themoviedb.org/3/genre/movie/list?api_key='.$key.'&language='.$lan;
    $json = file_get_contents($url);
    $results = json_decode($json,true);
    $id = array();

    for($i=0; $i < count($results['genres']); $i++){
        $id[$i] = $results['genres'][$i]['id'];
        $genres[$id[$i]] = $results['genres'][$i]['name'];
        
    }
    return $genres;
}

function getGenres($genre_ids, $genres){
    $genersMovie = null;
    for($i=0; $i < count($genre_ids); $i++){
        $genersMovie.= $genres[$genre_ids[$i]].',';
    }
    $genersMovie = rtrim($genersMovie,',');
    return $genersMovie;
}

function prepareXMLresponse($films){
    header('Access-Control-Allow-Origin: *');
    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<films>';
    for($i=0; $i< count($films); $i++){
        echo '<film>';
        echo '<id>'.$films[$i]->getId().'</id>';
        echo '<title>'.$films[$i]->getTitle().'</title>';
        echo '<title_original>'.$films[$i]->getTitleOriginal().'</title_original>';
        echo '<poster>'.$films[$i]->getImg().'</poster>';
        echo '<rating>'.$films[$i]->getRating().'</rating>';
        echo '<description>'.$films[$i]->getDescription().'</description>';
        echo '<lan>'.$films[$i]->getLan().'</lan>';
        echo '<genre>'.$films[$i]->getGenre().'</genre>';
        echo "<year>".$films[$i]->getYear()."</year>";
        echo '</film>';
    }
    echo '</films>';
}

?>

