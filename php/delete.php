<?php
    include "config.php";
    if(isset($_GET['id'])){
        $dlt_id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = mysqli_query($conn, "DELETE FROM url WHERE shorten_url = '{$dlt_id}'");
        if($sql){
            header("location: ../");
        }else{
            header("location: ../");
        }
    }elseif(isset($_GET['delete'])){
        $sql2 = mysqli_query($conn, "DELETE FROM url");
        if($sql2){
            header("location: ../");
        }else{
            header("location: ../");
        }
    }else{
        header("location: ../");
    }
?>