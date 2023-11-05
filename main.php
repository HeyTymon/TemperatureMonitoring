<?php 
	session_start(); 
	if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	
?>

<!DOCTYPE html>
<html lang = "pl">
	<head>
		<meta charset = "utf-8"/>
		<title>System monitorowania temperatury</title>
		<link rel="stylesheet" href = "style1.css" type = "text/css"/>
		
		<!-- Dołączyć html5shiv -->

	</head>
	<body>
		
		<header id = "mainHeader"><h2>System monitorowania i regulacji temperatury w budynku inteligentnym</h2><h3><?php echo "Witaj ".$_SESSION['login'] ?></header>
		<nav id = "menuNav">
			<ul>
				<li><a href="index.php">Strona główna</a></li>
				<li><a href="days.php">Pozostałe dni</a></li>
				<li><a href="control.php">Ustawienia</a></li>
				<li><a href="logout.php">Wyloguj</a></li>
			</ul>
		</nav>
		
		<main>
			<article id = "measuresArticle">
				<section id = "recentTempArticle"> 
					<table border="1">
						<tr>
							<th>ID</th>
							<th>Temperatura</th>
							<th>Data</th>
							<th>Nazwa czujnika</th>
						</tr>
						<?php
							$conn = new mysqli("localhost", "root", "", "bme280");
				
							if ($conn->connect_error) {
								die("Error: " . $conn->connect_error);
							}
				
							$sql = "SELECT id, temperature, time, sensor_name FROM measurements ORDER BY time DESC LIMIT 50";
				
							$result = $conn->query($sql);
				
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>";
									echo "<td>" . $row["id"] . "</td>";
									echo "<td>" . $row["temperature"] . "</td>";
									echo "<td>" . $row["time"] . "</td>";
									echo "<td>" . $row["sensor_name"] . "</td>";
									echo "</tr>";
								}
							} else {
								echo "Brak danych do wyświetlenia";
							}
				
							$conn->close();
						?>
					</table>
				</section>

				<section id = "recentHumidityArticle"> 
					<table border="1">
						<tr>
							<th>ID</th>
							<th>Wilgotność</th>
							<th>Data</th>
							<th>Nazwa czujnika</th>
						</tr>
						<?php
							$conn = new mysqli("localhost", "root", "", "bme280");

							if ($conn->connect_error) {
								die("Error: " . $conn->connect_error);
							}

							$sql = "SELECT id, humidity, time, sensor_name FROM measurements ORDER BY time DESC LIMIT 50";

							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>";
									echo "<td>" . $row["id"] . "</td>";
									echo "<td>" . $row["humidity"] . "</td>";
									echo "<td>" . $row["time"] . "</td>";
									echo "<td>" . $row["sensor_name"] . "</td>";
									echo "</tr>";
								}
							} else {
								echo "Brak danych do wyświetlenia";
							}

							$conn->close();
						?>
    				</table>
				</section>
				<section id = "recentPreasureArticle"> 
					recentPreasureArticle </br>
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
				</section>
			</article>
			
			<article id = "statsArticle">
				<?php
					$conn = new mysqli("localhost", "root", "", "bme280");

					if ($conn->connect_error) {
						die("Error: " . $conn->connect_error);
					}

					$sql = "SELECT AVG(temperature) AS avg_temp, MAX(temperature) AS max_temp, MIN(temperature) AS min_temp, ABS(AVG(temperature)) AS abs_temp FROM measurements";
					$result = $conn->query($sql);
					$row = $result->fetch_assoc();
					echo $row["avg_temp"] . " ----- " . $row["max_temp"] . " ----- " . $row["min_temp"] . " ----- " . $row["abs_temp"] . " ----- ";
				?>
			</article>
		</main>
		
		<footer id = "mainFooter">Autor: Tymon Jastrzębski 259526</footer>
	</body>
</html>