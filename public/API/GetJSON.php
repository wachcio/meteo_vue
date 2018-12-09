<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');
header('X-Requested-With: XMLHttpRequest');

//if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    


header('Content-Type: application/json');


// ini_set("display_errors", 0);

require_once 'DB.php';
require_once 'Sensors.php';

// if (isset($_GET['operation']) || isset($_GET['sensor']) || isset($_GET['month']) || ($_GET['year']) ||(isset($_GET['data']))) {
    if (isset($_GET['data'])) {
        $data = $_GET['data'];
    
        if ($data == "current") {
            $s = new Sensors();
            $s->addSensors();
            if (isset($_GET['sensor'])) {
                echo json_encode($s->addSensor($_GET['sensor']));
            } else {
                echo json_encode($sensorsData);
            }
        }
    }

    if (isset($_GET['getSensorName'])) {
        $getSensorName = $_GET['getSensorName'];
    
        
        $s = new Sensors();
        if ($getSensorName == "all") {
            echo json_encode($s->getSensorName('all'));
        }
    }

    if (isset($_GET['operation']) && isset($_GET['sensor']) && ($_GET['year'])) {
        if (isset($_GET['hour'])) {
            $hour = $_GET['hour'];
        } else {
            $hour = -1;
        }

        if (isset($_GET['day'])) {
            $day = $_GET['day'];
        } else {
            $day = -1;
        }
        if (isset($_GET['month'])) {
            $month = $_GET['month'];
        } else {
            $month = -1;
        }

        
        $year = $_GET['year'];
        $sensor = $_GET['sensor'];
        $operation = $_GET['operation'];

        // var_dump($_GET);
        $s = new Sensors();

    
        
        if ($sensor == "all") {
            echo json_encode($s->statisticSensors($operation, $hour, $day, $month, $year));
        } else {
            echo json_encode($s->statisticSensor($operation, $sensor, $hour, $day, $month, $year));
        }
    }
// }
