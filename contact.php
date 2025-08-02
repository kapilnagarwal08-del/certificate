<?php 

include('admin_idgl/includes/config.php');


if(isset($_POST['submit']))
	{

		$query = "INSERT INTO `queries` (
		`name`,
		`email`,
		`phone`,
		`subject`,
		`message`,
		`type`
		)
		 VALUES (
		'".$_POST['name']."',
		'".$_POST['email']."',
		'".$_POST['phone']."',
		'".$_POST['subject']."',
		'".$_POST['message']."',
		'contact'
		)";

		
		$result=mysqli_query($link,$query);

			if($result)
			{
                  	echo "<script>alert('Your query has been sent successfully!')
				    window.location=('../index.php')</script>";
                }
            	else{
        		   echo "<script>alert('Try Again')</script>";
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
		<title>Contact Us | GEMOLOGICAL LABORATORY OF INDIA</title>
		
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
		<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&amp;display=swap" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  .form-control:focus {
    border-color: #000;
    box-shadow: none;
  }

  .btn-dark:hover {
    background-color: #333;
    transition: 0.3s ease;
  }

  @media (max-width: 576px) {
    h2 {
      font-size: 24px;
    }

    .form-control, .btn {
      font-size: 16px;
    }
  }
</style>

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
										Contact Us
									</h1>
								</div>
								<div class="breadcrumbs">
									<a href="index.php">Home</a><span class="delimiter"></span>Contact Us
								</div>
							</div>
						</div>

						<div id="content" class="site-content" role="main">
							<div class="page-contact">
								<section class="section section-padding">
									<div class="section-container small">
										<!-- Block Contact Map -->
										<div class="block block-contact-map">
											<div class="block-widget-wrap">
												<!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.1427740714075!2d77.22551648885498!3d28.65544340000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d04313a02f195%3A0xc69e8249cfabedc0!2sGLI%20Gemological%20Laboratory%20Of%20India!5e0!3m2!1sen!2sin!4v1752911248212!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>-->
												<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3501.143052046958!2d77.2273507755016!3d28.655435075652267!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2s!5e0!3m2!1sen!2sin!4v1753439073359!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
											</div>
										</div>
									</div>
								</section>	

								

						<!-- Bootstrap 5 CSS & Icons CDN -->


<!-- Contact Form Section -->
<section style="background-color: beige; padding: 60px 0px; ">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-6 col-lg-6 ">
        <div class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
          <h2 class="text-center mb-4 fw-bold" style="color:orange;">Address </h2><br>
          <p><strong>Location :</strong> 1117, Chhatta Madan Gopal, Maliwara, Chandni Chowk, Delhi-110006(India)</p><br><br>
          <p><strong>Mobile No. : </strong>+91-9810889499, 09953089499</p><br><br>
          <p><strong>Telephone :</strong> 011-40244325</p><br>
          <p><strong>Website :</strong> <a href="www.gliindia.co.in">www.gliindia.co.in</a></p><br><br>
          <p><strong>E-mail :</strong><a href="gli.gemlab@gmail.com"> gli.gemlab@gmail.com</a></p>
        </div>
      </div>

       <div class="col-6 col-lg-6">
        <div class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
          <h2 class="text-center mb-4 fw-bold" style="color:orange;">Get In Touch</h2>
          <form action="contact.php" method="post">
            <div class="mb-3">
              <label class="form-label">Name*</label>
              <input type="text" name="name" class="form-control rounded-pill px-4 py-2" placeholder="Enter your full name" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email*</label>
              <input type="email" name="email" class="form-control rounded-pill px-4 py-2" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Phone*</label>
              <input type="tel" name="phone" class="form-control rounded-pill px-4 py-2" placeholder="Enter your phone number" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Subject*</label>
              <input type="text" name="subject" class="form-control rounded-pill px-4 py-2" placeholder="Subject of your message" required>
            </div>
            <div class="mb-4">
              <label class="form-label">Message*</label>
              <textarea name="message" class="form-control rounded-4 px-4 py-2" rows="5" placeholder="Write your message here..." required></textarea>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-dark px-5 py-2 rounded-pill">Send Message</button>
            </div>
          </form>
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