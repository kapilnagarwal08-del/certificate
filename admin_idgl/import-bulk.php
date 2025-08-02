<?php
require_once 'includes/config.php';

// Enable error logging for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/certificate/admin_idgl/error.log');
error_reporting(E_ALL);

// Verify PHPExcel path
$excelPath = 'C:/xampp/htdocs/certificate/admin_idgl/PHPExcel/Classes/PHPExcel.php';
if (!file_exists($excelPath)) {
    die("Error: PHPExcel.php not found at $excelPath. Download from https://github.com/PHPOffice/PHPExcel/archive/1.8.1.zip and place the Classes folder in PHPExcel/");
}
require_once $excelPath;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'] ?? '';
    $excel_file = $_FILES['excel_file'] ?? null;
    $image_files = $_FILES['images'] ?? null;

    // Validate inputs
    if (empty($category) || empty($excel_file['name'])) {
        $error = "Please select a category and upload an Excel file.";
    } else {
        // Ensure Uploads directory exists and is writable
        $target_dir = 'Uploads/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        if (!is_writable($target_dir)) {
            $error = "Uploads directory is not writable.";
        } else {
            // Process Excel file
            try {
                $inputFileName = $excel_file['tmp_name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);

                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Get header row
                $headerRow = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, false)[0];

                // Process each row
                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false)[0];
                    $data = array_combine($headerRow, $rowData);

                    // Default values to prevent undefined index errors
                    $defaults = [
                        'Certificate No' => '',
                        'Category' => $category,
                        'Supplier Name' => '',
                        'Weight' => '',
                        'Shape And Cut' => '',
                        'Measurment' => '',
                        'Colour' => '',
                        'Optic Character' => '',
                        'Refractive Index' => '',
                        'Spcific Gravity' => '',
                        'Microscopic obr.' => '',
                        'Species' => '',
                        'Variety' => '',
                        'Comments' => '',
                        'Total Depth' => '',
                        'Fluorescence' => '',
                        'Stone Weight' => '',
                        'Description' => '',
                        'Design No' => '',
                        'Diamond Weight' => '',
                        'No of Diamonds' => '',
                        'Clarity' => ''
                    ];
                    $data = array_merge($defaults, array_filter($data));

                    // Process image if available
                    $image_path = null;
                    if (!empty($image_files['name'][$row-2])) {
                        $image_name = basename($image_files['name'][$row-2]);
                        $target_file = $target_dir . uniqid() . '_' . $image_name;

                        if (move_uploaded_file($image_files['tmp_name'][$row-2], $target_file)) {
                            $image_path = $target_file;
                        } else {
                            $error = "Failed to upload image: $image_name";
                        }
                    }

                    // Insert into appropriate table
                    switch ($category) {
                        case 'diamond':
                            insertDiamond($data, $image_path);
                            break;
                        case 'gems':
                            insertGem($data, $image_path);
                            break;
                        case 'vision':
                            insertVision($data, $image_path);
                            break;
                        default:
                            $error = "Invalid category selected.";
                            break;
                    }
                }

                $success = "Data imported successfully!";
            } catch (Exception $e) {
                $error = "Error processing Excel file: " . $e->getMessage();
            }
        }
    }
}

function insertDiamond($data, $image_path) {
    global $conn;

    $sql = "INSERT INTO daimond (c_no, category, supplier, weight, shape, measurment, 
            color, oc, rf, sg, mo, species, variety, comment, total_depth, fluorescence, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssss", 
        $data['Certificate No'],
        $data['Category'],
        $data['Supplier Name'],
        $data['Weight'],
        $data['Shape And Cut'],
        $data['Measurment'],
        $data['Colour'],
        $data['Optic Character'],
        $data['Refractive Index'],
        $data['Spcific Gravity'],
        $data['Microscopic obr.'],
        $data['Species'],
        $data['Variety'],
        $data['Comments'],
        $data['Total Depth'],
        $data['Fluorescence'],
        $image_path
    );

    $stmt->execute();
    $stmt->close();
}

function insertGem($data, $image_path) {
    global $conn;

    $sql = "INSERT INTO gems (c_no, category, supplier, weight, stoneweight, shape, 
            measurment, color, oc, rf, sg, mo, species, variety, comment, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssss", 
        $data['Certificate No'],
        $data['Category'],
        $data['Supplier Name'],
        $data['Weight'],
        $data['Stone Weight'],
        $data['Shape And Cut'],
        $data['Measurment'],
        $data['Colour'],
        $data['Optic Character'],
        $data['Refractive Index'],
        $data['Spcific Gravity'],
        $data['Microscopic obr.'],
        $data['Species'],
        $data['Variety'],
        $data['Comments'],
        $image_path
    );

    $stmt->execute();
    $stmt->close();
}

function insertVision($data, $image_path) {
    global $conn;

    $sql = "INSERT INTO vision (c_no, supplier, description, design_no, grossweight, 
            diamondweight, shape, no_of_diamon, color, clarity, comment, category, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssis", 
        $data['Certificate No'],
        $data['Supplier Name'],
        $data['Description'],
        $data['Design No'],
        $data['Weight'],
        $data['Diamond Weight'],
        $data['Shape And Cut'],
        $data['No of Diamonds'],
        $data['Colour'],
        $data['Clarity'],
        $data['Comments'],
        $data['Category'],
        $image_path
    );

    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bulk Import Data</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="css/morris.css">
    <link href="css/switchery.min.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        select, input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <?php require_once 'includes/header.php'; ?>
    <br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="container">
        <h2>Bulk Import Data</h2>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form action="import-bulk.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="diamond">Diamond</option>
                    <option value="gems">Gems</option>
                    <option value="vision">Vision</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="excel_file">Excel File</label>
                <input type="file" name="excel_file" id="excel_file" accept=".xls,.xlsx" required>
            </div>
            
            <div class="form-group">
                <label for="images">Images (ZIP file containing images named as Certificate No)</label>
                <input type="file" name="images[]" id="images" multiple>
                <small>Note: Upload individual images or a ZIP file containing all images</small>
            </div>
            
            <button type="submit">Import Data</button>
        </form>
    </div>

    <?php include 'includes/header.php'; ?>

    <div class="wrapper">
        <div class="container">
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