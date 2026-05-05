<?php 
// 1. Added session_start to ensure the username can be seen
session_start();
include_once('functions/userfunctions.php');
include_once('includes/header.php');

if(isset($_GET['product']))
{
    $product_slug = $_GET['product'];
    $product_data = getSlugActive("products", $product_slug);
    $product = mysqli_fetch_array($product_data);

    if($product)
    {
        $original_price = $product['original_price'];
        $selling_price = $product['selling_price'];
        $percentage_off = ($original_price > 0) ? round((($original_price - $selling_price) / $original_price) * 100) : 0;
        ?>
        
        <div class="py-3 bg-primary">
            <div class="container">
                <h6 class="text-white">
                    Home / Collections / <?= $product['name']; ?>
                    <?php if(isset($_SESSION['auth'])): ?>
                        <span class="float-end"><i class="fa fa-user"></i> <?= $_SESSION['auth_user']['name']; ?></span>
                    <?php endif; ?>
                </h6>
            </div>
        </div>

        <div class="container product_data mt-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="shadow p-2">
                        <img src="admin/uploads/<?= $product['image']; ?>" class="w-100" alt="<?= $product['name']; ?>">
                    </div>
                </div>

                <div class="col-md-8">
                    <h2 class="fw-bold"><?= $product['name']; ?> 
                        <span class="float-end text-danger"><?php if($product['trending']){ echo "Trending"; } ?></span>
                    </h2>
                    <hr>
                    <p><?= $product['small_description']; ?></p>

                    <div class="row">
                        <div class="col-md-4">
                            <h4>Rs <span class="text-success fw-bold"><?= $product['selling_price']; ?></span> </h4>
                        </div>
                        <div class="col-md-4">
                            <h5>Rs <s class="text-danger"><?= $product['original_price']; ?></s> </h5>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label class="fw-bold">Quantity</label>
                            <div class="input-group mb-3" style="width:130px">
                                <button class="input-group-text decrement-btn">-</button>
                                <input type="text" class="form-control text-center bg-white qty-input" value="1" disabled>
                                <button class="input-group-text increment-btn">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button class="btn btn-primary px-4 addToCartBtn" value="<?= $product['id']; ?>">
                                <i class="fa fa-shopping-cart me-2"></i> Add to cart 
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-danger rounded-pill px-4 fw-bold addToCartBtn" value="<?= $product['id']; ?>">
                                <i class="fa fa-bolt me-2"></i> Buy Now
                            </button>
                        </div>
                    </div>
                    
                    <hr>
                    <h6>Product Description:</h6>
                    <p><?= $product['description']; ?></p>
                </div>
            </div>
        </div>
        <?php
    }
    else
    {
        echo "Product not found";
    }
}
else
{
    echo "Something went wrong";
}

include('includes/footer.php');
?>