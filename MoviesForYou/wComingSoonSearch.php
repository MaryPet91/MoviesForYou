<?php
include('film.php');
include('utility.php');

$my_url = 'https://www.comingsoon.it/film/?titolo=';

if(isset($_GET['s'])){
	$search = $_GET['s'];
	$my_url = format_url($my_url,$search);
	
	$html = file_get_contents($my_url);

	$dom = new DOMDocument();
	libxml_use_internal_errors(true);
	$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);
	libxml_clear_errors(true);

	$title_x = "//*[@id=\"page\"]/div[2]/div/main/div/div/div/article/div/div[3]/a/div[2]/div[1]";
	$year_x = "//*[@id=\"page\"]/div[2]/div/main/div/div/div/article/div/div[3]/a/ul/li[2]";
	$nation_x = "//*[@id=\"page\"]/div[2]/div/main/div/div/div/article/div/div[3]/a/ul/li[3]";
	//*[@id="page"]/div[2]/div/main/div/div/div/article/div/div[3]/a[1]/ul/li[3]/text()
	$direction_x = "//*[@id=\"page\"]/div[2]/div/main/div/div/div/article/div/div[3]/a/ul/li[4]";
	
	$title_x = $xpath->query($title_x);
	$year_x = $xpath->query($year_x);
	$nation_x = $xpath->query($nation_x);
	$direction_x = $xpath->query($direction_x);
	
	$size = count($title_x);
	$films = array();

	for($i=0; $i < $size; $i++){
	
		if($title_x[$i]!=null){
			$title = $title_x[$i]->childNodes->item(0)->nodeValue;
			$title = control_character($title);			
		}else $title = 'Non disponibile';
		if($year_x[$i]!=null){
			$year = $year_x[$i]->childNodes->item(1)->nodeValue;
			$year = delPoints($year);
			$year = delBlank($year);
		}else $year = 'Non disponibile';
		if( $direction_x[$i]!=null){
		   $direction = $direction_x[$i]->childNodes->item(1)->nodeValue;
		   $direction= delPoints($direction);
		   $direction = delBlank($direction);
		}else $direction = 'Non disponibile';
		if($nation_x[$i] != null){
			$nation = $nation_x[$i]->childNodes->item(1)->nodeValue;
			$nation = delPoints($nation);
			$nation = delBlank($nation);
		 }else $nation = 'Non disponibile';
		
		 $film = new Film($title,"","", "", "", "", "", "", "", $year,
		 "", "", $direction, "", "", "", "", $nation);
		$films[$i]=$film;
	}
	
	prepareXMLresponse($films);

}else{
	echo 'Nessun parametro specificato per la ricerca';
}

//Praparazione del documento XML
function prepareXMLresponse($films){
		header('Access-Control-Allow-Origin: *');
		header("Content-type: text/xml; charset=utf-8");
		echo "<?xml version='1.0' encoding='UTF-8'?>";
		echo "<films>";
		for($i=0; $i< count($films); $i++){
			echo "<film>";
			echo "<title>".$films[$i]->getTitle()."</title>";
			echo "<year>".$films[$i]->getYear()."</year>";
			echo "<nation>".$films[$i]->getNationality()."</nation>";
			echo "<direction>".$films[$i]->getDirection()."</direction>";
			echo "</film>";
		}
		echo "</films>";
}
?>
