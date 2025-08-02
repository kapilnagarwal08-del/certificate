
<?php 
session_start();

include('admin_idgl/includes/config.php');


if(isset($_POST['submit']))
	{

		$query = "INSERT INTO `queries` (
		`email`,
		`type`
		)
		 VALUES (
		'".$_POST['email']."',
		'index'
		)";

		
		$result=mysqli_query($link,$query);

			if($result)
			{
			                 $_SESSION['subscribe']='subscribe';

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
		<title>GEMOLOGICAL LABORATORY OF INDIA (GLI) – Trusted Gem & Jewellery Certification in India</title>
		<meta name="description" content="Indian Diamond & Gold Laboratory (IDGL) offers reliable and unbiased certification services for diamonds, gemstones, and gold jewellery. Trusted by jewellers and customers alike, IDGL provides international-standard gemological testing and expert consultation across India. Ensure purity, authenticity, and trust with every report.">
		<meta name="keywords" content="diamond certification India, gold testing laboratory, gemstone testing India, IDGL certification, gemological laboratory India, jewellery testing lab, diamond grading report, authentic diamond certificate, gem testing lab India, 4Cs of diamond, certified jewellery India, Indian Diamond and Gold Laboratory, trusted gem lab India, diamond lab report, gold hallmark testing, gem consultancy India">
		<meta name="author" content="Indian Diamond & Gold Laboratory (IDGL)">
		
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

		<!-- Site Stylesheet -->
		<link rel="stylesheet" href="assets/css/app.css" type="text/css">
		<link rel="stylesheet" href="assets/css/responsive.css" type="text/css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
		
		<!-- Google Web Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&amp;display=swap" rel="stylesheet">
		 <style>
   
    .container {
      max-width: 1200px;
      margin: 40px auto;
      background: #fff;
      padding: 30px;
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .column {
      flex: 1;
      min-width: 280px;
    }

    h2 {
      font-size: 22px;
      margin-bottom: 15px;
      color: #222;
    }

    .welcome strong {
      display: block;
      font-size: 14px;
      margin-bottom: 10px;
      color: #666;
    }

    .welcome p {
      font-size: 15px;
      color: #444;
      line-height: 1.6;
    }

    .read-btn {
      margin-top: 20px;
      display: inline-block;
      background-color: #1c9cea;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 4px;
    }

    

    .form input, .form textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    .form textarea {
      resize: vertical;
      height: 80px;
    }

    .form button {
      background-color: #111;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .form button:hover {
      background-color: #333;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        padding: 20px;
      }

      .form input, .form textarea {
        font-size: 16px;
      }
    }
    
  </style>
	</head>
	
	<body class="home home-4 title-4">
		<div id="page" class="hfeed page-wrapper">
			
			<?php include('include/header.php'); ?>

			<div id="site-main" class="site-main">
				<div id="main-content" class="main-content">
					<div id="primary" class="content-area">
						<div id="content" class="site-content" role="main">
							<section class="section m-b-0">
								<!-- Block Sliders (Layout 4) -->
								<div class="block block-sliders layout-4 auto-height color-white nav-center">
									<div class="slick-sliders" data-autoplay="true" data-dots="true" data-nav="true" data-columns4="1" data-columns3="1" data-columns2="1" data-columns1="1" data-columns1440="1" data-columns="1">
										<div class="item slick-slide">
											<div class="item-content">
												<div class="content-image">
													<img width="1920" height="781" src="media/slider/4-1.jpg" alt="Image Slider">
												</div>
												<div class="item-info horizontal-center vertical-middle text-center">
													<div class="content">
														<!-- <div class="subtitle-slider">International Standards, Indian Precision</div> -->
														<!-- <h2 class="title-slider">Certified Purity. Guaranteed Trust.</h2> -->
														<!-- <a class="button-slider button button-white button-outline thick-border" href="contact.php">Contact Now</a> -->
													</div>
												</div>
											</div>
										</div>
										<div class="item slick-slide">
											<div class="item-content">
												<div class="content-image">
													<img width="1920" height="781" src="media/slider/4-2.jpg" alt="Image Slider">
												</div>
												<div class="item-info horizontal-center vertical-middle text-center">
													<div class="content">
														<!-- <div class="subtitle-slider">We Provide</div>
														<h2 class="title-slider">Gem & Jewellery Certification You Can Rely On</h2> -->
														<!-- <a class="button-slider button button-white button-outline thick-border" href="service.php">See Our Service</a> -->
													</div>
												</div>
											</div>
										</div>
										<div class="item slick-slide">
											<div class="item-content">
												<div class="content-image">
													<img width="1920" height="781" src="media/slider/4-3.jpg" alt="Image Slider">
												</div>
												<div class="item-info horizontal-center vertical-middle text-center">
													<div class="content">
														<!-- <div class="subtitle-slider">Jewellery’s True Identity, Verified</div>
														<h2 class="title-slider">Excellence in Gemology & Jewellery Authentication</h2> -->
														<!-- <a class="button-slider button button-white button-outline thick-border" href="service.php">See Our Service</a> -->
													</div>
												</div>
											</div>
										</div>

											<div class="item slick-slide">
											<div class="item-content">
												<div class="content-image">
													<img width="1920" height="781" src="media/slider/4-4.jpg" alt="Image Slider">
												</div>
												<div class="item-info horizontal-center vertical-middle text-center">
													<div class="content">
														<!-- <div class="subtitle-slider">Jewellery’s True Identity, Verified</div>
														<h2 class="title-slider">Excellence in Gemology & Jewellery Authentication</h2> -->
														<!-- <a class="button-slider button button-white button-outline thick-border" href="service.php">See Our Service</a> -->
													</div>
												</div>
											</div>
										</div>

											<div class="item slick-slide">
											<div class="item-content">
												<div class="content-image">
													<img width="1920" height="781" src="media/slider/4-5.jpg" alt="Image Slider">
												</div>
												<div class="item-info horizontal-center vertical-middle text-center">
													<div class="content">
														<!-- <div class="subtitle-slider">Jewellery’s True Identity, Verified</div>
														<h2 class="title-slider">Excellence in Gemology & Jewellery Authentication</h2> -->
														<!-- <a class="button-slider button button-white button-outline thick-border" href="service.php">See Our Service</a> -->
													</div>
												</div>
											</div>
										</div>

									</div>
								</div>
							</section>

							


<div class="container">
  
  <!-- Welcome Section -->
  <div class="column welcome">
    <h2 style="color:orange;">WELCOME</h2>
    <strong>GEMOLOGICAL LABORATORY OF INDIA</strong>
    <p>Astro-Gemology is the synergy of two sciences – Astrology & Gemology. The basic theory of Astro-Gemology is that the nine planets are linked to the nine gems and that the stone of the planet governing fortune can generate fortune.</p>
    <p>Gemology postulates that gems not only enhance fortune but also have therapeutic properties which can be used in the medical field Scholars...</p>
    <a href="about.php" class="read-btn">READ MORE</a>
  </div>

  <!-- Services and Courses -->
  <div class="column">
    <h2 style="color:orange;">OUR SERVICES</h2>
    <ul>
     <a href="service.php"> <li>Diamond Grading Report</li></a>
      <a href="service.php"><li>Gem Identification Report</li></a>
      <a href="service.php"><li>Jewellery Quality Analysis</li></a>
      <a href="service.php"><li>Astrology Consultancy</li></a>
      <a href="service.php"><li>Authentic Certified Gemstone</li></a>
    </ul>
    <h2 style="margin-top: 25px;color:orange;">OUR COURSES</h2>
    <ul>
      <li>Polished Diamond Grading Prog.</li>
      <li>Color Stone Identification Prog.</li>
      <li>Professional Jewellery Design Prog.</li>
      <li>Mounted Jewellery Grading Prog.</li>
      <li>Navratna Identification Prog.</li>
    </ul>
  </div>

  <!-- Form Section -->
  <div class="column form">
    <h2 style="color:orange;">GET CERTIFICATE</h2>
    <input type="text" placeholder="Name" />
    <input type="text" placeholder="Mobile Num" />
    <input type="email" placeholder="Email-ID" />
    <input type="text" placeholder="City" />
    <textarea placeholder="Comment"></textarea>
    <button>Enquiry</button>
  </div>

</div>





						

							

							

							

							<section class="section section-padding background-img bg-img-3 p-t-70 p-b-70 m-b-0">
								<div class="section-container">
									<!-- Block Feature (Layout 2) -->
									<div class="block block-feature layout-2">
										<div class="block-widget-wrap">
											<div class="row">
												<div class="col-md-4 sm-m-b-50">
													<div class="box">
														<div class="box-icon animation-horizontal">
															<span>
																<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.998 511.998" style="enable-background:new 0 0 511.998 511.998;"><g><g><path d="M256.013,59.844c-108.193,0-196.218,88.025-196.218,196.218c0,108.201,88.025,196.218,196.218,196.218    S452.23,364.263,452.23,256.061C452.23,147.869,364.206,59.844,256.013,59.844z M256.013,435.217    c-98.791,0-179.155-80.372-179.155-179.155c0-98.791,80.364-179.155,179.155-179.155s179.155,80.364,179.155,179.155    C435.168,354.844,354.804,435.217,256.013,435.217z"></path></g></g><g><g><path d="M256.013,281.655h-68.25c-4.709,0-8.531,3.813-8.531,8.531v42.656c0,2.849,1.425,5.511,3.796,7.098l21.797,14.529v38.092    c0,3.489,2.124,6.629,5.358,7.925l42.656,17.062c1.032,0.409,2.107,0.606,3.174,0.606c1.689,0,3.353-0.503,4.786-1.467    c2.338-1.587,3.745-4.231,3.745-7.064V290.186C264.544,285.468,260.722,281.655,256.013,281.655z M247.482,397.022l-25.594-10.237    v-36.88c0-2.849-1.425-5.511-3.796-7.098l-21.797-14.529v-29.561h51.187V397.022z"></path></g></g><g><g><path d="M262.044,190.311l-42.656-42.656c-2.448-2.44-6.108-3.174-9.299-1.851c-3.182,1.322-5.264,4.436-5.264,7.883v17.062    h-17.062V85.437h-17.062v93.843c0,4.709,3.822,8.531,8.531,8.531h34.125c4.709,0,8.531-3.822,8.531-8.531v-4.999l25.594,25.594    v30.593h-59.718c-4.709,0-8.531,3.822-8.531,8.531v33.434l-25.594-20.466v-47.092c0-4.709-3.822-8.531-8.531-8.531h-68.25v17.062    h59.718v42.656c0,2.585,1.177,5.042,3.199,6.663l42.656,34.125c1.544,1.237,3.43,1.868,5.332,1.868    c1.263,0,2.525-0.273,3.694-0.845c2.96-1.425,4.837-4.402,4.837-7.687V247.53h59.718c4.709,0,8.531-3.822,8.531-8.531v-42.656    C264.544,194.082,263.648,191.915,262.044,190.311z"></path></g></g><g><g><path d="M343.824,87.937l-62.218,62.218l-17.062-17.062V68.375h-17.062v68.25c0,2.261,0.896,4.428,2.5,6.032l25.594,25.594    c1.595,1.604,3.762,2.5,6.032,2.5c2.261,0,4.428-0.896,6.032-2.5l68.25-68.25L343.824,87.937z"></path></g></g><g><g><path d="M442.829,243.785c-1.433-2.926-4.402-4.786-7.661-4.786h-25.594v-76.781c0-4.709-3.813-8.531-8.531-8.531h-51.187    c-2.269,0-4.428,0.896-6.032,2.5l-42.656,42.656c-3.336,3.336-3.336,8.727,0,12.063l31.625,31.625v81.78    c0,4.718,3.813,8.531,8.531,8.531h34.125c2.628,0,5.11-1.22,6.731-3.293l59.718-76.781    C443.895,250.2,444.262,246.711,442.829,243.785z M371.278,315.78h-21.422v-76.781c0-2.261-0.896-4.428-2.5-6.032l-28.093-28.093    l34.125-34.125h39.124v76.781c0,4.709,3.813,8.531,8.531,8.531h16.678L371.278,315.78z"></path></g></g><g><g><path d="M297.21,491.386c-13.582,2.355-27.445,3.549-41.197,3.549c-0.026,0-0.051,0-0.077,0    c-63.771,0-123.737-24.826-168.85-69.913c-45.139-45.096-70.007-105.079-70.024-168.884c-0.008-34.364,7.192-67.644,21.405-98.919    l-15.527-7.055C7.704,183.674-0.009,219.335,0,256.138c0.017,68.361,26.669,132.635,75.015,180.955    c48.338,48.304,112.586,74.904,180.921,74.904c0.026,0,0.051,0,0.085,0c14.725,0,29.561-1.271,44.106-3.796L297.21,491.386z"></path></g></g><g><g><path d="M346.623,477.147c-9.162,3.762-18.641,6.979-28.161,9.546l4.445,16.482c10.212-2.764,20.364-6.211,30.2-10.246    L346.623,477.147z"></path></g></g><g><g><path d="M506.506,202.895C477.235,64.843,341.146-23.694,203.06,5.602l3.54,16.687C335.43-5.027,462.502,77.589,489.81,206.435    c10.528,49.583,4.752,102.315-16.252,148.468l15.527,7.064C511.591,312.521,517.767,256.027,506.506,202.895z"></path></g></g><g><g><path d="M185.528,10.312c-8.983,2.44-17.898,5.417-26.506,8.838l6.296,15.859c8.019-3.182,16.32-5.955,24.681-8.233    L185.528,10.312z"></path></g></g><g><g><path d="M151.13,45.264c-17.54-17.455-45.795-18.274-64.325-1.868L39.491,85.437H8.608c-3.447,0-6.56,2.073-7.883,5.264    S0.136,97.56,2.576,100l42.656,42.656c1.664,1.664,3.848,2.5,6.032,2.5c2.056,0,4.112-0.734,5.742-2.227l93.843-85.312    c1.732-1.57,2.739-3.779,2.79-6.117C153.69,49.171,152.785,46.911,151.13,45.264z M51.546,124.843L29.202,102.5h13.531    c2.09,0,4.104-0.759,5.665-2.15l49.728-44.183c9.444-8.369,22.864-9.7,33.57-4.189L51.546,124.843z"></path></g></g><g><g><path d="M509.441,412.123l-42.656-42.656c-3.208-3.233-8.395-3.336-11.773-0.282l-93.843,85.312    c-1.723,1.578-2.73,3.796-2.79,6.125c-0.051,2.329,0.862,4.59,2.517,6.236c9.12,9.077,21.132,13.65,33.169,13.65    c11.116,0,22.266-3.907,31.156-11.79l47.306-42.033h30.883c3.447,0,6.569-2.073,7.883-5.264    C512.614,418.231,511.881,414.563,509.441,412.123z M469.293,409.623c-2.09,0-4.104,0.768-5.665,2.158l-49.72,44.175    c-9.444,8.352-22.864,9.7-33.579,4.189l80.151-72.865l22.343,22.343H469.293z"></path></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
															</span>
														</div>
														<div class="box-title-wrap">
															<h3 class="box-title">
											 		 			International standard services
															</h3>
														</div>
													</div>
												</div>
												<div class="col-md-4 sm-m-b-50">
													<div class="box">
														<div class="box-icon icon-2 animation-horizontal">
															<span>
																<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"><g><g><path d="M457.987,31.531c-2.688-6.997-13.013-8.533-17.749-3.499c-21.44,18.88-48.939,29.248-77.547,29.248    c-39.424,0-75.989-19.627-97.771-52.501C262.937,1.792,259.609,0,256.025,0c-3.563,0-6.912,1.792-8.875,4.757    c-21.845,32.875-58.411,52.501-97.835,52.501c-28.928,0-56.704-10.603-78.208-29.867c-3.136-2.816-7.616-3.499-11.477-1.792    c-3.84,1.707-6.315,5.525-6.315,9.728v231.317c0,133.205,189.44,239.552,197.504,244.011c1.6,0.896,3.392,1.344,5.163,1.344    c1.771,0,3.563-0.448,5.163-1.301c8.064-4.459,197.504-110.827,197.504-244.011v-230.4    C458.777,34.688,458.563,33.067,457.987,31.531z M437.315,266.667c0,109.163-151.232,204.459-181.333,222.336    C225.859,471.125,74.649,375.936,74.649,266.667V56.811c22.165,14.165,48,21.803,74.667,21.803    c41.579,0,80.469-18.496,106.667-50.091c26.24,31.616,65.131,50.091,106.709,50.091c26.645,0,52.48-7.637,74.624-21.781V266.667z"></path></g></g><g><g><path d="M327.577,195.136c-4.16-4.16-10.923-4.16-15.083,0l-77.845,77.781l-35.072-35.115c-4.16-4.16-10.923-4.16-15.083,0    c-4.16,4.139-4.16,10.923,0,15.083l42.581,42.667c2.005,1.984,4.715,3.115,7.552,3.115s5.547-1.131,7.531-3.115l85.419-85.333    C331.737,206.059,331.737,199.296,327.577,195.136z"></path></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
																
															</span>
														</div>
														<div class="box-title-wrap">
															<h3 class="box-title">
											 		 			safety and trust 
															</h3>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="box">
														<div class="box-icon icon-3 animation-horizontal">
															<span>
																<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 508 508" style="enable-background:new 0 0 508 508;"><g><g><path d="M254,0C128.3,0,26.1,102.2,26.1,227.9c0,122.9,97.9,223.4,219.8,227.7V508l60.3-60.3l-60.3-60.3v52    c-113-4.4-203.5-97.5-203.5-211.5c0-116.7,94.9-211.6,211.6-211.6s211.6,94.9,211.6,211.6h16.3C481.9,102.2,379.7,0,254,0z     M262.1,426.6l21,21l-21,21V426.6z"></path></g></g><g><g><path d="M131.9,105.8V350h244.2V105.8H131.9z M229.6,122.1L229.6,122.1h48.8v32.6h-48.8V122.1z M359.8,333.7H148.2V122.1h65.1    v48.8h81.4v-48.8h65.1V333.7z"></path></g></g><g><g><polygon points="319.1,248.2 291.2,279.5 303.4,290.3 311,281.8 311,317.4 327.3,317.4 327.3,281.8 334.8,290.3 347,279.5   "></polygon></g></g><g><g><polygon points="251.4,248.2 223.5,279.5 235.7,290.3 243.2,281.8 243.2,317.4 259.5,317.4 259.5,281.8 267.1,290.3 279.2,279.5       "></polygon></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
															</span>
														</div>
														<div class="box-title-wrap">
															<h3 class="box-title">
											 		 			Consultation services 
															</h3>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
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
                                    	<a href="service.php">
											<img width="600" height="600" src="media/product/3.jpg" alt="">                                        
										</a>
		                       		</td>
			                        <td class="wishlist-item-info">
										<div class="wishlist-item-name">
											<a href="service.php">Twin Hoops</a>
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
                                    	<a href="service.php">
											<img width="600" height="600" src="media/product/4.jpg" alt="">                                        
										</a>
		                       		</td>
			                        <td class="wishlist-item-info">
										<div class="wishlist-item-name">
											<a href="service.php">Yilver And Turquoise Earrings</a>
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
                    						<a href="service.php">Twin Hoops</a> <span class="remove">remove</span>
                    					</th>
                    					<th>
                    						<a href="service.php">Medium Flat Hoops</a> <span class="remove">remove</span>
                    					</th>
                    					<th>
                    						<a href="service.php">Bold Pearl Hoop Earrings</a> <span class="remove">remove</span>
                    					</th>
                    				</tr>
                    			</thead>
                    			<tbody>
                    				<tr class="tr-image">
                    					<td class="td-label">Image</td>
                    					<td>
                    						<a href="service.php">
                    							<img width="600" height="600" src="media/product/3.jpg" alt="">
                    						</a>
                    					</td>
                    					<td>
                    						<a href="service.php">
                    							<img width="600" height="600" src="media/product/1.jpg" alt="">
                    						</a>
                    					</td>
                    					<td>
                    						<a href="service.php">
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

<?php 

 if(!isset($_SESSION["subscribe"]))
 { ?>

		<!-- Newsletter Popup -->
	
		
		
		<?php } ?>

		<!-- Dependency Scripts -->
		<script src="libs/popper/js/popper.min.js"></script>
		<script src="libs/jquery/js/jquery.min.js"></script>
		<script src="libs/bootstrap/js/bootstrap.min.js"></script>
		<script src="libs/slick/js/slick.min.js"></script>
		<script src="libs/mmenu/js/jquery.mmenu.all.min.js"></script>
		
		<!-- Site Scripts -->
		<script src="assets/js/app.js"></script>

		<script>
			var tag = document.createElement('script');

			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			var player;
			function onYouTubeIframeAPIReady() {
				player = new YT.Player('player', {
					width: '100%',
					videoId: 'PRgGRgtAvJ0',
					playerVars: {'autoplay': 1, 'playsinline': 1},
					events: {
						'onReady': onPlayerReady,
						'onStateChange': onPlayerStateChange
					}
				});
			}

			function onPlayerReady(event) {
				event.target.mute();
				event.target.playVideo();
			}

			function onPlayerStateChange(event) {
    			if (event.data == YT.PlayerState.ENDED) {
      				player.seekTo(0);
      				player.playVideo();
    			}
  			}
		</script>
	</body>

</html>