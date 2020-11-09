<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Page\Asset;
use Codeking\Advertiser\{CountryTable, CityTable};

class CKAdvertiser extends CBitrixComponent
{
	public function executeComponent() {
		//require($componentPath . '/functions.php');
		/*$countriesDataSputnik = file_get_contents("https://api.sputnik8.com/v1/countries?api_key=1c329ff31bce16fd692ef94c58ce1c4d&username=partners+tpo1@sputnik8.com&limit=100");
		$this->arResult["COUNTRIES"] = json_decode($countriesDataSputnik);
		if(isset($_GET['start']) && $_GET['start'] == 'y'){
			foreach($this->arResult["COUNTRIES"] as $country) {
				$result = CountryTable::add(array(
    				"NAME" => $country->name,
					"Sputnik" => $country->id
				));
				if ($result->isSuccess())
				{
				    	$countryTableId = $result->getId();
					$countryDataTripster = json_decode(file_get_contents("https://experience.tripster.ru/api/countries/?name_ru={$country->name}"));
					CountryTable::update($countryTableId, array(
						"Tripster" => $countryDataTripster->results[0]->id
					));
					//see($countryDataTripster);
					//die();
				}
			}
		}*/
		/*if(isset($_GET['start']) && $_GET['start'] == 'y') {
			$allCountries = CountryTable::getList();
			while ($countriesRow = $allCountries->fetch()) {
   				$countriesRows[] = $countriesRow;
			}
			//see($countriesRows);
			foreach($countriesRows as $country){
				$city = file_get_contents("https://api.sputnik8.com/v1/cities?api_key=1c329ff31bce16fd692ef94c58ce1c4d&username=partners+tpo1@sputnik8.com&country_id={$country['Sputnik']}");
				$citiesObjects = json_decode($city);
				foreach($citiesObjects as $objectCity) {
					$result = CityTable::add(array(
						"NAME" => $objectCity->name,
						"COUNTRY_ID" => $country["ID"],
						"Sputnik" => $objectCity->id
					));
					if($result->isSuccess()) {
						$cityTableId = $result->getId();
						$cityDataTripster = json_decode(file_get_contents("https://experience.tripster.ru/api/cities/?name_ru={$objectCity->name}"));
						CityTable::update($cityTableId, array(
							"Tripster" => $cityDataTripster->results[0]->id
						));
					}
				}
			}
		}*/
		/*if(isset($_GET['start']) && $_GET['start'] == 'y') {
			$cityQuery = CityTable::getList();
			while($cityQueryRes = $cityQuery->fetch()){
				//echo $cityQueryRes["NAME"];break;
				$getCityData = file_get_contents("https://surprizeme.ru/api/search/?query=" . $cityQueryRes["NAME"]);
				$getCityData = json_decode($getCityData);
				$getCityData = $getCityData->data;
				//see($getCityData[0]->city->slug);break;
				$slug = $getCityData[0]->city->slug;
				CityTable::update($cityQueryRes["ID"], array(
					"Surprise_Me" => $slug
				));
			}
		}*/
		$this->arResult["COUNTRIES"];
		$allCountries = CountryTable::getList();
		while ($countriesRow = $allCountries->fetch()) {
   			$this->arResult["COUNTRIES"][] = $countriesRow;
		};
		$this->arResult["CITIES"];
		$allCities = CityTable::getList();
		while ($citiesRow = $allCities->fetch()) {
			$this->arResult["CITIES"][] = $citiesRow;
		}
		$queryData = CIBlockElement::GetList(Array("SORT"=>"ASC"),Array("IBLOCK_ID" => $this->arParams["IBLOCK_ID"], "ACTIVE"=>'Y'), false, false, Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_*"));
		$this->arResult["DATA"];
		while($queryDataRes = $queryData->GetNextElement()){
			$dataArr = $queryDataRes->GetFields();
			$dataArr["PROPERTIES"] = $queryDataRes->GetProperties();
			$this->arResult["DATA"][] = $dataArr;
		}
		$this->includeComponentTemplate();
    }
}