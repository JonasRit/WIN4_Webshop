<?php
    $mysqli = new mysqli("localhost", "root", "", "webshop");
    if ($mysqli->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
    }

    $username = $_POST["username"] ?? '';

    // Prüfen ob Username schon existiert
    $sql = "SELECT * FROM kunde WHERE benutzername = ?";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('s', $username);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows > 0) {
        echo "Username bereits vergeben";
        exit();
    }

    // Einfügen
    $sql = "INSERT INTO kunde (benutzername, passwort, vorname, name, anschrift, email) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('ssssss', $username, $_POST["password"], $_POST["vorname"], $_POST["nachname"], $_POST["anschrift"], $_POST["email"]);
    $statement->execute();

    header("Location: ./LoginGUI.php");
    exit();
?>