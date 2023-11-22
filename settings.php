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
		<link rel="stylesheet" href = "styleSettings.css" type = "text/css"/>
	</head>
	<body>
		<main>
			<article id = "settingsArticle">
				<section id = "targetTempSection">
					<h2>Target temperature</h2>
						<form action = "targetTemp.php" method = "post">
							<label for = "temp">Enter the target temperature (to two decimal places):</label>
							<input type = "number" step = "0.01" name = "temp" placeholder = "20.00" required>
							<br> 
							<label for = "clusterTemp">Enter the target temperature (to two decimal places):</label>
							<input type = "number"  name = "clusterTemp" min="1" max="100" placeholder = "1" required>
							<br>
							<input type = "submit" value = "Submit target temperature">
						</form><br>

						<?php 

							if(isset($_SESSION['tempUpToDate'])) {
								echo $_SESSION['tempUpToDate'];
							}
							unset($_SESSION['tempUpToDate']);

						?>
				</section>

				<section id = "newSensorSection">

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
									<label for="clusterSensor">Cluster:</label>
									<input type="number" name="clusterSensor" min="1" max="100" placeholder="1" required>
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
									<span color = "red">You must be loged in as an admin to add new sensors!</span>
									<br>
									<br>
									<label for="newSensorName">Sensor name:</label>
									<input type="text" name="newSensorName" placeholder="Sensor" disabled>
									<br>
									<label for="newSensorIP">Sensor IP:</label>
									<input type="text" name="newSensorIP" placeholder="10.0.0.1" disabled>
									<br>
									<label for="clusterSensor">Cluster:</label>
									<input type="number" name="clusterSensor" min="1" max="100" placeholder="1" required disabled>
									<br>
									<input type="submit" value="Submit new sensor" disabled>
									<br>
									END;
								}
							?>
						</form>
				</section>
				
				<section id = "newUserSection">
					<h2>New User</h2>
						<form action = "newUser.php" method = "post">
							
							<?php
								if ($_SESSION['isAdmin']) {
									echo <<<END
										<label for="newUserName">User name:</label>
										<input type="text" name="newUserName" placeholder="User" required>
										<br>
										<label for="newPassword">User password:</label>
										<input type="password" name="newPassword" placeholder="Password" required>
										<br>
										<label for="newPassword2">Eneter password again:</label>
										<input type="password" name="newPassword2" placeholder="Password" required>
										<br>
										<label for="isUserAdmin">Is user an admin:</label>
										<input type="number" name="isUserAdmin" min="0" max="1" placeholder="0" required>
										<br>
										<label for="clusters">Clusters access:</label>
										<input type="number" name="clusters" min="-1" max="100" placeholder="0" required>
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
										<br>
										<label for="newUserName">User name:</label>
										<input type="text" name="newUserName" placeholder="User" disabled>
										<br>
										<label for="newPassword">User password:</label>
										<input type="password" name="newPassword" placeholder="Password" disabled>
										<br>
										<label for="newPassword2">Eneter password again:</label>
										<input type="password" name="newPassword2" placeholder="Password" disabled>
										<br>
										<label for="isUserAdmin">Is user an admin:</label>
										<input type="number" name="isUserAdmin" min="0" max="1" placeholder="0" required disabled> 
										<br>
										<label for="clusters">Clusters access:</label>
										<input type="number" name="clusters" min="-1" max="100" placeholder="0" required disabled>
										<br>
										<input type="submit" value="Submit new user" disabled>
									END;
								}
							?>
						</form>
				</section>

				<section id = "deleteUserSection">
					<h2>Delete user</h2>
						<form action = "deleteUser.php" method = "post">
							
							<?php
								if ($_SESSION['isAdmin']) {
									echo <<<END
										<label for="deleteUserName">User name:</label>
										<input type="text" name="deleteUserName" placeholder="User" required>
										<br>
										<label for="adminPassword">Admins password:</label>
										<input type="password" name="adminPassword" placeholder="Password" required>
										<br>
										<input type="submit" value="Submit new user">
										<br>
									END;
									
									if(isset($_SESSION['deletionSuccessful'])) {
										echo "User was deleted";
									}
									unset($_SESSION['deletionSuccessful']);

									if(isset($_SESSION['deletionFailed'])) {
										echo "User was not deleted";
									}
									unset($_SESSION['deletionFailed']);

									if(isset($_SESSION['userNotExists'])) {
										echo "User does not exist";
									}
									unset($_SESSION['userNotExists']);

									if(isset($_SESSION['userIsAdmin'])) {
										echo "You can not delete admin";
									}
									
								} else {
									echo <<<END
										<span color = "red">You must be loged in as an admin to add new users!</span>
										<label for="deleteUserName">User name:</label>
										<input type="text" name="deleteUserName" placeholder="User" required disabled>
										<br>
										<label for="adminPassword">Admins password:</label>
										<input type="password" name="adminPassword" placeholder="Password" required disabled>
										<br>
										<input type="submit" value="Submit new user" disabled>
										<br>
									END;
								}
							?>
						</form>
				</section>	
				
			</article>
		</main>
		<a href="main.php" class="back-button">Main page</a>
	</body>
</html>