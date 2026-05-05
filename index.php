<?php 
session_start();
include('functions/userfunctions.php'); 
include('includes/header.php');
include('includes/slider.php');
?>
<style>
    .main-bg { background-color: #EAEDED; min-height:90vh; padding: 10px 0; }
    .no-gap-row { margin-left: -5px !important; margin-right: -5px !important; }
    .tight-box { padding: 5px !important; }

    .grid-card { 
        background: #fff; 
        padding: 15px; 
        height: 100%; 
        box-shadow: 0 1px 2px rgba(0,0,0,0.1); 
    }

    .grid-img-container { 
        background: #fff; 
        height: 110px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        margin-bottom: 8px; 
        overflow: hidden;
    }
    .grid-img-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; 
        /* Optimization: smooth transition when loading */
        transition: opacity 0.3s;
    }

    .slider-section { 
        background: #fff; 
        padding: 15px; 
        margin: 10px 5px; 
        box-shadow: 0 1px 2px rgba(0,0,0,0.1); 
    }

    .slider-img-wrapper {
        height: 210px; 
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }
    .slider-img-wrapper img {
        max-width: 100%;
        max-height: 80%;
        object-fit: contain; 
    }

    .product-name { 
        font-size: 14px; 
        color: #0F1111; 
        font-weight: 500; 
        margin-top: 5px; 
        text-align: center;
        display: block;
    }

    .custom-scroll { 
        display: flex; 
        overflow-x: auto; 
        gap: 20px; 
        padding-bottom: 15px; 
        scrollbar-width: thin;
    }
</style>

<div class="main-bg">
    <div class="container-fluid">
        <?php
        $query = "SELECT * FROM category_cards WHERE status='0' ORDER BY row_number ASC, id ASC";
        $query_run = mysqli_query($con, $query);

        if(mysqli_num_rows($query_run) > 0)
        {
            $current_row = null;
            $row_open = false;

            while($card = mysqli_fetch_assoc($query_run))
            {
                if ($current_row !== $card['row_number']) 
                {
                    if ($row_open) { echo '</div>'; } 
                    $current_row = $card['row_number'];
                    echo '<div class="row no-gap-row">'; 
                    $row_open = true;
                }

                if($card['card_type'] == 'grid') 
                {
                    ?>
                    <div class="col-md-3 col-sm-6 tight-box"> 
                        <div class="grid-card">
                            <h5 class="fw-bold mb-3" style="font-size: 22px; color: #0F1111;"><?= $card['card_title']; ?></h5>
                            <div class="row g-2"> 
                                <?php for($i=1; $i<=4; $i++): ?>
                                    <div class="col-6 mb-3">
                                        <div class="grid-img-container">
                                            <img src="admin/uploads/<?= $card['p'.$i.'_image']; ?>" 
                                                 loading="lazy" 
                                                 onerror="this.src='admin/uploads/default.png'">
                                        </div>
                                        <span class="product-name text-truncate"><?= $card['p'.$i.'_name']; ?></span>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <div class="mt-2 text-start">
                                <a href="#" class="text-decoration-none" style="font-size: 14px; color: #007185;">See more</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                else if($card['card_type'] == 'slider') 
                {
                    if ($row_open) { echo '</div>'; $row_open = false; }
                    ?>
                    <div class="slider-section">
                        <h4 class="fw-bold mb-3" style="font-size: 22px; color: #0F1111;"><?= $card['card_title']; ?></h4>
                        <div class="custom-scroll">
                            <?php 
                            $slider_items = json_decode($card['slider_data'], true);
                            if($slider_items) {
                                foreach($slider_items as $item) {
                                    ?>
                                    <div class="text-center" style="min-width: 220px;">
                                        <div class="slider-img-wrapper">
                                            <img src="admin/uploads/<?= $item['image']; ?>" 
                                                 loading="lazy" 
                                                 onerror="this.src='admin/uploads/default.png'">
                                        </div>
                                        <p class="product-name px-2 text-truncate"><?= $item['name']; ?></p>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    $current_row = "slider_break"; 
                }
            }
            if ($row_open) { echo '</div>'; }
        }
        ?>
        
        <div class="container-fluid bg-white border-top border-bottom py-2 mt-2">
            <div class="text-center">
                <h5 class="fw-bold mb-3" style="font-size: 18px; color: #0F1111;">See personalized recommendations</h5>
                <a href="login.php" class="btn btn-warning fw-bold mb-2" 
                   style="background-color: #ece912; border: 1px solid #fbff14; border-radius: 50px; padding: 5px 100px; font-size: 14px; color: #0F1111; box-shadow: 0 2px 5px 0 rgba(213,217,217,.5);">
                    Sign in
                </a>
                <p class="small mt-1" style="font-size: 11px; color: #0F1111;">
                    New customer? <a href="register.php" class="text-decoration-none" style="color: #007185;">Start here.</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>