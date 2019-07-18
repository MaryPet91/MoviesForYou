<?php

function similar($s1,$s2,$d1,$d2){
    //echo $s1."-".$s2."<br>";
    if((isset($s1) && isset($s2) )){
        $first = explode('-',$s1);
        $second = explode('-',$s2);
        if(isset($d1) && isset($d2)){
            if(strcmp($s1,$s2)==0)
                return true;
            else if(strcmp($first[0],$second[0])==0 && strcmp($d1,$d2)==0)
                    return true;
            else if(strcmp($d1,$d2)==0){
                $perc = 0;
                similar_text($s1,$s2,$perc);
                if($perc > 80)
                    return true;
            }
        }
    }

}
//Viene utilizzata per trattare gli spazi bianchi nei parametri GET
function format_url($url,$params){
	if(strlen($params)>1 && isset($params) && isset($url)){
		$params = str_replace(' ','%20',$params);
		$url .= $params;
	}
	return $url;
}

function control_url($url){
	if(strlen($url)>1 && isset($url)){
		$url = str_replace(' ','%20',$url);
		$url = str_replace('!','%21',$url);
		$url = str_replace('','%27',$url);
	}
	return $url;
}

function control_character($string){
	if(isset($string)){
		$string = str_replace('&','&amp;',$string);
	}
	return $string;
}

//Specie di analyzer per il titolo
//1 rimpiazza i due punti con -
//2 toglie gli spazi bianchi
//3 tutto in minuscolo
function format_title($string){
	if(strlen($string)>1 && isset($string)){
		$string = str_replace(':','-',$string);
		$string = str_replace(' ','',$string);
		$string = strtolower($string);
	}
	return $string;
}

//Toglie lo spazio bianco davanti le stringhe
function delBlank($string){
	$finalString = "";
	if(strlen($string)>1 && isset($string)){
		$finalString = trim($string,' ');
	}
	return $finalString;
}

//Toglie i punti iniziali della stringa passata in input
function delPoints($string){
	$finalString = "";
	if(strlen($string)>1 && isset($string)){
		$finalString = trim($string,':');
	}
	return $finalString;
}

//utilizzata nel mediator per prelevare i dati xml da i wrapper
function getDataFromSource($url){
    if(isset($url)){
		if(simplexml_load_file($url))
			$xml = simplexml_load_file($url);
    }else echo "bad URL";
    return $xml;
}

//prende in input un data nel seguente formato: aaaa/mm/gg
//ricava l'anno
function format_date($date){

	if(isset($date)){
		$date = substr($date,0,4);
	}
	return $date;
}

function set_apici($string){
	if(isset($string)){
		$string = str_replace("'","''",$string);
	}
	return $string;
}
?>