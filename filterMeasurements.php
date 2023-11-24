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
        $clusterNumber = $_POST['clusterNumber'];
        $formattedDate = date('Y-m-d', strtotime($_POST['datePicker']));

        $_SESSION['formattedDate'] = $formattedDate;

		switch($parameter) {
            
                case "Date ASC": {
                    $_SESSION['filterValues1'] = "SELECT `id`, `temperature`, `date`, `sensorName`, `cluster` FROM `measurementstoday` WHERE `cluster` = $clusterNumber AND DATE(`date`) =  '$formattedDate' ORDER BY `date` ASC LIMIT $limit";
                    $_SESSION['filterValues2'] = "SELECT `id`, `humidity`, `date`, `sensorName`, `cluster` FROM `measurementstoday` WHERE `cluster` = $clusterNumber AND DATE(`date`) =  '$formattedDate' ORDER BY `date` ASC LIMIT $limit";
                } break;

                case "Date DESC": {
                    $_SESSION['filterValues1'] = "SELECT `id`, `temperature`,`date`, `sensorName`, `cluster` FROM `measurementstoday` WHERE `cluster` = $clusterNumber AND DATE(`date`) =  '$formattedDate' ORDER BY `date` DESC LIMIT $limit";
                    $_SESSION['filterValues2'] = "SELECT `id`, `humidity`,`date`, `sensorName`, `cluster` FROM `measurementstoday` WHERE `cluster` = $clusterNumber AND DATE(`date`) =  '$formattedDate' ORDER BY `date` DESC LIMIT $limit";
                } break;

                case "Min values": {
                    $_SESSION['filterValues1'] = "SELECT `id`, `temperature`,`date`, `sensorName`, `cluster` FROM `measurementstoday` WHERE `cluster` = $clusterNumber AND DATE(`date`) =  '$formattedDate' ORDER BY temperature ASC LIMIT $limit";
                    $_SESSION['filterValues2'] = "SELECT `id`, `humidity`,`date`, `sensorName`, `cluster` FROM `measurementstoday` WHERE `cluster` = $clusterNumber AND DATE(`date`) =  '$formattedDate' ORDER BY `humidity` ASC LIMIT $limit";
                } break;

                case "Max values": {
                    $_SESSION['filterValues1'] = "SELECT `id`, `temperature`,`date`, `sensorName`, `cluster` FROM `measurementstoday` WHERE `cluster` = $clusterNumber AND DATE(`date`) =  '$formattedDate' ORDER BY temperature DESC LIMIT $limit";
                    $_SESSION['filterValues2'] = "SELECT `id`, `humidity`,`date`, `sensorName`, `cluster` FROM `measurementstoday` WHERE `cluster` = $clusterNumber AND DATE(`date`) =  '$formattedDate' ORDER BY `humidity` DESC LIMIT $limit";
                } break;

                case "Sensor name": {
                    $_SESSION['filterValues1'] = "SELECT `id`, `temperature`,`date`, `sensorName`, `cluster` FROM `measurementstoday` WHERE sensorName = '$sensorName' AND `cluster` = $clusterNumber AND DATE(`date`) =  '$formattedDate' LIMIT $limit";
                    $_SESSION['filterValues2'] = "SELECT `id`, `humidity`,`date`, `sensorName`, `cluster` FROM `measurementstoday` WHERE sensorName = '$sensorName' AND `cluster` = $clusterNumber AND DATE(`date`) =  '$formattedDate' LIMIT $limit";
                } break;

        }

        header('Location: main.php');
	}
    
	$connection->close();

?>