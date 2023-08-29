<?php 
include "db.php" ;
include "config.php" ;

session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

$query1 = "SELECT * FROM tbl_208_users WHERE id=". $_SESSION['user_id'];
$result1 = mysqli_query($connection, $query1);
if(!$result1) {
    die("DB query failed.");
}

$querycheck = "SELECT * FROM tbl_208_vol_users WHERE id_user =" .$_SESSION['user_id'];
$result2 = mysqli_query($connection, $querycheck);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Kudos - Status</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <link rel="stylesheet" href="style/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;1,800&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </head>
    <body id="statusPage">
        <aside>
            <a href="#"></a>
            <ul>
                <li><a class="bi bi-pencil-square" href="createVol.php"><span>&nbsp;&nbsp;Request</span></a></li>
            </ul>
        </aside>
        <section id="wrapper">
            <header>
                <section>
                    <a href="#"></a>
                    <h1><b>Volunteers</b></h1>
                    <?php
                            $row1 = mysqli_fetch_assoc($result1);
                            $img = $row1["img_url"];
                            if(!$img) $img = "img/default.svg";
                            echo '<a href="profile.php">';
                            echo '<img src="'.$img.'"></a>';
                        ?> 
                </section>
            </header>
            <main id="statusP">
                <?php 
                    $row2 = mysqli_fetch_assoc($result2);
                    if($row2["statusr"] == "approve"){
                        echo     '<section><div><b>Request Approved</b></div>';
                        echo     '<div>Your volunteer request has been approved. <br>Thank you for your interest and dedication!</div>';
                        echo     '<img src="img/approved.svg"><br>';
                        echo     '<section><h2 class="me-3">Download Kudos app:</h2>';
                        echo     '<article class="bi bi-google-play"></article>';
                        echo     '<article class="bi bi-apple"></article></section><br>';
                        echo     '<h2 class="me-3">Check your mailbox for further information.</h2></section>';
                    }   
                    else if($row2["statusr"] == "declined"){
                        echo '<section><div><b>Request Declined</b></div>';
                        echo   '<div>We regret to inform you that your volunteer request has been declined. Thank you for your interest!</div>';
                        echo    '<img src="img/declined.svg"></section>';
                    }else {
                        echo    '<section><div><b>Request Pending</b></div>';
                        echo    '<div>Your volunteer request is pending approval. <br>We will notify you once it`s approved!</div>';
                        echo    '<img src="img/waiting.svg"></section>';
                    }
                ?>
            </main>
        </section>
    </body>
</html>
<?php
    mysqli_close($connection);
?>