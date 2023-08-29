<?php
include 'db.php';
include "config.php";

session_start();
if (isset($_POST['edit'])) {
	$email = $_POST['loginMail'];
	$password = $_POST['loginPass'];

    $query 	= "SELECT * FROM tbl_208_users order by name";
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($result)) {
        if($row["email"] == $email && $row["password"] == $password){
            if (is_array($row)) {
                if ($row["user_type"] === "admin") {
                    $_SESSION['user_id'] = $row["id"];
                    header('Location: dashboard.php');    
                    exit();
                } else if ($row["user_type"] === "usr") {
                    $querycheck = "SELECT * FROM tbl_208_vol_users WHERE id_user =" .$row["id"];
                    $result1 = mysqli_query($connection, $querycheck);
                    if($result1->num_rows == 0){
                        $_SESSION['user_id'] = $row["id"];
                        header('Location: createVol.php');
                        exit();
                    }
                    else{
                        $_SESSION['user_id'] = $row["id"];
                        header('Location: statusPage.php');
                        exit();
                    }
                }
            }
        } else {
            $message = "Invalid Email or Password!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Kudos - Login</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="style/style.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="script/script.js"></script>


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    </head>
    <body id="login" class="opensans">
        <div>
            <section></section>
            <h1>Welcome Back!</h1>
            <form action="login.php" method="POST">
                <label>
                    <b>Email: </b>
                    <input type="email" required name="loginMail" value="" class="form-control">
                </label>
                <label>
                    <b>Password: </b>
                    <input type="password" required name="loginPass" id="loginPass" pattern="[0-9]+" title="Please enter only numbers" class="form-control">
                </label>
                <a href="#">Forgot Password?</a>
                <label><input type="submit" name="edit" value="Login" class="btn btn-info"></label>
                <a href="signUp.php">Don't have an account ?&nbsp<b>Sign Up</b></a>
                <h5>Or login with</h5>
                <article id="social">
                    <a href="#" id="facebook" class="bi bi-facebook"></a>
                    <a href="#" id="gmail" class="bi bi-envelope-fill"></a>
                </article>
                <article class="error-message">
                    <?php if(isset($message)) {echo $message;} ?> 
                </article>
            </form>
        </div> 
    </body>
</html>
<?php
    mysqli_close($connection);
?>