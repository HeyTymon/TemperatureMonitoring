<?php
	
	session_start();
	if (!isset($_POST['login']) || !isset($_POST['password'])) {
    header('Location: index.php');
    exit();
	}

    require_once "connection.php";

	$connection = @new mysqli($host, $user, $password, $dbName);

    $_SESSION['password'] = $_POST['password'];

    if($connection->connect_errno != 0){
		echo "Error: ".$connection->connect_errno;
	} else {

        $sqlQuery = "SELECT * FROM `users`";

        if($result = @$connection->query($sqlQuery)) {
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if($row['login'] == $_POST['login'] && $row['password'] == $_POST['password']) {
                        $_SESSION['login'] = $row['login'];
                        $_SESSION['password'] = $row['password'];
                        $_SESSION['isLogined'] = true;
                        $_SESSION['isAdmin'] = $row['isAdmin'];
                        $_SESSION['clusterInfo'] = $row['clusters'];
                        unset($_SESSION['loginError']);

                        $result->free();

                        header('Location: main.php');
                    } 
                }
            }
            $_SESSION['loginError'] = '<br> Wrong login or password! Try again';
            header('Location: index.php');
        }

    }


    $connection->close();
?>