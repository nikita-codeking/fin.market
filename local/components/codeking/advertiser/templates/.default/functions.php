<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Web\HttpClient;

class BitrixSender {
    private $advertiser; //поле хранящее определенного рекламодателя
    private $httpClient;

    /**
     * CurlSender constructor.
     * @param $advertiser рекламодатель
     */
    public function __construct($advertiser) {
        $this->advertiser = $advertiser;

        $this->httpClient = new HttpClient();

        if($this->advertiser->getHeaderAuth()) {
            $this->httpClient->setHeader('Authorization', $this->advertiser->getToken(), true);
        }

        $this->httpClient->setHeader('Content-Type', 'application/json', true);
    }

    /**
     * Функция для получения данных от рекламодателей
     *
     * @return mixed возвращает дессириализованный json ответ от Api рекламодателя
     */
    public function get() {
        return json_decode($this->httpClient->get($this->advertiser->getRequestString()), true);
    }
}

abstract class Advertiser{
    private $request; //Поле для хранение строки для запроса к Api рекламодателя
    private $classname;
    private $config; //Поле хранения конфигурации из config.php

    protected function init() {
        $this->classname = (new \ReflectionClass(get_class($this)))->getShortName();
        $this->config = (include(__DIR__ . '/config.php'))[$this->classname];
    }

    protected function getConfigAdvertiser() {
        return $this->config;
    }

    public function getToken() {
        return $this->config['token'];
    }

    public function getHeaderAuth() {
        return $this->config['headerAuth'];
    }

    public function getRequestString() {
        return $this->request;
    }

    protected function setRequestString(string $req) {
        $this->request = $req;
    }
}

class Sputnik8 extends Advertiser{

    /**
     * Sputnik8 constructor.
     * @param $resource ресурс где будем искать по параметрам(Например 'experiences' - ресурс с экскурсиями)
     * @param array $parameters параметры для выборки и сортировки в определенном ресурсе
     */
    function __construct($resource, array $parameters = array()) {
        self::init();

        $config = parent::getConfigAdvertiser();

        $query_string = http_build_query($parameters);

        self::setRequestString("https://api.sputnik8.com/v1/$resource?api_key={$config['token']}&username={$config['username']}&$query_string");
    }
}

class Tripster extends Advertiser{

    /**
     * Tripster constructor.
     * @param $resource ресурс где будем искать по параметрам(Например 'experiences' - ресурс с экскурсиями)
     * @param array $parameters параметры для выборки и сортировки в определенном ресурсе
     */
    function __construct($resource, array $parameters = array()) {
        self::init();
        
        $query_string = http_build_query($parameters);

        self::setRequestString("https://experience.tripster.ru/api/$resource/?$query_string");
    }
}

function getResource($advertiser, $resource, $parameters, $paginationKey, $valRes = '') {
    $queryAdvertiser = [];

    $advertiserRequest = new $advertiser($resource, $parameters);

    while (true) {
        $advertiserRequest = new $advertiser($resource, $parameters);
        $advertiserGet = (new BitrixSender($advertiserRequest))->get();
        $advertiserGet = ($valRes != '') ? $advertiserGet[$valRes] : $advertiserGet;
        if (count($advertiserGet) == 0 || $parameters[$paginationKey] > 3) {
            break;
        } else {
            $queryAdvertiser = array_merge($queryAdvertiser, $advertiserGet);
            $parameters[$paginationKey]++;
        }
    }

    return $queryAdvertiser;
}
