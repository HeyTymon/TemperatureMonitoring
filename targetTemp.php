<?php

	session_start(); 
	if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	

    //prawie dobrze - poprawić co z warunkiem i będzie działać
    if($_POST['clusterTemp'] == $_SESSION['clusterInfo'] || $_SESSION['clusterInfo'] == -1) {
        $_SESSION['tempUpToDate'] = "You  have permision to this cluster";
        header('Location: settings.php');
		exit();
    } 

    require_once "connection.php";
    $connection = new mysqli($host, $user, $password, $dbName);

    if ($connection->connect_error) {
        die("Error: " . $connection->connect_error);
    } 
    
    //change to avg(all sensors last measure)
    $sqlQuerry = "SELECT ROUND(AVG(temperature),2) AS avgTemperature FROM `measurementstoday` LIMIT 1";
    $sqlQuerry2 = "SELECT * FROM `clusters` WHERE `id` = " . $_POST['clusterTemp'] . " LIMIT 1";

    $result = $connection->query($sqlQuerry);
    $row = $result->fetch_assoc();

    $result2 = $connection->query($sqlQuerry2);
    $row2 = $result2->fetch_assoc();

    if(isset($_POST['temp']) && $_POST['temp'] > $row['avgTemperature']) {

        $url = "http://" . $row2['ip'] . "/reciveTemp"; 
        $data = array('temp' => $_POST['temp']);
        $options = array(
            'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),),);

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);   

        // $msg1 = "Text sent to ESP32: " . $_POST['temp'];
        // $msg2 = "Error sending text to ESP32";

        // echo ($result !== false) ?  $msg1 :  $msg2;
        
        if($result !== false) {
            $_SESSION['tempUpToDate'] = "Target temperature was sent to controller";
        } else {
            $_SESSION['tempUpToDate'] = "An error occurred during temperature setting";
        }

    } else {
        
        $_SESSION['tempUpToDate'] = "Target temperature is equal or higher than current temperature";

    }

    $connection->close(); 
	
	//header('Location: settings.php');
?>