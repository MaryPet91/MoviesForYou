<?php
include "utility.php";
include "article.php";

if(isset($_GET['q']) && strcmp($_GET['q'],'news')==0) {
    $search = $_GET['q']; //articles da cercare
    $search = explode(' ',$_GET['q']);
    $titolo = "";
    for($i=0;$i<count($search);$i++){
        $titolo.= $search[$i];
        $titolo .= "+";
    }
    $pageSearch = "https://movieplayer.it/news/";
    $pageSearch = control_character($pageSearch); 
    $html = file_get_contents($pageSearch);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);
    libxml_clear_errors(true);
    $main_u = "https://movieplayer.it";
    $article = null;
    $articles = array();

    for($i=2;$i<12;$i++){
        $link_x="//*[@id=\"mvp-page-area\"]/div/div/div[".$i."]/div[2]/h2/a/@href";
        $title_x = "//*[@id=\"mvp-page-area\"]/div/div/div[".$i."]/div[2]/h2/a";
        $img_x = "//*[@id=\"mvp-page-area\"]/div/div/div[".$i."]/div[1]/a/img[1]/@src";
        $art_x = "//*[@id=\"mvp-page-area\"]/div/div/div[".$i."]/div[2]/p";
                    
        $title_x = $xpath->query($title_x);
        $link_x = $xpath->query($link_x);
        $img_x = $xpath->query($img_x);
        $art_x = $xpath->query($art_x);

        $img = $img_x[0]->childNodes->item(0)->nodeValue;
        $title = $title_x[0]->childNodes->item(0)->nodeValue;
        $link = $link_x[0]->childNodes->item(0)->nodeValue;
        $art = $art_x[0]->childNodes->item(0)->nodeValue;
        $title = control_character($title);
        $art = control_character($art);
        $link = control_character($link);
        $article = new Article($title,$img,$main_u.$link,$art,"","");
        $articles[$i] = $article;
    }
    prepareXMLresponse($articles);
    
}
//Praparazione del documento XML
function prepareXMLresponse($articles){
    header('Access-Control-Allow-Origin: *');
    header("Content-type: text/xml; charset=utf-8");
    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<articles>";
    for($i=2;$i<count($articles);$i++){
        echo "<article>";
        echo "<title>".$articles[$i]->getTitle()."</title>";
        echo "<img>".$articles[$i]->getImg()."</img>";
        echo "<link>".$articles[$i]->getLink()."</link>";
        echo "<art>".$articles[$i]->getArt()."</art>";
        echo "<review>".getReview($articles[$i]->getLink())."</review>";
        echo "</article>";
    }   
    echo "</articles>";
}
function getReview($url){
    $html = file_get_contents($url);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);
    libxml_clear_errors(true);

    $articles = "//*[@id=\"mvp-page-area\"]/article/div/div/p";
    $artcicles = $xpath->query($articles);

    $review = "";

    for($i=0;$i<count($artcicles[0]->childNodes);$i++){
        $review .= $artcicles[0]->childNodes->item($i)->nodeValue;
    }
    for($i=0;$i<count($artcicles[1]->childNodes);$i++){
        $review .= $artcicles[1]->childNodes->item($i)->nodeValue;
    }

    $review = control_character($review);
   return $review;
}
?>