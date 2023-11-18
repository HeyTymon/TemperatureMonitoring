<?php
    session_start(); 
    if(!isset($_SESSION['isLogined'])) { 
        header('Location: index.php');
        exit();
    }	

    require_once "connection.php";
    $connection = @new mysqli($host, $user, $password, $dbName);

	if($connection->connect_errno != 0) {
		echo "Error: ".$connection->connect_errno;
	} else {
		
		$newSensorName = $_POST['newSensorName'];
		$newSensorIP = $_POST['newSensorIP'];
        $clusterSensor = $_POST['clusterSensor'];

        $sqlQuery1 = "SELECT * FROM `sensors` WHERE ip = '$newSensorIP' OR name = '$newSensorName'";

        $sqlQuery2 = "INSERT INTO `sensors` (`id`, `name`, `ip`, `cluster`) VALUES (NULL, '$newSensorName', '$newSensorIP', '$clusterSensor')";
		
		if($result = @$connection->query($sqlQuery1)) {
            if($result->num_rows == 0) {
                if(@$connection->query($sqlQuery2)) {
                    $_SESSION['isCreatedSensor'] = true;
                    header('Location: settings.php');
                } else {
                    $_SESSION['isDataNotCorrectSensor'] = true; 
                    header('Location: settings.php');
                }
            } else {
                $_SESSION['dataTakenSensor'] = true;
                header('Location: settings.php');
            }
	    } else {
            echo "error"; //todo
        }
    }

	$connection->close();

?>