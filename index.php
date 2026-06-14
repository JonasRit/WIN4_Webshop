<?php
    session_start();
        if(isset($_SESSION["logged_in"])) {

        if($_SESSION["logged_in"] === true) {
            $logged_in = $_SESSION["logged_in"];
        } else {
            $logged_in = false;
        }
    }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="./css/myindex.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Startseite</title>
</head>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Sportgeschäft.de</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link active" href="#">Startseite</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Startseite</a>
        </li>
        
    </ul>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="./php/loginGUI.php">
                <?php 
                if(isset($logged_in) && $logged_in === true) {
                    echo "Logout";
                } else {
                    echo "Login";
                }
            ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Warenkorb</a>
        </li>
        <li class="nav-item">
            <span class="nav-link">Status: 
            <?php 
                if(isset($logged_in) && $logged_in === true) {
                    echo "Eingeloggt";
                } else {
                    echo "Nicht eingeloggt";
                }
            ?>
            </span>
            </span>
        </li>
    </ul>
</div>
  </div>
</nav>

<body>
    <h1>Hallo</h1>
    <div class="row row_category justify-content-start">
    <?php
		  	$mysqli = new mysqli("localhost", "root", "", "webshop");
            if ($mysqli->connect_errno) {
                die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
            }

            $id = isset($_GET["id"]) ? $_GET["id"] : NULL;

            if($id == NULL) {
                // Hauptkategorien
                $sql = "SELECT * FROM produktkategorie WHERE parent_id IS NULL";
                $statement = $mysqli->prepare($sql);
            } else {
                // Unterkategorien prüfen
                $sql = "SELECT * FROM produktkategorie WHERE parent_id = ?";
                $statement = $mysqli->prepare($sql);
                $statement->bind_param('i', $id);
            }

            $statement->execute();
            $result = $statement->get_result();

            if($result->num_rows > 0) {
                // Kategorien/Unterkategorien anzeigen
                while($row = $result->fetch_object()) {
                    echo '<div class="col-3">
                        <a href="./index.php?id=' . $row->id . '" style="text-decoration: none;">
                            <div class="card category text-bg-dark">
                                <img src="./img/schuhe.webp" class="card-img" alt="...">
                                <div class="card-img-overlay">
                                    <h5 class="card-title">' . $row->name . '</h5>
                                </div>
                            </div>
                        </a>
                    </div>';
                }
            } else {
                // Produkte anzeigen
                $sql = "SELECT p.* FROM produkt p, produkt_produktkategorie ppk WHERE p.id = ppk.produkt_id AND ppk.produktkategorie_id = ?";
                $statement = $mysqli->prepare($sql);
                $statement->bind_param('i', $id);
                $statement->execute();
                $result = $statement->get_result();

                while($row = $result->fetch_object()) {
                    echo '<div class="col-3">
                        <div class="card text-bg-dark">
                            <img src="./img/schuhe.webp" class="card-img" alt="...">
                            <div class="card-img-overlay">
                                <h5 class="card-title">' . $row->bezeichnung . '</h5>
                                <p>' . $row->preis . ' €</p>
                            </div>
                        </div>
                    </div>';
                }
            }
        ?>


        </div>

</body>
</html>