<?php
include 'functions.php';

$excursionAdvertiser = $_POST['city_excursion'];
$excursionAdvertiser = explode('|',$excursionAdvertiser);
//$excursionSearch = json_decode($_POST['search']);

$advertiserExcursion = [
    'Tripster' => [],
    'Sputnik8' => [],
	'Surprise_Me' => [],
	'Weatlas' => []
];

if($excursionAdvertiser[1] != 0) {
    $advertiserExcursion['Tripster'] = getResource('Tripster', 'experiences',['page_size' => 100, 'page' => 1, 'city' => $excursionAdvertiser[1]], 'page', 'results');
}

if($excursionAdvertiser[0] != 0) {
    $advertiserExcursion['Sputnik8'] = getResource('Sputnik8', 'products',['limit' => 100, 'page' => 1, 'city_id' => $excursionAdvertiser[0]], 'page');
}

if($excursionAdvertiser[2] != '') {
	$querySurp = file_get_contents("https://app.surprizeme.ru/api/products/?city=" . $excursionAdvertiser[2] . "&lang=ru");
	$querySurpRes = json_decode($querySurp);
	$advertiserExcursion['Surprise_Me'] = $querySurpRes->data;
}
if($excursionAdvertiser[3] != '') {
	$data = array('mode' => 'json', 'aid' => '16184', 'key' => '9d54b4ac3689e696a93e7f4f811163d3', 'Lang' => 'Ru', 'NameCity' => $excursionAdvertiser[3]);
	$options = array(
		'http' => array(
		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'method'  => 'POST',
		'content' => http_build_query($data)
    	)
	);
	$context  = stream_context_create($options);
	$queryWeatlas = file_get_contents("http://api.weatlas.com/export/activitylist/", false, $context);
	$queryWeatlasRes = json_decode($queryWeatlas);
	if(!empty($queryWeatlasRes->activity)){
		$advertiserExcursion['Weatlas'] = $queryWeatlasRes->activity;
	} else {
		$advertiserExcursion['Weatlas'] = [];
	}
}
$searchAdvertiserExcursion = [
    'Tripster' => [],
    'Sputnik8' => []
];

if($excursionSearch != '') {

    foreach ($advertiserExcursion as $key => $excursies) {
        foreach ($excursies as $num => $excursion) {
            if($key == 'Tripster') {
                if(stripos($excursion['title'], $excursionSearch) !== false ||
                    stripos($excursion['tagline'], $excursionSearch) !== false) {
                    $searchAdvertiserExcursion[$key][] = $excursion;
                }
            }

            if($key == 'Sputnik8') {
                if(stripos($excursion['title'], $excursionSearch) !== false ||
                    stripos($excursion['description'], $excursionSearch) !== false) {
                    $searchAdvertiserExcursion[$key][] = $excursion;
                }
            }
        }
    }

    $advertiserExcursion = $searchAdvertiserExcursion;
}

echo json_encode($advertiserExcursion);
