<?php 
session_start();
include('functions/userfunctions.php');
include('includes/header.php');
?>
<div class="py-5">
    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-primary text-white"><h4>My Orders</h4></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tracking No</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $user_id = $_SESSION['auth_user']['user_id'];
                        $orders = mysqli_query($con, "SELECT * FROM orders WHERE user_id='$user_id' ORDER BY id DESC");
                        while($row = mysqli_fetch_array($orders)) {
                            $diff = time() - strtotime($row['created_at']);
                            ?>
                            <tr>
                                <td><?= $row['tracking_no']; ?></td>
                                <td>Rs <?= $row['total_price']; ?></td>
                                <td>
                                    <?php 
                                    if($diff < 1) echo "<span class='badge bg-warning'>Confirmed</span>";
                                    elseif($diff >= 1 && $diff < 2) echo "<span class='badge bg-info'>Shipping</span>";
                                    else echo "<span class='badge bg-success'>Delivered</span>";
                                    ?>
                                </td>
                                <td><a href="view-order-details.php?track=<?= $row['tracking_no']; ?>" class="btn btn-primary btn-sm">Track</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>