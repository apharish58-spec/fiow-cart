
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure $cart_count uses your existing logic or database connection
$cart_count = (isset($_SESSION['cart'])) ? count($_SESSION['cart']) : 0;
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
   /* Change this to 'relative' so it takes up its own space */
.header-fixed-container {
    position: relative; 
    width: 100%;
    z-index: 1000;
    background-color: #0b386b;
}

/* Remove 'padding-top' from the body so there is no gap */
body {
    margin: 0;
    padding: 0;
    background-color: #f0f2f2;
}

    /* Normal body with no top padding since header is not floating */
    body {
        margin: 0;
        padding: 0;
    }

    /* Main Navbar Container */
    .nav-top {
        background-color: #0b386b; 
        padding: 10px 20px; 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        gap: 15px; 
        height: 56px;
        font-family: Arial, sans-serif;
    }

    /* FIXED SEARCH WRAPPER */
    .search-wrapper {
        flex: 1; 
        display: flex; 
        background-color: white; 
        border-radius: 4px; 
        max-width: 650px; 
        height: 40px; 
        align-items: center;
        position: relative; 
    }

    /* SMALL CATEGORY SELECT */
    .search-cat-select {
        background-color: #f3f3f3; 
        border: none; 
        border-right: 1px solid #ddd; 
        height: 100%; 
        padding: 0 5px; 
        outline: none; 
        cursor: pointer; 
        font-size: 13px;
        width: 65px; /* Small fixed width */
        border-radius: 4px 0 0 4px;
    }

    #resultsList {
        position: absolute;
        top: 40px; 
        left: 0;
        width: 100%;
        background: white;
        border: 1px solid #ddd;
        z-index: 2100;
        display: none; 
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        max-height: 300px;
        overflow-y: auto;
    }

    .result-item {
        display: block;
        padding: 10px 15px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        border-bottom: 1px solid #eee;
        font-weight: bold;
    }

    /* YELLOW HIGHLIGHT FOR SEARCH RESULTS */
    .result-item:hover {
        background-color: #febd69; 
        color: #000;
    }

    /* STABLE SECONDARY BAR (iPhone, Shoes, etc.) */
    .nav-bottom {
        background-color: #072d5c; 
        padding: 8px 15px; 
        display: flex; 
        align-items: center; 
        gap: 20px; 
        overflow-x: auto; 
        white-space: nowrap;
        height: 40px;
    }

    .nav-bottom a {
        color: white; 
        text-decoration: none; 
        font-size: 14px;
    }

    /* --- DROPDOWN SLIDING FIX --- */
    .nav-account-wrapper {
        position: relative;
        display: inline-block;
        padding: 10px 0; /* Keeps menu open when moving mouse to it */
    }

    .dropdown-menu-box {
        display: none; 
        position: absolute;
        top: 100%; /* Slides down exactly below the bar */
        right: 0;
        background-color: white;
        min-width: 180px;
        box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
        z-index: 3000;
        border-radius: 4px;
        padding: 10px 0;
    }

    /* Shows the box when hovering over the Account wrapper */
    .nav-account-wrapper:hover .dropdown-menu-box {
        display: block;
    }

    .dropdown-menu-box a {
        color: #333 !important;
        padding: 10px 15px;
        text-decoration: none;
        display: block;
        font-size: 14px;
        border-bottom: 1px solid #eee;
    }

    .dropdown-menu-box a:hover {
        background-color: #f1f1f1;
    }
</style>

<div class="header-fixed-container">
    <nav class="nav-top">
        <div style="margin-right: 10px;">
            <a href="index.php" style="color: #ffffff; font-family: 'Bebas Neue', cursive; font-size: 28px; text-decoration: none; letter-spacing: 1px;">
                HARISH
            </a>
        </div>

        <a href="my-addresses.php" style="text-decoration: none; display: flex; align-items: center; gap: 8px; margin-right: 15px; cursor: pointer;">
    <i class="fa-solid fa-location-dot" style="font-size: 18px; color: #ccc;"></i>
    <div style="line-height: 1.2;">
        <span style="font-size: 11px; color: #ccc; display: block;">
            <?php 
                // Check if user is logged in and has an address set
                if(isset($_SESSION['auth_user']['address']) && !empty($_SESSION['auth_user']['address'])) {
                    echo "Delivering to " . $_SESSION['auth_user']['address'];
                } else {
                    echo "Delivering to Coimbatore"; // Default if empty
                }
            ?>
        </span>
        <span style="font-size: 13px; font-weight: bold; color: #ffffff; display: block;">
            <?php 
                // Change text if address is missing
                if(!isset($_SESSION['auth_user']['address']) || empty($_SESSION['auth_user']['address'])) {
                    echo "Update location"; 
                } else {
                    echo "Change address";
                }
            ?>
        </span>
    </div>
