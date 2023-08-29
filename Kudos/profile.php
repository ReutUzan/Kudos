<?php
include "db.php";
include "config.php";

session_start();
if (isset($_POST['edit'])) {
    $id = $_SESSION['user_id'];
    $newEmail = $_POST["newemail"];
    $newName = $_POST["newname"];
    $newPassword = $_POST["newpass"];

    $query1 = "SELECT * FROM tbl_208_users WHERE id=" . $id;
    $result1 = mysqli_query($connection, $query1);
    $row = mysqli_fetch_assoc($result1);

    if (!empty($newEmail)) {
        $querycheck = "SELECT * FROM tbl_208_users WHERE email = '$newEmail'";
        $result1 = mysqli_query($connection, $querycheck);

        if($result1->num_rows == 0){
            $row['email'] = $newEmail; 
        }else{
            $message = "Your email exists in the system";
        }
    }
    if (!empty($newName)) {
        $row['name'] = $newName;
    }
    if (!empty($newPassword)) {
        $row['password'] = $newPassword;
    }

    $query = "UPDATE tbl_208_users SET email='" . $row['email'] . "', name='" . $row['name'] . "', password='" . $row['password'] . "' WHERE id=" . $id;
    mysqli_query($connection, $query);

    header('Location: profile.php');
    exit();
}
else {
    if(!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $query1 = "SELECT * FROM tbl_208_users WHERE id=". $_SESSION['user_id'];
    $result1 = mysqli_query($connection, $query1);
    if(!$result1) {
        die("DB query failed.");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Kudos - Volunteer Page</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        
        <link rel="stylesheet" href="style/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;1,800&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body id="profile">
    <aside>
            <?php
                $row = mysqli_fetch_assoc($result1);
                if($row["user_type"] == "admin"){
                    echo  '<a href="dashboard.php"></a>';
                }else{
                    echo '<a href="statusPage.php"></a>';
                }
            ?>
            <ul>
                <?php
                    if($row["user_type"] == "admin"){
                        echo '<li><a class="bi bi-house-door-fill" href="dashboard.php"><span>&nbsp;&nbsp;Dashboard</span></a></li>';
                        echo '<li><a class="bi bi-grid-fill" href="inquiries.php"><span>&nbsp;&nbsp;Inquiries</span></a></li>';
                        echo '<li><a class="bi bi-people-fill" href="index.php"><span>&nbsp;&nbsp;Volunteers</span></a></li>';
                        echo '<li><a class="bi bi-calendar-event-fill"></a></li>';
                    }else {
                        echo '<li><a class="bi bi-person-square" href="#"><span>&nbsp;&nbsp;Profile</span></a></li>';
                    }
                ?>
            </ul>
            <?php
                if($row["user_type"] == "admin"){
                echo    '<section><h1><b>Today`s Events</b></h1>';
                echo    '<h3>10:00 - 13:30</h3><div><div></div>';
                echo       '<h2>Fund Raising</h2></div></section>';
                }
            ?>
        </aside>
        <section id="wrapper">
            <header>
                <section>
                    <div>
                        <a href="dashboard.php"></a>
                        <h1><b>My Profile</b></h1>
                    </div>    
                    <?php
                        $img = $row["img_url"];
                        if(!$img) $img = "img/default.svg";
                        echo '<a href="profile.php">';
                        echo '<img src="'.$img.'"></a>';    
                    ?> 
                </section>
            </header>
            <main id="myProfile"> 
                <div class= "main-card">
                    <div class= "header-card">
                        <?php
                            echo '<img src="'.$row["img_url"].'">';
                        ?>
                        <?php
                            echo '<h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">' . $row["name"] . '</h4>';
                        ?>
                    </div>
                    <div class="borderdata">
                        <h2>My Data</h2>
                    </div>
                    <div><br>
                        <form class="myform" action="profile.php" method="POST">
                            <div class="row">
                                <div class="col">                                               
                                    <label>Full Name</label>
                                    <input class="form-control" type="text" name="newname" placeholder="<?php echo $row['name']; ?>" value="">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <label>Email</label>
                                    <input class="form-control" type="text" name="newemail" placeholder="<?php echo $row['email']; ?>">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <b>Change Password</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>New Password</label>
                                    <input class="form-control" type="password" name="newpass" placeholder="••••••">
                                </div>
                            </div><br>
                            <label><input type="submit" value="Save Changes" name="edit" class="btn btn-info"></label>
                            <article class="error-message">
                                <?php if(isset($message)) {echo $message;}?>
                            </article>
                        </form>
                    </div>
                </div>
                <button class="btn btn-danger">
                    <i class="fa fa-sign-out"></i>
                    <a href="login.php">&nbsp;&nbsp;Logout</a>
                </button>
            </main>
        </section>
    </body>
</html>
<?php
    mysqli_close($connection);
?>