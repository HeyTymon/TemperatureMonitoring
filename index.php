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
		<title>Sign in</title>
		<link rel="stylesheet" href = "styleLogin.css" type = "text/css"/> 
	</head>
	<body>
		<div class="container">
		
			<form action ="login2.php" method = "post">
				<label for = "login">Login:</label>
				<input type ="text" name = "login"><br><br>
			
				<label for = "password">Password:</label>
				<input type ="password" name = "password"><br><br>
				<input type ="submit" value = "Sign in">
			</form> 
			
			<?php 
				if(isset($_SESSION['loginError'])) echo $_SESSION['loginError'];
			?>
		</div>
	</body>
</html>