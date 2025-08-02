<?php

include("admin_idgl/includes/config.php");
$result = null; // Default value to prevent undefined variable warning
$numrows = 0; // Initialize numrows to prevent undefined variable warning

global $link;
 

if (isset($_GET['category']) && isset($_GET['c_no'])) {
    $category = mysqli_real_escape_string($link, $_GET['category']); // Sanitize input
    $c_no = mysqli_real_escape_string($link, $_GET['c_no']); // Sanitize input

    if ($category == 1) {
        $query = mysqli_query($link, "SELECT * FROM `vision` WHERE `c_no`='$c_no' AND `category`='$category'");
    } else if ($category == 2) {
        $query = mysqli_query($link, "SELECT * FROM `daimond` WHERE `c_no`='$c_no' AND `category`='$category'");
    } else if ($category == 3) {
        $query = mysqli_query($link, "SELECT * FROM `gems` WHERE `c_no`='$c_no' AND `category`='$category'");
    } else if ($category == 4) {
        $query = mysqli_query($link, "SELECT * FROM `rudraksha` WHERE `c_no`='$c_no' AND `category`='$category'");
    }

    if ($query) {
        $numrows = mysqli_num_rows($query);
    } else {
        $error = "Database query failed: " . mysqli_error($link);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Report | GEMOLOGICAL LABORATORY OF INDIA</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="media/logo.png">
    
    <!-- Dependency Styles -->
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="libs/feather-font/css/iconfont.css" type="text/css">
    <link rel="stylesheet" href="libs/icomoon-font/css/icomoon.css" type="text/css">
    <link rel="stylesheet" href="libs/font-awesome/css/font-awesome.css" type="text/css">
    <link rel="stylesheet" href="libs/wpbingofont/css/wpbingofont.css" type="text/css">
    <link rel="stylesheet" href="libs/elegant-icons/css/elegant.css" type="text/css">
    <link rel="stylesheet" href="libs/slick/css/slick.css" type="text/css">
    <link rel="stylesheet" href="libs/slick/css/slick-theme.css" type="text/css">
    <link rel="stylesheet" href="libs/mmenu/css/mmenu.min.css" type="text/css">
    <link rel="stylesheet" href="libs/slider/css/jslider.css">

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="assets/css/app.css" type="text/css">
    <link rel="stylesheet" href="assets/css/responsive.css" type="text/css">
    
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body class="page">
    <div id="page" class="hfeed page-wrapper">
        <?php include('include/header.php'); ?>
        
        <div id="site-main" class="site-main">
            <div id="main-content" class="main-content">
                <div id="primary" class="content-area">
                    <div id="title" class="page-title">
                        <div class="section-container">
                            <div class="content-title-heading">
                                <h1 class="text-title-heading" style="color:orange;">
                                    Verify Report
                                </h1>
                            </div>
                            <div class="breadcrumbs">
                                <a href="index.php">Home</a><span class="delimiter"></span>Verify Report
                            </div>
                        </div>
                    </div>

                    <div id="content" class="site-content" role="main">
                        <div class="page-contact">
                            <section class="section section-padding background-img bg-img-7 p-t-70 p-b-70 m-b-0">
                                <div class="section-container">
                                    <div class="block block-contact-form">
                                        <div class="block-widget-wrap text-center">
                                            <div class="block-title">
                                                <h2 style="color:orange;">Verify Your Report!</h2>
                                            </div>
                                            <div class="block-content d-flex justify-content-center">
                                                <form class="w-100 w-md-auto d-flex flex-column flex-md-row align-items-center justify-content-center gap-2" method="GET" action="verify-report.php">
                                                    <div class="form-group w-100 w-md-auto">
                                                        <select name="category" id="category" class="form-control w-100" required>
                                                            <option value="">Select Category</option>
                                                            <option value="1">Jewellery</option>
                                                            <option value="2">Diamond</option>
                                                            <option value="3">Gems</option>
                                                            <option value="4">Rudraksha</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group w-100 w-md-auto">
                                                        <input type="text" id="certNo" name="c_no" class="form-control w-100" placeholder="Enter Certification No." required>
                                                    </div>
                                                    <button type="submit" class="btn btn-warning w-100 w-md-auto">CHECK</button>
                                                </form>
                                                
                                                <?php
                                                if (isset($error)) {
                                                    echo "<p style='color:red;'>$error</p>";
                                                }

                                                if (isset($numrows) && $numrows > 0) {
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        if ($category == 1) {
                                                ?>
                                                            <table border="0" width="100%" style="background: #00000017;margin-bottom: 50px;margin-top: 50px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="2" style="text-align:center; background: #289ee6; color: #FFF; font-size: 16px;">Jewellery Testing Report</td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:40%; text-align:left;">Certificate No</th>
                                                                        <td style="color:brown; font-size: 14px; font-weight: bold;"><?php echo htmlspecialchars($row['c_no']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:40%; text-align:left; font-weight: bold;">Description</th>
                                                                        <td style="font-weight: bold;"><?php echo htmlspecialchars($row['description']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Gross Weight</th>
                                                                        <td><?php echo htmlspecialchars($row['grossweight']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Diamond Weight</th>
                                                                        <td><?php echo htmlspecialchars($row['diamondweight']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left; font-weight: bold;">Shape of Diamond</th>
                                                                        <td style="font-weight: bold;"><?php echo htmlspecialchars($row['shape']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Color</th>
                                                                        <td><?php echo htmlspecialchars($row['color']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Clarity</th>
                                                                        <td><?php echo htmlspecialchars($row['clarity']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Comment</th>
                                                                        <td><?php echo htmlspecialchars($row['comment']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Image</th>
                                                                        <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="200px" /></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        <?php } else if ($category == 2) { ?>
                                                            <table border="0" width="100%" style="background: #00000017;margin-bottom: 50px;margin-top: 50px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="2" style="text-align:center; background: #289ee6; color: #FFF; font-size: 16px;">Diamond Testing Report</td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:40%; text-align:left;">Certificate No</th>
                                                                        <td style="color:brown; font-size: 14px; font-weight: bold;"><?php echo htmlspecialchars($row['c_no']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:40%; text-align:left; font-weight: bold;">Weight</th>
                                                                        <td style="font-weight: bold;"><?php echo htmlspecialchars($row['weight']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Shape And Cut</th>
                                                                        <td><?php echo htmlspecialchars($row['shape']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Color</th>
                                                                        <td><?php echo htmlspecialchars($row['color']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Clarity</th>
                                                                        <td><?php echo htmlspecialchars($row['oc']); ?></td>
                                                                    </tr>
                                                                    <!-- <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left; font-weight: bold;">Finish</th>
                                                                        <td style="font-weight: bold;"><?php //echo htmlspecialchars($row['finish']); ?></td>
                                                                    </tr> -->
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left; font-weight: bold;">Measurement</th>
                                                                        <td style="font-weight: bold;"><?php echo htmlspecialchars($row['measurment']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Table Size</th>
                                                                        <td><?php echo htmlspecialchars($row['rf']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Crown Height</th>
                                                                        <td><?php echo htmlspecialchars($row['sg']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Pavilion Depth</th>
                                                                        <td><?php echo htmlspecialchars($row['mo']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Girdle Thickness</th>
                                                                        <td><?php echo htmlspecialchars($row['species']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Culet</th>
                                                                        <td><?php echo htmlspecialchars($row['variety']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Total Depth</th>
                                                                        <td><?php echo htmlspecialchars($row['total_depth']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Fluorescence</th>
                                                                        <td><?php echo htmlspecialchars($row['fluorescence']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Image</th>
                                                                        <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="200px" /></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        <?php } else if ($category == 3) { ?>
                                                            <table border="0" width="100%" style="background: #00000017;margin-bottom: 50px;margin-top: 50px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="2" style="text-align:center; background: #289ee6; color: #FFF; font-size: 16px;">Gems Testing Report</td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:40%; text-align:left;">Certificate No</th>
                                                                        <td style="color:brown; font-size: 14px; font-weight: bold;"><?php echo htmlspecialchars($row['c_no']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Gem</th>
                                                                        <td><?php echo htmlspecialchars($row['variety']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:40%; text-align:left; font-weight: bold;">Gross Weight</th>
                                                                        <td style="font-weight: bold;"><?php echo htmlspecialchars($row['weight']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Shape And Cut</th>
                                                                        <td><?php echo htmlspecialchars($row['shape']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Measurement</th>
                                                                        <td><?php echo htmlspecialchars($row['measurment']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Color</th>
                                                                        <td><?php echo htmlspecialchars($row['color']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left; font-weight: bold;">Optic Character</th>
                                                                        <td style="font-weight: bold;"><?php echo htmlspecialchars($row['oc']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left; font-weight: bold;">Refractive Index</th>
                                                                        <td style="font-weight: bold;"><?php echo htmlspecialchars($row['rf']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Specific Gravity</th>
                                                                        <td><?php echo htmlspecialchars($row['sg']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Microscopic obs.</th>
                                                                        <td><?php echo htmlspecialchars($row['mo']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Species</th>
                                                                        <td><?php echo htmlspecialchars($row['species']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Comments</th>
                                                                        <td><?php echo htmlspecialchars($row['comment']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Image</th>
                                                                        <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="200px" /></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        <?php } else if ($category == 4) { ?>
                                                            <table border="0" width="100%" style="background: #00000017;margin-bottom: 50px;margin-top: 50px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="2" style="text-align:center; background: #289ee6; color: #FFF; font-size: 16px;">Rudraksha Testing Report</td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:40%; text-align:left;">Certificate No</th>
                                                                        <td style="color:brown; font-size: 14px; font-weight: bold;"><?php echo htmlspecialchars($row['c_no']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:40%; text-align:left; font-weight: bold;">Description</th>
                                                                        <td style="font-weight: bold;"><?php echo htmlspecialchars($row['description']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Weight</th>
                                                                        <td><?php echo htmlspecialchars($row['weight']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Shape</th>
                                                                        <td><?php echo htmlspecialchars($row['shape']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Comments</th>
                                                                        <td><?php echo htmlspecialchars($row['comment']); ?></td>
                                                                    </tr>
                                                                    <tr style="width:40%; text-align:left;background: #ffffff;">
                                                                        <th style="width:30%; text-align:left;">Image</th>
                                                                        <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="200px" /></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        <?php } ?>
                                                    <?php
                                                    }
                                                } else if (isset($_GET['category']) && isset($_GET['c_no'])) {
                                                    echo "<h3 style='color:red'>Sorry, no record found</h3>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div><!-- #content -->
                </div><!-- #primary -->
            </div><!-- #main-content -->
        </div>

        <?php include('include/footer.php'); ?>
    </div>

    <!-- Back Top button -->
    <div class="back-top button-show">
        <i class="arrow_carrot-up"></i>
    </div>

    <!-- Search -->
    <div class="search-overlay">
        <div class="close-search"></div>
        <div class="wrapper-search">
            <form role="search" method="get" class="search-from ajax-search" action="#">
                <a href="#" class="search-close"></a>
                <div class="search-box">
                    <button id="searchsubmit" class="btn" type="submit">
                        <i class="icon-search"></i>
                    </button>
                    <input type="text" autocomplete="off" value="" name="s" class="input-search s" placeholder="Search...">
                    <div class="content-menu_search">
                        <label>Suggested</label>
                        <ul id="menu_search" class="menu">
                            <li><a href="#">Earrings</a></li>
                            <li><a href="#">Necklaces</a></li>
                            <li><a href="#">Bracelets</a></li>
                            <li><a href="#">Jewelry Box</a></li>
                        </ul>            
                    </div>
                </div>
            </form>    
        </div>    
    </div>

    <!-- Wishlist -->
    <div class="wishlist-popup">
        <div class="wishlist-popup-inner">
            <div class="wishlist-popup-content">
                <div class="wishlist-popup-content-top">
                    <span class="wishlist-name">Wishlist</span>
                    <span class="wishlist-count-wrapper"><span class="wishlist-count">2</span></span>                                
                    <span class="wishlist-popup-close"></span>
                </div>
                <div class="wishlist-popup-content-mid">
                    <table class="wishlist-items">                        
                        <tbody>
                            <tr class="wishlist-item">
                                <td class="wishlist-item-remove"><span></span></td>
                                <td class="wishlist-item-image">
                                    <a href="shop-details.html">
                                        <img width="600" height="600" src="media/product/3.jpg" alt="">                                        
                                    </a>
                                </td>
                                <td class="wishlist-item-info">
                                    <div class="wishlist-item-name">
                                        <a href="shop-details.html">Twin Hoops</a>
                                    </div>
                                    <div class="wishlist-item-price">
                                        <span>$150.00</span>
                                    </div>
                                    <div class="wishlist-item-time">June 4, 2022</div>                                
                                </td>
                                <td class="wishlist-item-actions">
                                    <div class="wishlist-item-stock">
                                        In stock 
                                    </div>
                                    <div class="wishlist-item-add">
                                        <div data-title="Add to cart">
                                            <a rel="nofollow" href="#">Add to cart</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="wishlist-item">
                                <td class="wishlist-item-remove"><span></span></td>
                                <td class="wishlist-item-image">
                                    <a href="shop-details.html">
                                        <img width="600" height="600" src="media/product/4.jpg" alt="">                                        
                                    </a>
                                </td>
                                <td class="wishlist-item-info">
                                    <div class="wishlist-item-name">
                                        <a href="shop-details.html">Yilver And Turquoise Earrings</a>
                                    </div>
                                    <div class="wishlist-item-price">
                                        <del aria-hidden="true"><span>$150.00</span></del> 
                                        <ins><span>$100.00</span></ins>
                                    </div>
                                    <div class="wishlist-item-time">June 4, 2022</div>                                
                                </td>
                                <td class="wishlist-item-actions">
                                    <div class="wishlist-item-stock">
                                        In stock 
                                    </div>
                                    <div class="wishlist-item-add">
                                        <div data-title="Add to cart">
                                            <a rel="nofollow" href="#">Add to cart</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="wishlist-popup-content-bot">
                    <div class="wishlist-popup-content-bot-inner">
                        <a class="wishlist-page" href="shop-wishlist.html">
                            Open wishlist page                                    
                        </a>
                        <span class="wishlist-continue" data-url="">
                            Continue shopping                                        
                        </span>
                    </div>
                    <div class="wishlist-notice wishlist-notice-show">Added to the wishlist!</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compare -->
    <div class="compare-popup">
        <div class="compare-popup-inner">
            <div class="compare-table">
                <div class="compare-table-inner">
                    <a href="#" id="compare-table-close" class="compare-table-close">
                        <span class="compare-table-close-icon"></span>
                    </a>
                    <div class="compare-table-items">
                        <table id="product-table" class="product-table">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="#" class="compare-table-settings">Settings</a>
                                    </th>
                                    <th>
                                        <a href="shop-details.html">Twin Hoops</a> <span class="remove">remove</span>
                                    </th>
                                    <th>
                                        <a href="shop-details.html">Medium Flat Hoops</a> <span class="remove">remove</span>
                                    </th>
                                    <th>
                                        <a href="shop-details.html">Bold Pearl Hoop Earrings</a> <span class="remove">remove</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="tr-image">
                                    <td class="td-label">Image</td>
                                    <td>
                                        <a href="shop-details.html">
                                            <img width="600" height="600" src="media/product/3.jpg" alt="">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="shop-details.html">
                                            <img width="600" height="600" src="media/product/1.jpg" alt="">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="shop-details.html">
                                            <img width="600" height="600" src="media/product/2.jpg" alt="">
                                        </a>
                                    </td>
                                </tr>
                                <tr class="tr-sku">
                                    <td class="td-label">SKU</td>
                                    <td>VN00189</td>
                                    <td></td>
                                    <td>D1116</td>
                                </tr>
                                <tr class="tr-rating">
                                    <td class="td-label">Rating</td>
                                    <td>
                                        <div class="star-rating">
                                            <span style="width:80%"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="star-rating">
                                            <span style="width:100%"></span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr class="tr-price">
                                    <td class="td-label">Price</td>
                                    <td><span class="amount">$150.00</span></td>
                                    <td><del><span class="amount">$150.00</span></del> <ins><span class="amount">$100.00</span></ins></td>
                                    <td><span class="amount">$200.00</span></td>
                                </tr>
                                <tr class="tr-add-to-cart">
                                    <td class="td-label">Add to cart</td>
                                    <td>
                                        <div data-title="Add to cart">
                                            <a href="#" class="button">Add to cart</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div data-title="Add to cart">
                                            <a href="#" class="button">Add to cart</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div data-title="Add to cart">
                                            <a href="#" class="button">Add to cart</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tr-description">
                                    <td class="td-label">Description</td>
                                    <td>Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet magna posuere eget.</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</td>
                                    <td>The EcoSmart Fleece Hoodie full-zip hooded jacket provides medium weight fleece comfort all year around. Feel better in this sweatshirt because Hanes keeps plastic bottles of landfills by using recycled polyester.7.8 ounce fleece sweatshirt made with up to 5 percent polyester created from recycled plastic.</td>
                                </tr>
                                <tr class="tr-content">
                                    <td class="td-label">Content</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</td>
                                </tr>
                                <tr class="tr-dimensions">
                                    <td class="td-label">Dimensions</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quickview -->
    <div class="quickview-popup">
        <div id="quickview-container"> 
            <div class="quickview-container"> 
                <a href="#" class="quickview-close"></a> 
                <div class="quickview-notices-wrapper"></div> 
                <div class="product single-product product-type-simple">
                    <div class="product-detail">
                        <div class="row"> 
                            <div class="img-quickview"> 
                                <div class="product-images-slider">
                                    <div id="quickview-slick-carousel"> 
                                        <div class="images"> 
                                            <div class="scroll-image">
                                                <div class="slick-wrap">
                                                    <div class="slick-sliders image-additional" data-dots="true" data-columns4="1" data-columns3="1" data-columns2="1" data-columns1="1" data-columns="1" data-nav="true">
                                                        <div class="img-thumbnail slick-slide"> 
                                                            <a href="media/product/3.jpg" class="image-scroll" title="">
                                                                <img width="900" height="900" src="media/product/3.jpg" alt="">
                                                            </a> 
                                                        </div>
                                                        <div class="img-thumbnail slick-slide"> 
                                                            <a href="media/product/3-2.jpg" class="image-scroll" title="">
                                                                <img width="900" height="900" src="media/product/3-2.jpg" alt="">
                                                            </a> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 
                                    </div> 
                                </div> 
                            </div> 
                            <div class="quickview-single-info">
                                <div class="product-content-detail entry-summary">
                                    <h1 class="product-title entry-title">Twin Hoops</h1>
                                    <div class="price-single">
                                        <div class="price">
                                            <del><span>$150.00</span></del>
                                            <span>$100.00</span>
                                        </div>
                                    </div>
                                    <div class="product-rating"> 
                                        <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
                                            <span style="width:80%">Rated <strong class="rating">4.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span>
                                        </div> 
                                        <a href="#" class="review-link">(<span class="count">1</span> customer review)</a> 
                                    </div>
                                    <div class="description"> 
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis…</p> 
                                    </div>
                                    <form class="cart" method="post" enctype="multipart/form-data">
                                        <div class="quantity-button">
                                            <div class="quantity"> 
                                                <button type="button" class="plus">+</button> 
                                                <input type="number" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" placeholder="" inputmode="numeric" autocomplete="off"> 
                                                <button type="button" class="minus">-</button> 
                                            </div> 
                                            <button type="submit" class="single-add-to-cart-button button alt">Add to cart</button> 
                                        </div> 
                                        <button class="button quick-buy">Buy It Now</button>
                                    </form> 
                                </div> 
                            </div> 
                        </div> 
                    </div>
                </div> 
                <div class="clearfix"></div> 
            </div> 
        </div>
    </div>

    <!-- Page Loader -->
    <div class="page-preloader">
        <div class="loader">
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- Dependency Scripts -->
    <script src="libs/popper/js/popper.min.js"></script>
    <script src="libs/jquery/js/jquery.min.js"></script>
    <script src="libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="libs/slick/js/slick.min.js"></script>
    <script src="libs/mmenu/js/jquery.mmenu.all.min.js"></script>
    <script src="libs/slider/js/tmpl.js"></script>
    <script src="libs/slider/js/jquery.dependClass-0.1.js"></script>
    <script src="libs/slider/js/draggable-0.1.js"></script>
    <script src="libs/slider/js/jquery.slider.js"></script>
    
    <!-- Site Scripts -->
    <script src="assets/js/app.js"></script>
</body>
</html>