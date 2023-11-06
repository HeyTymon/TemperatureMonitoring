<?php 
	session_start(); 
	
	if(isset($_SESSION['isLogined']) && $_SESSION['isLogined'] == true) {
		header('Location: main.php');
		exit();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8"/>
		<title>Logowanie</title>
		<!--<link rel="stylesheet" href = "style1.css" type = "text/css"/> -->
	</head>
	<body>
		
		<form action ="login.php" method = "post">
			<label for = "login">Login:</label>
			<input type ="text" name = "login"><br><br>
		 
			<label for = "password">Password:</label>
			<input type ="password" name = "password"><br><br>
			<input type ="submit" value = "Sign in">
		</form> 
		
		<?php 
			if(isset($_SESSION['loginError'])) echo $_SESSION['loginError'];
		?>
		
	</body>
</html>