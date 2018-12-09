<?php

require_once 'DB.php' ;

class airlyDustSensor
{

    //Połączenie i pobranie ze strony Airly danych o czujniku na ul. Warszawskiej w Rypinie
    public function getData()
    {
        require_once 'HTTP/Request2.php';
        $request = new HTTP_Request2;
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setUrl('https://airapi.airly.eu/v2/measurements/point');
        // $request->setUrl('https://airapi.airly.eu/v2/installations/2944'); //id2944

        $request->setHeader(array('Accept'=>'application/json', 'apikey'=>'21f8c7970f554ceba41436ccf28138c4','Accept-Language'=>'pl', 'Accept-Encoding'=>'gzip'));

        $url = $request->getUrl();
        $url->setQueryVariables(array("lat" => "53.06277", "lng" => "19.41194"));
        $response = $request->send();
        $table = json_decode($response->getBody());
        // $table = json_decode($table);
        
        $result['airQuality'] = round($table->{"current"}->{"indexes"}[0]->{"value"}, 1);
        $result['pm1'] = round($table->{"current"}->{"values"}[0]->{"value"}, 1);
        $result['pm25'] = round($table->{"current"}->{"values"}[1]->{"value"}, 1);
        $result['pm10'] = round($table->{"current"}->{"values"}[2]->{"value"}, 1);
        $result['pressure'] = round($table->{"current"}->{"values"}[3]->{"value"}, 0);
        $result['humidity'] = round($table->{"current"}->{"values"}[4]->{"value"}, 1);
        $result['temperature'] = round($table->{"current"}->{"values"}[5]->{"value"}, 1);
        $result['opis'] = $table->{"current"}->{"indexes"}[0]->{"advice"};

        return $result;
    }

    //Zapis odczytanych wyników do bazy
    public function writeToDB()
    {
        $data = $this->getData();

        $db = new DB();
        $db->getData("INSERT INTO pyl_warszawska (jakosc_powietrza, pm1, pm25, pm10, cisnienie, wilgotnosc, temperatura) VALUES  (".$data["airQuality"].", ".$data["pm1"].", ".$data["pm25"].", ".$data["pm10"].", ".$data["pressure"].", ".$data["humidity"].", ".$data["temperature"].")");
    }
}

$dust = new airlyDustSensor;

$dust->getData();
$dust->writeToDB();
