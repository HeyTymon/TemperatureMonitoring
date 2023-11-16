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
		<title>System monitorowania temperatury</title>
		<link rel="stylesheet" href = "style1.css" type = "text/css"/>
		
		<!-- Dołączyć html5shiv -->

	</head>
	<body>
		
		<header id = "mainHeader"><h1>S. S. T. W. B. I.</h1><h2><?php echo "Welcome ".$_SESSION['login'] ?></h2></header>
		<nav id = "menuNav">
			<ul>
				<li><a href="index.php">Clear filters</a></li>
				<li><a href="days.php">Other days</a></li>
				<li><a href="settings.php">Settings</a></li>
				<li><a href="logout.php">Sign out</a></li>
			</ul>
		</nav>
		
		<main>
			<article id = "measuresArticle">
				<section id = "recentTempArticle"> 
					<table border="1">
						<tr>
							<th>ID</th>
							<th>Temperature</th>
							<th>Date</th>
							<th>Sensor name</th>
						</tr>

						<?php
							$connection = new mysqli($host, $user, $password, $dbName);
				
							if ($connection->connect_error) {
								die("Error: " . $connection->connect_error);
							}
						
							if(isset($_SESSION['filterValues1'])) {
								$sql = $_SESSION['filterValues1'];
							} else {
								$sql = "SELECT id, temperature, date, sensorName FROM measurementstoday ORDER BY date DESC LIMIT 50";
							}
							
							$result = $connection->query($sql);
				
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>";
									echo "<td>" . $row["id"] . "</td>";
									echo "<td>" . $row["temperature"] . "</td>";
									echo "<td>" . $row["date"] . "</td>";
									echo "<td>" . $row["sensorName"] . "</td>";
									echo "</tr>";
								}
							} else {
								echo "Brak danych do wyświetlenia";
							}

							unset($_SESSION['filterValues1']);
				
							$connection->close();
						?>
					</table>
				</section>

				<section id = "recentHumidityArticle"> 
					<table border="1">
						<tr>
							<th>ID</th>
							<th>Humidity</th>
							<th>Date</th>
							<th>Sensor name</th>
						</tr>
						<?php
							$connection = new mysqli($host, $user, $password, $dbName);

							if ($connection->connect_error) {
								die("Error: " . $connection->connect_error);
							}

							if(isset($_SESSION['filterValues2'])) {
								$sql = $_SESSION['filterValues2'];
							} else {
								$sql = "SELECT id, humidity, date, sensorName FROM measurementstoday ORDER BY date DESC LIMIT 50";
							}

							$result = $connection->query($sql);

							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>";
									echo "<td>" . $row["id"] . "</td>";
									echo "<td>" . $row["humidity"] . "</td>";
									echo "<td>" . $row["date"] . "</td>";
									echo "<td>" . $row["sensorName"] . "</td>";
									echo "</tr>";
								}
							} else {
								echo "Brak danych do wyświetlenia";
							}

							unset($_SESSION['filterValues2']);

							$connection->close();
						?>
    				</table>
				</section>

				<section id = "filterTheMeasurements"> 
					<h2>Filter the measurements</h2>
					<form  action = "filterMeasurements.php" method = "post">
						<label for = "parameter">Filtr parameter</label>
						<select name = "parameter">
							<option>Date ASC</option>
							<option>Date DESC</option>
							<option>Max values</option>
							<option>Min value</option>
							<option>Sensor name</option>
						</select><br><br>
						<label for = "sensor">Sensor name</label>
						<input type ="text" name = "sensor" value = "Sensor"><br><br>
						<label for = "limit">Records numer (max 500)</label>
						<input type = "number" name="limit" min="1" max="500" required><br><br>
						<input type ="submit" value = "Filter">
					</form>
				</section>
			</article>
			
			<article id = "statsArticle">
				
			</article>
		</main>
		
		<footer id = "mainFooter">Autor: Tymon Jastrzębski 259526</footer>
	</body>
</html>