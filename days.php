<?php 
	session_start(); 
	if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	
	
	require_once "connection.php";
	$connection = new mysqli("localhost", "root", "", "bme280");
	
	
?>