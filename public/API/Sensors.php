<?php

$sensorsData = [];

include_once("./sensorsArray.php");



class Sensors
{

    //Parametry funkcji: nazwa czujnika, nazwę bazy, pole w bazie, rodzaj czujnika (avr czy Rpi a przez to różne if)
    //Funkcja ma zwracać tablicę asocjacyjną: nazwa czujnika, wartość aktualna, wartość max, wartość min, data odczytu
    
 
    public function getCurrentData($sensor)
    {

        // tablica $arr - pola sensorName, value, valueMax, valueMin, date
        // dla specjalnych czujników wartości tablcy inne zależne od sensorType
        // mathOperation - zaokrąglenia itd.
        //$picture - plik obrazu

        require_once 'DB.php';
        $db = new DB();
        $db->connectDB();

        global $sensorsData;

        $sensorName = $sensor[0];
        $tableName = $sensor[1];
        $fieldName = $sensor[2];
        $sensorType = $sensor[3];
        $mathOperation = $sensor[4];
        $picture = $sensor[5];
        $unit = $sensor[6];
        $alarmMin = $sensor[7];
        $alarmMax = $sensor[8];

        $arr = [];

        $arr["sensorName"] = $sensorName;
        $arr["picture"] = $picture;
        $arr["unit"] = $unit;

        $arr["sensorCategoryTitle"] = $sensorType;
        $arr["alarmMin"] = $alarmMin;
        $arr["alarmMax"] = $alarmMax;

        if ($sensorType == "Odczyty z AVR") {
            $arr["sensorCategoryNr"] = 1;
            
            $arr["valueCurrent"] = $db->getData("SELECT `" . $fieldName . "`, `data_odczytu`, `id` FROM  `" . $tableName . "` ORDER BY  `id` DESC LIMIT 0 , 1");
            $arr["valueMax"] = $db->getData("SELECT `" . $fieldName . "`, `data_odczytu` FROM  `" . $tableName . "` WHERE  `data_odczytu` > DATE_SUB( NOW( ) , INTERVAL 1 DAY ) ORDER BY `" . $fieldName . "` DESC LIMIT 1");
            $arr["valueMin"] = $db->getData("SELECT `" . $fieldName . "`, `data_odczytu` FROM  `" . $tableName . "` WHERE  `data_odczytu` > DATE_SUB( NOW( ) , INTERVAL 1 DAY ) ORDER BY `" . $fieldName . "` ASC LIMIT 1");

            

            if ($mathOperation == "temp") {
                $arr["valueCurrent"]["value"] = round(($arr["valueCurrent"][$fieldName]) / 10, 1);
                $arr["valueMax"]["value"] = round(($arr["valueMax"][$fieldName]) / 10, 1);
                $arr["valueMin"]["value"] = round(($arr["valueMin"][$fieldName]) / 10, 1);
            }
            

            if ($mathOperation == "z100_1") {
                $arr["valueCurrent"]["value"] = round(($arr["valueCurrent"][$fieldName]) / 100, 1);
                $arr["valueMax"]["value"] = round(($arr["valueMax"][$fieldName]) / 100, 1);
                $arr["valueMin"]["value"] = round(($arr["valueMin"][$fieldName]) / 100, 1);
            }

            if ($mathOperation == "z100_2") {
                $arr["valueCurrent"]["value"] = round(($arr["valueCurrent"][$fieldName]) / 100, 2);
                $arr["valueMax"]["value"] = round(($arr["valueMax"][$fieldName]) / 100, 2);
                $arr["valueMin"]["value"] = round(($arr["valueMin"][$fieldName]) / 100, 2);
            }

            if ($mathOperation == "wiatrKM") {
                $arr["valueCurrent"]["value"] = round(($arr["valueCurrent"][$fieldName] * 2.4006279999999998) / 60, 2);
                $arr["valueMax"]["value"] = round(($arr["valueMax"][$fieldName] * 2.4006279999999998) / 60, 2);
                $arr["valueMin"]["value"] = round(($arr["valueMin"][$fieldName] * 2.4006279999999998) / 60, 2);
            }

            if ($mathOperation == "wiatrMS") {
                $arr["valueCurrent"]["value"] = round(($arr["valueCurrent"][$fieldName] * 0.6668411111) / 60, 2);
                $arr["valueMax"]["value"] = round(($arr["valueMax"][$fieldName] * 0.6668411111) / 60, 2);
                $arr["valueMin"]["value"] = round(($arr["valueMin"][$fieldName] * 0.6668411111) / 60, 2);
            }

            if ($mathOperation == "porywWiatrKM") {
                $arr["valueCurrent"]["value"] = round(($arr["valueCurrent"][$fieldName] * 2.4006279999999998), 2);
                $arr["valueMax"]["value"] = round(($arr["valueMax"][$fieldName] * 2.4006279999999998), 2);
                $arr["valueMin"]["value"] = round(($arr["valueMin"][$fieldName] * 2.4006279999999998), 2);
            }

            if ($mathOperation == "porywWiatrMS") {
                $arr["valueCurrent"]["value"] = round(($arr["valueCurrent"][$fieldName] * 0.6668411111), 2);
                $arr["valueMax"]["value"] = round(($arr["valueMax"][$fieldName] * 0.6668411111), 2);
                $arr["valueMin"]["value"] = round(($arr["valueMin"][$fieldName] * 0.6668411111), 2);
            }

            if ($mathOperation == "opady") {
                $arr["valueMax"] = $db->getData("SELECT SUM(`" . $fieldName . "`), `data_odczytu` FROM  `" . $tableName . "` WHERE  `data_odczytu` > DATE_SUB( NOW( ) , INTERVAL 1 HOUR )");
                $arr["valueMin"] = $db->getData("SELECT SUM(`" . $fieldName . "`), `data_odczytu` FROM  `" . $tableName . "` WHERE  `data_odczytu` > DATE_SUB( NOW( ) , INTERVAL 1 DAY )");


                $arr["valueCurrent"]["value"] = round($arr["valueCurrent"][$fieldName] * 0.2794, 2);
                $arr["valueMax"]["value"] = round($arr["valueMax"]["SUM(`opady`)"] * 0.2794, 2);
                $arr["valueMin"]["value"] = round($arr["valueMin"]["SUM(`opady`)"] * 0.2794, 2);

                unset($arr["valueMax"]["SUM(`opady`)"]);
                unset($arr["valueMin"]["SUM(`opady`)"]);
            }

            if ($mathOperation == "kierunekWiatru") {
                //Kierunek wiatru słownie
                switch ($arr["valueCurrent"][$fieldName]) {
                    case 0:
                        $kierunek_wiatru_slownie = "N";
                        $kierunek_wiatru_stopnie = 0;
                        break;
                    case 1:
                        $kierunek_wiatru_slownie = "NNE";
                        $kierunek_wiatru_stopnie = 22.5;
                        break;
                    case 2:
                        $kierunek_wiatru_slownie = "NE";
                        $kierunek_wiatru_stopnie = 45;
                        break;
                    case 3:
                        $kierunek_wiatru_slownie = "ENE";
                        $kierunek_wiatru_stopnie = 67.5;
                        break;
                    case 4:
                        $kierunek_wiatru_slownie = "E";
                        $kierunek_wiatru_stopnie = 90;
                        break;
                    case 5:
                        $kierunek_wiatru_slownie = "ESE";
                        $kierunek_wiatru_stopnie = 112.5;
                        break;
                    case 6:
                        $kierunek_wiatru_slownie = "SE";
                        $kierunek_wiatru_stopnie = 135;
                        break;
                    case 7:
                        $kierunek_wiatru_slownie = "SSE";
                        $kierunek_wiatru_stopnie = 157.5;
                        break;
                    case 8:
                        $kierunek_wiatru_slownie = "S";
                        $kierunek_wiatru_stopnie = 180;
                        break;
                    case 9:
                        $kierunek_wiatru_slownie = "SSW";
                        $kierunek_wiatru_stopnie = 202.5;
                        break;
                    case 10:
                        $kierunek_wiatru_slownie = "SW";
                        $kierunek_wiatru_stopnie = 225;
                        break;
                    case 11:
                        $kierunek_wiatru_slownie = "WSW";
                        $kierunek_wiatru_stopnie = 247.5;
                        break;
                    case 12:
                        $kierunek_wiatru_slownie = "W";
                        $kierunek_wiatru_stopnie = 270;
                        break;
                    case 13:
                        $kierunek_wiatru_slownie = "WNW";
                        $kierunek_wiatru_stopnie = 292.5;
                        break;
                    case 14:
                        $kierunek_wiatru_slownie = "NW";
                        $kierunek_wiatru_stopnie = 315;
                        break;
                    case 15:
                        $kierunek_wiatru_slownie = "NNW";
                        $kierunek_wiatru_stopnie = 337.5;
                        break;
                }

                $arr["valueCurrent"]["value"] = $kierunek_wiatru_slownie;
                $arr["valueMax"]["value"] = " ";
                $arr["valueMin"]["value"] = " ";
                $arr["picture"] = $picture . $kierunek_wiatru_stopnie;
            }

            if ($mathOperation == null) {
                $arr["valueCurrent"]["value"] = $arr["valueCurrent"][$fieldName];
                $arr["valueMax"]["value"] = $arr["valueMax"][$fieldName];
                $arr["valueMin"]["value"] = $arr["valueMin"][$fieldName];
            }

            $arr["valueCurrent"]["date"] = $arr["valueCurrent"]["data_odczytu"];
            $arr["valueMax"]["date"] = $arr["valueMax"]["data_odczytu"];
            $arr["valueMin"]["date"] = $arr["valueMin"]["data_odczytu"];

            // unset($arr["valueCurrent"]["data_odczytu"]);
            // unset($arr["valueMax"]["data_odczytu"]);
            // unset($arr["valueMin"]["data_odczytu"]);

            unset($arr["valueCurrent"][$fieldName]);
            unset($arr["valueMax"][$fieldName]);
            unset($arr["valueMin"][$fieldName]);
            unset($arr["valueCurrent"]["id"]);
            unset($arr["valueMax"]["id"]);
            unset($arr["valueMin"]["id"]);
        }
        // -----------------------RPi--------------------------

        if ($sensorType == "Odczyty z Raspberry Pi" || $sensorType == "Odczyty ze studni") {
            if ($sensorType == "Odczyty z Raspberry Pi") {
                $arr["sensorCategoryNr"] = 2;
            }

            if ($sensorType == "Odczyty ze studni") {
                $arr["sensorCategoryNr"] = 3;
            }

            $arr["valueCurrent"] = $db->getData("SELECT  * FROM `" . $tableName . "` ORDER BY  `" . $tableName . "`.`id` DESC LIMIT 1");
            $arr["valueMax"] = $db->getData("SELECT * FROM  `" . $tableName . "` WHERE `time` > DATE_SUB( NOW( ) , INTERVAL 1 DAY ) ORDER BY  `" . $tableName . "`.`value` DESC LIMIT 1 ");
            $arr["valueMin"] = $db->getData("SELECT * FROM  `" . $tableName . "` WHERE `time` > DATE_SUB( NOW( ) , INTERVAL 1 DAY ) ORDER BY  `" . $tableName . "`.`value` ASC LIMIT 1 ");

         

            $arr["valueCurrent"]["date"] = $arr["valueCurrent"]["data"];
            $arr["valueMax"]["date"] = $arr["valueMax"]["data"];
            $arr["valueMin"]["date"] = $arr["valueMin"]["data"];

            if ($mathOperation == "zegary") {
                $arr["valueCurrent"]["date"] = $arr["valueCurrent"]["time"];
                $arr["valueMax"]["date"] = $arr["valueMax"]["time"];
                $arr["valueMin"]["date"] = $arr["valueMin"]["time"];
            }

            unset($arr["valueCurrent"]["time"]);
            unset($arr["valueMax"]["time"]);
            unset($arr["valueMin"]["time"]);

            unset($arr["valueCurrent"]["data"]);
            unset($arr["valueMax"]["data"]);
            unset($arr["valueMin"]["data"]);
        }

        //-------------------------------------czystość powietrza ----------------------------------

        if ($sensorType == "Czujnik pyłu na ul. Warszawskiej") {
            $arr["sensorCategoryNr"] = 4;

            $arr["valueCurrent"] = $db->getData("SELECT `" . $fieldName . "`, `data_odczytu`, `id` FROM  `" . $tableName . "` ORDER BY  `id` DESC LIMIT 0 , 1");
            $arr["valueMax"] = $db->getData("SELECT `" . $fieldName . "`, `data_odczytu`, `id` FROM  `" . $tableName . "` WHERE  `data_odczytu` > DATE_SUB( NOW( ) , INTERVAL 1 DAY ) ORDER BY `" . $fieldName . "` DESC LIMIT 1");
            $arr["valueMin"] = $db->getData("SELECT `" . $fieldName . "`, `data_odczytu`, `id` FROM  `" . $tableName . "` WHERE  `data_odczytu` > DATE_SUB( NOW( ) , INTERVAL 1 DAY ) ORDER BY `" . $fieldName . "` ASC LIMIT 1");


            $arr["valueCurrent"]["date"] = $arr["valueCurrent"]["data_odczytu"];
            $arr["valueMax"]["date"] = $arr["valueMax"]["data_odczytu"];
            $arr["valueMin"]["date"] = $arr["valueMin"]["data_odczytu"];

            $arr["valueCurrent"]["value"] = $arr["valueCurrent"][$fieldName];
            $arr["valueMax"]["value"] = $arr["valueMax"][$fieldName];
            $arr["valueMin"]["value"] = $arr["valueMin"][$fieldName];

            unset($arr["valueCurrent"][$fieldName]);
            unset($arr["valueMax"][$fieldName]);
            unset($arr["valueMin"][$fieldName]);
        }

        if ($arr["valueCurrent"]["value"] === null) {
            $arr["valueCurrent"]["value"] = "";
            $arr["valueCurrent"]["date"] = "";
        }

        if ($arr["valueMax"]["value"] === null) {
            $arr["valueMax"]["value"] = "";
            $arr["valueMax"]["date"] = "";
        }

        if ($arr["valueMin"]["value"] === null) {
            $arr["valueMin"]["value"] = "";
            $arr["valueMin"]["date"] = "";
        }

       

        unset($arr["valueCurrent"]["data_odczytu"]);
        unset($arr["valueMax"]["data_odczytu"]);
        unset($arr["valueMin"]["data_odczytu"]);
        unset($arr["valueCurrent"]["id"]);
        unset($arr["valueMax"]["id"]);
        unset($arr["valueMin"]["id"]);

       

        array_push($sensorsData, $arr);


        return $arr;
    }

