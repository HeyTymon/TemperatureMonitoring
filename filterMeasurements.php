<?php

    session_start(); 
        
    if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	

    require_once "connection.php";
    $connection = @new mysqli($host, $user, $password, $dbName);

    if($connection->connect_errno != 0){
		echo "Error: ".$connection->connect_errno;
	} else {
		
		$parameter = $_POST['parameter'];
        $sensorName = $_POST['sensor'];
        $limit = $_POST['limit'];

		switch($parameter) {
            
                case "Date ASC": {
                    $_SESSION['filterValues1'] = "SELECT `id`, `temperature`,`date`, `sensorName` FROM `measurementstoday` ORDER BY `date` ASC LIMIT $limit";
                    $_SESSION['filterValues2'] = "SELECT * FROM `measurementstoday` ORDER BY `date` ASC LIMIT $limit";
                } break;

                case "Date DESC": {
                    $_SESSION['filterValues1'] = "SELECT `id`, `temperature`,`date`, `sensorName` FROM `measurementstoday` ORDER BY `date` DESC LIMIT $limit";
                    $_SESSION['filterValues2'] = "SELECT `id`, `humidity`,`date`, `sensorName` FROM `measurementstoday` ORDER BY `date` DESC LIMIT $limit";
                } break;

                case "Min values": {
                    $_SESSION['filterValues1'] = "SELECT `id`, `temperature`,`date`, `sensorName` FROM `measurementstoday` ORDER BY temperature DESC LIMIT $limit";
                    $_SESSION['filterValues2'] = "SELECT `id`, `humidity`,`date`, `sensorName` FROM `measurementstoday` ORDER BY `humidity` DESC LIMIT $limit";
                } break;

                case "Max values": {
                    $_SESSION['filterValues1'] = "SELECT `id`, `temperature`,`date`, `sensorName` FROM `measurementstoday` ORDER BY temperature ASC LIMIT $limit";
                    $_SESSION['filterValues2'] = "SELECT `id`, `humidity`,`date`, `sensorName` FROM `measurementstoday` ORDER BY `humidity` ASC LIMIT $limit";
                } break;

                case "Sensor name": {
                    $_SESSION['filterValues1'] = "SELECT `id`, `temperature`,`date`, `sensorName` FROM `measurementstoday` WHERE sensorName = '$sensorName' LIMIT $limit";
                    $_SESSION['filterValues2'] = "SELECT `id`, `humidity`,`date`, `sensorName` FROM `measurementstoday` WHERE sensorName = '$sensorName' LIMIT $limit";
                } break;

        }

        header('Location: main.php');
	}
    
	$connection->close();

?>