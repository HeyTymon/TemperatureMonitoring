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

        $sqlQuery3 = "SELECT * FROM `clusters` WHERE `id` = '$clusterSensor'";

        $result = @$connection->query($sqlQuery3);
        if($result->num_rows == 0) {
            $_SESSION['newSensorSession'] = "Cluster does not exists";
            header('Location: settings.php');
            $connection->close();
            exit();
        }
		
		if($result = @$connection->query($sqlQuery1)) {
            if($result->num_rows == 0) {
                if(@$connection->query($sqlQuery2)) {
                    $_SESSION['newSensorSession'] = "New sensor was added";
                    header('Location: settings.php');
                } else {
                    $_SESSION['newSensorSession'] = "Incorrect input data! Try again";
                    header('Location: settings.php');
                }
            } else {
                $_SESSION['newSensorSession'] = "Name or IP already taken";
                header('Location: settings.php');
            }
	    } else {
            echo "error"; //todo
        }
    }

	$connection->close();

?>