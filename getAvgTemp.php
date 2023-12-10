<?php 

    require_once "connection.php";

    $conn = mysqli_connect($host, $user, $password, $dbName);
    $sql = "SELECT
    ROUND(AVG(`temperature`), 2) AS avg_temperature,
    ROUND(AVG(`humidity`), 2) AS avg_humidity
    FROM (SELECT
            `temperature`,
            `humidity`,
            ROW_NUMBER() OVER (ORDER BY `date` DESC) AS row_num
            FROM measurementstoday) AS subquery
    WHERE subquery.row_num <= 3";

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo $row['avg_temperature'];
        mysqli_close($conn);
    }

?>