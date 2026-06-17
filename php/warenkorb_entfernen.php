<?php
    session_start();
    $warenkorb = $_SESSION["warenkorb"];

    foreach($warenkorb as $key => $value) {
        if($value == $_POST["produkt_id"]) {
            unset($_SESSION["warenkorb"][$key]);
            break;
        }
    }
    header("Location: ./warenkorbGUI.php");
    exit();
?>