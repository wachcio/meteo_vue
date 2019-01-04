<?php
// require_once 'dbconnect.php';


// $polaczenie = mysqli_connect($host, $user, $password);
// $db->getData( "SET CHARSET utf8");
// $db->getData( "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
// mysqli_select_db($polaczenie, $database);



$sensorsData = [];

// $sensorsDetail [0]["Temperatura", "AVR", "temperatura", "Odczyty z AVR", "temp", "temperatura_na_zewnatrz.png", "°C"];
 
$sensorsDetail = Array(
    0 => array("Temperatura", "AVR", "temperatura", "Odczyty z AVR", "temp", "temperatura_na_zewnatrz.png", "°C"),
    1 => array("Temperatura w urządzeniu", "AVR", "temperatura2", "Odczyty z AVR", "temp", "temperatura_raspberry.png", "°C"),
    2 => array("Prędkość wiatru km/h", "AVR", "predkosc_wiatru", "Odczyty z AVR", "wiatrKM", "wiatr.png", "km/h"),
    3 => array("Prędkość wiatru m/s", "AVR", "predkosc_wiatru", "Odczyty z AVR", "wiatrMS", "wiatr_ms.png", "m/s"),
    4 => array("Poryw wiatru km/h", "AVR", "poryw_wiatru", "Odczyty z AVR", "porywWiatrKM", "porywy_wiatru.png", "km/h"),
    5 => array("Poryw wiatru m/s", "AVR", "poryw_wiatru", "Odczyty z AVR", "porywWiatrMS", "porywy_wiatru_ms.png", "m/s"),
    // 6 => array("Kierunek wiatru", "AVR", "kierunek_wiatru", "Odczyty z AVR", "kierunekWiatru", "API/windDirectionArrow.php?w="),
    6 => array("Kierunek wiatru", "AVR", "kierunek_wiatru", "Odczyty z AVR", "kierunekWiatru", "API/windDirectionArrow.php?w=", ""),
    7 => array("Opady", "AVR", "opady", "Odczyty z AVR", "opady", "opady.png", ""),
    // 8 => array("Ciśnienie", "AVR", "cisnienie", "Odczyty z AVR", "hPa", "cisnienie.png", "hPa"),
    8 => array("Ciśnienie", "AVR", "cisnienie", "Odczyty z AVR", "", "cisnienie.png", "hPa"),
    // 9 => array("Ciśnienie zredukowane", "AVR", "cisnienie_zredukowane", "Odczyty z AVR", "hPa", "cisnienie_zredukowane.png", "hPa"),
    9 => array("Ciśnienie zredukowane", "AVR", "cisnienie_zredukowane", "Odczyty z AVR", "", "cisnienie_zredukowane.png", "hPa"),
    10 => array("Temperatura BMP180", "AVR", "temp_BMP", "Odczyty z AVR", "temp", "domek_ogrodowy.png", "°C"),
    11 => array("Wilgotność", "AVR", "wilgotnosc", "Odczyty z AVR", "z100_2", "wilgotnosc.png", "%"),
    12 => array("Temperatura SHT21", "AVR", "temp_SHT", "Odczyty z AVR", "z100_1", "temperatura_na_zewnatrz.png", "°C"),
    13 => array("Punkt rosy", "AVR", "punkt_rosy", "Odczyty z AVR", "z100_2", "punkt_rosy.png", "°C"),
    14 => array("Ciśnienie pary", "AVR", "cisnienie_pary", "Odczyty z AVR", "z100_2", "cisnienie_pary.png", "hPa"),
    // 15 => array("Nasłonecznienie", "AVR", "lux", "Odczyty z AVR", "lux", "LUX.png", "lx"),
    15 => array("Nasłonecznienie", "AVR", "lux", "Odczyty z AVR", "", "LUX.png", "lx"),
    //-----------------RPi----------------
    16 => array("Raspberry Pi", "Raspberry_Pi", "", "Odczyty z Raspberry Pi", "", "temperatura_raspberry.png", "°C"),
    17 => array("Kotłownia pomieszczenie", "28-0000062b6be2", "", "Odczyty z Raspberry Pi", "", "temperatura_piec_co.png", "°C"),
    18 => array("Kotłownia wyjście CO", "28-0000062bbaf9", "", "Odczyty z Raspberry Pi", "", "temperatura_piec_co.png", "°C"),
    19 => array("Kotłownia powrót CO", "28-0000062b77b6", "", "Odczyty z Raspberry Pi", "", "temperatura_piec_co.png", "°C"),
    20 => array("Bojler", "28-031467987aff", "", "Odczyty z Raspberry Pi", "", "bojler.png", "°C"),
    21 => array("Grunt temperatura", "gpio_20_temp", "", "Odczyty z Raspberry Pi", "", "temperatura_grunt.png", "°C"),
    22 => array("Grunt wilgotność", "gpio_20_humid", "", "Odczyty z Raspberry Pi", "", "wilgotnosc_grunt.png", "%"),
    23 => array("Balkon temperatura", "gpio_21_temp", "", "Odczyty z Raspberry Pi", "", "temperatura_balkon.png", "°C"),
    24 => array("Balkon wilgotność", "gpio_21_humid", "", "Odczyty z Raspberry Pi", "", "wilgotnosc_balkon.png", "%"),
    25 => array("Pokój gościnny", "28-0000062ac124", "", "Odczyty z Raspberry Pi", "", "temperatura.png", "°C"),
    26 => array("Przdpokój góra", "28-0000062b68cc", "", "Odczyty z Raspberry Pi", "", "temperatura.png", "°C"),
    27 => array("Akwarium", "wireless_192.168.2.195_18fe34e83e65_temp", "", "Odczyty z Raspberry Pi", "", "temperatura_akwarium.png", "°C"),
    28 => array("Sypialnia", "zegar_sypialnia", "", "Odczyty z Raspberry Pi", "zegary", "temperatura.png", "°C"),
    29 => array("Salon", "zegar_salon", "", "Odczyty z Raspberry Pi", "zegary", "temperatura.png", "°C"),
    //--------------Rpi studnia-------
    30 => array("Raspberry Pi studnia", "Rpi_studnia", "", "Odczyty ze studni", "", "temperatura_raspberry.png", "°C"),
    31 => array("Studnia", "28-031661bc32ff", "", "Odczyty ze studni", "", "studnia.png", "°C"),
    32 => array("Studnia rura", "28-800000262700", "", "Odczyty ze studni", "", "studnia.png", "°C"),
    33 => array("Garaż", "28-8000000493a0", "", "Odczyty ze studni", "", "garaz.png", "°C"),
    //--------------Czystość powietrza-------
    34 => array("Indeks czystości powietrza", "pyl_warszawska", "jakosc_powietrza", "Czujnik pyłu na ul. Warszawskiej", "", "pyl.png", " "),
    35 => array("Pył zawieszony PM1", "pyl_warszawska", "pm1", "Czujnik pyłu na ul. Warszawskiej", "", "pyl_1.png", "μg/m3"),
    36 => array("Pył zawieszony PM2,5", "pyl_warszawska", "pm25", "Czujnik pyłu na ul. Warszawskiej", "", "pyl_25.png", "μg/m3"),
    37 => array("Pył zawieszony PM10", "pyl_warszawska", "pm10", "Czujnik pyłu na ul. Warszawskiej", "", "pyl_10.png", "μg/m3"),
    38 => array("Ciśnienie", "pyl_warszawska", "cisnienie", "Czujnik pyłu na ul. Warszawskiej", "", "cisnienie_zredukowane.png", "hPa"),
    39 => array("Wilgotność", "pyl_warszawska", "wilgotnosc", "Czujnik pyłu na ul. Warszawskiej", "", "wilgotnosc.png", "%"),
    40 => array("Temperatura", "pyl_warszawska", "temperatura", "Czujnik pyłu na ul. Warszawskiej", "", "temperatura.png", "°C"),

);



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

        $arr = [];

        $arr["sensorName"] = $sensorName;
        $arr["picture"] = $picture;
        $arr["unit"] = $unit;

        $arr["sensorCategoryTitle"] = $sensorType;

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
