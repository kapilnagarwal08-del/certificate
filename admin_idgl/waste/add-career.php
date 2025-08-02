<?php

error_reporting(0);
session_start();
include('includes/config.php');
include('classes/careerClass.php');

$obj = new career();
$list=$obj->select();





if(isset($_REQUEST['update']))
{
	$obj->update($_REQUEST);
}


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
        <title> Admin</title>

        <!--Morris Chart CSS -->
		<link rel="stylesheet" href="css/morris.css">

        <!-- Switchery css -->
        <link href="css/switchery.min.css" rel="stylesheet" />
		<link href="css/font-awesome.min.css" rel="stylesheet" />

        <!-- App CSS -->
        <link href="css/style.css" rel="stylesheet" type="text/css" />
		<script src="editor/ckeditor/ckeditor.js"></script>
  </head>


    <body>

        <!-- Navigation Bar-->
       <!-- Navigation Bar-->
        <?php include('includes/header.php'); ?>



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="wrapper">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        
                        <h4 class="page-title">Edit About Page</h4>
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">

						   <div class="col-sm-12">
						<?php if($_SESSION['msg']!='') { ?>
                            <h4 class="alert alert-success"><?php echo $_SESSION['msg']; $_SESSION['msg']=''; ?></h4>
						  <?php } ?>
						   </div>		

                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
                                    <form>
									
                                        <input type="hidden" class="form-control" name="editid" value="<?php echo $list[0]['ID']; ?>">
										
										<fieldset class="form-group">
                                            <label for="exampleInputEmail1">Content</label>
                                             <textarea class="form-control" id="content" name="content"><?php echo $list[0]['content']; ?></textarea>
											 
									<script>	
									
										CKEDITOR.replace( 'content', {
												allowedContent: true
											} );
									</script>
                                         </fieldset>
										 
										
                                        <input type="submit" class="btn btn-primary" value="Update" name="update"/>
										
                                    </form>
                                </div><!-- end col -->
							</div><!-- end row -->
                        </div>
                    </div><!-- end col -->
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