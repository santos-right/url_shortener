<!-- let's redirect user to their original link using shorten link -->
<?php
    include "php/config.php";
    $new_url = "";
    if(isset($_GET)){
        foreach($_GET as $key=>$val){
            $u = mysqli_real_escape_string($conn, $key);
            $new_url = str_replace('/', '', $u); //removing/ sign from url
        }

        // getting the full url of that short url which we are getting from url
        $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");
        if(mysqli_num_rows($sql) > 0){
            $count_query = mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '{$new_url}'");
            if(mysqli_num_rows($sql) > 0){
                // let's redirect user
                $full_url = mysqli_fetch_assoc($sql);
                header("Location:".$full_url['full_url']);
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>URL Shortener in php | Santos-Right</title>
</head>
<body>
    <div class="wrapper">
    <h1 class="typing"></h1>
        <form action="#">
            <input type="text" name="full-url" placeholder="Enter or paste a long url" required>
            <i class="fas fa-link url-link"></i>
            <button>Shorten</button>
        </form>
        <?PHP
        $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
        if(mysqli_num_rows($sql2) > 0){
            ?>
                <div class="count">
                    <?php
                        $sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM url");
                        $res = mysqli_fetch_assoc($sql3);

                        $sql4 = mysqli_query($conn, "SELECT clicks FROM url");
                        $total = 0;
                        while($c = mysqli_fetch_assoc($sql4)){
                            $total = $c['clicks'] + $total;
                        }
                    ?>
                    <span>Total Links: <span> <?php echo end($res); ?> </span> & Total Clicks: <span> <?php echo $total; ?> </span> </span>
                    <a href="php/delete.php?delete=all">Clear All</a>
                </div>

                <div class="url-area">
                    <div class="title">
                        <li>Shorten URL</li>
                        <li>Original URL</li>
                        <li>Clicks</li>
                        <li>Action</li>
                    </div>
                    <?php
                        while($row = mysqli_fetch_assoc($sql2)){
                    ?>
                    <div class="data">
                        <li>
                            <a href="http://<?php echo $domain.$row['shorten_url']?>" target="_blank">
                                <?php
                                    if($domain.strlen($row['shorten_url']) > 50){
                                        echo $domain.substr($row['shorten_url'], 0, 50). '....';
                                    }else{
                                        echo $domain.$row['shorten_url'];
                                    }
                                ?> 
                            </a> 
                        </li>
                        <li> 
                            <?php
                                if(strlen($row['full_url']) > 65){
                                    echo substr($row['full_url'], 0, 65). '....';
                                }else{
                                    echo $row['full_url'];
                                }
                            ?>  
                        </li>
                        <li> <?php echo $row['clicks'] ?> </li>
                        <li> <a href="php/delete.php?id=<?php echo $row['shorten_url'] ?>">Delete</a> </li>
                    </div>
                <?php
            }
            
        }
        ?>
        </div>
    </div>

    <div class="blur-effect"></div>

    <div class="popup-box">
        <div class="info-box">Your short link is ready. You can also edit your short link now but can't edit once you save it</div>
        <form action="#">
            <label>Edit your shorten url</label>
            <input type="text" spellcheck="false" value="">
            <i class="fas fa-copy url-copy"></i>
            <button>Save</button>
            <button id="close">Close</button>
        </form>
    </div>


    <script src="js/typed.js"></script>
    <script src="js/main.js"></script>


</body>
</html>