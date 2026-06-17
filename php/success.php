<?php
    session_start();
    $warenkorb = $_SESSION["warenkorb"];
    $kunde_id = $_SESSION["kunde_id"];

    $mysqli = new mysqli("localhost", "root", "", "webshop");
    if ($mysqli->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
    }

    

//neuer Warenkorb einfügen um id zu bekommen
    $sql = "INSERT INTO warenkorb (kunde_id, datum) VALUES (?, NOW())";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $kunde_id);
    $stmt->execute();

    //Id herausfinden
    $warenkorb_id = $mysqli->insert_id;

    //Produkte in diesen Warenkorb

    if(isset($_SESSION["warenkorb"]) && !empty($_SESSION["warenkorb"])) {
        foreach($_SESSION["warenkorb"] as $produkt_id) {
                    $sql = "INSERT INTO warenkorb_produkt (warenkorb_id, produkt_id) VALUES (?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('ii', $warenkorb_id, $produkt_id);
            $stmt->execute();
        }
    } else {
        echo '<p>Dein Warenkorb ist leer.</p>';
    }

    unset($_SESSION["warenkorb"]);
    header("Location: ../index.php");
    exit();

?>