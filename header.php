<?php session_start(); ?>
<header class="header header-2 header-intro-clearance">
            <div class="header-top">
                <div class="container">
                    <div class="header-right">
                        <ul class="top-menu">
                            <li>
                                <ul>
                                <?php if(isset($_SESSION['login_user_name'])) {?>
                                    <li><a href="logout.php"><?php echo $_SESSION['login_user_name'] ?> / logout</a></li>
                                <?php }else{ ?>
                                    <li><a href="#signin-modal" data-toggle="modal">Sign in / Sign up</a></li>
                                <?php } ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php   if(isset($_SESSION['login_user_name'])) { ?>
            <div class="header-middle">
                <div class="container">
                    <div class="header-right">
                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li>
                                    <a href="index.php" class="sf-with-ul">Home</a>
                                </li>
                                <?php if($_SESSION['login_user_type']==1){?>
                                <li>
                                    <a href="product.php" class="sf-with-ul">Product</a>
                                </li>
                                <li>
                                    <a href="customer.php" class="sf-with-ul">Customer</a>
                                </li>
                                <?php }?>
                                <li>
                                    <a href="order.php" class="sf-with-ul">Order</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <div class="icon">
                                    <i class="icon-shopping-cart"></i>
                                </div>
                                <p>Cart</p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div id="cart_val"></div>
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .cart-dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->
        <?php } ?>
        </header><!-- End .header -->