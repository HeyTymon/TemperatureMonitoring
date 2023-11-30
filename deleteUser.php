<?php 
    session_start(); 
    if(!isset($_SESSION['isLogined'])) { 
        header('Location: index.php');
        exit();
    }   

    if($_POST['adminPassword'] !== $_SESSION['password']) {
        $_SESSION['deleteUserSession'] = "Wrong admin password!";
        header('Location: settings.php');
        exit();
    } 

    if($_POST['deleteUserName'] == "admin" || $_POST['deleteUserName'] == $_SESSION['login']) {
        $_SESSION['deleteUserSession'] = "You can not delete this user, because his account is logined or 'admin'";
        header('Location: settings.php');
        exit();
    }

    require_once "connection.php";

    $connection = new mysqli($host, $user, $password, $dbName);

    if ($connection->connect_error) {
        die("Error: " . $connection->connect_error);
    } else {
        
        $sqlQuerry1 = "SELECT * FROM `users` WHERE `login` = '" . $connection->real_escape_string($_POST['deleteUserName']) . "'";

        $result1 = $connection->query($sqlQuerry1);

        if($result1->num_rows == 0) {
            $_SESSION['deleteUserSession'] = "User does not exist";
            header('Location: settings.php');
        } else {

            $sqlQuery = "DELETE FROM `users` WHERE `login` = ?";
            $stmt = $connection->prepare($sqlQuery);
            $stmt->bind_param("s", $_POST['deleteUserName']); 
        
            $stmt->execute();

            $affectedRows = $stmt->affected_rows;
        
            $stmt->close();
        
            if ($affectedRows == 1) {
                $_SESSION['deleteUserSession'] = "User was deleted";
                header('Location: settings.php');
            } else {
                $_SESSION['deleteUserSession'] = "User was not deleted";
                header('Location: settings.php');
            }

        } 
    }

    $connection->close();
?>
