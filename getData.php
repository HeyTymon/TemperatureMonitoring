<?php

    require_once "connection.php";
    $conn = mysqli_connect($host, $user, $password, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `temperature`, `humidity`, `date` FROM measurementstoday";
    $result = $conn->query($sql);

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);

    $conn->close();


?>