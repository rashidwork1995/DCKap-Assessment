<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DCKAP Task</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="assets/images/icons/site.html">
    <link rel="mask-icon" href="assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/plugins/jquery.countdown.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skins/skin-demo-2.css">
    <link rel="stylesheet" href="assets/css/demos/demo-2.css">
    <link rel="stylesheet" type="text/css" href="assets/sweetalert/sweet-alert.css">
</head>
<body>
    <div class="page-wrapper">
    <?php include 'header.php'; ?>
            <div class="container">
                <div class="tab-content">
                    <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
                        <div class="products">
                            <form method="POST" id="add_product" name="add_product" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_id">Product ID *</label>
                                            <input type="text" class="form-control" id="product_id" name="product_id" value="<?php echo('PROD'.rand());?>" required readonly>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="product_name">Product Name *</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="customer_price">Customer Price *</label>
                                            <input type="text" class="form-control" id="customer_price" name="customer_price" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="guest_price">Guest Price *</label>
                                            <input type="text" class="form-control" id="guest_price" name="guest_price" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="image">Image *</label>
                                            <input type="file" class="form-control" id="image" name="image[]" multiple required>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="doc">Doc</label>
                                            <input type="file" class="form-control" id="doc" name="doc[]" multiple>
                                        </div><!-- End .form-group -->

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="descritpiton">Description</label>
                                            <textarea type="text" class="form-control" id="descritpiton" name="descritpiton"></textarea>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="spec">Spec</label>
                                            <textarea type="text" class="form-control" id="spec" name="spec" ></textarea>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="features">Features</label>
                                            <textarea type="text" class="form-control" id="features" name="features" ></textarea>
                                        </div><!-- End .form-group -->
                                        <div class="form-footer">
                                            <input type="hidden" value="product_add" name="method" id="method" />
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>Add</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div><!-- End .form-footer -->
                                        <br>
                                    </div>
                                </div>
                            </form>
                               
                        </div><!-- End .products -->
                    </div><!-- .End .tab-pane -->
            </div><!-- End .container -->
    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.plugin.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.countdown.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/demos/demo-2.js"></script>
    <script type="text/javascript" src="assets/sweetalert/sweet-alert.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/product.js"></script>
</body>
</html>