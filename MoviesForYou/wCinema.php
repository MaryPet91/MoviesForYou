<?php
include('cinema.php');
include('utility.php');

$param = $_GET['s'];

if(isset($param)){

    $data = file_get_contents('cinema.json','r');
    $data_decode = json_decode($data,true);
    $cinemas = array();
    $z= 0;
    $x= 0;
    $y = 0;
    
    for($i=0; $i < count($data_decode); $i++){
        $nome = $data_decode[$i]['cnome'];
        $regione = $data_decode[$i]['cregione'];
        $provincia = $data_decode[$i]['cprovincia'];
        $latitudine = $data_decode[$i]['clatitudine'];
        $longitudine = $data_decode[$i]['clongitudine'];

        switch($param){
            case $nome:
                $cinema = new Cinema($nome,$regione,$provincia,$latitudine,$longitudine);
                $cinemas[$z] = $cinema;
                $z++;
                break;
            case format_title($regione):
                $cinema = new Cinema($nome,$regione,$provincia,$latitudine,$longitudine);
                $cinemas[$z] = $cinema;
                $z++;
                break;
            case $provincia:
                $cinema = new Cinema($nome,$regione,$provincia,$latitudine,$longitudine);
                $cinemas[$z] = $cinema;
                $z++;
                break;
        }
    }
    prepareXMLresponse($cinemas);
}

function prepareXMLresponse($cinemas){
    header('Access-Control-Allow-Origin: *');
    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<cinema>';
    for($i=0;$i<count($cinemas);$i++){
        echo '<place>';
        echo '<nome>'.$cinemas[$i]->getNome().'</nome>';
        echo '<regione>'.$cinemas[$i]->getRegione().'</regione>';
        echo '<provincia>'.$cinemas[$i]->getProvincia().'</provincia>';
        echo '<latitudine>'.$cinemas[$i]->getLatitudine().'</latitudine>';
        echo '<longitudine>'.$cinemas[$i]->getLongitudine().'</longitudine>';
        echo '</place>';
    }
    echo '</cinema>';
}   
?>