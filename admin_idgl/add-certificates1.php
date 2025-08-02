<?php
session_start();
// Error reporting settings
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

include('includes/config.php');
include('classes/visionClass1.php');
$obj = new vision1();

// Handle form submissions
if (isset($_REQUEST['add'])) {
    $obj->add($_REQUEST, $link);
}

if (isset($_REQUEST['editID'])) {
    $i = 0;
    $list = $obj->edit($_REQUEST['editID'], $link);
}

if (isset($_REQUEST['update'])) {
    $obj->update($_REQUEST, $link);
}

if (isset($_REQUEST['deleteID'])) {
    $obj->delete($_REQUEST['deleteID'], $link);
}

// Initialize $list and $i for safety
$list = isset($list) ? $list : [];
$i = isset($i) ? $i : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <title>Admin</title>
    <link rel="stylesheet" href="css/morris.css">
    <link href="css/switchery.min.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
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
    <?php include('includes/header.php'); ?>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="btn-group pull-right m-t-15">
                        <a href="view-certificates1.php" class="btn btn-custom">
                            View Certificates 
                            <span class="m-l-5"><i class="fa fa-cog"></i></span>
                        </a>
                    </div>
                    <h4 class="page-title">Add Daimond</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" name="editid" value="<?php echo isset($list[$i]['ID']) ? base64_encode($list[$i]['ID']) : ''; ?>">
                                    <input type="hidden" value="2" name="category"/>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Certificate No</label>
                                        <input type="text" class="form-control" name="c_no" required value="<?php echo isset($list[$i]['c_no']) ? htmlspecialchars($list[$i]['c_no']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Weight</label>
                                        <input type="text" class="form-control" name="weight" value="<?php echo isset($list[$i]['weight']) ? htmlspecialchars($list[$i]['weight']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Shape and Cut</label>
                                        <input type="text" class="form-control" name="shape" value="<?php echo isset($list[$i]['shape']) ? htmlspecialchars($list[$i]['shape']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Color</label>
                                        <input type="text" class="form-control" name="color" value="<?php echo isset($list[$i]['color']) ? htmlspecialchars($list[$i]['color']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Clarity</label>
                                        <input type="text" class="form-control" name="oc" value="<?php echo isset($list[$i]['oc']) ? htmlspecialchars($list[$i]['oc']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Finish</label>
                                        <input type="text" class="form-control" name="comment" value="<?php echo isset($list[$i]['comment']) ? htmlspecialchars($list[$i]['comment']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Measurment</label>
                                        <input type="text" class="form-control" name="measurment" value="<?php echo isset($list[$i]['measurment']) ? htmlspecialchars($list[$i]['measurment']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Table Size</label>
                                        <input type="text" class="form-control" name="rf" value="<?php echo isset($list[$i]['rf']) ? htmlspecialchars($list[$i]['rf']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Crown Height</label>
                                        <input type="text" class="form-control" name="sg" value="<?php echo isset($list[$i]['sg']) ? htmlspecialchars($list[$i]['sg']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Pavilion Depth</label>
                                        <input type="text" class="form-control" name="mo" value="<?php echo isset($list[$i]['mo']) ? htmlspecialchars($list[$i]['mo']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Girdle Thickness</label>
                                        <input type="text" class="form-control" name="species" value="<?php echo isset($list[$i]['species']) ? htmlspecialchars($list[$i]['species']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Culet</label>
                                        <input type="text" class="form-control" name="variety" value="<?php echo isset($list[$i]['variety']) ? htmlspecialchars($list[$i]['variety']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Total Depth</label>
                                        <input type="text" class="form-control" name="total_depth" value="<?php echo isset($list[$i]['total_depth']) ? htmlspecialchars($list[$i]['total_depth']) : ''; ?>"/>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Fluorescence</label>
                                        <input type="text" class="form-control" name="fluorescence" value="<?php echo isset($list[$i]['fluorescence']) ? htmlspecialchars($list[$i]['fluorescence']) : ''; ?>"/>
                                    </fieldset>

                                    <?php if (!empty($list[$i]['image'])) { ?>
                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Uploaded</label>
                                        <img src="../Uploads/<?php echo htmlspecialchars($list[$i]['image']); ?>" width="200px" />
                                    </fieldset>
                                    <?php } ?>
                                    <img id="preview" src="#" alt="Image Preview" style="display:none; max-width:300px;"><br><br>
                                    <fieldset class="form-group">
                                        <label for="exampleInputEmail1">Image</label>
                                        <input type="file" class="form-control" id="imageInput" name="image" />
                                    </fieldset>

                                    <?php if (isset($_REQUEST['editID'])) { ?>
                                        <input type="submit" class="btn btn-primary" value="Update" name="update"/>
                                    <?php } else { ?>
                                        <input type="submit" class="btn btn-primary" value="Submit" name="add"/>
                                    <?php } ?>
                                </form>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- container -->
    </div><!-- End wrapper -->

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