</a>

        <div class="search-wrapper">
            <select class="search-cat-select">
                <option value="all">All</option>
                <option value="kitchen">Home & Kitchen</option>
                <option value="electronics">Electronics</option>
            </select>

            <input type="text" id="searchInput" autocomplete="off" style="border: none; outline: none; flex: 1; padding: 0 15px; font-size: 14px; height: 100%;" placeholder="Search for products..." onkeyup="filterCategories()">
            
            <button style="background-color: #febd69; border: none; height: 100%; padding: 0 15px; cursor: pointer; border-radius: 0 4px 4px 0;">
                <i class="fa-solid fa-magnifying-glass" style="font-size: 18px; color: #333;"></i>
            </button>

            <div id="resultsList">
                <?php
                // Calling your existing function
                $categories = getAllActive("categories");
                if(mysqli_num_rows($categories) > 0) {
                    foreach($categories as $item) {
                        echo '<a href="products.php?category='.$item['slug'].'" class="result-item">'.$item['name'].'</a>';
                    }
                }
                ?>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 20px; color: white;">
            
            <div class="nav-account-wrapper">
                <a href="" style="text-decoration: none; color: white; line-height: 1.2;">
                    <span style="font-size: 13px; color: #fbfdfd; display: block;">
                        Hello, <?php echo (isset($_SESSION['auth'])) ? $_SESSION['auth_user']['name'] : 'sign in'; ?>
                    </span>
                    <span style="font-size: 14px; font-weight: bold;">Account <i class="fa fa-caret-down" style="font-size: 10px;"></i></span>
                </a>
                
      <div class="dropdown-menu-box shadow-sm border rounded bg-white" style="min-width: 240px; padding: 8px 0;">
    <?php if(isset($_SESSION['auth'])): ?>
        
        <!-- Profile: Brand Blue -->
        <a href="profile.php" class="menu-item">
            <i class="fa-solid fa-circle-user icon-fixed" style="color: #0b386b;"></i>
            <span class="text-dark">My Profile</span>
        </a>

        <!-- Orders: Gold/Orange (Amazon Style) -->
        <a href="my-orders.php" class="menu-item">
            <i class="fa-solid fa-bag-shopping icon-fixed" style="color: #ff9900;"></i>
            <span class="text-dark">My Orders</span>
        </a>

        <!-- Wishlist: Red -->
        <a href="wishlist.php" class="menu-item">
            <i class="fa-solid fa-heart icon-fixed" style="color: #e41e31;"></i>
            <span class="text-dark  ">  Wishlist  </span>
        </a>
        
      

        <!-- Customer Care: Green -->
        <a href="customer-care.php" class="menu-item">
            <i class="fa-solid fa-headset icon-fixed" style="color: #28a745;"></i>
            <span class="text-dark  ">  24/7 Customer Care  </span>
        </a>

        <!-- Cart: Dark Gray/Black -->
        <a href="cart.php" class="menu-item">
            <i class="fa-solid fa-cart-shopping icon-fixed" style="color: #232f3e;"></i>
            <span class="text-dark  ">  Cart  </span>
        </a>
        <!-- Logout: Bold Red -->
        <a href="logout.php" class="menu-item logout-hover">
            <i class="fa-solid fa-right-from-bracket icon-fixed" style="color: #b12704;"></i>
            <span style="color: #b12704; font-weight: bold;  ">   Logout  </span>
        </a>

    <?php else: ?>
        <!-- Guest Section -->
        <div class="px-3 py-2 text-center">
            <a href="login.php" class="btn btn-warning w-100 fw-bold mb-2" style="background-color: #febd69;">Sign In</a>
            <a href="register.php" class="btn btn-warning w-100 fw-bold mb-2" style="background-color: #1faa0c;">  Start  Register Here</a>
           </div>
    <?php endif; ?>
</div>
            </div>

            <a href="my-orders.php" style="text-decoration: none; color: white; line-height: 1.2;">
                <span style="font-size: 11px; color: #ccc; display: block;">Returns</span>
                <span style="font-size: 14px; font-weight: bold;">& Orders</span>
            </a>
        
            <a href="cart.php" style="display: flex; align-items: flex-end; text-decoration: none; color: white; position: relative;">
                <div style="position: relative;">
                    <span style="position: absolute; top: -12px; left: 10px; color: #f08804; font-weight: bold; font-size: 16px;">
                        <?= $cart_count; ?>
                    </span>
                    <i class="fa-solid fa-cart-shopping" style="font-size: 26px;"></i>
                </div>
                <span style="font-size: 14px; font-weight: bold; margin-left: 5px;">Cart</span>
            </a>
        </div>
    </nav>

    <div class="nav-bottom">
        <a href="categories.php" style="font-weight: bold;"><i class="fa fa-bars"></i> All</a>
        <a href="products.php?category=iPhone%2017">iPhone</a>
        <a href="products.php?category=shoes%20shoes">Shoes</a>
        <a href="products.php?category=laptap">Laptap</a>
        <a href="products.php?category=Washing%20Machine">Washing Machine</a>
    </div>
</div>

<script>
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
    } else {
        list.style.display = "none";
    }
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.search-wrapper')) {
        document.getElementById('resultsList').style.display = 'none';
    }
});
</script>