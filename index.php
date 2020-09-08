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
        <div class="row">
            <div class="col-lg-12">
                <div class="jumbotron">
                    <div class="container">
                        <h1 style="text-align: center;">HATSHOPPING</h1>
                        <p style="text-align: center;">THE #1 SOURCE FOR HATS ONLINE</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h1 style="text-align: center; color: white">Top-sellers</h1>
                </div>
            </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <!-- Container for the image gallery -->
            <div class="container">

              <!-- Full-width images with number text -->
              <div class="mySlides">
                <div class="numbertext">1 / 6</div>
                <img src="img/slika1.jpg" style="width:100% height:100%" class="center">
            </div>

            <div class="mySlides">
                <div class="numbertext">2 / 6</div>
                <img src="img/slika2.jpg" style="width:100% height:50%" class="center">
            </div>

            <div class="mySlides">
                <div class="numbertext">3 / 6</div>
                <img src="img/slika3.jpg" style="width:100% height:50% " class="center">
            </div>

            <div class="mySlides">
                <div class="numbertext">4 / 6</div>
                <img src="img/slika4.jpg" style="width:100% height:50%" class="center">
            </div>

            <div class="mySlides">
                <div class="numbertext">5 / 6</div>
                <img src="img/slika5.jpg" style="width:100% height:50% " class="center">
            </div>

            <div class="mySlides">
                <div class="numbertext">6 / 6</div>
                <img src="img/slika6.jpg" style="width:100% height:50% " class="center">
            </div>

            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

            <!-- Image text -->
            <div class="caption-container">
                <h3 id="caption"></h3>
            </div>

            <!-- Thumbnail images -->
            <div class="row">
                <div class="column">
                  <img class="demo cursor" src="img/slika1.jpg" style="width:100% " onclick="currentSlide(1)" alt="Desert Sky Shantung Planter Hat">
              </div>
              <div class="column">
                  <img class="demo cursor" src="img/slika2.jpg" style="width:100%" onclick="currentSlide(2)" alt="Marco Palm Straw Fedora Hat">
              </div>
              <div class="column">
                  <img class="demo cursor" src="img/slika3.jpg" style="width:100%" onclick="currentSlide(3)" alt="Removable Face Shield Bucket Hat">
              </div>
              <div class="column">
                  <img class="demo cursor" src="img/slika4.jpg" style="width:100%" onclick="currentSlide(4)" alt="Killer Whale Mesh Trucker Snapback Baseball Cap">
              </div>
              <div class="column">
                  <img class="demo cursor" src="img/slika5.jpg" style="width:100%" onclick="currentSlide(5)" alt="Chagall Hemp Straw Fedora Hat">
              </div>
              <div class="column">
                  <img class="demo cursor" src="img/slika6.jpg" style="width:100%" onclick="currentSlide(6)" alt="Bondi Rush Straw Safari Fedora Hat">
              </div>
          </div>
      </div>
  </div>
</div>

<div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1 style="text-align: center; color: white;">All products</h1>
            </div>
        </div>
</div>

<div class="row">
  <div class="products">

  </div>
</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Quantity:</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" id="quantity" name="quantity" class="form-control" placeholder="Quantity">
                </div>
                <input type="text" id="product_id" name="product_id" class="form-control" style="display: none">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addToCart();">Add product</button>
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

<script type="text/javascript">
    var slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
      showSlides(slideIndex += n);
  }

    // Thumbnail image controls
    function currentSlide(n) {
      showSlides(slideIndex = n);
  }

  function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("demo");
      var captionText = document.getElementById("caption");
      if (n > slides.length) {slideIndex = 1}
          if (n < 1) {slideIndex = slides.length}
              for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
            captionText.innerHTML = dots[slideIndex-1].alt;
        }
    </script>

<script>
    function loadProducts() {
        $.get("controller.php?action=returnProduct", function(data) {
            let json_data = JSON.parse(data);
            $.get("https://api.exchangeratesapi.io/latest?base=USD", function(data2){


                $.each(json_data, function(key, value) {
                    let eur_value = Math.round(value.price * data2.rates.EUR, 2);
                    $(".products").append(`<div class='col-lg-3'><div class="productNode"><h3>${value.product_name}</h3><h4>Price: $${value.price}</h4><h4>EUR €${eur_value}</h4><button class="btn btn-primary add" type="button" onclick="openModal(${value.id});">Buy</button></div></div>`);
                });
            });

        });
    }
    loadProducts();
    function openModal(id) {
        $("#product_id").val(id);
        $(".modal").modal("show");
    }

    function Product(quantity, productId) {
        this.quantity = quantity;
        this.product_id = productId;
    }

    function addToCart() {
        let quantity = $("#quantity").val();
        let productId = $("#product_id").val();
        if(quantity == 0) {
            alert("Unesite kolicinu!");
        } else {
            let product = new Product(quantity , productId);
            let json_product = JSON.stringify(product);

            $.post( "controller.php?action=addToCart", json_product, function( data ) {
                let rData = JSON.parse(data);
                console.log(rData.message);
                $(".modal").modal("hide");
                $("#quantity").val("");
            });
        }
    }
</script>
</body>

</html>