<?php 
session_start();
include('functions/userfunctions.php');
include('includes/header.php');

if(isset($_GET['track'])) {
    $tracking_no = mysqli_real_escape_string($con, $_GET['track']);
    $user_id = $_SESSION['auth_user']['user_id'];

    $order_query = "SELECT * FROM orders WHERE tracking_no='$tracking_no' AND user_id='$user_id' LIMIT 1";
    $order_run = mysqli_query($con, $order_query);

    if(mysqli_num_rows($order_run) > 0) {
        $orderData = mysqli_fetch_array($order_run);
        
        // --- AUTO-SET TRACKING LOGIC ---
        $order_time = strtotime($orderData['created_at']);
        $diff_seconds = (time() - $order_time); 

        $width = "15%"; 
        $status_title = "Order Confirmed";

        if($diff_seconds >= 1 && $diff_seconds < 2) { 
            $width = "55%"; 
            $status_title = "Shipping... (On the Way)";
        } elseif($diff_seconds >= 2) { 
            $width = "100%"; 
            $status_title = "✅ Order Delivered!";
        }
        ?> 

        <div class="py-5">
            <div class="container">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Tracking: <?= $orderData['tracking_no']; ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-5 text-center">
                            <h5 class="text-primary fw-bold mb-3"><?= $status_title; ?></h5>
                            <div class="d-flex justify-content-between px-2 small fw-bold">
                                <span>CONFIRMED</span>
                                <span>SHIPPING</span>
                                <span>DELIVERED</span>
                            </div>
                            <div class="progress" style="height: 15px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                                     style="width: <?= $width; ?>;"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 border-end">
                                <h5>Delivery Details</h5>
                                <hr>
                                <p><strong>Name:</strong> <?= $orderData['name']; ?></p>
                                <p><strong>Address:</strong> <?= $orderData['address']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <h5>Items Ordered</h5>
                                <hr>
                                <table class="table table-sm">
                                    <?php
                                    $order_id = $orderData['id'];
                                    $items_query = "SELECT oi.*, p.name FROM order_items oi, products p WHERE oi.prod_id = p.id AND oi.order_id = '$order_id'";
                                    $items_run = mysqli_query($con, $items_query);
                                    foreach($items_run as $item) {
                                        echo "<tr><td>{$item['name']}</td><td>x{$item['qty']}</td><td>Rs {$item['price']}</td></tr>";
                                    }
                                    ?>
                                </table>
                                <h4 class="text-end fw-bold">Total: Rs <?= $orderData['total_price']; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php 
    } else { echo "Order not found."; }
} else { header("Location: my-orders.php"); }
include('includes/footer.php'); ?>