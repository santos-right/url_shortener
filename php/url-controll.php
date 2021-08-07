<?php
    include "config.php";
    // let's get the value which are sending from js ajax
    $full_url = mysqli_real_escape_string($conn, $_POST['full-url']);

    // if full url box is not empty and the user entered url is a valid url
    if(!empty($full_url) && filter_var($full_url, FILTER_VALIDATE_URL)){
        $ran_url = substr(md5(microtime()), rand(0, 26), 5); // generating random 5 character url
        // checking if that random generated url already exist in the database or not
        $sql = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");
        if(mysqli_num_rows($sql) > 0){
            echo "Something went wrong. Please regenerate url again";
        }else{
            // let's insert user typed url into the table with short url
            $sql2 = mysqli_query($conn, "INSERT INTO url (shorten_url, full_url, clicks)
                                        VALUES('{$ran_url}', '{$full_url}', '0')");
            if($sql2){ // if data inserted successfully
                // selecting recently inserted short link/url
                $sql3 = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");
                if(mysqli_num_rows($sql3) > 0){
                    $shorten_url = mysqli_fetch_assoc($sql3);
                    echo $shorten_url['shorten_url'];
                }
            }else{
                echo "Something went wrong. Please regenerate url again";
            }
        }
    }else{
        echo "$full_url - This is not a valid URL";
    }
?>