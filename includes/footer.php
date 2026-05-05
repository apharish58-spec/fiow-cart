

<!-- 2. Back to Top Bar -->
<div class="container-fluid text-center py-3" style="background-color: #37475a; cursor: pointer;" onclick="window.scrollTo(0, 0);">
    <a href="#" class="text-white text-decoration-none small">Back to top</a>
</div>

<!-- 3. Dark Blue Link Section -->
<footer style="background-color: #232f3e; color: #DDD; padding: 60px 0;">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <h6 class="text-white fw-bold mb-3">Get to Know Us</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">About Us</a></li>
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">Careers</a></li>
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">Press Releases</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-white fw-bold mb-3">Connect with Us</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">Facebook</a></li>
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">Twitter</a></li>
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">Instagram</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-white fw-bold mb-3">Make Money with Us</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">Sell on Shop</a></li>
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">Become an Affiliate</a></li>
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">Advertise Products</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-white fw-bold mb-3">Let Us Help You</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">Your Account</a></li>
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">Help Center</a></li>
                    <li class="mb-2"><a href="#" class="text-reset text-decoration-none footer-link">Returns</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- 4. Black Copyright Section -->
<div class="container-fluid py-4" style="background-color: #131a22; border-top: 1px solid #3a4553;">
    <div class="text-center text-white small">
        <div class="mb-3">
            <img src="assets/images/logo-white.png" alt="Logo" style="height: 30px; opacity: 0.8;">
        </div>
        <div class="mb-2" style="font-size: 12px;">
            <a href="#" class="text-white text-decoration-none mx-2">Conditions of Use & Sale</a>
            <a href="#" class="text-white text-decoration-none mx-2">Privacy Notice</a>
            <a href="#" class="text-white text-decoration-none mx-2">Interest-Based Ads</a>
        </div>
        <p class="m-0" style="color: #999;">© 1996-2026, YourShop.com, Inc. or its affiliates</p>
    </div>
</div>

<!-- Your Provided Scripts -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
<script src="assets/js/custom.js"></script>

<script>
    alertify.set('notifier','position', 'top-center');
    <?php if (isset($_SESSION['message'])) { ?>
        alertify.success('<?= $_SESSION['message']; ?>');
        <?php unset($_SESSION['message']); ?>
    <?php } ?>
</script>
</body>
</html>