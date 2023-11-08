<?php

	session_start(); 
	if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	
	
	if (isset($_POST['temp'])) {
        $targetTemp = $_POST['temp'];

        $url = "http://172.16.1.139/send_text"; //wystawić httpclient na esp32
        $data = array('temp' => $temp);
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
            echo "Text sent to ESP32: " . $temp;
        } else {
            echo "Error sending text to ESP32";
        }
    } else {
        echo "Text not provided";
    }

	echo '<a href = "main.php"> Main page </ar>';
?>