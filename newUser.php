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
		$isUserAdmin = $_POST['isUserAdmin']; //to nie działa 
		
		if($newPassword == $newPassword2) {
			$sqlQuery = "INSERT INTO `users` (`id`, `login`, `password`, `isAdmin`) VALUES (NULL, '$newUserName', '$newPassword', 'isUserAdmin')";
			
			if(@$connection->query($sqlQuery)) {
				$_SESSION['isCreated'] = true;
				header('Location: settings.php');
			} else {
				$_SESSION['isDataNotCorrect'] = true; //okodować to w settings.php
			}
			
		} else {
			$_SESSION['isPassNotCorrect'] = true;
			header('Location: settings.php');
		}	
	}
	
	$connection->close();


?>