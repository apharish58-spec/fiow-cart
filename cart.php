<?php 
session_start();
include('functions/userfunctions.php');
include('includes/header.php');
?>

<style>
    body { background-color: #f0f2f2; }
    .cart-page-wrapper { display: flex; width: 100%; padding: 20px; gap: 20px; align-items: flex-start; }
    .cart-items-column { flex: 1; background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 4px; }
    .sidebar-right-column { width: 320px; display: flex; flex-direction: column; gap: 15px; position: sticky; top: 10px; }
    .box-container { background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 4px; }
    .btn-amazon-buy { background: #FFD814; border: 1px solid #FCD200; border-radius: 20px; padding: 10px; width: 100%; font-weight: 500; color: #0f1111; text-align: center; cursor: pointer; }
    .cart-row { display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee; }
</style>

<form action="checkout.php" method="POST">
    <div class="cart-page-wrapper">
        <div class="cart-items-column">
            <h3 class="fw-normal mb-3">Shopping Cart</h3>
            <?php 
            $items = getCartItems(); 
            if(mysqli_num_rows($items) > 0) {
                foreach ($items as $citem) {
                    ?>
                    <div class="card product_data shadow-sm mb-3 border-0 border-bottom">
                        <div class="card-body">
                            <div class="row align-items-center text-center">
                                <div class="col-md-1">
                                    <input type="checkbox" name="selected_cart_ids[]" class="product-checkbox" 
                                           value="<?= $citem['cid']; ?>" 
                                           data-price="<?= $citem['selling_price']; ?>" 
                                           data-qty="<?= $citem['prod_qty']; ?>">
                                </div>
                                <div class="col-md-2">
                                    <img src="admin/uploads/<?= $citem['image']; ?>" width="60px" alt="Image">
                                </div>
                                <div class="col-md-3">
                                    <h6 class="fw-bold mb-0"><?= $citem['name']; ?></h6>
                                </div>
                                <div class="col-md-2">
                                    <h6 class="text-muted">x<?= $citem['prod_qty']; ?></h6>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm deleteItemBtn" value="<?= $citem['cid']; ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <h6>Rs <?= $citem['selling_price']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<h4 class='text-center p-5'>Your cart is empty</h4>";
            }
            ?>
        </div>

        <div class="sidebar-right-column">
            <div class="box-container">
                <div class="text-success small mb-2">
                    <i class="fa fa-check-circle"></i> Order eligible for FREE Delivery.
                </div>
                <h5 class="fw-normal">Subtotal (<span id="count">0</span> items):</h5>
                <h4 class="fw-bold">Rs <span id="total">0</span></h4>
                
                <button type="submit" name="proceed_to_checkout_btn" class="btn-amazon-buy mt-3">Proceed to Buy</button>
                
                <div class="mt-3 border-top pt-2">
                    <small class="text-muted">EMI Options Available</small>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const totalDisplay = document.getElementById('total');
    const countDisplay = document.getElementById('count');

    function update() {
        let total = 0, count = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                total += parseFloat(cb.getAttribute('data-price')) * parseInt(cb.getAttribute('data-qty'));
                count++;
            }
        });
        totalDisplay.innerText = total.toLocaleString('en-IN');
        countDisplay.innerText = count;
    }
    checkboxes.forEach(cb => cb.addEventListener('change', update));
});
</script>

<?php include('includes/footer.php'); ?>