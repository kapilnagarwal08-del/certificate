<?phpsession_start();error_reporting(0);include('includes/config.php');include('classes/visionClass.php');$obj = new vision();if(isset($_REQUEST['add'])){	$obj->add($_REQUEST);}
if(isset($_REQUEST['editID'])){   $i=0;   $list=$obj->edit($_REQUEST['editID']);}

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
        <meta name="description" content="">
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
        <?php include('includes/header.php'); ?>


        <div class="wrapper">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15">
                            <a href="view-certificates.php" class="btn btn-custom">
							View Certificates 
							<span class="m-l-5">
							<i class="fa fa-cog"></i>
							</span>
							</a>
                         </div>
                        <h4 class="page-title">Add Certificate</h4>
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
						<div class="row">
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                                    <form method="post" enctype="multipart/form-data">
									
                                        <input type="hidden" class="form-control" name="editid" value="<?php echo base64_encode($list[$i]['ID']); ?>">
										<fieldset class="form-group"><label for="exampleInputEmail1">Category</label><select class="form-control" name="category" required ><option value=''>Select Category</option>	<option value="1" <?php if($list[$i]['category']==1)  {  echo 'selected';} ?>>Jewellery</option>	<option value="2" <?php if($list[$i]['category']==2)  {  echo 'selected';} ?>>Gem</option></select>	</fieldset>
							
										
										 <fieldset class="form-group">
<label for="exampleInputEmail1">Certificate No</label><input type="text" class="form-control" name="c_no" required value="<?php echo $list[$i]['c_no']; ?>"/>
	</fieldset>											<fieldset class="form-group"><label for="exampleInputEmail1">Description</label><input type="text" class="form-control" name="description"  value="<?php echo $list[$i]['description']; ?>"/></fieldset><fieldset class="form-group"><label for="exampleInputEmail1">Gross Weight</label><input type="text" class="form-control" name="grossweight"  value="<?php echo $list[$i]['grossweight']; ?>"/></fieldset><fieldset class="form-group"><label for="exampleInputEmail1">Diamond Weight</label><input type="text" class="form-control" name="diamondweight"  value="<?php echo $list[$i]['diamondweight']; ?>"/></fieldset>
										 
										 
									<fieldset class="form-group">	<label for="exampleInputEmail1">Shape of Diamond</label>	<input type="text" class="form-control" name="shape"  value="<?php echo $list[$i]['shape']; ?>"/></fieldset>
<fieldset class="form-group">	<label for="exampleInputEmail1">Color</label>	<input type="text" class="form-control" name="color"  value="<?php echo $list[$i]['color']; ?>"/></fieldset>	<fieldset class="form-group">	<label for="exampleInputEmail1">Clarity</label>	<input type="text" class="form-control" name="clarity"  value="<?php echo $list[$i]['clarity']; ?>"/></fieldset>																																
										 
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
               
              </div> <!-- container -->
		</div> <!-- End wrapper -->
 
        <script src="js/bootstrap.min.js"></script>
       
        <script src="js/jquery.nicescroll.js"></script>
      



    </body>
</html>