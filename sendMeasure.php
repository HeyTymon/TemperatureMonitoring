<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "sstwbi";

    $conn = mysqli_connect($hostname, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        echo "Connected successfully<br>";

        if (isset($_POST["temperature"]) && isset($_POST["humidity"]) && isset($_POST["sensorName"])) {
            $t = $_POST["temperature"];
            $h = $_POST["humidity"];
            $s = $_POST["sensorName"];

            $sql = "INSERT INTO `measurementstoday`(`temperature`, `humidity`, `sensorName`) VALUES (" . $t . "," . $h . ",'" . $s . "')";

            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully<br>";
            } else {
                echo "Error: " . $sql . " " . mysqli_error($conn);
            }
        } else {
            echo "<br>No data";
        }

        mysqli_close($conn);
    }
?>