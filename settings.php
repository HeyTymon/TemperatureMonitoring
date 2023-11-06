<?php 
	session_start(); 
	if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8"/>
		<title>Settings</title>
	</head>
	<body>
		<h2>Target temperature</h2>
		<form action = "targetTemp.php" method = "post">
			<label for = "username">Enter the target temperature (to two decimal places):</label>
			<input type ="text"  name="username"><br>
			<input type="submit" value="Submit target temperature">
		</form>
		
		<h2>New User</h2>
		<form action = "newUser.php" method = "post">
			
			<?php
		 
			if ($_SESSION['isAdmin']) {
				echo <<<END
					<label for="newUserName">User name:</label>
					<input type="text" name="newUserName" placeholder="User">
					<br>
					<label for="newPassword">User password:</label>
					<input type="password" name="newPassword" placeholder="Password">
					<br>
					<label for="newPassword2">Eneter password again:</label>
					<input type="password" name="newPassword2" placeholder="Password">
					<br>
					<label for="isUserAdmin">Is user an admin:</label>
					<input type="number" name="isUserAdmin" min="0" max="1" required>
					<br>	
					<input type="submit" value="Submit new user">
					<br>
				END;
				
					if(isset($_SESSION['isPassNotCorrect'])) { 
						echo "pass error";
					}
					unset($_SESSION['isPassNotCorrect']);
					
					if(isset($_SESSION['isCreated'])) {
						echo "user created";
					}
					unset($_SESSION['isCreated']);
					
					if(isset($_SESSION['isDataNotCorrect'])){
						echo "data error";
					}

			} else {
				echo <<<END
					<span color = red>You must be loged in as an admin to add new users!</span>
					<br>
					<label for="newUserName">User name:</label>
					<input type="text" name="newUserName" placeholder="User" disabled>
					<br>
					<label for="newPassword">User password:</label>
					<input type="password" name="newPassword" placeholder="Password" disabled>
					<br>
					<label for="newPassword2">Eneter password again:</label>
					<input type="password" name="newPassword2" placeholder="Password"disabled>
					<br>
					<label for="isUserAdmin">Is user an admin:</label>
					<input type="number" name="isUserAdmin" min="0" max="1" required disabled>
					<br>
					<input type="submit" value="Submit new user" disabled>
				END;
			}
			
			?>
			
		</form>
		<h2>New sensor</h2>
		todo
		<br><br>
		<a href = "main.php">Main page</a>
	</body>
</html>