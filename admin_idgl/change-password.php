<?php

include('includes/config.php');
include('classes/user.php');

$obj= new User();

//update
if(isset($_REQUEST['changepwd']))
{
	$obj->changepwd($_REQUEST);
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
       
	<!--password match -->
<script>
    function myFunction() {
        var pass1 = document.getElementById("pass1").value;
        var pass2 = document.getElementById("pass2").value;
        if (pass1 != pass2) 
		{
            //alert("Passwords Do not match");
            alert("Passwords Doesn't Match!!!");
			document.getElementById("pass2").style.borderColor = "#E34234";
			return false;
        }
		return true;
        
		
    }
</script>
<!--password match -->	
	
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
                       
                        <h4 class="page-title">Change Password</h4>
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
                                            <label>Old Password</label>
                                             <input type="password" name="old_password" class="form-control"/>
										</fieldset>
										 
										  <fieldset class="form-group">
                                            <label>New Password</label>
                                             <input type="password" name="password" id="pass1" class="form-control"/>
										</fieldset>
										
										 <fieldset class="form-group">
                                            <label>Confirm New Password</label>
                                             <input type="password" name="password1" id="pass2" class="form-control"/>
										</fieldset>
									
										
										<input type="submit" class="btn btn-primary" value="Submit" onclick="return myFunction()" name="changepwd"/>
										
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