<?php
/**
 * Created by PhpStorm.
 * User: kmflipp
 * Date: 31.07.17
 * Time: 18:29
 */


if ( 0 < $_FILES['file']['error'] ) {
    echo 'Error: ' . $_FILES['file']['error'];
}else{
    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
    echo "ok";
}