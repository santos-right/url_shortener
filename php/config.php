<?php

    $domain = "localhost/url_shortener/";

    $conn = mysqli_connect("localhost", "root", "santos", "urlshortener");
    if(!$conn){ //if database is  not connected
        echo "Database connection error" .mysqli_connect_error();
    }
?>