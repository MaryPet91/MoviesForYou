<?php
include_once 'film.php';
include_once 'utility.php';
include_once 'libro.php';

if(isset($_GET['s']) && isset($_GET['c']) && strcmp($_GET['c'],'book')==0){
    $url_b = 'https://www.amazon.it/s/url=search-alias%3Dstripbooks&field-keywords=';
	$search = $_GET['s'];
	$url_b = format_url($url_b,$search);
    $xpath = getData($url_b);

    for($i=0;$i<=15;$i++){
        $title = "//*[@id=\"result_".$i."\"]/div/div/div/div[2]/div[1]/div[1]/a/h2";
        $data = "//*[@id=\"result_".$i."\"]/div/div/div/div[2]/div[1]/div[1]/span[3]";
        $img = "//*[@id=\"result_".$i."\"]/div/div/div/div[1]/div/div/a/img/@src";
        $price = "//*[@id=\"result_".$i."\"]/div/div/div/div[2]/div[2]/div[1]/div[2]/a/span";
        $link = "//*[@id=\"result_".$i."\"]/div/div/div/div[2]/div[2]/div[1]/div[2]/a/@href";
        $author = "//*[@id=\"result_".$i."\"]/div/div/div/div[2]/div[1]/div[2]/span[2]/a";
    
        $title_x = $xpath->query($title);
        $data_x = $xpath->query($data);
        $img_x = $xpath->query($img);
        $price_x = $xpath->query($price);
        $link_x = $xpath->query($link);
        $author_x = $xpath->query($author);
    
        if($title_x[0] != null){
            $title = $title_x[0]->childNodes->item(0)->nodeValue;
            $title = control_character($title);
        }else $title = 'Non disponibile';
        if($data_x[0] != null){
            $data = $data_x[0]->childNodes->item(0)->nodeValue;
            $data = control_character($data);
        }else $data = 'Non disponibile';
        if($img_x[0] != null){
            $img = $img_x[0]->childNodes->item(0)->nodeValue;
            $img = control_character($img);
        }else $img = 'Non disponibile';
        if($price_x[0] != null){
            $price = $price_x[0]->childNodes->item(0)->nodeValue;
            $price = control_character($price);
        }else $price = 'Non disponibile';
        if($link_x[0] != null){
            $link = $link_x[0]->childNodes->item(0)->nodeValue;
            $link = control_character($link);
        }else $link = 'Non disponibile';
        if($author_x[0] != null){
            $author = $author_x[0]->childNodes->item(0)->nodeValue;
            $author = control_character($author);
        }else $author = 'Non disponibile';

        $book = new Libro($title,$data,$img,$price,$link,$author);
        $books[$i] = $book;
    }
    
    prepareXMLresponseBook($books);    
}

function getData($my_url){
    $html = file_get_contents($my_url);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);
    libxml_clear_errors(true);
    
    return $xpath;
}

function prepareXMLresponseBook($books){
    header('Access-Control-Allow-Origin: *');
    header("Content-type: text/xml; charset=utf-8");
    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<books>";
    for($i=0; $i< count($books); $i++){
        echo "<book>";
        echo "<title>".$books[$i]->getTitle()."</title>";
        echo "<data>".$books[$i]->getData()."</data>";
        echo "<img>".$books[$i]->getImg()."</img>";
        echo "<price>".$books[$i]->getPrice()."</price>";
        echo "<link>".$books[$i]->getLink()."</link>";
        echo "<author>".$books[$i]->getAuthor()."</author>";
        echo "</book>";
    }
    echo "</books>";
}
?>