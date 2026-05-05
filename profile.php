<?php 
include('functions/userfunctions.php');
include('includes/header.php');

// Security: Check if user is logged in
if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit();
}

// Get basic user info from users table
$userData = getUserData(); 
$user_id = $_SESSION['auth_user']['user_id'];
?>

<div class="container mt-5">
    <div class="row">
        
        <div class="col-md-4 text-center">
            <div class="card shadow-sm p-4 border-0">
                <div class="profile-circle mx-auto mb-3" style="width: 120px; height: 120px; background-color: #0b386b; color: #febd69; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 50px; font-weight: bold; border: 4px solid #f8f9fa;">
                    <?= strtoupper(substr($userData['name'], 0, 1)); ?>
                </div>
                <h4 class="fw-bold"><?= $userData['name']; ?></h4>
                <p class="text-muted">Account Dashboard</p>
                <hr>
                <div class="list-group list-group-flush text-start">
                    <a href="my-orders.php" class="list-group-item list-group-item-action border-0"><i class="fa fa-shopping-bag me-2"></i> My Orders</a>
                    <a href="my-addresses.php" class="list-group-item list-group-item-action border-0"><i class="fa fa-location-dot me-2"></i> Manage Addresses</a>
                    <a href="logout.php" class="list-group-item list-group-item-action border-0 text-danger"><i class="fa fa-sign-out-alt me-2"></i> Logout</a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">Personal Settings</h5>
                </div>
                <div class="card-body">
                    <form action="functions/update_profile.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="<?= $userData['name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?= $userData['phone']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold">Email ID</label>
                            <input type="email" class="form-control bg-light" value="<?= $userData['email']; ?>" readonly>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" name="update_settings_btn" class="btn" style="background-color: #febd69; font-weight: bold;">Update Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Shipping Addresses</h5>
                    <a href="my-addresses.php" class="btn btn-sm btn-dark">+ Add New</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php 
                        $addr_query = "SELECT * FROM user_addresses WHERE user_id = '$user_id'";
                        $addr_query_run = mysqli_query($con, $addr_query);

                        if(mysqli_num_rows($addr_query_run) > 0) {
                            while($address = mysqli_fetch_assoc($addr_query_run)) {
                                ?>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 border rounded shadow-sm" style="border-left: 4px solid #febd69 !important;">
                                        <h6 class="fw-bold mb-1"><?= $address['full_name']; ?></h6>
                                        <!-- FIXED: Using $address['email'] instead of $item['email'] -->
                                        <strong>Email:</strong> <?= $address['email']; ?><br>
                                        <p class="small text-muted mb-2">
                                            <?= $address['address_line_1']; ?><br>
                                            <?= $address['city']; ?>, <?= $address['state']; ?> - <?= $address['pincode']; ?><br>
                                            <strong>Ph:</strong> <?= $address['phone']; ?>
                                        </p>
                                        <div class="mt-2 border-top pt-2">
                                            <a href="edit-address.php?id=<?= $address['id']; ?>" class="text-primary small text-decoration-none me-3">Edit</a>
                                            <a href="functions/address_actions.php?delete_id=<?= $address['id']; ?>" class="text-danger small text-decoration-none">Remove</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<p class="text-center">No addresses found.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
                </div>
            </div>

        </div>
    </div>
 </div
          > <style>
    body { background-color: #f8f9fa; }
    .card { border-radius: 8px; }
    .list-group-item-action:hover { background-color: #fdf2e2; color: #0b386b; }
    .form-control:focus { border-color: #febd69; box-shadow: 0 0 0 0.2rem rgba(254, 189, 105, 0.25); }
</style>

<?php include('includes/footer.php'); ?>