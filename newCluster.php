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
		
		$newClusterId = $_POST['newClusterId'];
		$newClusterIp = $_POST['newClusterIp'];

        $sqlQuery1 = "SELECT * FROM `clusters` WHERE `id` = '$newClusterId' OR `ip` = '$newClusterIp'";

        $sqlQuery2 = "INSERT INTO `clusters` (`id`,`ip`) VALUES ('$newClusterId', '$newClusterIp')";
		
		if($result = @$connection->query($sqlQuery1)) {
            if($result->num_rows == 0) {
                if(@$connection->query($sqlQuery2)) {
                    $_SESSION['newClusterSession'] = "New cluster was added";
                    header('Location: settings.php');
                } else {
                    $_SESSION['newClusterSession'] = "Incorrect input data! Try again";
                    header('Location: settings.php');
                }
            } else {
                $_SESSION['newClusterSession'] = "ID or IP already taken";
                header('Location: settings.php');
            }
	    } else {
            echo "error"; //todo
        }
    }

	$connection->close();

?>