<?php
if (!defined('IN_CFG')) {
    echo 'You should not be here. This attempt was logged!';
    die();
}

session_start();
date_default_timezone_set('Europe/Zurich');
error_reporting(0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

require_once("config.php");
require_once("db.php");
require_once("class/PHPMailerAutoload.php");
require_once('class/jwt.php');


