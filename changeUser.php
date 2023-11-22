<?php

	session_start(); 
	if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	
	

    require_once "connection.php";

    $connection = new mysqli($host, $user, $password, $dbName);

    if ($connection->connect_error) {
        die("Error: " . $connection->connect_error);
    }

    if($_POST['changeUserName'] == NULL && $_POST['changeUserPassword'] == NULL && $_POST['changeCluster'] == NULL && $_POST['changePermission'] == NULL) {
        $_SESSION['zeroChanges'] = 1;
        header('Location: settings.php');
        $connection->close();
        exit();
    }

    $sqlQuery = "SELECT * FROM `users` WHERE `login` = '" . $connection->real_escape_string($_POST['selectUser']) . "'";

    $result1 = $connection->query($sqlQuery);
    if($result1->num_rows == 1) { 
        $row = $result1->fetch_assoc();

        if($row['isAdmin'] == 1) {
            $_SESSION['userIsAdminChanges'] = 1;
            header('Location: settings.php');
            $connection->close();
            exit();
        }

        $changeUserNameX = ($_POST['changeUserName'] == NULL) ? $row['login'] : $_POST['changeUserName'];
        $changeUserPasswordX = ($_POST['changeUserPassword'] == NULL) ? $row['password'] : $_POST['changeUserPassword'];
        $changeClusterX = ($_POST['changeCluster'] == NULL) ? $row['clusters'] : $_POST['changeCluster'];
        $changePermissionX = ($_POST['changePermission'] == NULL) ? $row['isAdmin'] : $_POST['changePermission'];

        $sqlQuery = "UPDATE `users` SET `login`= ?, `password`= ?, `isAdmin`= ?, `clusters`= ? WHERE `login` = ?";

        $stmt = $connection->prepare($sqlQuery);
        $stmt->bind_param("sssis", $changeUserNameX, $changeUserPasswordX, $changePermissionX, $changeClusterX, $_POST['selectUser']);
        if($stmt->execute()) {
            $_SESSION['changesSuccessful'] = 1;
            header('Location: settings.php');
        } else {
            $_SESSION['changesFailed'] = 1;
            header('Location: settings.php');
        }
        $stmt->close();

    } else {
        $_SESSION['userNotExistsChanges'] = 1;
        header('Location: settings.php');
    }


    $connection->close();
?>