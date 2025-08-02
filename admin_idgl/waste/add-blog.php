<?php
error_reporting(0);
include('includes/config.php');
include('classes/trainingClass.php');
$obj=new blog_class();

if(isset($_REQUEST['add']))
{
	$obj->add($_REQUEST);
}

if(isset($_REQUEST['editID']))
{
	$i=0;
	$list=$obj->edit($_REQUEST['editID']);
}

if(isset($_REQUEST['update']))
{
	$obj->update($_REQUEST);
}

if(isset($_REQUEST['deleteID']))
{
	$obj->delete($_REQUEST['deleteID']);
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
			<link href="css/bootstrap-datepicker.min.css" rel="stylesheet">
			<link href="css/daterangepicker.css" rel="stylesheet">
		
		<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
		<script>
function getSubCat(val) {
	$.ajax({
	type: "POST",
	url: "get_sub_cat.php",
	data:'catID='+val,
	success: function(data){
		$("#subCat-list").html(data);
	}
	});
}
</script>
       
		
	
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
                        <div class="btn-group pull-right m-t-15">
                            <a href="view-blog.php" class="btn btn-custom">
							View Blogs 
							<span class="m-l-5">
							<i class="fa fa-cog"></i>
							</span>
							</a>
                         </div>
                        <h4 class="page-title">Add Blog</h4>
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">

                       

                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                                    <form method="post" enctype="multipart/form-data">
									
                                        <input type="hidden" class="form-control" name="editid" value="<?php echo base64_encode($list[$i]['ID']); ?>">
										
							            <fieldset class="form-group">
                                            <label>Heading</label>
                                             <input type="text" name="heading" class="form-control" value="<?php echo $list[$i]['heading']; ?>"/>
										  </fieldset>
										  
										 <fieldset class="form-group">
                                            <label>Blog Category</label>
                                             <input type="text" name="category" class="form-control" value="<?php echo $list[$i]['category']; ?>"/>
										  </fieldset>
										 
										 
										 <?php if(isset($list[$i]['image'])) { ?>
										 
										 <fieldset class="form-group">
                                            <label>Uploaded Image</label>
                                             <img src="uploads/<?php echo $list[$i]['image']; ?>" style="width:100px"/>
										  </fieldset>
										 
										 <?php }  ?>
										 
										  <fieldset class="form-group">
                                            <label for="exampleInputEmail1">Image</label>
                                             <input type="file" name="image" class="form-control"/>
										  </fieldset>
										  
										  
										 <fieldset class="form-group">
                                            <label for="exampleInputEmail1">Content</label>
                                             <textarea class="form-control" id="content" name="content"><?php echo $list[0]['content']; ?></textarea>
											 
										<script>	
									
										CKEDITOR.replace( 'content', {
												allowedContent: true
											} );
									</script>
                                         </fieldset>
										 
										
										
										<fieldset class="form-group">
                                            <label for="exampleInputEmail1">Date</label>
                                             <input type="text" class="form-control" placeholder="mm/dd/yyyy" name="date" value="<?php echo $list[$i]['date']; ?>">
                                         </fieldset>
										 
										 
										 
										
										  
										  
										 <fieldset class="form-group">
                                            <label for="exampleInputEmail1">Status</label>
                                             <select class="form-control" name="status">
												<option value="1" <?php if($list[$i]['status']==1){ echo "selected";} ?>>Active</option>
												<option value="0" <?php if($list[$i]['status']==0){ echo "selected";} ?>>Inactive</option>
											</select>
                                         </fieldset>
										 
										<?php if(isset($_REQUEST['editID'])) { ?>
                                        <input type="submit" class="btn btn-primary" value="Update" name="update"/>
										<?php } else { ?>
										<input type="submit" class="btn btn-primary" value="Submit" name="add"/>
										<?php } ?>
                                    </form>
                                </div><!-- end col -->
							</div><!-- end row -->
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->


               <!-- Footer -->
                <footer class="footer text-right">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                2017 © Primarosa.
                            </div>
                        </div>
                    </div>
                </footer>
              </div> <!-- container -->
		</div> <!-- End wrapper -->

		 <!-- jQuery  -->

              <script src="js/jquery.min.js"></script>
        <script src="js/tether.min.js"></script><!-- Tether for Bootstrap -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/waves.js"></script>
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/switchery.min.js"></script>

        <script src="js/moment.js"></script>
     	<script src="js/bootstrap-timepicker.min.js"></script>
     	
     	<script src="js/bootstrap-datepicker.min.js"></script>
  
     	<script src="js/daterangepicker.js"></script>

        <script src="js/jquery.form-pickers.init.js"></script>

        <!-- App js -->
        <script src="js/jquery.core.js"></script>
        <script src="js/jquery.app.js"></script>



    </body>
</html>