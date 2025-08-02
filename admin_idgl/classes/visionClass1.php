<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class vision1
{
  function selectContent($links)
{
    $query = "SELECT * FROM daimond";
    $res = mysqli_query($links, $query);
    $infoArr = [];
    $i = 0;
    while ($row = mysqli_fetch_assoc($res)) {
        $infoArr[$i] = [
            'ID' => $row['ID'] ?? '',
            'category' => $row['category'] ? stripslashes($row['category']) : '',
            'c_no' => $row['c_no'] ? stripslashes($row['c_no']) : '',
            'supplier' => $row['supplier'] ? stripslashes($row['supplier']) : '',
            'weight' => $row['weight'] ? stripslashes($row['weight']) : '',
            'shape' => $row['shape'] ? stripslashes($row['shape']) : '',
            'measurment' => $row['measurment'] ? stripslashes($row['measurment']) : '',
            'color' => $row['color'] ? stripslashes($row['color']) : '',
            'oc' => $row['oc'] ? stripslashes($row['oc']) : '',
            'rf' => $row['rf'] ? stripslashes($row['rf']) : '',
            'sg' => $row['sg'] ? stripslashes($row['sg']) : '',
            'mo' => $row['mo'] ? stripslashes($row['mo']) : '',
            'species' => $row['species'] ? stripslashes($row['species']) : '',
            'variety' => $row['variety'] ? stripslashes($row['variety']) : '',
            'comment' => $row['comment'] ? stripslashes($row['comment']) : '',
            'total_depth' => $row['total_depth'] ? stripslashes($row['total_depth']) : '',
            'fluorescence' => $row['fluorescence'] ? stripslashes($row['fluorescence']) : '',
            'image' => $row['image'] ?? '' // Added image field
        ];
        $i++;
    }
    return $infoArr;
}

    function selectbyStatus($links)
    {
        $query = "SELECT * FROM vision WHERE status = 1";
        $res = mysqli_query($links, $query);
        $infoArr = [];
        $i = 0;
        while ($row = mysqli_fetch_assoc($res)) {
            $infoArr[$i] = [
                'ID' => $row['ID'] ?? '',
                'category' => $row['category'] ? stripslashes($row['category']) : '',
                'c_no' => $row['c_no'] ? stripslashes($row['c_no']) : '',
                'description' => $row['description'] ? stripslashes($row['description']) : '',
                'grossweight' => $row['grossweight'] ? stripslashes($row['grossweight']) : '',
                'diamondweight' => $row['diamondweight'] ? stripslashes($row['diamondweight']) : '',
                'shape' => $row['shape'] ? stripslashes($row['shape']) : '',
                'color' => $row['color'] ? stripslashes($row['color']) : '',
                'clarity' => $row['clarity'] ? stripslashes($row['clarity']) : '',
                'total_depth' => $row['total_depth'] ? stripslashes($row['total_depth']) : '',
                'fluorescence' => $row['fluorescence'] ? stripslashes($row['fluorescence']) : ''
            ];
            $i++;
        }
        return $infoArr;
    }

  function single($id, $links)
{
    $query = "SELECT * FROM daimond WHERE c_no = ?";
    $stmt = mysqli_prepare($links, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $infoArr = [];
    $i = 0;
    while ($row = mysqli_fetch_assoc($res)) {
        $infoArr[$i] = [
            'ID' => $row['ID'] ?? '',
            'category' => $row['category'] ? stripslashes($row['category']) : '',
            'c_no' => $row['c_no'] ? stripslashes($row['c_no']) : '',
            'supplier' => $row['supplier'] ? stripslashes($row['supplier']) : '',
            'weight' => $row['weight'] ? stripslashes($row['weight']) : '',
            'shape' => $row['shape'] ? stripslashes($row['shape']) : '',
            'measurment' => $row['measurment'] ? stripslashes($row['measurment']) : '',
            'color' => $row['color'] ? stripslashes($row['color']) : '',
            'oc' => $row['oc'] ? stripslashes($row['oc']) : '',
            'rf' => $row['rf'] ? stripslashes($row['rf']) : '',
            'sg' => $row['sg'] ? stripslashes($row['sg']) : '',
            'mo' => $row['mo'] ? stripslashes($row['mo']) : '',
            'species' => $row['species'] ? stripslashes($row['species']) : '',
            'variety' => $row['variety'] ? stripslashes($row['variety']) : '',
            'comment' => $row['comment'] ? stripslashes($row['comment']) : '',
            'total_depth' => $row['total_depth'] ? stripslashes($row['total_depth']) : '',
            'fluorescence' => $row['fluorescence'] ? stripslashes($row['fluorescence']) : '',
            'image' => $row['image'] ?? '' // Fixed typo: removed trailing space
        ];
        $i++;
    }
    mysqli_stmt_close($stmt);
    return $infoArr;
}

    function add($data, $links)
    {
        $imagefile = '';
        if (!empty($_FILES['image']['name'])) {
            $img_name = $_FILES['image']['name'];
            $temp = $_FILES['image']['tmp_name'];
            $ext = pathinfo($img_name, PATHINFO_EXTENSION);
            $imagefile = time() . '.' . $ext;
            $target = "../Uploads/" . $imagefile;
            move_uploaded_file($temp, $target);
        }

        $query = "INSERT INTO daimond (c_no, category, weight, shape, measurment, color, oc, rf, sg, mo, species, variety, comment, total_depth, fluorescence, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($links, $query);
        mysqli_stmt_bind_param($stmt, "ssssssssssssssss", 
            $data['c_no'], $data['category'], $data['weight'], $data['shape'], 
            $data['measurment'], $data['color'], $data['oc'], $data['rf'], 
            $data['sg'], $data['mo'], $data['species'], $data['variety'], 
            $data['comment'], $data['total_depth'], $data['fluorescence'], $imagefile
        );
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            $_SESSION['msg'] = "Added Successfully";
            echo "<script>location='view-certificates1.php'</script>";
        } else {
            echo "<script>alert('Data Insertion failed');</script>";
        }
        mysqli_stmt_close($stmt);
    }

    function edit($data, $links)
    {
        $editID = base64_decode($data);
        $query = "SELECT * FROM daimond WHERE ID = ?";
        $stmt = mysqli_prepare($links, $query);
        mysqli_stmt_bind_param($stmt, "i", $editID);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $infoArr = [];
        $i = 0;
        while ($row = mysqli_fetch_assoc($res)) {
            $infoArr[$i] = [
                'ID' => $row['ID'] ?? '',
                'category' => $row['category'] ? stripslashes($row['category']) : '',
                'c_no' => $row['c_no'] ? stripslashes($row['c_no']) : '',
                'supplier' => $row['supplier'] ? stripslashes($row['supplier']) : '',
                'weight' => $row['weight'] ? stripslashes($row['weight']) : '',
                'shape' => $row['shape'] ? stripslashes($row['shape']) : '',
                'measurment' => $row['measurment'] ? stripslashes($row['measurment']) : '',
                'color' => $row['color'] ? stripslashes($row['color']) : '',
                'oc' => $row['oc'] ? stripslashes($row['oc']) : '',
                'rf' => $row['rf'] ? stripslashes($row['rf']) : '',
                'sg' => $row['sg'] ? stripslashes($row['sg']) : '',
                'mo' => $row['mo'] ? stripslashes($row['mo']) : '',
                'species' => $row['species'] ? stripslashes($row['species']) : '',
                'variety' => $row['variety'] ? stripslashes($row['variety']) : '',
                'comment' => $row['comment'] ? stripslashes($row['comment']) : '',
                'total_depth' => $row['total_depth'] ? stripslashes($row['total_depth']) : '',
                'fluorescence' => $row['fluorescence'] ? stripslashes($row['fluorescence']) : '',
                'image' => $row['image'] ?? ''
            ];
            $i++;
        }
        mysqli_stmt_close($stmt);
        return $infoArr;
    }
function update($data, $links)
{
    $id = base64_decode($data['editid']);
    $imagefile = '';
    
    // Get the existing image info first
    $existing = $this->edit($data['editid'], $links);
    $existingImage = $existing[0]['image'] ?? '';
    
    if (!empty($_FILES['image']['name'])) {
        // Delete the old image if it exists
        if (!empty($existingImage)) {
            $oldFilePath = "../Uploads/" . $existingImage;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
        
        // Upload the new image
        $img_name = $_FILES['image']['name'];
        $temp = $_FILES['image']['tmp_name'];
        $ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $imagefile = time() . '.' . $ext;
        $target = "../Uploads/" . $imagefile;
        move_uploaded_file($temp, $target);
        
        $query = "UPDATE daimond SET c_no = ?, category = ?, weight = ?, shape = ?, measurment = ?, color = ?, oc = ?, rf = ?, sg = ?, mo = ?, species = ?, variety = ?, comment = ?, total_depth = ?, fluorescence = ?, image = ? WHERE ID = ?";
        $stmt = mysqli_prepare($links, $query);
        mysqli_stmt_bind_param($stmt, "ssssssssssssssssi", 
            $data['c_no'], $data['category'], $data['weight'], $data['shape'], 
            $data['measurment'], $data['color'], $data['oc'], $data['rf'], 
            $data['sg'], $data['mo'], $data['species'], $data['variety'], 
            $data['comment'], $data['total_depth'], $data['fluorescence'], $imagefile, $id
        );
    } else {
        // Keep the existing image
        $query = "UPDATE daimond SET c_no = ?, category = ?, weight = ?, shape = ?, measurment = ?, color = ?, oc = ?, rf = ?, sg = ?, mo = ?, species = ?, variety = ?, comment = ?, total_depth = ?, fluorescence = ?, image = ? WHERE ID = ?";
        $stmt = mysqli_prepare($links, $query);
        mysqli_stmt_bind_param($stmt, "ssssssssssssssssi", 
            $data['c_no'], $data['category'], $data['weight'], $data['shape'], 
            $data['measurment'], $data['color'], $data['oc'], $data['rf'], 
            $data['sg'], $data['mo'], $data['species'], $data['variety'], 
            $data['comment'], $data['total_depth'], $data['fluorescence'], $existingImage, $id
        );
    }
    
    $res = mysqli_stmt_execute($stmt);
    if ($res) {
        $_SESSION['msg'] = "Updated Successfully";
        header('location:view-certificates1.php');
    } else {
        echo "<script>alert('Data Updation failed');</script>";
    }
    mysqli_stmt_close($stmt);
}

    function delete($data, $links)
    {
        $deleteID = base64_decode($data);
        $query = "DELETE FROM daimond WHERE ID = ?";
        $stmt = mysqli_prepare($links, $query);
        mysqli_stmt_bind_param($stmt, "i", $deleteID);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            $_SESSION['msg'] = "Deleted Successfully";
            header('location:view-certificates1.php');
        } else {
            echo "<script>alert('Data Deletion failed');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>