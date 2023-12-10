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
		<link rel="stylesheet" href = "styleMain.css" type = "text/css"/>

	</head>
	<body>
		
		<header id = "mainHeader">
				<h1>S. S. T. W. B. I.</h1>
				<h2>
					<?php 
						echo "Welcome ".$_SESSION['login'].", today is ";
						date_default_timezone_set('Europe/Warsaw');
						echo date('F j, Y');
						echo "</h2>";
						$connection = new mysqli($host, $user, $password, $dbName);
				
							if ($connection->connect_error) {
								die("Error: " . $connection->connect_error);
							}

							$sql = "SELECT
							ROUND(AVG(`temperature`), 2) AS avg_temperature,
							ROUND(AVG(`humidity`), 2) AS avg_humidity
							FROM
							(
								SELECT
									`temperature`,
									`humidity`,
									ROW_NUMBER() OVER (ORDER BY `date` DESC) AS row_num
								FROM
									measurementstoday
							) AS subquery
							WHERE
							subquery.row_num <= 3";

							echo "<h2>";
							$result = $connection->query($sql);
							echo " \n Average temperature: ".$result->fetch_assoc()['avg_temperature']."°C";
							echo ", average humidity: --";
							$connection->close();
					?>
				</h2>
		</header>
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

			<section id = "filterTheMeasurements"> 
					<h2>Filter the measurements</h2>
					<form  action = "filterMeasurements.php" method = "post">
						<label for = "parameter">Filter parameters</label>
						<select name = "parameter">
							<option>Date ASC</option>
							<option>Date DESC</option>
							<option>Max values</option>
							<option>Min values</option>
							<option>Sensor name</option>
						</select><br><br>
						<label for = "datePicker">Date</label>
						<input type ="date" name = "datePicker" value = <?php echo date('Y-m-d') ?>><br><br>
						<label for = "sensor">Sensor name</label>
						<input type ="text" name = "sensor" placeholder = "Sensor"><br><br>
						<label for = "clusterNumber">Cluster number</label>
						<input type = "number" name="clusterNumber" min="0" max="100" placeholder="1" required><br><br>
						<label for = "limit">Records numer (max 500)</label>
						<input type = "number" name="limit" min="1" max="500" placeholder="10" required><br><br>
						<input type ="submit" value = "Filter">
					</form>
				</section>

				<section id = "recentTempArticle"> 
					<table border="1">
						<tr>
							<th>ID</th>
							<th>Temperature</th>
							<th>Date</th>
							<th>Sensor name</th>
							<th>Cluster</th>
						</tr>

						<?php
							$connection = new mysqli($host, $user, $password, $dbName);
				
							if ($connection->connect_error) {
								die("Error: " . $connection->connect_error);
							}
						
							if(isset($_SESSION['filterValues1'])) {
								$sql = $_SESSION['filterValues1'];
							} else {
								$sql = "SELECT id, temperature, date, sensorName, cluster FROM measurementstoday WHERE cluster = 2 ORDER BY date DESC LIMIT 50";
							}
							
							$result = $connection->query($sql);
				
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>";
									echo "<td>" . $row["id"] . "</td>";
									echo "<td>" . $row["temperature"] . "</td>";
									echo "<td>" . $row["date"] . "</td>";
									echo "<td>" . $row["sensorName"] . "</td>";
									echo "<td>" . $row["cluster"] . "</td>";
									echo "</tr>";
								}
							} else {
								echo "No data to display";
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
							<th>Cluster</th>
						</tr>
						<?php
							$connection = new mysqli($host, $user, $password, $dbName);

							if ($connection->connect_error) {
								die("Error: " . $connection->connect_error);
							}

							if(isset($_SESSION['filterValues2'])) {
								$sql = $_SESSION['filterValues2'];
							} else {
								$sql = "SELECT id, humidity, date, sensorName, cluster FROM measurementstoday WHERE cluster = 2 ORDER BY date DESC LIMIT 50";
							}

							$result = $connection->query($sql);

							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>";
									echo "<td>" . $row["id"] . "</td>";
									echo "<td>" . $row["humidity"] . "</td>";
									echo "<td>" . $row["date"] . "</td>";
									echo "<td>" . $row["sensorName"] . "</td>";
									echo "<td>" . $row["cluster"] . "</td>";
									echo "</tr>";
								}
							} else {
								echo "No data to display";
							}

							unset($_SESSION['filterValues2']);

							$connection->close();
						?>
    				</table>
				</section>


			</article>
			
		</main>
		
		<footer id = "mainFooter">Author: Tymon Jastrzębski 259526</footer>
	</body>
</html>