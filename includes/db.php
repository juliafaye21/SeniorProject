<?php
//$con=mysqli_connect("localhost", "root", "J@F3g322","ecom");
$con = mysqli_init();
$con->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
$con->ssl_set("/var/lib/mysql/client-key.pem", "/var/lib/mysql/client-cert.pem", "/etc/ssl/certs/ca-bundle.crt", NULL, "ECDHE-RSA-AES256-SHA384");
$con->real_connect("localhost", "root", "Minnie4311g","ecom", 3306, NULL, MYSQLI_CLIENT_SSL);
$con->close();

?>
