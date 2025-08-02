<?php
session_start();
error_reporting(E_ALL);
include('includes/config.php');
include('classes/visionClass2.php');
$obj = new vision2();

if(isset($_REQUEST['check']))
{
    $list = $obj->single($_REQUEST['c_no'], $link);
}
else
{
    $list = $obj->selectContent($link);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <title>Admin</title>
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
                        <div class="btn-group pull-right m-t-15">
                            <a href="add-certificates2.php" class="btn btn-custom">
                            Add 
                            <span class="m-l-5">
                            <i class="fa fa-cog"></i>
                            </span>
                            </a>
                        </div>
                        <h4 class="page-title">List</h4>
                    </div>
                    <div class="col-sm-12">
                        <form class="form-inline" method="post">
                            <input type="text" name="c_no" placeholder="Enter Certificate No." style="padding: 8px 15px; float: left; margin-bottom: 15px;">
                            <button type="submit" name="check" class="btn btn-primary mb-2" style="float: left; padding: 10px 15px; text-transform: uppercase; letter-spacing: 1px; background: #289ee6; color: #fff; border: 0px;">Check</button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-12">
                        <div class="card-box">
                            <?php if(isset($_SESSION['msg']) && $_SESSION['msg']!='') { ?>
                                <h4 class="alert alert-success"><?php echo $_SESSION['msg']; $_SESSION['msg']=''; ?></h4>
                            <?php } ?>
                            <div class="table-responsive">
                                <table class="table table-bordered m-b-0">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Certificate</th>
                                            <th>Certificate No.</th>
                                            <th>QR Code</th>
                                            <th>Gem</th>
                                            <th>Gross Weight</th>
                                            <th>Shape And Cut</th>
                                            <th>Measurement</th>
                                            <th>Colour</th>
                                            <th>Optic Character</th>
                                            <th>Refractive Index</th>
                                            <th>Specific Gravity</th>
                                            <th>Microscopic obs.</th>
                                            <th>Species</th>
                                            <th>Comments</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sn=1; foreach($list as $item) { ?>
                                            <tr>
                                                <th class="text-muted"><?php echo $sn; ?></th>
                                                <th class="text-muted"><?php if($item['category']==3) { echo 'Gems'; } ?></th>
                                                <td><?php echo htmlspecialchars($item['c_no']); ?></td>
                                                <td>https://idgllab.in/verify-report.php?category=<?php echo htmlspecialchars($item['category']); ?>&c_no=<?php echo htmlspecialchars($item['c_no']); ?></td>
                                                <td><?php echo htmlspecialchars($item['variety']); ?></td>
                                                <td><?php echo htmlspecialchars($item['weight']); ?></td>
                                                <td><?php echo htmlspecialchars($item['shape']); ?></td>
                                                <td><?php echo htmlspecialchars($item['measurment']); ?></td>
                                                <td><?php echo htmlspecialchars($item['color']); ?></td>
                                                <td><?php echo htmlspecialchars($item['oc']); ?></td>
                                                <td><?php echo htmlspecialchars($item['rf']); ?></td>
                                                <td><?php echo htmlspecialchars($item['sg']); ?></td>
                                                <td><?php echo htmlspecialchars($item['mo']); ?></td>
                                                <td><?php echo htmlspecialchars($item['species']); ?></td>
                                                <td><?php echo htmlspecialchars($item['comment']); ?></td>
                                                <td>
                                                    <?php if(!empty($item['image'])): ?>
                                                        <img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="Gem Image" style="max-width: 100px; max-height: 100px;">
                                                    <?php else: ?>
                                                        No Image
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="add-certificates2.php?editID=<?php echo base64_encode($item['ID']); ?>">
                                                        <span class="label label-success">Edit</span>
                                                    </a>
                                                    <a href="add-certificates2.php?deleteID=<?php echo base64_encode($item['ID']); ?>" onclick="return confirm('Are you sure you want to delete')">
                                                        <span class="label label-success">Delete</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php $sn++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer text-right">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                2018 © .
                            </div>
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



        <!--Morris Chart-->

		<script src="js/morris.min.js"></script>

		<script src="js/raphael-min.js"></script>



        <!-- Counter Up  -->

        <script src="js/jquery.waypoints.js"></script>

        <script src="js/jquery.counterup.min.js"></script>



        <!-- App js -->

        <script src="js/jquery.core.js"></script>

        <script src="js/jquery.app.js"></script>



        <!-- Page specific js -->

        <script src="js/jquery.dashboard.js"></script>



    </body>

</html>