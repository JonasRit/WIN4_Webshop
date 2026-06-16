<?php
session_start();
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    if(isset($_POST["produkt_id"])) {
        $_SESSION["warenkorb"][] = $_POST["produkt_id"];
    }
    header("Location: ../index.php");
    exit();
} else {
    header("Location: ./loginGUI.php");
    exit();
}
?>