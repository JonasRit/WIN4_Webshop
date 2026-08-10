<?php
    session_start();

    $timeout = 10 *60;

    if (isset($_SESSION["letzte_aktivi"])) {
        if (time() - $_SESSION["letzte_aktivi"] > $timeout) {
            session_destroy();
            header("Location: ./php/loginGUI.php");
            exit();
        }
    }

    $_SESSION["letzte_aktivi"] = time();



    require_once 'config.php';
    if(isset($_SESSION["logged_in"])) {
    $logged_in = $_SESSION["logged_in"];
    } else {
        $logged_in = false;
    }

    if($logged_in !== true){
    header("Location: ./loginGUI.php");
    exit();
    }

    if(isset($_SESSION["warenkorb"])){
        $warenkorb = $_SESSION["warenkorb"];
    }else{
        $warenkorb = [];
    }
    

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="../css/myWarenkorbGUI.css" rel="stylesheet">
    <title>Warenkorb</title>
</head>
<body>


<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Sportgeschäft.de</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link active" href="../index.php">Startseite</a>
            </li>
            
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./loginGUI.php">
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
                <a class="nav-link active" href="./warenkorbGUI.php">Warenkorb</a>
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

<?php

    $mysqli = new mysqli("localhost", "root", "", "webshop");
    if ($mysqli->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
    }

    

    $gesamtpreis = 0;
    foreach($warenkorb as $produkt_id) {
    
        $sql = "SELECT * FROM produkt p WHERE p.id = ?";
        $statement = $mysqli->prepare($sql);
        $statement->bind_param('i', $produkt_id);
        $statement->execute();
        $result = $statement->get_result();
    $row = $result->fetch_object();
    $gesamtpreis += $row->preis;
    
    echo '
    <div class="col-3">
        <div class="card produkt text-bg-dark">
            <img src="../img/' . $row->bild . '" class="card-img" alt="...">
            <div class="card-img-overlay">
                <h5 class="card-title">' . $row->bezeichnung . '</h5>
                <p>' . $row->beschreibung . '</p>
                <p>' . $row->preis . ' €</p>
            </div>
            <form action="./warenkorb_entfernen.php" method="POST">
                <input type="hidden" name="produkt_id" value="' . $produkt_id . '">
                <button type="submit" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">X</button>
            </form>
        </div>
    </div>';
}
?>

<form action="<?php echo PAYPAL_URL; ?>" method="post">
    <input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="item_name" value="Warenkorb">
    <input type="hidden" name="item_number" value="<?php echo session_id(); ?>">
    <input type="hidden" name="amount" value="<?php echo $gesamtpreis; ?>">
    <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">
    <input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
    <input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">
    <button type="submit" class="btn btn-success">Mit PayPal bezahlen</button>
</form>



    
</body>
</html>