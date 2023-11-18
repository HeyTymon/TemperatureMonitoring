<?php
    require_once "connection.php";

    $conn = mysqli_connect($host, $user, $password, $dbName);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {

        if (isset($_POST["temperature"]) && isset($_POST["humidity"]) && isset($_POST["sensorName"]) && isset($_POST["cluster"])) {

            $sql = "INSERT INTO `measurementstoday`(`temperature`, `humidity`, `sensorName`, `cluster`) VALUES (" . $_POST["temperature"] . "," . $_POST["humidity"] . ",'" . $_POST["sensorName"] . "'," . $_POST["cluster"] . ")";

            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . " " . mysqli_error($conn);
            }
            
        } else {
            echo "No data";
        }

        mysqli_close($conn);
    }
?>