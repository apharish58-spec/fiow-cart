<?php 
session_start();
include('functions/userfunctions.php');
include('includes/header.php'); 

if(isset($_GET['category'])) 
{
    $category_slug = $_GET['category'];
    $category_data = getSlugActive("categories", $category_slug);
    $category = mysqli_fetch_array($category_data);

    if($category)
    {
        $cid = $category['id'];
        ?>

        <style>
            /* 1. BLUE TOP NAVBAR STYLE */
            .top-navbar {
                background-color: #0d6efd;
                padding: 10px 15px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: sticky;
                top: 0;
                z-index: 1000;
                gap: 10px;
            }

            .company-name { color: white; font-weight: bold; font-size: 18px; text-decoration: none; white-space: nowrap; }
            .header-search-form { flex: 1; display: flex; justify-content: center; }
            .header-search-box {
                width: 100%; max-width: 350px; height: 38px; background: white;
                display: flex; align-items: center; padding: 0 10px; border-radius: 4px; position: relative;
            }
            .header-search-box input { width: 100%; border: none; outline: none; font-size: 14px; }
            .account-section { position: relative; }
            .account-btn { background: none; border: none; color: white; font-size: 22px; cursor: pointer; display: flex; align-items: center; }
            .account-dropdown {
                display: none; position: absolute; right: 0; top: 40px;
                background-color: white; min-width: 150px; box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
                z-index: 1100; border-radius: 4px;
            }
            .account-dropdown a { color: black; padding: 12px 16px; text-decoration: none; display: block; font-size: 14px; border-bottom: 1px solid #eee; }

            /* 2. AMAZON-STYLE LIST BOXES */
            .collection-bg { background-color: #f7f7f7; padding: 15px 0; min-height: 100vh; }
            .product-row-box {
                display: flex; background: #fff; border-bottom: 1px solid #e0e0e0; padding: 20px;
                text-decoration: none !important; color: inherit; align-items: flex-start; margin-bottom: 2px;
            }
            .product-row-box:hover { background-color: #fcfcfc; }
            .image-column { flex: 0 0 250px; display: flex; justify-content: center; }
            .image-column img { max-width: 100%; max-height: 220px; object-fit: contain; }
            .details-column { flex: 1; padding-left: 25px; display: flex; flex-direction: column; }
            .product-name-title { font-size: 20px; font-weight: 500; color: #0F1111; margin-bottom: 4px; }
            .product-desc-text {
                font-size: 14px; color: #565959; margin-bottom: 12px;
                display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
            }
            .selling-amt { font-size: 28px; font-weight: bold; color: #0F1111; }
            .currency-symbol { font-size: 14px; vertical-align: super; margin-right: 2px; }
            .mrp-row { font-size: 13px; color: #565959; }
            .strike { text-decoration: line-through; }
            .discount-tag { color: #CC0C39; margin-left: 5px; }

            .search-results-list {
                background: white; width: 100%; position: absolute; top: 42px; left: 0;
                z-index: 1100; border-radius: 4px; display: none; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            }
            .result-item { display: block; padding: 10px; color: #333; text-decoration: none; border-bottom: 1px solid #eee; }
        </style>

        

        <div class="collection-bg">
            <div class="container">
                <?php
                $products = getProdByCategory($cid);
                if(mysqli_num_rows($products) > 0) {
                    foreach($products as $item) {
                        $selling = $item['selling_price'];
                        $original = $item['original_price'];
                        $off = ($original > $selling) ? round((($original - $selling) / $original) * 100) : 0;
                    ?>
                        <a href="product-view.php?product=<?=$item['slug']; ?>" class="product-row-box">
                            <div class="image-column">
                                <img src="admin/uploads/<?=$item['image']; ?>" alt="<?=$item['name']; ?>">
                            </div>
                            <div class="details-column">
                                <div class="product-name-title"><?=$item['name']; ?></div>
                                <div class="product-desc-text"><?= $item['small_description']; ?></div>
                                <div class="price-box">
                                    <div><span class="currency-symbol">₹</span><span class="selling-amt"><?= number_format($selling); ?></span></div>
                                    <div class="mrp-row">
                                        M.R.P: <span class="strike">₹<?= number_format($original); ?></span>
                                        <?php if($off > 0): ?><span class="discount-tag">(<?= $off; ?>% off)</span><?php endif; ?>
                                    </div>
                                    <p class="text-success small mt-2 mb-0">FREE delivery available</p>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-warning rounded-pill px-4 fw-bold">Add to cart</button>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                } else {
                    echo "<p class='p-3'>No products found in this category.</p>";
                }
                ?>
            </div>
        </div>

        <script>
        function toggleAccountMenu() {
            var dropdown = document.getElementById("accountDropdown");
            dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
        }

        function filterCategories() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toUpperCase();
            var list = document.getElementById('resultsList');
            var items = list.getElementsByClassName('result-item');
            if (input.value.length > 0) {
                list.style.display = "block";
                for (var i = 0; i < items.length; i++) {
                    var txtValue = items[i].textContent || items[i].innerText;
                    items[i].style.display = (txtValue.toUpperCase().indexOf(filter) > -1) ? "" : "none";
                }
            } else { list.style.display = "none"; }
        }
        </script>

        <?php 
    }
    else {
        echo "<div class='container py-5'><h3>Category not found.</h3></div>";
    }
}
else {
    echo "<div class='container py-5'><h3>Something went wrong. Category slug is missing.</h3></div>";
}

include('includes/footer.php'); 
?>