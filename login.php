<?php
	
	session_start();
	if (!isset($_POST['login']) || !isset($_POST['password'])) {
    header('Location: index.php');
    exit();
	}

	require_once "connection.php";

	$connection = @new mysqli($host, $user, $password, $dbName);

	
	if($connection->connect_errno != 0){
		echo "Error: ".$connection->connect_errno;
	} else {
		
		$login = $_POST['login'];
		$password  = $_POST['password'];

		$_SESSION['password'] = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");
		
		$sqlQuery = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
		
		if($result = @$connection->query(
		sprintf($sqlQuery,mysqli_real_escape_string($connection,$login),mysqli_real_escape_string($connection,$password)))) {
			if($result->num_rows == 1) {
				
				$row = $result->fetch_assoc();
				$_SESSION['login'] = $row['login'];
				$_SESSION['isAdmin'] = $row['isAdmin'];
				$_SESSION['isLogined'] = true;
				unset($_SESSION['loginError']);
				
				$result->free();
				
				header('Location: main.php');
				
			} else {
				$_SESSION['loginError'] = '<br> Wrong login or password! Try again';
				header('Location: index.php');
			}
		}
		
		$connection->close();
	}
?>
