<?php 
session_start();
include('functions/userfunctions.php');
include('includes/header.php');
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body { background-color: #fcfcfc; }
    .address-wrapper { max-width: 1000px; margin: 30px auto; padding: 0 15px; }
    .address-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
    .btn-add { background: #fff; border: 1px solid #adb5bd; border-radius: 8px; padding: 8px 18px; font-weight: 500; text-decoration: none; color: #111; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .address-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(310px, 1fr)); gap: 20px; }
    .address-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; min-height: 200px; display: flex; flex-direction: column; transition: box-shadow 0.2s; }
    .address-card:hover { border-color: #e77600; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .addr-label { font-weight: bold; color: #565959; font-size: 13px; border-bottom: 1px solid #eee; margin-bottom: 10px; }
    .addr-name { font-weight: 700; font-size: 16px; margin-bottom: 5px; }
    .addr-info { font-size: 14px; color: #111; line-height: 1.5; }
    .addr-links { margin-top: auto; padding-top: 15px; }
    .addr-links a { color: #007185; text-decoration: none; font-size: 13px; margin-right: 15px; cursor: pointer; }
    .add-new-slot { border: 2px dashed #ccc; text-align: center; justify-content: center; align-items: center; cursor: pointer; }
</style>

<div class="address-wrapper">
    <div class="address-header">
        <h2>Your Addresses</h2>
        <a href="#new-address-form" class="btn-add">+ Add Address</a>
    </div>

    <div class="address-grid">
        <?php 
        $user_id = $_SESSION['auth_user']['user_id'];
        $query = "SELECT * FROM user_addresses WHERE user_id = '$user_id' ORDER BY id DESC";
        $query_run = mysqli_query($con, $query);

        if(mysqli_num_rows($query_run) > 0) {
            $count = 1;
            foreach($query_run as $item) {
                ?>
                <div class="address-card">
                    <div class="addr-label">Address <?= $count++; ?></div>
                    <div class="addr-name"><?= $item['full_name']; ?></div>
                    <div class="addr-info">
                        <strong>Email:</strong> <?= $item['email']; ?><br>
                        <?= $item['address_line_1']; ?><br>
                        <?= $item['city']; ?>, <?= $item['state']; ?> <?= $item['pincode']; ?><br>
                        <strong>Phone:</strong> <?= $item['phone']; ?>
                    </div>
                    <div class="addr-links">
                        <a href="edit-address.php?id=<?= $item['id']; ?>">Edit</a>
                        <a href="javascript:void(0);" class="text-danger delete_addr_btn" value="<?= $item['id']; ?>">Remove</a>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <a href="#new-address-form" style="text-decoration: none;">
            <div class="address-card add-new-slot">
                <i class="fa fa-plus fa-3x"></i>
                <h4 class="text-muted">Add Address</h4>
            </div>
        </a>
    </div>

    <div id="new-address-form" class="mt-5 pt-4 border-top">
        <div class="card p-4 border-0 shadow-sm" style="background:#fff; border:1px solid #ddd !important;">
            <h4 class="mb-4">Add a new address</h4>
            <form action="functions/address_actions.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold small">Full Name</label>
                        <input type="text" name="full_name" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
    <label class="fw-bold small">Email Address</label>
    <input type="email" name="email" required class="form-control">
</div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small">Phone</label>
                        <input type="text" name="phone" required class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small">Pincode</label>
                        <input type="text" name="pincode" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold small">Address Line</label>
                        <input type="text" name="address_line" required class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small">City</label>
                        <input type="text" name="city" required class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small">State</label>
                        <input type="text" name="state" required class="form-control">
                    </div>
                </div>
                <button type="submit" name="save_address_btn" class="btn btn-warning rounded-pill px-5 mt-2">Save Address</button>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.delete_addr_btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const addrId = this.getAttribute('value');
        Swal.fire({
            title: 'Remove Address?',
            text: "Are you sure? This will delete the address from your database.",
            icon: 'error', 
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "functions/address_actions.php?delete_id=" + addrId;
            }
        });
    });
});
</script>

<?php include('includes/footer.php'); ?>