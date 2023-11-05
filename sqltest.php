<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Tabela z danymi SQL</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Temperatura</th>
            <th>Wilgotność</th>
            <th>Data</th>
            <th>Nazwa czujnika</th>
        </tr>
        <?php
            $conn = new mysqli("localhost", "root", "", "bme280");

            if ($conn->connect_error) {
                die("Error: " . $conn->connect_error);
            }

            $sql = "SELECT id, temperature, humidity, time, sensor_name FROM measurements";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["temperature"] . "</td>";
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
</body>
</html>
