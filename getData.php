<?php

    require_once "connection.php";
    $conn = mysqli_connect($host, $user, $password, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT
    ROUND(AVG(`temperature`), 2) AS avg_temperature,
    ROUND(AVG(`humidity`), 2) AS avg_humidity,
    DATE_FORMAT(`date`, '%Y-%m-%d %H:00:00') AS hour, `sensorName`
    FROM measurementstoday
    ROUP BY hour, `sensorName`
    ORDER BY hour";
    $result = $conn->query($sql);

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);

    $conn->close();


?>