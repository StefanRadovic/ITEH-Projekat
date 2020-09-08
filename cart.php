<?php
    session_start();
    if(!isset($_SESSION['user_id'])) {
        header("Location: login.php");
    }
    include "db.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HatsShop</title>

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
            <button class="btn btn-primary" onclick="openModal();">Send order</button>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Unos adrese:</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="address">Unesite adresu:</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Address">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="sendOrder();">Send</button>
            </div>
            </div>
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
    function loadCart() {
        $.get("controller.php?action=returnProductFromCart", function(data) {
            let json_data = JSON.parse(data);
            if(json_data.status != 0){
                $("table tbody").empty();
                $.each(json_data, function(key, value) {
                    $("table tbody").append(`<tr><td>${value.product}</td><td>${value.price}</td><td>${value.quantity}</td><td>$${value.total}</td><td><button class="btn btn-primary btn-danger" type="button" onclick="deleteFromCart(${value.product_id});">Delete</button></td></tr>`);
                });
            } else {
                console.log(json_data.message);
                $(".table").hide();
                $(".cart-main").html(`<h1 style="color:white">${json_data.message}</h1>`);
            }
        });
    }
    loadCart();
    function openModal() {
        $(".modal").modal("show");
    }
    function sendOrder() {
        let address = $("#address").val();
        if(address == 0) {
            alert("Unesite adresu!");
        } else {
            let product = {address: address};
            let json_product = JSON.stringify(product);

            $.post( "controller.php?action=sendOrder", json_product, function( data ) {
                let rData = JSON.parse(data);
                console.log(rData.message);
                $(".modal").modal("hide");
                $("#address").val("");
                loadCart();
            });
        }
    }
    function deleteFromCart(id) {
        $.get("controller.php?action=deleteFromCart&product_id="+id, function(data) {
            let json_data = JSON.parse(data);
            console.log(json_data.message);
            loadCart();
        });
    }
    </script>
</body>

</html>