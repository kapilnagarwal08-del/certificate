<?php
error_reporting(0);
include('includes/config.php');
include('classes/contentClass.php');
$obj=new content();

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
                            <a href="view-content.php" class="btn btn-custom">
							View Content 
							<span class="m-l-5">
							<i class="fa fa-cog"></i>
							</span>
							</a>
                         </div>
                        <h4 class="page-title">Add Service Content</h4>
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
                                            <label for="exampleInputEmail1">Service Name</label>
                                            <select class="form-control" name="catID"   onchange="getSubCat(this.value);" required>
												<option value="">Select Service</option>
												<?php
												$getcategory=mysql_query("select * from category");
												while($row=mysql_fetch_array($getcategory))
												{
												?>
												<option value="<?php echo $row['ID']; ?>" <?php echo $list[$i]['catID']==$row['ID']?'selected':''; ?>>
													<?php echo $row['category']; ?>
												</option>
												<?php } ?>
											</select>
                                         </fieldset>
										 
										 <fieldset class="form-group">
										 <label for="exampleInputEmail1">Subservice Name</label>
                                            <select class="form-control" name="subcatID" required id="subCat-list">
												<option value="">Select Subservice</option>
											</select>
                                         </fieldset>
										 
										 
										 <?php if(isset($list[$i]['image'])) { ?>
										 
										 <fieldset class="form-group">
                                            <label for="exampleInputEmail1">Uploaded Image</label>
                                             <img src="uploads/<?php echo $list[$i]['image']; ?>" style="width:100px"/>
										  </fieldset>
										 
										 <?php }  ?>
										 
										  <fieldset class="form-group">
                                            <label for="exampleInputEmail1">Image</label>
                                             <input type="file" name="image"/>
										  </fieldset>
										  
										
										  
										 
										 <fieldset class="form-group">
                                            <label for="exampleInputEmail1">Content</label>
                                             <textarea class="form-control" id="content" name="content"><?php echo $list[$i]['content']; ?></textarea>
											 
											 <script>
										    CKEDITOR.replace( 'content' );
											</script>
                                         </fieldset>
										 
										 
										  <fieldset class="form-group">
                                            <label for="exampleInputEmail1">Meta Title</label>
                                             <input type="text" class="form-control" name="meta_title" value="<?php echo $list[$i]['meta_title']; ?>">
                                         </fieldset>
										 
										 
										  <fieldset class="form-group">
                                            <label for="exampleInputEmail1">Meta Keywords</label>
                                             <textarea class="form-control"  name="meta_keyword" rows="4"><?php echo $list[$i]['meta_keyword']; ?></textarea>
											 
                                         </fieldset>
										 
										 
										  <fieldset class="form-group">
                                            <label for="exampleInputEmail1">Meta Description</label>
                                             <textarea class="form-control"  name="meta_description" rows="4"><?php echo $list[$i]['meta_description']; ?></textarea>
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

        <script src="js/bootstrap.min.js"></script>
       
        <script src="js/jquery.nicescroll.js"></script>
      



    </body>
</html>