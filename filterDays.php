<?php 

    session_start(); 
    if(!isset($_SESSION['isLogined'])) { 
        header('Location: index.php');
        exit();
    }	

    $dateFilter = ($_POST['dateFilter'] == "ASC") ? "ASC" : "DESC";

    $sqlQuery1 = "SELECT `id`, MAX(temperature) AS maxTemperature, CAST(`date` AS DATE) AS date, `sensorName`, `cluster` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE) ORDER BY CAST(`date` AS DATE) $dateFilter";
    $sqlQuery2 = "SELECT `id`, MIN(temperature) AS minTemperature, CAST(`date` AS DATE) AS date, `sensorName`, `cluster` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE) ORDER BY CAST(`date` AS DATE) $dateFilter";
    $sqlQuery3 = "SELECT `id`, ROUND(AVG(temperature),2) AS avgTemperature, CAST(`date` AS DATE) AS date, `sensorName`, `cluster` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE) ORDER BY CAST(`date` AS DATE) $dateFilter";
    $sqlQuery4 = "SELECT `id`, ROUND(MAX(temperature) - MIN(temperature),2) AS amplitude, CAST(`date` AS DATE) AS date, `sensorName`, `cluster` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE) ORDER BY CAST(`date` AS DATE) $dateFilter";

    $sqlQuery21 = "SELECT `id`, MAX(humidity) AS maxHumidity, CAST(`date` AS DATE) AS date, `sensorName`, `cluster` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE) ORDER BY CAST(`date` AS DATE) $dateFilter";
    $sqlQuery22 = "SELECT `id`, MIN(humidity) AS minHumidity, CAST(`date` AS DATE) AS date, `sensorName`, `cluster` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE) ORDER BY CAST(`date` AS DATE) $dateFilter";
    $sqlQuery23 = "SELECT `id`, ROUND(AVG(humidity),2) AS avgHumidity, CAST(`date` AS DATE) AS date, `sensorName`, `cluster` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE) ORDER BY CAST(`date` AS DATE) $dateFilter";
    $sqlQuery24 = "SELECT `id`, ROUND(MAX(humidity) - MIN(humidity),2) AS amplitude, CAST(`date` AS DATE) AS date, `sensorName`, `cluster` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE) ORDER BY CAST(`date` AS DATE) $dateFilter";
    

    switch($_POST['parameter']) {
        
        case "Maximum values" : {
            $_SESSION['filterDaysValues1'] = $sqlQuery1;
            $_SESSION['filterDaysValues2'] = $sqlQuery21;
            $_SESSION['columnName1'] = "maxTemperature";
            $_SESSION['columnName2'] = "maxHumidity";
            $_SESSION["sensorNameSession"] = 1;
        } break;

        case "Minimum values" : {
            $_SESSION['filterDaysValues1'] = $sqlQuery2;
            $_SESSION['filterDaysValues2'] = $sqlQuery22;
            $_SESSION['columnName1'] = "minTemperature";
            $_SESSION['columnName2'] = "minHumidity";
            $_SESSION["sensorNameSession"] = 1;
        } break;

        case "Average values" : {
            $_SESSION['filterDaysValues1'] = $sqlQuery3;
            $_SESSION['filterDaysValues2'] = $sqlQuery23;
            $_SESSION['columnName1'] = "avgTemperature";
            $_SESSION['columnName2'] = "avgHumidity";
        } break;

        case "Amplitude" : {
            $_SESSION['filterDaysValues1'] = $sqlQuery4;
            $_SESSION['filterDaysValues2'] = $sqlQuery24;
            $_SESSION['columnName1'] = "amplitude";
            $_SESSION['columnName2'] = "amplitude";
        } break;
    }

    header('Location: days.php');

?>