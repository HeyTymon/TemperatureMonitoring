<?php

    require_once "connection.php";

    $connection = mysqli_connect($host, $user, $password, $dbName);


    if($connection->connect_errno != 0) {
        echo "Error: ".$connection->connect_errno;
    } else {

        if(isset($_POST['name']) && isset($_POST['ip'])) {

            $sqlQuery = "SELECT * FROM `sensors` WHERE `name` = '" . $_POST['name'] . "' AND `ip` = '" . $_POST['ip'] . "';";

            if($result = $connection->query($sqlQuery)) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "present";
                    $isSensor = true;
                } else {
                    echo "not present";
                    $isSensor = false;
                }
            }

        } else {
            echo "No data";
        }  
    }

    mysqli_close($connection);
?>