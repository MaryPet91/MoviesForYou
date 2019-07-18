<?php
include_once 'film.php';
include_once 'utility.php';
include_once 'libro.php';
include_once 'wAmazonBook.php';

if(isset($_GET['s']) && isset($_GET['c']) && strcmp($_GET['c'],'dvd')==0){
    $my_url = "https://www.amazon.it/s/url=search-alias%3Ddvd&field-keywords=";
    $search = $_GET['s'];
	$my_url = format_url($my_url,$search);
    $xpath = getData($my_url);
    $books = array();
    for($i=0;$i<=15;$i++){
      
        $title = "//*[@id=\"result_".$i."\"]/div/div[3]/div[1]/a/h2";
        $data = "//*[@id=\"result_".$i."\"]/div/div[3]/div[1]/span[2]";
        $img = "//*[@id=\"result_".$i."\"]/div/div[2]/div/div/a/img/@src";
        $price = "//*[@id=\"result_".$i."\"]/div/div[6]/a/span";
        $link = "//*[@id=\"result_".$i."\"]/div/div[6]/a/@href";
        $type = "//*[@id=\"result_".$i."\"]/div/div[5]/a/h3";

        $title_x = $xpath->query($title);
        $data_x = $xpath->query($data);
        $img_x = $xpath->query($img);
        $price_x = $xpath->query($price);
        $link_x = $xpath->query($link);
        $type_x = $xpath->query($type);
    
        if($title_x[0] != null){
            $title = $title_x[0]->childNodes->item(0)->nodeValue;
            $title = control_character($title);
        }else $title = 'Non disponibile';
        if($data_x[0] != null){
            $data = $data_x[0]->childNodes->item(0)->nodeValue;
        }else $data = 'Non disponibile';
        if($img_x[0] != null){
            $img = $img_x[0]->childNodes->item(0)->nodeValue;
            $img = control_character($img);
        }else $img = 'Non disponibile';
        if($price_x[0] != null){
            $price = $price_x[0]->childNodes->item(0)->nodeValue;
        }else $price = 'Non disponibile';
        if($link_x[0] != null){
            $link = $link_x[0]->childNodes->item(0)->nodeValue;
            $link = control_character($link);
        }else $link = 'Non disponibile';
        if($type_x[0] != null){
            $type = $type_x[0]->childNodes->item(0)->nodeValue;
            $type = control_character($type);
        }else $type = 'Non disponibile';

        $book = new Libro($title,$data,$img,$price,$link,$type);
        $books[$i] = $book;
    }
} 
prepareXMLresponseDvd($books);

function prepareXMLresponseDvd($books){
    header('Access-Control-Allow-Origin: *');
    header("Content-type: text/xml; charset=utf-8");
    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<dvds>";
    for($i=0; $i< count($books); $i++){
        echo "<dvd>";
        echo "<title>".$books[$i]->getTitle()."</title>";
        echo "<data>".$books[$i]->getData()."</data>";
        echo "<img>".$books[$i]->getImg()."</img>";
        echo "<price>".$books[$i]->getPrice()."</price>";
        echo "<link>".$books[$i]->getLink()."</link>";
        echo "<type>".$books[$i]->getAuthor()."</type>";
        echo "</dvd>";
    }
    echo "</dvds>";
}
?>