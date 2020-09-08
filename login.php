<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
include "db.php";
if(isset($_POST['submit'])) {
    if(empty($_POST['username']) || empty($_POST['password'])) {
        $msg = "Greska! Prazna polja!";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = $mysqli -> real_escape_string($username);
        $password = $mysqli -> real_escape_string($password);

        $password = md5($password);
        $sql = "SELECT * FROM users WHERE username ='$username' AND password = '$password'";

        if($q = $mysqli->query($sql)) {
            if(mysqli_num_rows($q) > 0) {
                    //login
                $red = $q -> fetch_object();
                $_SESSION['user_id'] = $red -> id;
                $_SESSION['user_name'] = $red -> username;
                $_SESSION['admin'] = $red -> admin;

                if($red->admin == 0) {
                    header("Location: index.php");
                } else {
                    header("Location: admin.php");
                }
            } else {
                $msg = "Pogresan username ili password";
            }
        }
        else $msg = "Greska sa bazom!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row">
           <div class="col-lg-12">
            <div class="jumbotron">
                <div class="container">
                    <h1 style="text-align: center;">HATSHOPPING</h1>
                    <p style="text-align: center;">THE #1 SOURCE FOR HATS ONLINE</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <div class="well">
                <h3 style="text-align: center;">Login</h3>
                <?php
                if(isset($msg)) {
                    echo $msg;
                }
                ?>
                <form action="" method="POST">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                    <input type="submit" name="submit" class="btn btn-block btn-primary" value="Login">
                    <br>
                </form>
            </div>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>
</html>