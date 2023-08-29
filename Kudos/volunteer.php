<?php
include "db.php";
include "config.php";

session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['edit'])) {
    $editv = $_GET['edit'];

    if ($editv == "approve") {
        $query = "UPDATE tbl_208_vol SET approve = 1, statusVol ='Offline' WHERE id=" . $_GET["VolId"];
        mysqli_query($connection, $query);
        $statusr = "approve";
        $insertQuery = "UPDATE tbl_208_vol_users SET statusr='$statusr' WHERE id_vol=" . $_GET["VolId"];
        mysqli_query($connection, $insertQuery);
    } else if ($editv == "decline" || $editv == "delete") {
        $query = "DELETE FROM tbl_208_vol WHERE id=" . $_GET["VolId"];
        mysqli_query($connection, $query);
        if ($editv == "decline") {
            $insertQuery = "UPDATE tbl_208_vol_users SET statusr='decline' WHERE id_vol=" . $_GET["VolId"];
            mysqli_query($connection, $insertQuery);
        }
        header('Location: index.php?id=' . $_SESSION['user_id']);
        $message = "deleted";
        exit;
    }
}

$query = "SELECT * FROM tbl_208_vol WHERE id=" . $_GET["id"];
$result = mysqli_query($connection, $query);

$query1 = "SELECT * FROM tbl_208_users WHERE id=" . $_SESSION['user_id'];
$result1 = mysqli_query($connection, $query1);
if (!$result1) {
    die("DB query failed.");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Kudos - Volunteer</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <script src="script/scriptvol.js"></script>
        <link rel="stylesheet" href="style/style.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;1,800&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    </head>
    <body id="volunteer">
        <aside>
            <a href="dashboard.php"></a>
            <ul>
                <li><a class="bi bi-house-door-fill" href="dashboard.php"><span>&nbsp;&nbsp;Dashboard</span></a></li>
                <li><a class="bi bi-grid-fill" href="inquiries.php"><span>&nbsp;&nbsp;Inquiries</span></a></li>
                <li><a class="bi bi-people-fill" href="index.php"><span>&nbsp;&nbsp;Volunteers</span></a></li>
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
                        <h1><b>Volunteer Profile</b></h1>
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
                    <?php
                        $row = mysqli_fetch_assoc($result);
                        
                        $img = $row["img_url"];
                        if(!$img) $img = "img/default.svg";
                        echo '<img src="'.$img.'">';
                        echo '<div><h1><b>'.$row["name"].'</b></h1>';
                        echo '<p><b>Age :</b>'.$row["age"].'<br>';
                        echo '<b>City :</b>'.$row["city"].'<br>';
                        echo '<b>Phone Number :</b>'.$row["phone"].'</br>';
                        echo '<b>About: </b>'.$row["about"].'<br>';
                        echo '<b>Status: </b>'.$row["statusVol"].'</p></div>';
                        $aprv = $row["approve"];

                        echo '<form id = "myform" action="volunteer.php">';
                        echo '<input type="hidden" name="VolId" value="' . $row["id"] . '">';
                        echo '<input type="hidden" name="id" value="'. $row1["id"] .'">';
                        if ($aprv == 0) {
                            echo '<button type="submit" class="btn btn-info" name="edit" value="approve" onclick="return submitForm(\'Are you sure you want to approve?\')"><i class="bi bi-person-check-fill"></i>&nbsp;&nbsp;Approve Request</button>';
                            echo '<button type="submit" class="btn btn-outline-secondary" name="edit" value="decline" onclick="return submitForm(\'Are you sure you want to decline?\')"><i class="bi bi-person-dash-fill"></i>&nbsp;&nbsp;Decline Request</button>';
                        } else {
                            echo '<button type="submit" class="btn btn-outline-secondary" name="edit" value="delete" onclick="return submitForm(\'Are you sure you want to delete?\')"><i class="bi bi-person-x-fill"></i>&nbsp;&nbsp;Delete Request</button>';
                        }
                        echo '</form>'; 
                    ?>
                </section>
            </main>
        </section>
    </body>
</html>
<?php
    mysqli_close($connection);
?>