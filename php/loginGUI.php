<?php
    session_start();
    if(isset($_SESSION["logged_in"])) {
        $logged_in = $_SESSION["logged_in"];
    }

?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <?php


        if(isset($logged_in) && $logged_in === true) {
            echo '<form action="./logout.php" method="get">
                    <button type="submit">Logout</button>
                </form>';
         }else {
            echo '<form action="./login.php" method="get">
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password">
                        <input type="submit" value="Anmelden">
                    </form>';
        }
    ?>

    
</body>
</html>