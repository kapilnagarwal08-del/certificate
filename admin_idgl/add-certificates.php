<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('classes/visionClass.php');
$obj = new vision();

if(isset($_REQUEST['add']))
{
	$obj->add($_REQUEST, $link);
}

if(isset($_REQUEST['editID']))
{
   $i=0;
   $list=$obj->edit($_REQUEST['editID'], $link);
}



if(isset($_REQUEST['update']))

{

	$obj->update($_REQUEST, $link);

}



if(isset($_REQUEST['deleteID']))

{

	$obj->delete($_REQUEST['deleteID'], $link);

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

            data: 'catID=' + val,

            success: function(data) {

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

                    <h4 class="page-title">Add Jwellery</h4>

                </div>

            </div>







            <div class="row">

                <div class="col-sm-12">

                    <div class="card-box">

                        <div class="row">

                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">

                                <form method="post" enctype="multipart/form-data">



                                    <input type="hidden" class="form-control" name="editid"
                                        value="<?php echo base64_encode($list[$i]['ID']); ?>">

                                    <input type="hidden" value="1" name="category" />



                                    <fieldset class="form-group">

                                        <label for="exampleInputEmail1">Certificate No</label>
                                        <input type="text" class="form-control" name="c_no" required
                                            value="<?php echo $list[$i]['c_no']; ?>" />

                                    </fieldset>



                                    <!--<fieldset class="form-group">-->

                                    <!--    <label for="exampleInputEmail1">Supplier</label>-->
                                    <!--    <input type="text" class="form-control" name="supplier"-->
                                    <!--        value="<?php echo $list[$i]['supplier']; ?>" />-->

                                    <!--</fieldset>-->


                                    <fieldset class="form-group">

                                        <label for="exampleInputEmail1">Description</label>
                                        <input type="text" class="form-control" name="description"
                                            value="<?php echo $list[$i]['description']; ?>" />
                                    </fieldset>


                                    <!--<fieldset class="form-group">-->

                                    <!--    <label for="exampleInputEmail1">Net Weight</label>-->
                                    <!--    <input type="text" class="form-control" name="design_no"-->
                                    <!--        value="<?php echo $list[$i]['design_no']; ?>" />-->
                                    <!--</fieldset>-->


                                    <fieldset class="form-group">

                                        <label for="exampleInputEmail1">Gross Weight</label>
                                        <input type="text" class="form-control" name="grossweight"
                                            value="<?php echo $list[$i]['grossweight']; ?>" />
                                    </fieldset>

                                    <fieldset class="form-group">

                                        <label for="exampleInputEmail1">Diamond Weight</label>
                                        <input type="text" class="form-control" name="diamondweight"
                                            value="<?php echo $list[$i]['diamondweight']; ?>" />
                                    </fieldset>






                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Shape of Diamond</label>
                                        <input type="text" class="form-control" name="shape"
                                            value="<?php echo $list[$i]['shape']; ?>" />
                                    </fieldset>



                                    <!--<fieldset class="form-group">-->
                                    <!--    <label for="exampleInputEmail1">Stone Weight</label>-->
                                    <!--    <input type="text" class="form-control" name="no_of_diamon"-->
                                    <!--        value="<?php echo $list[$i]['no_of_diamon']; ?>" />-->
                                    <!--</fieldset>-->


                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Color</label>
                                        <input type="text" class="form-control" name="color"
                                            value="<?php echo $list[$i]['color']; ?>" />
                                    </fieldset>


                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Clarity</label>
                                        <input type="text" class="form-control" name="clarity"
                                            value="<?php echo $list[$i]['clarity']; ?>" />
                                    </fieldset>


                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Finish</label>
                                        <input type="text" class="form-control" name="comment"
                                            value="<?php echo $list[$i]['comment']; ?>" />
                                    </fieldset>

                                    <?php if($list[$i]['image']!='') { ?>
                                    <fieldset class="form-group">

                                        <label for="exampleInputEmail1">Uploaded</label>
                                        <img src="../uploads/<?php echo $list[$i]['image']; ?>" width="200px" />

                                    </fieldset>
                                    <?php } ?>
                                        <img id="preview" src="#" alt="Image Preview" style="display:none; max-width:300px;"><br><br>
                                    <fieldset class="form-group">

                                        <label for="exampleInputEmail1">Image</label>
                                        <input type="file" class="form-control"  id="imageInput"  name="image" />

                                    </fieldset>


                                    <?php if(isset($_REQUEST['editID'])) { ?>

                                    <input type="submit" class="btn btn-primary" value="Update" name="update" />

                                    <?php } else { ?>

                                    <input type="submit" class="btn btn-primary" value="Submit" name="add" />

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


<script>
document.getElementById('imageInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>






</body>

</html>