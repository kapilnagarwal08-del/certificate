<?php
error_reporting(0);
session_start();
include('includes/config.php');
include('classes/testimonialsClass.php');
$obj=new content();

$list=$obj->select();



?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App title -->
        <title>Admin</title>

        <!--Morris Chart CSS -->
		<link rel="stylesheet" href="css/morris.css">

        <!-- Switchery css -->
        <link href="css/switchery.min.css" rel="stylesheet" />
		<link href="css/font-awesome.min.css" rel="stylesheet" />

        <!-- App CSS -->
        <link href="css/style.css" rel="stylesheet" type="text/css" />
  </head>


    <body>

       <?php include('includes/header.php'); ?>



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="wrapper">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15">
                            <a href="add-testimonials.php" class="btn btn-custom">
							Add Testimonials
							<span class="m-l-5">
							<i class="fa fa-cog"></i>
							</span>
							</a>
                        </div>
                        <h4 class="page-title">Testimonials List</h4>
                    </div>
                </div>


               


                


                <div class="row">
                    
                    <div class="col-xs-12 col-lg-12">
                        <div class="card-box">

                           <?php if($_SESSION['msg']!='') { ?>
                            <h4 class="alert alert-success"><?php echo $_SESSION['msg']; $_SESSION['msg']=''; ?></h4>
						  <?php } ?>

                            <div class="table-responsive">
                                <table class="table table-bordered m-b-0">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Name</th>
											<th>Image</th>
											<th>Testimonials</th>
                                            <th>Position</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									
									<?php  $sn=1; for($i=0;$i<count($list);$i++) { ?>
                                        <tr>
                                            <th class="text-muted"><?php echo $sn; ?></th>
                                          
                                            <td><?php echo $list[$i]['name']; ?></td>
											<td><img src="uploads/<?php echo $list[$i]['image'];?>" style="width:100px"/></td>
											<td>
											
											<?php echo $list[$i]['content']; ?>
											
											</td>
											<td><?php echo $list[$i]['position']; ?></td>
											<td><?php echo $list[$i]['status']==1?'Active':'Inactive'; ?></td>
                                           <td>
											<a href="add-testimonials.php?editID=<?php echo base64_encode($list[$i]['ID']); ?>">
											<span class="label label-success">Edit</span>
											</a>
											
											
											<a href="add-testimonials.php?deleteID=<?php echo base64_encode($list[$i]['ID']); ?>" onclick="return confirm('Are you sure you want to delete')">
												<span class="label label-success">Delete</span>
											</a>
											</td>
                                        </tr>
									<?php $sn++; } ?>
                                        
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div><!-- end col-->


                </div>
                <!-- end row -->
			</div> <!-- container -->
		</div> <!-- End wrapper -->

        <!-- jQuery  -->
        <script src="js/jquery.min.js"></script>
        <script src="js/tether.min.js"></script><!-- Tether for Bootstrap -->
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