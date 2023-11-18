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
		
		$newUserName = $_POST['newUserName']; 
		$newPassword = $_POST['newPassword'];
		$newPassword2 = $_POST['newPassword2'];
		$isUserAdmin = $_POST['isUserAdmin'];  
		$clusters = $_POST['clusters'];
		
		if($newPassword == $newPassword2) {

			$sqlQuery1 = "SELECT * FROM `users` WHERE login = '$newUserName'";
			$sqlQuery2 = "INSERT INTO `users` (`id`, `login`, `password`, `isAdmin`, `clusters`) VALUES (NULL, '$newUserName', '$newPassword', '$isUserAdmin', '$clusters')";
			
			if($result = @$connection->query($sqlQuery1)) {
				if($result->num_rows == 0) {
					if(@$connection->query($sqlQuery2)) {
						$_SESSION['isCreated'] = true;
						header('Location: settings.php');
					} else {
						$_SESSION['isDataNotCorrect'] = true; 
						header('Location: settings.php');
					}
				} else {
					$_SESSION['dataTaken'] = true;
                	header('Location: settings.php');
				}
			} else {
				echo "error"; //todo
			}
			
		} else {
			$_SESSION['isPassNotCorrect'] = true;
			header('Location: settings.php');
		}	
	}
	
	$connection->close();


?>