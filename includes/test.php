<?php
$con = mysqli_init();
$con->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, false);
$con->ssl_set("/var/lib/mysql/localhost.crt", "/var/lib/mysql/localhost.key", "/etc/ssl/certs/ca-bundle.crt", NULL, "ECDHE-RSA-AES256-SHA384");
$con->real_connect("127.0.0.1", "root", "J@F3g322","ecom");
$res = mysqli_query("SHOW STATUS LIKE 'ssl_cipher';",$com);
print_r(mysqli_fetch_row($res));
$con->close();
echo "Finished.";
?>