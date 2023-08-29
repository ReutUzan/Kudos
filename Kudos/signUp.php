<?php
include 'db.php';
include "config.php";

if (isset($_POST['edit'])) {
    $name = $_POST['name'];
	$email = $_POST['loginMail'];
	$password = $_POST['loginPass'];

    $query = "SELECT MAX(id) AS max_id FROM tbl_208_users";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $nextId = $row['max_id'] + 1;

    $querycheck = "SELECT * FROM tbl_208_users WHERE email = '$email'";
    $result1 = mysqli_query($connection, $querycheck);

    if($result1->num_rows == 0){
        $insertQuery = "INSERT INTO tbl_208_users (id, name, email, password) VALUES ('$nextId', '$name', '$email', '$password')";
        mysqli_query($connection, $insertQuery);
        header('Location: login.php'); 
        exit();   
    }else{
        $message = "Your email exists in the system";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Kudos - Sign Up</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="style/style.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="script/scriptvol.js"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">        
    </head>
    <body id="login" class="opensans">
        <div>
            <section></section>
            <h2><b>Sign Up<b></h2>
            <form action="signUp.php" method="POST">
                <label>
                    <b>Full Name: </b><input type="text" name="name" value="" class="form-control">
                </label>
                <label>
                    <b>Email: </b>
                    <input type="email" required name="loginMail" value="" class="form-control">
                </label>
                <label>
                    <b>Password: </b>
                    <input type="password" required name="loginPass" id="loginPass" pattern="[0-9]+" title="Please enter only numbers" class="form-control">
                </label>   
                <label><input type="submit" value="Sign Up" name="edit" class="btn btn-info"></label>
                <article class="error-message">
                    <?php if(isset($message)) {echo $message;}?>
                </article>
            </form>
        </div> 
    </body>
</html>
<?php
    mysqli_close($connection);
?>