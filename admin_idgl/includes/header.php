<?php  include("session-check.php");?>
<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">
            <!-- LOGO -->
            <div class="topbar-left">
                <a href="index.php" class="logo">
                    <i class="fa fa-dashboard"></i>
                    <span>Admin Panel</span>
                </a>
            </div>
            <!-- End Logo container-->
            <div class="menu-extras">
                <ul class="nav navbar-nav pull-right">
                    <li class="nav-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>
                    <li class="nav-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="images/avatar-1.jpg" alt="user" class="img-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-arrow profile-dropdown " aria-labelledby="Preview">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="text-overflow"><small>Welcome ! admin</small> </h5>
                            </div>
                            <a href="change-password.php" class="dropdown-item notify-item">
                                <i class="fa fa-user"></i> <span>Change Password</span>
                            </a>
                            <!-- item-->
                            <a href="logout.php" class="dropdown-item notify-item">
                                <i class="fa fa-lock"></i> <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div> <!-- end menu-extras -->
            <div class="clearfix"></div>
        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->
    <div class="navbar-custom">
        <div class="container">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    <li class="has-submenu"> <a href="#"><i class="fa fa-caret-down"></i><span> Manage Jewellery</span>
                        </a>
                        <ul class="submenu">
                            <li> <a href="add-certificates.php">Add</a> </li>
                            <li> <a href="view-certificates.php">View</a> </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="fa fa-caret-down"></i><span> Manage Diamond </span> </a>
                        <ul class="submenu">
                            <li> <a href="add-certificates1.php">Add</a> </li>
                            <li> <a href="view-certificates1.php">View</a> </li>
                        </ul>
                    </li>
                    <li class="has-submenu"> <a href="#"><i class="fa fa-caret-down"></i><span> Manage Gems</span> </a>
                        <ul class="submenu">
                            <li> <a href="add-certificates2.php">Add</a> </li>
                            <li> <a href="view-certificates2.php">View</a> </li>
                        </ul>
                    </li>
                    <li class="has-submenu"> <a href="#"><i class="fa fa-caret-down"></i><span> Manage Images</span>
                        </a>
                        <ul class="submenu">
                            <li> <a href="add-images.php">Add</a> </li>
                            <li> <a href="view-images.php">View</a> </li>
                        </ul>
                    </li>
                    <li class="has-submenu"> <a href="#"><i class="fa fa-caret-down"></i><span>Queries</span>
                        </a>
                        <ul class="submenu">
                            <li> <a href="squery.php">Subscribe query</a> </li>
                            <li> <a href="cquery.php">Contact query</a> </li>
                        </ul>
                    </li>

                    <li><a href="import-bulk.php">Import Bulk</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- End Navigation Bar-->