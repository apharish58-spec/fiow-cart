<?php
session_start();
include('functions/userfunctions.php');

if(isset($_POST['placeOrderBtn'])) {
    $user_id = $_SESSION['auth_user']['user_id'];
    $tracking_no = "TRACK-".rand(111111, 999999);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $pincode = mysqli_real_escape_string($con, $_POST['pincode']);
    $total_price = mysqli_real_escape_string($con, $_POST['total_price']);

    $query = "INSERT INTO orders (tracking_no, user_id, name, email, phone, address, pincode, total_price, payment_mode) 
              VALUES ('$tracking_no', '$user_id', '$name', '$email', '$phone', '$address', '$pincode', '$total_price', 'COD')";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        $order_id = mysqli_insert_id($con);
        foreach($_POST['selected_cart_ids'] as $cart_id) {
            $cart_res = mysqli_query($con, "SELECT * FROM carts WHERE id = '$cart_id'");
            $cart_data = mysqli_fetch_array($cart_res);
            $prod_id = $cart_data['prod_id'];
            $qty = $cart_data['prod_qty'];

            $price_res = mysqli_query($con, "SELECT selling_price FROM products WHERE id='$prod_id' LIMIT 1");
            $price_data = mysqli_fetch_array($price_res);
            $price = $price_data['selling_price'];

            mysqli_query($con, "INSERT INTO order_items (order_id, prod_id, qty, price) VALUES ('$order_id', '$prod_id', '$qty', '$price')");
            mysqli_query($con, "DELETE FROM carts WHERE id = '$cart_id'");
        }
        $_SESSION['message'] = "Check out completed successfully!";
        header('Location: my-orders.php');
        exit();
    }
}
?>