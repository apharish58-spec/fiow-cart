<?php 
session_start();
include('functions/userfunctions.php');
include('includes/header.php');

// Check if button was clicked AND if items were actually selected
if(!isset($_POST['proceed_to_checkout_btn']) || !isset($_POST['selected_cart_ids'])) {
    echo "<script>alert('Please select at least one item from the cart.'); window.location.href='cart.php';</script>";
    exit();
}

$selected_ids = $_POST['selected_cart_ids'];
$ids_string = implode(',', $selected_ids);

$uid = $_SESSION['auth_user']['user_id'];

// --- UPDATED: Fetch the LATEST address from user_addresses table ---
$addr_query = "SELECT * FROM user_addresses WHERE user_id = '$uid' ORDER BY id DESC LIMIT 1";
$addr_query_run = mysqli_query($con, $addr_query);

if(mysqli_num_rows($addr_query_run) > 0) {
    $userData = mysqli_fetch_array($addr_query_run);
    // Map the column names from your database screenshot
    $name = $userData['full_name'];
    $email = $userData['email'];
    $phone = $userData['phone'];
    $pincode = $userData['pincode'];
    $address_text = $userData['address_line_1'];
    $city = $userData['city'];
    $state = $userData['state'];
} else {
    // Fallback if no saved address exists
    $name = $_SESSION['auth_user']['name'];
    $email = $_SESSION['auth_user']['email'];
    $phone = $pincode = $address_text = $city = $state = "";
}
?>

<div class="py-5">
    <div class="container">
        <div class="card shadow">
            <form action="placeorder.php" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <h5>Shipping Details</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" value="<?= $name; ?>" required class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?= $email; ?>" required class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="<?= $phone; ?>" required class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Pincode</label>
                                    <input type="text" name="pincode" value="<?= $pincode; ?>" required class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Address</label>
                                    <textarea name="address" required class="form-control" rows="3"><?= $address_text; ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>City</label>
                                    <input type="text" name="city" value="<?= $city; ?>" required class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>State</label>
                                    <input type="text" name="state" value="<?= $state; ?>" required class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h5>Order Summary</h5>
                            <hr>
                            <table class="table">
                                <tbody>
                                    <?php
                                    $query = "SELECT c.id as cid, c.prod_qty, p.id as pid, p.name, p.selling_price 
                                              FROM carts c, products p 
                                              WHERE c.prod_id = p.id AND c.id IN ($ids_string) AND c.user_id = '$uid'";
                                    $query_run = mysqli_query($con, $query);
                                    $totalAmount = 0;
                                    foreach ($query_run as $item) {
                                        $totalAmount += $item['selling_price'] * $item['prod_qty']; ?>
                                        <tr>
                                            <td><?= $item['name']; ?></td>
                                            <td>x<?= $item['prod_qty']; ?></td>
                                            <td>Rs <?= $item['selling_price']; ?></td>
                                        </tr>
                                        <input type="hidden" name="selected_cart_ids[]" value="<?= $item['cid']; ?>">
                                    <?php } ?>
                                </tbody>
                            </table>
                            <hr>
                            <h5>Total: <span class="float-end">Rs <?= $totalAmount; ?></span></h5>
                            <input type="hidden" name="total_price" value="<?= $totalAmount; ?>">
                            <button type="submit" name="placeOrderBtn" class="btn btn-primary w-100 mt-3">Confirm Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>