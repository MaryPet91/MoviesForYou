<?php
include_once 'film.php';
include_once 'utility.php';
//ritogna oggetto mysqli
function getSQL(){
    $mysqli = new mysqli('localhost', 'root', '', 'upcomingfilm');
    if ($mysqli->connect_error) {
        die('Errore di connessione (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
    } 
    if (!$mysqli->query("USE upcomingfilm")) {
        die($mysqli->error);
    }
    return $mysqli;
}
//Inserisce i campi nel DB
function updateDB($mysqli,$films){
    if(!$mysqli)
        return;
    for($i=0;$i<count($films);$i++){
        $id = $films[$i]->getId();
        $title = $films[$i]->getTitle();
        $img = $films[$i]->getImg();
        $rating = $films[$i]->getRating();
        $description = $films[$i]->getDescription();
        $lan = $films[$i]->getLan();
        $genre = $films[$i]->getGenre();
        $year = $films[$i]->getYear();
        $trailer = $films[$i]->getLink();
        $day = date('Y-m-d');
        //$query = "INSERT INTO film VALUES ('".$id."','".$title."','".$img."','".$rating."','".$description."','".$lan."','".$genre.'","'.$year."',".$day.");";
        $description = set_apici($description);
        $title = set_apici($title);

        $query = "INSERT INTO film (id,title,poster,rating,descriptions,lan, genre,year,day,trailer) VALUES ('{$id}', '{$title}', '{$img}', '{$rating}', '{$description}','{$lan}','{$genre}','{$year}','{$day}','{$trailer}')";
        //echo $query."<br/>";
        $result = $mysqli->query($query) or die($mysqli->error);
    }
}
//Controlla l'ultima volta che viene aggiornato il DB
function isAfterWeek($mysqli){
    if(!$mysqli)
        return;
    $query = "SELECT day FROM film";
    $result = $mysqli->query($query) or die($mysqli->error);
    if($result->num_rows == 0){
        return true;
    }
    $day = mysqli_fetch_row($result);
    $now = date('Y-m-d');
    $now = explode('-',$now);
    $day = explode('-',$day[0]);
    if($now[2] - $day[2] >= 7){
        return true;
    }else return false;
}
//Controlla se il DB è vuoto
function isEmpty($mysqli){
    if(!$mysqli)
        return;
    $query = "SELECT * FROM film";
    $result = $mysqli->query($query) or die($mysqli->error);
    if($result->num_rows == 0){
        return true;
    }else return false;
}
//Ritorna un array contenente un oggetto per ogni record nella tabella
function getValues($mysqli){
    if(!$mysqli)
        return;

    $query = "SELECT * FROM film";
    $result = $mysqli->query($query) or die($mysqli->error);
    $i = 0;
    $film = null;
    $films = array();

    while($data = mysqli_fetch_row($result)){
        $film = new Film($data[1], "", $data[2], $data[3], $data[4], $data[0], $data[5], "", $data[6], $data[7],
        $data[9], "", "", "", "", "", "", "");
        $films[$i] = $film;
        $i++;
    }
    return $films;
}
//Elimina tutti i recordi presenti in tabella
function delAll($mysqli){
    if(!$mysqli)
        return;
    $query = "TRUNCATE TABLE film";
    $result = $mysqli->query($query) or die($mysqli->error);
    if($result){
        return true;
    }else return false;
}
?>