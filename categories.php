<?php 
session_start();
include('functions/userfunctions.php');
include('includes/header.php'); 
?>

<style>
    /* 1. HEADER SETTINGS */
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

    .company-name { 
        color: white; 
        font-weight: bold; 
        font-size: 18px; 
        text-decoration: none; 
        white-space: nowrap;
    }

    .header-search-form {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .header-search-box {
        width: 100%;
        max-width: 350px;
        height: 38px;
        background: white;
        display: flex;
        align-items: center;
        padding: 0 10px;
        border-radius: 4px;
        position: relative;
    }

    .header-search-box input { width: 100%; border: none; outline: none; font-size: 14px; }

    /* ACCOUNT DROPDOWN STYLES */
    .account-section { position: relative; }
    .account-btn { background: none; border: none; color: white; font-size: 22px; cursor: pointer; display: flex; align-items: center; }
    .account-dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: 40px;
        background-color: white;
        min-width: 150px;
        box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
        z-index: 1100;
        border-radius: 4px;
    }
    .account-dropdown a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        font-size: 14px;
        border-bottom: 1px solid #eee;
    }

    /* 2. THE ATTACHED ROWS - FULL WIDTH */
    .collection-bg { 
        background-color: #eaeded; 
        padding: 15px 0; 
        width: 100%;
    }

    .attached-block {
        display: flex;
        flex-direction: column;
        gap: 1px; 
        padding: 0 5px;
    }

    .scroll-row { 
        display: flex; 
        overflow-x: auto; 
        scroll-behavior: smooth; 
        gap: 1px; 
        width: 100%; 
    }
    .scroll-row::-webkit-scrollbar { display: none; }

    .product-card {
        background: #ffffff;
        flex: 0 0 42%; 
        height: 200px; 
        display: flex;
        flex-direction: column;
        padding: 10px;
        text-decoration: none !important;
        border: 0.5px solid #f0f0f0; 
        box-sizing: border-box;
    }

    @media (min-width: 992px) {
        .product-card { flex: 0 0 calc(16.6% - 1px); height: 250px; }
    }

    .img-box {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .img-box img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .category-name {
        font-size: 13px;
        font-weight: bold;
        color: #000;
        margin-bottom: 5px;
    }

    .search-results-list {
        background: white;
        width: 100%;
        position: absolute;
        top: 42px;
        left: 0;
        z-index: 1100;
        border-radius: 4px;
        display: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .result-item { display: block; padding: 10px; color: #333; text-decoration: none; border-bottom: 1px solid #eee; }
</style>



<div class="collection-bg">
    <div class="container-fluid">
        <h3 class="fw-bold mb-2 px-2" style="font-size: 1.1rem;">Our Collection</h3>
        
        <div class="attached-block">
            <?php
            mysqli_data_seek($categories, 0); 
            $all_items = mysqli_fetch_all($categories, MYSQLI_ASSOC);
            $rows = array_chunk($all_items, 10);

            foreach ($rows as $row_data) {
                ?>
                <div class="scroll-row">
                    <?php foreach($row_data as $item): ?>
                        <a href="products.php?category=<?=$item['slug']; ?>" class="product-card">
                            <div class="category-name"><?=$item['name']; ?></div>
                            <div class="img-box">
                                <img src="admin/uploads/<?=$item['image']; ?>" alt="<?=$item['name']; ?>">
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php
            }
            ?>
        </div>
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

window.onclick = function(event) {
    if (!event.target.matches('.account-btn')) {
        var dropdowns = document.getElementsByClassName("account-dropdown");
        for (var i = 0; i < dropdowns.length; i++) {
            dropdowns[i].style.display = "none";
        }
    }
}
</script>

<?php include('includes/footer.php'); ?>