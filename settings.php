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
		<!--<link rel="stylesheet" href = "styleSettings.css" type = "text/css"/>-->
	</head>
	<body>
		<h2>Target temperature</h2>
			<form action = "targetTemp.php" method = "post">
				<label for = "temp">Enter the target temperature (to two decimal places):</label>
				<input type = "number" step = "0.01" name = "temp" value = "20.00">
				<br>
				<input type = "submit" value = "Submit target temperature">
			</form><br>

			<?php 

				if(isset($_SESSION['tempUpToDate'])) {
					echo $_SESSION['tempUpToDate'];
				}
				unset($_SESSION['tempUpToDate']);

			?>
		
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
								echo "Passwords do not match! Try again";
							}
							unset($_SESSION['isPassNotCorrect']);

							if(isset($_SESSION['dataTaken'])) {
								echo "Name already taken";
							}
							unset($_SESSION['dataTaken']);
							
							if(isset($_SESSION['isCreated'])) {
								echo "New user was created";
							}
							unset($_SESSION['isCreated']);
							
							if(isset($_SESSION['isDataNotCorrect'])){
								echo "Incorrect input data! Try again";
							}
							unset($_SESSION['isDataNotCorrect']);

					} else {
						echo <<<END
							<span color = "red">You must be loged in as an admin to add new users!</span>
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
			<form action = "newSensor.php" method = "post">
				<?php
					if ($_SESSION['isAdmin']) {
						echo <<<END
						<label for="newSensorName">Sensor name:</label>
						<input type="text" name="newSensorName" placeholder="Sensor">
						<br>
						<label for="newSensorIP">Sensor IP:</label>
						<input type="text" name="newSensorIP" placeholder="10.0.0.1">
						<br>
						<input type="submit" value="Submit new sensor">
						<br>
						END;

						if(isset($_SESSION['isCreatedSensor'])) {
							echo "New sensor was added";
						}
						unset($_SESSION['isCreatedSensor']);

						if(isset($_SESSION['dataTakenSensor'])) {
							echo "Name or IP already taken";
						}
						unset($_SESSION['dataTakenSensor']);

						if(isset($_SESSION['isDataNotCorrectSensor'])){
							echo "Incorrect input data! Try again";
						}
						unset($_SESSION['isDataNotCorrectSensor']);

					} else {
						echo <<<END
						<label for="newSensorName">Sensor name:</label>
						<input type="text" name="newSensorName" placeholder="Sensor" disabled>
						<br>
						<label for="newSensorIP">Sensor IP:</label>
						<input type="text" name="newSensorIP" placeholder="10.0.0.1" disabled>
						<br>
						<input type="submit" value="Submit new sensor" disabled>
						<br>
						END;
					}
				?>
			</form>

		<br><br>

		<a href = "main.php">Main page</a>
	</body>
</html>