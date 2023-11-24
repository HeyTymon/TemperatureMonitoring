<?php 
	session_start(); 
	if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	

	require_once "connection.php";
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
							<label for = "clusterTemp">Enter cluster number:</label>
							<input type = "number"  name = "clusterTemp" min="1" max="100" placeholder = "1" required>
							<br>
							<input type = "submit" value = "Submit target temperature">
					
						<?php 

							if(isset($_SESSION['tempUpToDate'])) echo $_SESSION['tempUpToDate'];
							unset($_SESSION['tempUpToDate']);

						?>
						</form><br>
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

									$sensorMessages = [
										'isCreatedSensor' => 'New sensor was added',
										'dataTakenSensor' => 'Name or IP already taken',
										'isDataNotCorrectSensor' => 'Incorrect input data! Try again',
									];
									
									foreach ($sensorMessages as $key => $message) {
										if (isset($_SESSION[$key])) {
											echo $message;
											unset($_SESSION[$key]);
										}
									}

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

									if(isset($_SESSION['newUserSession'])){
										echo  $_SESSION['newUserSession'];
										unset($_SESSION['newUserSession']);
									}

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
										<input type="submit" value="Delete user">
										<br>
									END;

									if(isset($_SESSION['deleteUserSession'])){
										echo  $_SESSION['deleteUserSession'];
										unset($_SESSION['deleteUserSession']);
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
										<input type="submit" value="Delete user" disabled>
										<br>
									END;
								}
							?>
						</form>
				</section>	

				<section id="changeUser">
					<h2>Change user settings</h2>
					<form action="changeUser.php" method="post">

						<?php
						if ($_SESSION['isAdmin']) {
							echo <<<END
								<label for="selectUser">User name:</label>
								<input type="text" name="selectUser" placeholder="User" required>
								<br>
								<label for="changeUserName">New name:</label>
								<input type="text" name="changeUserName" placeholder="User">
								<br>
								<label for="changeUserPassword">New password:</label>
								<input type="password" name="changeUserPassword" placeholder="Password">
								<br>
								<label for="changeCluster">Change cluster:</label>
								<input type="number" name="changeCluster" min="-1" max="100" placeholder="1">
								<br>
								<label for="changePermission">Change permission:</label>
								<input type="number" name="changePermission" min="0" max="1" placeholder="0">
								<br>
								<label for="adminPassword">Admins password:</label>
								<input type="password" name="adminPassword" placeholder="Password" required>
								<br>
								<input type="submit" value="Submit Changes">
								<br>
							END;

							if(isset($_SESSION['changeUserSession'])){
								echo  $_SESSION['changeUserSession'];
								unset($_SESSION['changeUserSession']);
							}


						} else {
							echo <<<END
								<span color="red">You must be logged in as an admin to change user details!</span>
								<label for="selectUser">User name:</label>
								<input type="text" name="selectUser" placeholder="User" required disabled>
								<br>
								<label for="changeUserName">New name:</label>
								<input type="text" name="changeUserName" placeholder="User" disabled>
								<br>
								<label for="changeUserPassword">New password:</label>
								<input type="password" name="changeUserPassword" placeholder="Password" disabled>
								<br>
								<label for="changeCluster">Change cluster:</label>
								<input type="number" name="changeCluster" min="-1" max="100" placeholder="1" disabled>
								<br>
								<label for="adminPassword">Admins password:</label>
								<input type="password" name="adminPassword" placeholder="Password" disabled>
								<br>
								<label for="changePermission">Change permission:</label>
								<input type="number" name="changePermission" min="0" max="1" placeholder="0" disabled>
								<br>
								<input type="submit" value="Submit Changes">
								<br>
							END;
						}
						?>
					</form>
				</section>
			</article>

			<article id = "tablesArticle">
				<section id = "usersTabel">
					<?php
						if($_SESSION['isAdmin']) {
							echo <<<END
							<table border="1">
								<tr>
									<th>User</th>
									<th>Password</th>
									<th>Admin</th>
									<th>Cluster</th>
								</tr>
							END;
					
									$connection = new mysqli($host, $user, $password, $dbName);
					
									if ($connection->connect_error) {
										die("Error: " . $connection->connect_error);
									}
								
									$sqlQuery = "SELECT * FROM `users`"; 
									
									$result = $connection->query($sqlQuery);
						
									if ($result->num_rows > 0) {
										while ($row = $result->fetch_assoc()) {
											echo "<tr>";
											echo "<td>" . $row["login"] . "</td>";
											echo "<td>" . $row["password"] . "</td>";
											echo "<td>" . $row["isAdmin"] . "</td>";
											echo "<td>" . $row["clusters"] . "</td>";
											echo "</tr>";
										}
									} else {
										echo "No data to display";
									}
						
									$connection->close();
								
							echo "</table>";
						}
					?>
				</seciton>

				<section id = "sensorsTabel">
					<?php 
						if($_SESSION['isAdmin']) {
							echo <<<END
							<table border="1">
								<tr>
									<th>ID</th>
									<th>Sensor</th>
									<th>IP</th>
									<th>Cluster</th>
								</tr>
							END;
							
									$connection = new mysqli($host, $user, $password, $dbName);
						
									if ($connection->connect_error) {
										die("Error: " . $connection->connect_error);
									}
								
									$sqlQuery = "SELECT * FROM `sensors`"; 
									
									$result = $connection->query($sqlQuery);
						
									if ($result->num_rows > 0) {
										while ($row = $result->fetch_assoc()) {
											echo "<tr>";
											echo "<td>" . $row["id"] . "</td>";
											echo "<td>" . $row["name"] . "</td>";
											echo "<td>" . $row["ip"] . "</td>";
											echo "<td>" . $row["cluster"] . "</td>";
											echo "</tr>";
										}
									} else {
										echo "No data to display";
									}
						
									$connection->close();
								
							echo "</table>";
						}
					?>
				</seciton>
			</article>
		</main>

		<br><br>
		<a href="main.php" class="back-button">Main page</a>
	</body>
</html>