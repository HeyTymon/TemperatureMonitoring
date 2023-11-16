<?php

    require_once "connection.php";

    $connection = mysqli_connect($host, $user, $password, $dbName);

    function sendDataToESP($state) {
        $url = "http://" . $_POST['ip'] . "/sendState"; 

        //echo ($state) ? $url : "Error";

        //Check this 
        $data = array('state' => $state);
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result !== false) {
            echo "Text sent to ESP32: " . $text;
        } else {
            echo "Error sending text to ESP32";
        }
    }


    if($connection->connect_errno != 0) {
        echo "Error: ".$connection->connect_errno;
    } else {

        if(isset($_POST['name']) && isset($_POST['ip'])) {

            $sqlQuery = "SELECT * FROM `sensors` WHERE `name` = '" . $_POST['name'] . "' AND `ip` = '" . $_POST['ip'] . "';";

            if($result = $connection->query($sqlQuery)) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "Sensor " . $row['name'] . " was found!<br>";
                    $isSensor = true;
                } else {
                    echo "Sensor " . $_POST['name'] . " was not found!<br>";
                    $isSensor = false;
                }
            }

        } else {
            echo "<br> No data";
        }  
    }

    sendDataToESP($isSensor);

    mysqli_close($connection);
?>