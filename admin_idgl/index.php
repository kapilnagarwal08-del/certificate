<?php
session_start();
error_reporting(E_ALL);

include("includes/config.php");  
include('classes/visionClass.php');

$obj = new vision();

if (isset($_REQUEST['check'])) {
    $list = $obj->single($_REQUEST['c_no'], $link);
} else {
    $list = $obj->selectContent($link);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="css/morris.css">
    <link href="css/switchery.min.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php include('includes/header.php'); ?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group m-t-15">
                    <a href="add-certificates.php" class="btn btn-custom">Add Jewellery <span class="m-l-5"><i class="fa fa-cog"></i></span></a>
                    <br/><br/>
                    <a href="view-certificates.php" class="btn btn-custom">View Jewellery <span class="m-l-5"><i class="fa fa-cog"></i></span></a>
                </div>
            </div>
        </div>
        <footer class="footer text-right">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">2018 © .</div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/waves.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/switchery.min.js"></script>
<script src="js/morris.min.js"></script>
<script src="js/raphael-min.js"></script>
<script src="js/jquery.waypoints.js"></script>
<script src="js/jquery.counterup.min.js"></script>
<script src="js/jquery.core.js"></script>
<script src="js/jquery.app.js"></script>
<script src="js/jquery.dashboard.js"></script>

</body>
</html>