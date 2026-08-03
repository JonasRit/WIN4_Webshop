<?php
    session_start();
    
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    $mysqli = new mysqli("localhost", "root", "", "webshop");
    if ($mysqli->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
    }

    $sql = "SELECT * FROM kunde WHERE benutzername = ? AND passwort = ?";
    $statement = $mysqli->prepare($sql);
    $statement->bind_param('ss', $username, $password);
    $statement->execute();
    $result = $statement->get_result();

    if($result->num_rows == 1) {
    $row = $result->fetch_object();
    $_SESSION["logged_in"] = true;
    $_SESSION["kunde_id"] = $row->id;
    header("location: ../index.php");
    exit();
} else {
    header("location: ./LoginGUI.php");
    exit();
}

?>