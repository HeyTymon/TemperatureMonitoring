<?php 
	session_start(); 
	if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	

	require_once "connection.php";
	$connection = mysqli_connect($host, $user, $password, $dbName);

	$sqlQuery1 = "SELECT `id`, MAX(temperature) AS maxTemperature, CAST(`date` AS DATE) AS date, `sensorName` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE)";
	$sqlQuery2 = "SELECT `id`, MIN(temperature) AS minTemperature, CAST(`date` AS DATE) AS date, `sensorName` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE)";
	$sqlQuery3 = "SELECT `id`, ROUND(AVG(temperature),2) AS avgTemperature, CAST(`date` AS DATE) AS date, `sensorName` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE)";
	$sqlQuery4 = "SELECT `id`, ROUND(MAX(temperature) - MIN(temperature),2) AS amplitude, CAST(`date` AS DATE) AS date, `sensorName` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE)";
	$sqlQuery5 = "SELECT `id`, MAX(humidity) AS maxHumidity, CAST(`date` AS DATE) AS date, `sensorName` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE)";

	function echoTable($sqlQuery, $columnName, $connection) {

		if($connection->connect_errno != 0) {
			echo "Error: ".$connection->connect_errno;
		} else {
			if($result = $connection->query($sqlQuery)) {
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td>" . $row["id"] . "</td>";
						echo "<td>" . $row["$columnName"] . "</td>";
						echo "<td>" . $row["date"] . "</td>";
						echo "<td>" . $row["sensorName"] . "</td>";
						echo "</tr>";
							}
						} else {
							echo "No data";
						}
						} else {
							echo "Error SQL";
						}
					}
	}

?>	

<!DOCTYPE html>
<html>
	<head>
		<title>Other days stats</title>
	</head>
	<body>
		<label for = "maxTemp">Table 1. Max Temp</label>
		<table border="1" name = "maxTemp">

				<tr>
					<th>ID</th>
					<th>Temperature</th>
					<th>Date</th>
					<th>Sensor name</th>
				</tr>

				<?php
					echoTable($sqlQuery1,"maxTemperature",$connection);
				?>

		</table><br><br>

		<label for = "avgTemp">Table 2. Min Temp</label>
		<table border="1" name = "avgTemp">
				<tr>
					<th>ID</th>
					<th>Temperature</th>
					<th>Date</th>
					<th>Sensor name</th>
				</tr>

				<?php
					echoTable($sqlQuery2,"minTemperature",$connection);
				?>

		</table><br><br>

		<label for = "minTemp">Table 3. Avg Temp</label>
		<table border="1" name = "minTemp">
				<tr>
					<th>ID</th>
					<th>Temperature</th>
					<th>Date</th>
					<th>Sensor name</th>
				</tr>

				<?php
					echoTable($sqlQuery3,"avgTemperature",$connection);
				?>

		</table><br><br>

		<label for = "amplitudeTemp">Table 4. Amplitude Temp</label>
		<table border="1" name = "amplitudeTemp">
				<tr>
					<th>ID</th>
					<th>Temperature</th>
					<th>Date</th>
					<th>Sensor name</th>
				</tr>

				<?php
					echoTable($sqlQuery4,"amplitude",$connection);
				?>

		</table><br><br>

		<h1>... to be continued ...</h1>
		<a href = "main.php">Main page</a>

		<?php 
			$connection->close(); 
		?>
	</body>
</html>