    public function addSensors()
    {
        //Dodawanie czujników do tablicy globalnej $sensorsData
        $arr =[];
        global $sensorsDetail;

        for ($i=0; $i<count($sensorsDetail); $i++){
            array_push($arr, $this->getCurrentData($sensorsDetail[$i]));
            // var_dump($sensorsDetail[$i]);
        }

         return $arr;
    }
    public function addSensor($sensorNr){

        
        global $sensorsDetail;

        return $this->getCurrentData($sensorsDetail[$sensorNr]);
    }

    public function getStatisticData($operation, $sensor, $hour, $day, $month, $year)
    {

        require_once 'DB.php';
        $db = new DB();
        $db->connectDB();

        

        $sensorName = $sensor[0];
        $tableName = $sensor[1];
        $fieldName = $sensor[2];
        $sensorType = $sensor[3];
        $mathOperation = $sensor[4];
        $picture = $sensor[5];
        $unit = $sensor[6];

        // var_dump($sensorName);
        $arr = [];
       
        $arr["sensorName"] = $sensorName;
        $arr["picture"] = $picture;
        $arr["unit"] = $unit;
        $arr["operation"] = $operation;
        // $arr["date"] = "";

        $arr["sensorCategoryTitle"] = $sensorType;
        // echo($sensorType);
        if ($sensorType == "Odczyty z AVR") {
            $arr["sensorCategoryNr"] = 1;

            if (($operation == "avg") || ($operation == "max") || ($operation == "min") || ($operation == "sum")) {
                if ($operation == "avg" || $operation == "sum") {
                $query = "SELECT ".$operation."(`" . $fieldName . "`) AS `".$operation."`, `data_odczytu` FROM  `AVR` WHERE YEAR( `data_odczytu`) = ". $year;
                } 
                if ($operation == "max" || $operation == "min") {
                $query = "SELECT `" . $fieldName . "`AS `".$operation."`, `data_odczytu` FROM  `AVR` WHERE YEAR( `data_odczytu`) = ". $year;
                }
                if ($month>0 && $month<13){
                    $query = $query. " AND MONTH( `data_odczytu` ) = ".$month;
                } else {
                    $month=-1;
                }

                if ($day>0 && $day<31){
                    $query = $query. " AND DAY( `data_odczytu` ) = ".$day;
                } else {
                    $day=-1;
                }

                if ($hour>-1 && $hour<24){
                    $query = $query. " AND HOUR( `data_odczytu` ) = ".$hour;
                } else {
                    $hour=-1;
                }

                if ($operation == "max") {
                    $query = $query. " ORDER BY `".$fieldName."` DESC LIMIT 1 ";
                }
                if ($operation == "min") {
                    $query = $query. " ORDER BY `".$fieldName."` ASC LIMIT 1 ";
                }

                // echo($query);
                
                $arr["value"] = $db->getData($query);
                if ($operation == "min" || $operation == "max") {
                $arr["date"] = $arr["value"]["data_odczytu"];
                }
                $arr["value"] = $arr["value"][$operation];
                
                
        
            }  

            if ($mathOperation == "temp") {
                $arr["value"] = round(($arr["value"]) / 10, 1);
            }
            

            if ($mathOperation == "z100_1") {
                $arr["value"] = round(($arr["value"]) / 100, 1);
            }

            if ($mathOperation == "z100_2") {
                $arr["value"] = round(($arr["value"]) / 100, 2);
            }

            if ($mathOperation == "wiatrKM") {
                $arr["value"] = round(($arr["value"] * 2.4006279999999998) / 60, 2);
            }

            if ($mathOperation == "wiatrMS") {
                $arr["value"] = round(($arr["value"] * 0.6668411111) / 60, 2);
            }

            if ($mathOperation == "porywWiatrKM") {
                $arr["value"] = round(($arr["value"] * 2.4006279999999998), 2);
            }

            if ($mathOperation == "porywWiatrMS") {
                $arr["value"] = round(($arr["value"] * 0.6668411111), 2);
            }

            if ($mathOperation == "opady") {
                $arr["value"] = round(($arr["value"] *  0.2794), 2);
                $arr["unit"] = "mm";
            }

            if ($mathOperation == "kierunekWiatru") {

                // if ($operation == "avg") {
                    $arr["value"] = $db->getData("SELECT AVG(`" . $fieldName . "`) AS `dominantaValue`, COUNT(`" . $fieldName . "`) AS `dominantaCount` FROM  `AVR` WHERE MONTH( `data_odczytu` ) = ".$month." AND YEAR( `data_odczytu`) = ". $year." GROUP BY `" . $fieldName . "` ORDER BY `dominantaCount` DESC LIMIT 1");
                
                    $arr["value"] = $arr["value"]["dominantaValue"];
                // }
                //Kierunek wiatru słownie
                switch ($arr["value"]) {
                    case 0:
                        $kierunek_wiatru_slownie = "N";
                        $kierunek_wiatru_stopnie = 0;
                        break;
                    case 1:
                        $kierunek_wiatru_slownie = "NNE";
                        $kierunek_wiatru_stopnie = 22.5;
                        break;
                    case 2:
                        $kierunek_wiatru_slownie = "NE";
                        $kierunek_wiatru_stopnie = 45;
                        break;
                    case 3:
                        $kierunek_wiatru_slownie = "ENE";
                        $kierunek_wiatru_stopnie = 67.5;
                        break;
                    case 4:
                        $kierunek_wiatru_slownie = "E";
                        $kierunek_wiatru_stopnie = 90;
                        break;
                    case 5:
                        $kierunek_wiatru_slownie = "ESE";
                        $kierunek_wiatru_stopnie = 112.5;
                        break;
                    case 6:
                        $kierunek_wiatru_slownie = "SE";
                        $kierunek_wiatru_stopnie = 135;
                        break;
                    case 7:
                        $kierunek_wiatru_slownie = "SSE";
                        $kierunek_wiatru_stopnie = 157.5;
                        break;
                    case 8:
                        $kierunek_wiatru_slownie = "S";
                        $kierunek_wiatru_stopnie = 180;
                        break;
                    case 9:
                        $kierunek_wiatru_slownie = "SSW";
                        $kierunek_wiatru_stopnie = 202.5;
                        break;
                    case 10:
                        $kierunek_wiatru_slownie = "SW";
                        $kierunek_wiatru_stopnie = 225;
                        break;
                    case 11:
                        $kierunek_wiatru_slownie = "WSW";
                        $kierunek_wiatru_stopnie = 247.5;
                        break;
                    case 12:
                        $kierunek_wiatru_slownie = "W";
                        $kierunek_wiatru_stopnie = 270;
                        break;
                    case 13:
                        $kierunek_wiatru_slownie = "WNW";
                        $kierunek_wiatru_stopnie = 292.5;
                        break;
                    case 14:
                        $kierunek_wiatru_slownie = "NW";
                        $kierunek_wiatru_stopnie = 315;
                        break;
                    case 15:
                        $kierunek_wiatru_slownie = "NNW";
                        $kierunek_wiatru_stopnie = 337.5;
                        break;
                }

                $arr["value"] = $kierunek_wiatru_slownie;
                $arr["picture"] = $arr["picture"] . $kierunek_wiatru_stopnie;
            }

            if ($sensorName == "Ciśnienie" || $sensorName == "Ciśnienie zredukowane") {

                $arr["value"] = round($arr["value"], 0);

            }
            if ($sensorName == "Nasłonecznienie") {

                $arr["value"] = round($arr["value"], 0);

            }
            
            
        }
        //  -----------------------RPi--------------------------

        if ($sensorType == "Odczyty z Raspberry Pi" || $sensorType == "Odczyty ze studni") {
            if ($sensorType == "Odczyty z Raspberry Pi") {
                $arr["sensorCategoryNr"] = 2;
            }

            if ($sensorType == "Odczyty ze studni") {
                $arr["sensorCategoryNr"] = 3;
            }

            if (($operation == "avg") || ($operation == "max") || ($operation == "min")) {
                if ($operation == "avg") {
                $query = "SELECT ".$operation."(`value`) AS `".$operation."` FROM  `" . $tableName . "` WHERE YEAR( `data`) = ". $year;
                }
                if ($operation == "max" || $operation == "min") {
                    $query = "SELECT `value` AS `".$operation."`, `data` FROM  `" . $tableName . "` WHERE YEAR( `data`) = ". $year;
                    }
                if ($month>0 && $month<13){
                    $query = $query. " AND MONTH( `data` ) = ".$month;
                } else {
                    $month=-1;
                }

                if ($day>0 && $day<31){
                    $query = $query. " AND DAY( `data` ) = ".$day;
                } else {
                    $day=-1;
                }

                if ($hour>-1 && $hour<24){
                    $query = $query. " AND HOUR( `data` ) = ".$hour;
                } else {
                    $hour=-1;
                }
                if ($operation == "max") {
                    $query = $query. " ORDER BY `value` DESC LIMIT 1 ";
                }
                if ($operation == "min") {
                    $query = $query. " ORDER BY `value` ASC LIMIT 1 ";
                }
                
                $arr["value"] = $db->getData($query);
                if ($operation == "min" || $operation == "max") {
                    $arr["date"] = $arr["value"]["data"];
                    }
                $arr["value"] = ROUND($arr["value"][$operation], 1);
            } 
            
        }

        // //  ------------------------------------czystość powietrza ----------------------------------

        if ($sensorType == "Czujnik pyłu na ul. Warszawskiej") {
            $arr["sensorCategoryNr"] = 4;

            if (($operation == "avg") || ($operation == "max") || ($operation == "min")) {
                if ($operation == "avg") {
                    $query = "SELECT ".$operation."(`" . $fieldName . "`) AS `".$operation."` FROM  `pyl_warszawska` WHERE YEAR( `data_odczytu`) = ". $year;
                    }
                    if ($operation == "max" || $operation == "min") {
                        $query = "SELECT `" . $fieldName . "` AS `".$operation."`, `data_odczytu` FROM  `pyl_warszawska` WHERE YEAR( `data_odczytu`) = ". $year;
                        }
                

                //zagnieździć ify żeby wyeliminować możliwość podania godziny bez miesiąca itd
                if ($month>0 && $month<13){
                    $query = $query. " AND MONTH( `data_odczytu` ) = ".$month;
                } else {
                    $month=-1;
                }

                if ($day>0 && $day<31){
                    $query = $query. " AND DAY( `data_odczytu` ) = ".$day;
                } else {
                    $day=-1;
                }

                if ($hour>-1 && $hour<24){
                    $query = $query. " AND HOUR( `data_odczytu` ) = ".$hour;
                } else {
                    $hour=-1;
                }
                
                if ($operation == "max") {
                    $query = $query. " ORDER BY `" . $fieldName . "` DESC LIMIT 1 ";
                }
                if ($operation == "min") {
                    $query = $query. " ORDER BY `" . $fieldName . "` ASC LIMIT 1 ";
                }
                
                $arr["value"] = $db->getData($query);
                if ($operation == "min" || $operation == "max") {
                    $arr["date"] = $arr["value"]["data_odczytu"];
                    }
                
            
                $arr["value"] = ROUND($arr["value"][$operation], 1);
            } 
            
        }
        
        $arr["year"] = $year;
        $arr["month"] = $month;
        $arr["day"] = $day;
        $arr["hour"] = $hour;

        // echo $query;

        return $arr;
    }

    public function statisticSensors($operation,  $hour, $day, $month, $year){

        $arr =[];
        global $sensorsDetail;

        for ($i=0; $i<count($sensorsDetail); $i++){
            array_push($arr, $this->getStatisticData($operation, $sensorsDetail[$i], $hour, $day, $month, $year));
            // var_dump($sensorsDetail[$i]);
        }

         return $arr;
    }

    public function statisticSensor($operation, $sensorNr, $hour, $day, $month, $year){

        
        global $sensorsDetail;

        return $this->getStatisticData($operation, $sensorsDetail[$sensorNr], $hour, $day, $month, $year);
    }

    public function getSensorName($sensorNumbers){

        
        global $sensorsDetail;

        if ($sensorNumbers == "all") {

            $arr = [];

            for ($i =0; $i< count($sensorsDetail); $i++) {
                $elem = $sensorsDetail[$i][0];
                // $elem1 = $sensorsDetail[$i][1];
                array_push($arr, $elem);
            }            

            return $arr;
        }
    }
}



// require_once 'czujniki.php';

//echo"Sensors: ";
//echo "<pre>";
//print_r($sensorsData);
//echo "</pre>";

// $s=new Sensors;
// $s->monthSensors(8,2018);
