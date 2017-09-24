<?php
if (!defined('IN_CFG')) {
    echo 'You should not be here. This attempt was logged!';
    die();
}

//database connection
$dbhost = "";
$dbuname = "root";
$dbpass = "PicioPacio2017";
$dbname = "wsp-api";


$reporting = "0";

$jwtKey = strtoupper(substr(md5('h44uuBjxED%:^D:wuK-'.md5(date('Ymd'))),0,20));

$smtp="email-smtp.eu-west-1.amazonaws.com";
$smtp_port="25";
$smtp_username="AKIAJDNR7HDBASIWINDA";
$smtp_password="Am1QagfJ7/72szHrIfIM3G8CxXUzUKvUCaF2jXI9QPNj";
$smtp_from="no-reply@wsp-security.com";