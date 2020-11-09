<?php
include 'functions.php';
if(isset($_POST["advertiser"]) && !empty($_POST["advertiser"]) && !empty($_POST["city"]) && isset($_POST["city"]) && !empty($_POST["query"]) && isset($_POST["query"])){
	$query = $_POST["query"];
	$city = $_POST["city"];
	$advertiserName = $_POST["advertiser"];
}
if($advertiserName == "Tripster"){
	$result = getResource('Tripster', 'search',['page_size' => 100, 'page' => 1, 'city' => $city, 'query' => $query], 'page', 'results');
}
echo json_encode($result);