<?php 
session_start();
include('functions/userfunctions.php');
include('includes/header.php');

// Redirect if no ID is provided
if(!isset($_GET['id'])) { 
    header("Location: my-addresses.php"); 
    exit(); 
}

$id = mysqli_real_escape_string($con, $_GET['id']);
$user_id = $_SESSION['auth_user']['user_id'];

// Fetch the specific address and ensure it belongs to the logged-in user
$res = mysqli_query($con, "SELECT * FROM user_addresses WHERE id='$id' AND user_id='$user_id' LIMIT 1");

if(mysqli_num_rows($res) > 0) {
    $data = mysqli_fetch_assoc($res);
?>

<div class="container mt-5">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
        <div class="card-header bg-white">
            <h4 class="fw-bold mb-0">Edit Address</h4>
        </div>
        <div class="card-body">
            <form action="functions/address_actions.php" method="POST">
                <!-- Hidden ID field is required for the UPDATE query[cite: 6] -->
                <input type="hidden" name="address_id" value="<?= $data['id']; ?>">
                
                <div class="mb-3">
                    <label class="fw-bold">Full Name</label>
                    <input type="text" name="full_name" value="<?= $data['full_name']; ?>" class="form-control" required>
                </div>

                <!-- Corrected: Added Email Input Field[cite: 6] -->
                <div class="mb-3">
                    <label class="fw-bold">Email Address</label>
                    <input type="email" name="email" value="<?= isset($data['email']) ? $data['email'] : ''; ?>" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Phone</label>
                        <input type="text" name="phone" value="<?= $data['phone']; ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Pincode</label>
                        <input type="text" name="pincode" value="<?= $data['pincode']; ?>" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Address</label>
                    <input type="text" name="address_line" value="<?= $data['address_line_1']; ?>" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">City</label>
                        <input type="text" name="city" value="<?= $data['city']; ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">State</label>
                        <input type="text" name="state" value="<?= $data['state']; ?>" class="form-control" required>
                    </div>
                </div>

                <button type="submit" name="update_address_btn" class="btn btn-warning w-100 fw-bold rounded-pill">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php 
} else {
    echo "<div class='container mt-5'><h4>Address not found.</h4></div>";
}
include('includes/footer.php'); 
?>