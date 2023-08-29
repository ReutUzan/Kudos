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

if (isset($_GET['edit'])) {
    $query = "SELECT MAX(id) AS max_id FROM tbl_208_vol";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    $nextId = $row['max_id'] + 1;
    $name = $_GET['name'];
	$age = $_GET['age'];
	$city = $_GET['city'];
	$phone = $_GET['phone'];
    $about = $_GET['about'];

    $row2 = mysqli_fetch_assoc($result1);
    $user = $row2["user_type"];
    $userid = $row2["id"];

    if($user == "usr"){
        $status= "waiting";
        $insertVolQuery = "INSERT INTO tbl_208_vol_users (id_user, id_vol, statusr) VALUES ('$userid', '$nextId', '$status')";
        mysqli_query($connection, $insertVolQuery);
        $approve ="0";
        $statusVol = "Waiting";
    }else{
        $approve ="1";
        $statusVol = "Offline";
    }

    $insertQuery = "INSERT INTO tbl_208_vol (id, name , age, city, phone, about,approve,statusVol) VALUES ('$nextId', '$name', '$age', '$city', '$phone', '$about', '$approve',  '$statusVol')";
    mysqli_query($connection, $insertQuery);
    
    if($user == "admin"){
        header('Location: index.php?id='.$_SESSION['user_id']);    
        exit();
    }else {
        header('Location: statusPage.php?id='.$_SESSION['user_id']);    
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Kudos - Create Volunteer</title>

        <script src="script/scriptvol.js"></script>
        <link rel="stylesheet" href="style/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;1,800&display=swap" rel="stylesheet">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    </head>
    <body id="craetevol">
        <aside>
            <?php
                $row1 = mysqli_fetch_assoc($result1);
                if($row1["user_type"] == "admin"){
                    echo  '<a href="dashboard.php"></a>';
                }else{
                    echo '<a href="#"></a>';
                }
            ?>
            <ul>
                <?php
                    if($row1["user_type"] == "admin"){
                        echo '<li><a class="bi bi-house-door-fill" href="dashboard.php"><span>&nbsp;&nbsp;Dashboard</span></a></li>';
                        echo '<li><a class="bi bi-grid-fill" href="inquiries.php"><span>&nbsp;&nbsp;Inquiries</span></a></li>';
                        echo '<li><a class="bi bi-people-fill" href="index.php"><span>&nbsp;&nbsp;Volunteers</span></a></li>';
                        echo '<li><a class="bi bi-calendar-event-fill"></a></li>';
                    }else {
                        echo '<li><a class="bi bi-pencil-square" href="#"><span>&nbsp;&nbsp;Request</span></a></li>';
                    }
                ?>
            </ul>
            <?php
                if($row1["user_type"] == "admin"){
                    echo    '<section><h1><b>Today`s Events</b></h1>';
                    echo    '<h3>10:00 - 13:30</h3><div><div></div>';
                    echo    '<h2>Fund Raising</h2></div></section>';
                }
            ?>
        </aside>
        <section id="wrapper">
            <header>
                <section>
                    <div>
                    <?php
                            if($row1["user_type"] == "admin"){
                                echo  '<a href="dashboard.php"></a>';
                                echo '<h1><b>Create Volunteer</b></h1>';
                            }else{
                                echo '<a href="#"></a>';
                            }
                        ?>
                    </div> 
                        <?php
                            $img = $row1["img_url"];
                            if(!$img) $img = "img/default.svg";
                            echo '<a href="profile.php">';
                            echo '<img src="'.$img.'"></a>';
                        ?> 
                </section>
            </header>
            <main id="formContainer">
                <form id="myform" action="createVol.php">
                    <?php
                        echo '<input type="hidden" name="id" value="' . $row1["id"] . '">';
                        if($row1["user_type"] == "admin"){
                            echo '<h1><b>Add a new Volunteer:</b></h1>';
                        }
                        else{
                            echo    '<section><h1>Hello and welcome!</h1>';
                            echo    '<p>We are excited to have you as a potential volunteer.<br>
                                    Our volunteer registration form is a simple and quick way to join our volunteer program.
                                    Please provide your basic personal details, availability, skills, interests, and any prior volunteering experience.
                                    We value your dedication and look forward to having you as part of our team, making a positive impact in our community.<br> 
                                    <b>Thank you </b>for your willingness to contribute!</p></section>';
                        }
                    ?>     
                    <div class="row">
                        <div class="col">
                            <label>Full Name:<input type="text" name="name" value="" pattern="^(\w\w+)\s(\w+)$" class="form-control"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Age:<input type="number" name="age" min="16" value="" class="form-control"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>City:<input type="text" name="city" value="" class="form-control"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Phone:<input type="tel" name="phone" value="" pattern="[0-9]{9,10}" title="only numbers, between 9-10 characters" class="form-control"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>About:<textarea name="about" rows="3" cols="29" class="form-control"></textarea></label><br>
                        </div>
                    </div>
                    <br>
                    <label><input type="submit" value="Submit" name="edit" class="btn btn-info" onclick="return submitForm('Are you sure you want to insert?')"></label>
                </form>
            </main>
        </section>
    </body>
</html>
<?php
    mysqli_close($connection);
?>