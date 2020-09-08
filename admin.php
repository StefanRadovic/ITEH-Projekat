<?php
    session_start();
    if(!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
        header("Location: login.php");
    }
    include "db.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
        integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
        include "inc/nav-bar.php";
    ?>

    <div class="container">
        <div class="row cart-main">
        <h2 style="color: white;">Pending Orders</h2>
        <table class="table" id="pending">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Time</th>
                        <th>Adress</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <h2 style="color: white;">Completed Orders</h2>
            <table class="table" id="completed">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Time</th>
                        <th>Adress</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <?php
        include "inc/footer.php";
    ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
        integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous">
    </script>
    <script>
    function pending() {
        $.get("controller.php?action=returnPendingOrders", function(data) {
            let json_data = JSON.parse(data);
            $("#pending tbody").empty();
            $.each(json_data, function(key, value) {
                $("#pending tbody").append(`<tr><td>${value.username}</td><td>${value.time_ordered}</td><td>${value.user_address}</td><td><button class="btn btn-primary btn-success" type="button" onclick="acceptOrder(${value.id});">Accept</button></td></tr>`);
            });
        });
    }
    pending();
    function completed() {
        $.get("controller.php?action=returnCompletedOrders", function(data) {
            let json_data = JSON.parse(data);
            $("#completed tbody").empty();
            $.each(json_data, function(key, value) {
                $("#completed tbody").append(`<tr><td>${value.username}</td><td>${value.time_ordered}</td><td>${value.user_address}</td><td>Accepted</td></tr>`);
            });
        });
    }
    completed();
    function acceptOrder(id) {
        $.get("controller.php?action=changeOrderStatus&order_id="+id, function(data) {
            let json_data = JSON.parse(data);
            pending();
            completed();
        });
    }
    </script>
</body>

</html>