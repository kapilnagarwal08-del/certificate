
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mobile Header Fix</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    header {
      background: #fff;
      border-bottom: 1px solid #ddd;
      position: relative;
      z-index: 999;
    }

    .container {
      max-width: 1200px;
      margin: auto;
      padding: 10px 15px;
    }

    .flex-between {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .site-logo img {
      max-height: 50px;
    }

    .quote-btn {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 8px 14px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
      text-decoration: none;
    }

    /* Hamburger Icon */
    .hamburger {
      width: 25px;
      height: 18px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      cursor: pointer;
    }

    .hamburger span {
      display: block;
      height: 3px;
      background-color: #333;
      border-radius: 2px;
    }

    /* Nav styles */
    .mobile-nav {
      display: none;
      background-color: #fff;
      border-top: 1px solid #ddd;
      width: 100%;
      position: absolute;
      top: 100%;
      left: 0;
    }

    .mobile-nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .mobile-nav ul li {
      border-bottom: 1px solid #eee;
    }

    .mobile-nav ul li a {
      display: block;
      padding: 12px 16px;
      color: #000;
      text-decoration: none;
      font-size: 15px;
    }

    .mobile-nav ul li a:hover {
      background: #f5f5f5;
    }

    .show-menu {
      display: block;
    }

    /* Desktop Header Hidden */
    .desktop-header {
      display: none;
    }

    /* Responsive Design */
    @media (min-width: 992px) {
      .mobile-header {
        display: none;
      }

      .desktop-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
      }

      .desktop-header nav ul {
        display: flex;
        list-style: none;
        gap: 20px;
        margin: 0;
        padding: 0;
      }

      .desktop-header nav ul li a {
        text-decoration: none;
        color: #000;
        font-weight: 500;
      }
    }
  </style>
</head>
<body>

  <header>
    <!-- Mobile Header -->
    <div class="mobile-header container">
      <div class="flex-between">
        <!-- Hamburger -->
        <div class="hamburger" id="toggleMenu">
          <span></span>
          <span></span>
          <span></span>
        </div>

        <!-- Logo Centered -->
        <div class="site-logo">
          <a href="index.php">
            <img src="media/logo.png" alt="Logo" />
          </a>
        </div>

        <!-- Quote Button -->
        <a href="contact.php" class="quote-btn">Get a Quote</a>
      </div>

      <!-- Toggle Menu -->
      <div class="mobile-nav" id="mobileMenu">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About GLI</a></li>
          <li><a href="service.php">Services</a></li>
          <li><a href="idgl4c.php">Courses</a></li>
          <li><a href="gallery.php">Gallery</a></li>
          <li><a href="certificate.php">Get Certificate</a></li>
          <li><a href="verify-report.php">Verify Report</a></li>
          <li><a href="contact.php">Contact Us</a></li>
        </ul>
      </div>
    </div>

    <!-- Desktop Header (Optional) -->
    <div class="desktop-header container">
      <div class="site-logo">
        <a href="index.php"><img src="media/logo.png" alt="Logo" /></a>
      </div>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About GLI</a></li>
          <li><a href="service.php">Services</a></li>
          <li><a href="idgl4c.php">Courses</a></li>
          <li><a href="gallery.php">Gallery</a></li>
          <li><a href="certificate.php">Get Certificate</a></li>
          <li><a href="verify-report.php">Verify Report</a></li>
          <li><a href="contact.php">Contact Us</a></li>
        </ul>
      </nav>
      <a href="contact.php" class="quote-btn">Get a Quote</a>
    </div>
  </header>

  <!-- JS to toggle mobile nav -->
  <script>
    const toggle = document.getElementById('toggleMenu');
    const menu = document.getElementById('mobileMenu');

    toggle.addEventListener('click', () => {
      menu.classList.toggle('show-menu');
    });
  </script>

</body>
</html>
