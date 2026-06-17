<?php
    define('PAYPAL_ID', 'schlager.seller@hs-offenburg.de');
    define('PAYPAL_SANDBOX', TRUE);
    define('PAYPAL_RETURN_URL', 'http://localhost/webshop/php/success.php');
    define('PAYPAL_CANCEL_URL', 'http://localhost/webshop/php/cancel.php');
    define('PAYPAL_CURRENCY', 'EUR');
    define('PAYPAL_URL', (PAYPAL_SANDBOX == true) ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr");
?>