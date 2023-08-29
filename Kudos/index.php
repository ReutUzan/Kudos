<?php 
include "db.php" ;
include "config.php" ;

session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$query 	= "SELECT * FROM tbl_208_vol order by name";
$result = mysqli_query($connection, $query);
if(!$result) {
    die("DB query failed.");
}

$query1 = "SELECT * FROM tbl_208_users WHERE id=". $_SESSION['user_id'] ;
$result1 = mysqli_query($connection, $query1);
if(!$result1) {
    die("DB query failed.");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Kudos - Volunteers List</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        
        <link rel="stylesheet" href="style/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;1,800&display=swap" rel="stylesheet">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    </head>
    <body id="volunteers">
        <aside>
            <a href="dashboard.php"></a>
            <ul>
                <li><a class="bi bi-house-door-fill" href="dashboard.php"><span>&nbsp;&nbsp;Dashboard</span></a></li>
                <li><a class="bi bi-grid-fill" href="inquiries.php"><span>&nbsp;&nbsp;Inquiries</span></a></li>
                <li><a class="bi bi-people-fill" href="#"><span>&nbsp;&nbsp;Volunteers</a></li>
                <li><a class="bi bi-calendar-event-fill"></a></li>
            </ul>
            <section>
                <h1><b>Today's Events</b></h1>
                <h3>10:00 - 13:30</h3>
                <div>
                    <div></div>
                    <h2>Fund Raising</h2>
                </div>
            </section>
        </aside>
        <section id="wrapper">
            <header>
                <section>
                    <div>
                        <a href="dashboard.php"></a>
                        <h1><b>Volunteers</b></h1>
                    </div>
                    <?php
                            $row1 = mysqli_fetch_assoc($result1);
                            $img = $row1["img_url"];
                            if(!$img) $img = "img/default.svg";
                            echo '<a href="profile.php">';
                            echo '<img src="'.$img.'"></a>';
                    ?> 
                </section>
            </header>
            <main>
                <section>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                    </div>
                    <div class="input-group">
                        <select id="cat" class="form-select" aria-label="Sort By"></select>
                    </section>
                    <ul>
                        <?php
                        if(isset($message)) {echo $message;};
                        while($row = mysqli_fetch_assoc($result)) {
                        $img = $row["img_url"];
                        if(!$img) $img = "img/default.svg";
                        echo        '<li>';
                        echo        '<a href="volunteer.php?id='.$row["id"].'">';
                        echo 		'<img src="'.$img.'">';
                        echo   		'<h1>'.$row["name"].'</h1>';
                        echo   		'<h2 id="status">'.$row["statusVol"].'</h2>';
                        echo        '</a></li>';
                    }
                    ?> 
                    <script src="script/script.js"></script>
                    <script>statusColor()</script>
                    </ul>
            </main>
            <?php
                echo '<a href="createVol.php" class="plus bi bi-plus-circle-fill"></a>';
                mysqli_free_result($result);
            ?>
        </section>
    </body>
</html>
<?php
    mysqli_close($connection);
?>