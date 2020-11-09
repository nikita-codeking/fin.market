<?php
include 'functions.php';
if(isset($_POST["advertiser"]) && !empty($_POST["advertiser"]) && isset($_POST["adv_id"]) && !empty($_POST["adv_id"])){
	$advertiserName = $_POST["advertiser"];
	$adv_id = $_POST["adv_id"];
}
if($advertiserName == "Tripster"){
	$result = file_get_contents("https://experience.tripster.ru/api/experiences/" . $adv_id . "/schedule/");
} else if($advertiserName == "Sputnik8") {
	$config = include("config.php");
	$token = $config["Sputnik8"]["token"];
	$user = $config["Sputnik8"]["username"];
	$result = file_get_contents("https://api.sputnik8.com/v1/products/" . $adv_id . "?api_key=" . $token . "&username=" . $user);
}
echo $result;