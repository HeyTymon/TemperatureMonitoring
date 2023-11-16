<?php

	session_start(); 
	if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	

    require_once "connection.php";
    $connection = new mysqli($host, $user, $password, $dbName);

    if ($connection->connect_error) {
        die("Error: " . $connection->connect_error);
    } 
    
    //change to avg(all sensors last measure)
    $sqlQuerry = "SELECT ROUND(AVG(temperature),2) AS avgTemperature FROM `measurementstoday` LIMIT 1";

    $result = $connection->query($sqlQuerry);
    $row = $result->fetch_assoc();

    //echo $row['avgTemperature'];

    if(isset($_POST['temp']) && $_POST['temp'] < $row['avgTemperature']) {

        $url = "http://172.16.1.200/reciveTemp"; // server.on("/reciveTemp", HTTP_POST, [](AsyncWebServerRequest *request){...
        $data = array('temp' => $_POST['temp']);
        $options = array(
            'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),),);

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);   

        $msg1 = "Text sent to ESP32: " . $_POST['temp'];
        $msg2 = "Error sending text to ESP32";

        echo ($result !== false) ?  $msg1 :  $msg2;

    } else {
        
        echo "Temp is already up to date";

    }
	
	echo '<br><a href = "main.php"> Main page </ar>';
?>