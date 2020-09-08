<?php 
    session_start();
    include "db.php";
    if(isset($_GET['action']) && $_GET['action']=="returnProduct") {
        $sql="SELECT * FROM products";
        if($q=$mysqli->query($sql)) {
            $niz = array();
            while($red = $q->fetch_object()) {
                $niz[] = $red;
            }
            echo json_encode($niz);
        } else {
            $answer['message'] = "Database error!";
            echo json_encode($answer);
        }
    }

    if(isset($_GET['action']) && $_GET['action']=="addToCart") {
        $data_json = file_get_contents("php://input");
        $data = json_decode($data_json);
        if($_SESSION['cart'][$data->product_id] = $data->quantity) {
            $answer['message'] = "Product added.";
            echo json_encode($answer);
        } else {
            $answer['message'] = "Erorr!";
            echo json_encode($answer);
        }
    }

    if(isset($_GET['action']) && $_GET['action']=="returnProductFromCart") {
        if(isset($_SESSION['cart'])) {
            $niz = array();


            $sql="SELECT * FROM products";
            if($q=$mysqli->query($sql)) {
                $products= array();
                while($red = $q->fetch_object()) {
                    $products[$red->id] = $red;
                }
                foreach($_SESSION['cart'] as $key => $value) {
                    $answer['product_id'] = $key;
                    $answer['product'] = $products[$key]->product_name;
                    $answer['quantity'] = $value;
                    $answer['price'] = $products[$key]->price;
                    $answer['total'] = floatval($products[$key]->price)*$value;
                    $niz[] = $answer;
                }
                if(empty($niz)) {
                    $answer['status'] = 0;
                    $answer['message'] = "Cart is empty.";
                    echo json_encode($answer);
                } else {
                    echo json_encode($niz);
                }

            } else {
                $answer['status'] = 0;
                $answer['message'] = "Database error!";
                echo json_encode($answer);
            }
            //echo json_encode($niz);
        } else {
            $answer['status'] = 0;
            $answer['message'] = "Cart is empty.";
            echo json_encode($answer);
        }
    }

    if(isset($_GET['action']) && $_GET['action']=="sendOrder") {
        $data_json = file_get_contents("php://input");
        $data = json_decode($data_json);
        $sql = "INSERT INTO orders (user_id, time_ordered, user_address) VALUES ('".$_SESSION['user_id']."', NOW(), '".$data->address."')";
        if($q = $mysqli->query($sql)) {
            $order_id = $mysqli->insert_id;

            foreach($_SESSION['cart'] as $key => $value) {
                $sql2 = "INSERT INTO orders_list (order_id, product_id, quantity) VALUES ('".$order_id."', '".$key."', '".$value."')";
                $q2 = $mysqli->query($sql2);
            }
            unset($_SESSION['cart']);
            $answer['status'] = 1;
            $answer['message'] = "Order sent";
            echo json_encode($answer);
        } else {
            $answer['status'] = 0;
            $answer['message'] = "Database Erorr";
            echo json_encode($answer);
        }
    }
    if(isset($_GET['action']) && $_GET['action']=="deleteFromCart") {
        $product_id = $_GET['product_id'];
        unset($_SESSION['cart'][$product_id]);
        $answer['message'] = "Product deleted";
        echo json_encode($answer);
    }
    if(isset($_GET['action']) && $_GET['action']=="returnPendingOrders") {
        $sql="SELECT o.*, u.username FROM orders AS o JOIN users AS u ON o.user_id = u.id WHERE status=0";
        if($q=$mysqli->query($sql)) {
            $niz = array();
            while($red = $q->fetch_object()) {
                $niz[] = $red;
            }
            echo json_encode($niz);
        } else {
            $answer['message'] = "Database error!";
            echo json_encode($answer);
        }
    }
    if(isset($_GET['action']) && $_GET['action']=="returnCompletedOrders") {
        $sql="SELECT o.*, u.username FROM orders AS o JOIN users AS u ON o.user_id = u.id WHERE status=1";
        if($q=$mysqli->query($sql)) {
            $niz = array();
            while($red = $q->fetch_object()) {
                $niz[] = $red;
            }
            echo json_encode($niz);
        } else {
            $answer['message'] = "Database error!";
            echo json_encode($answer);
        }
    }
    if(isset($_GET['action']) && $_GET['action']=="changeOrderStatus") {
        $order_id = $_GET['order_id'];
        $sql = "UPDATE orders SET status='1' WHERE id='$order_id'";
        if($q = $mysqli->query($sql)) {
            $answer['message'] = "Order status changed!";
            echo json_encode($answer);
        } else {
            $answer['message'] = "Error!";
            echo json_encode($answer);
        }
    }
?>