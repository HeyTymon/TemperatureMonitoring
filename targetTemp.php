<?php

	session_start(); 
	if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	

    if($_POST['clusterTemp'] !== $_SESSION['clusterInfo'] && $_SESSION['clusterInfo'] !== -1) {
        $_SESSION['tempUpToDate'] = "You dont have permision to access this cluster";
        header('Location: settings.php');
		exit();
    } 

    require_once "connection.php";
    $connection = new mysqli($host, $user, $password, $dbName);

    if ($connection->connect_error) {
        die("Error: " . $connection->connect_error);
    } 
    
    //change to avg(all sensors last measure)
    $sqlQuerry = "SELECT ROUND(AVG(temperature),2) AS avgTemperature FROM `measurementstoday` LIMIT 1"; //set

    $sqlQuerry2 = "SELECT * FROM `clusters` WHERE `id` = " . $_POST['clusterTemp'] . " LIMIT 1"; //both

    $result = $connection->query($sqlQuerry);
    $row = $result->fetch_assoc();

    $result2 = $connection->query($sqlQuerry2);
    $row2 = $result2->fetch_assoc();

    if(isset($_POST['set'])) {
        
    } else if(isset($_POST['reset'])) {

    }

    if(isset($_POST['temp']) && $_POST['temp'] > $row['avgTemperature']) { //set

        $url = "http://" . $row2['ip'] . "/reciveTemp"; //function
        $data = array('temp' => $_POST['temp']);
        $options = array(
            'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),),);

        $context  = stream_context_create($options);
        $_start = microtime(true); // czas start!
        $result = file_get_contents($url, false, $context);   
        $_stop = microtime(true); // zatrzymaj stoper
        if($result !== false) {
            $_SESSION['tempUpToDate'] = "Target temperature was sent to controller - ".(round(($_stop-$_start),3));
            header('Location: settings.php');
        } else {
            $_SESSION['tempUpToDate'] = "An error occurred during temperature setting";
            header('Location: settings.php');
        }

    } else {
        
        $_SESSION['tempUpToDate'] = "Target temperature is equal or higher than current temperature";
        header('Location: settings.php');
    }

    $connection->close(); 
	
?>