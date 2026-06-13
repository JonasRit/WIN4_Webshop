<?php

    $mysqli = new mysqli("localhost", "root", "", "webshop");
			if ($mysqli->connect_errno) {
				die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
			}
			$sql = "SELECT * FROM kunde;";
			$statement = $mysqli->prepare($sql);
			$statement->execute();
			$result = $statement->get_result();

			
			while($row = $result->fetch_object()) {
                

                if (isset($_POST["username"])) {
                    $username = $_POST["username"];
                }
                if($username == $row->benutzername) {
                    echo "Username bereits vergeben";
                    exit();
                } else {
                    $sql = "INSERT INTO kunde (benutzername, passwort, vorname, name, anschrift, email) 
                            VALUES (?, ?, ?, ?, ?, ?)";
                    $statement = $mysqli->prepare($sql);
                    $statement->bind_param('ssssss', $_POST["username"], $_POST["password"], $_POST["vorname"], $_POST["nachname"], $_POST["anschrift"], $_POST["email"]);
                    $statement->execute();
                    header("location: ./LoginGUI.php");
                }
						
			}
    
?>