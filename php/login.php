<?php
    if (isset($_GET["username"])) {
	    $username = $_GET["username"];
    }
    if (isset($_GET["password"])) {
	    $password = $_GET["password"];
    }
    if($username == "admin" && $password == "admin"){
        session_start();
        $_SESSION["logged_in"] = true;
        header("location: ../index.php");
    } else {
        $logged_in = false;
        header("location: ../html/login.html");
    }
?>