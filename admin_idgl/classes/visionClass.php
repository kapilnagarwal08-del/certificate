<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class vision
{
    function selectContent($link)
    {
        $query = "SELECT * FROM vision";
        $res = mysqli_query($link, $query);
        $infoArr = [];

        while ($row = mysqli_fetch_assoc($res)) {
            $infoArr[] = [
                'ID' => $row['ID'],
                'category' => stripslashes($row['category']),
                'c_no' => stripslashes($row['c_no']),
                'supplier' => stripslashes($row['supplier']),
                'description' => stripslashes($row['description']),
                'design_no' => stripslashes($row['design_no']),
                'grossweight' => stripslashes($row['grossweight']),
                'diamondweight' => stripslashes($row['diamondweight']),
                'shape' => stripslashes($row['shape']),
                'no_of_diamon' => stripslashes($row['no_of_diamon']),
                'color' => stripslashes($row['color']),
                'clarity' => stripslashes($row['clarity']),
                'comment' => stripslashes($row['comment']),
                'image' => $row['image'] ?? ''
            ];
        }

        return $infoArr;
    }

    function selectbyStatus($link)
    {
        $query = "SELECT * FROM vision WHERE `status` = 1";
        $res = mysqli_query($link, $query);
        $infoArr = [];

        while ($row = mysqli_fetch_assoc($res)) {
            $infoArr[] = [
                'ID' => $row['ID'],
                'category' => stripslashes($row['category']),
                'c_no' => stripslashes($row['c_no']),
                'description' => stripslashes($row['description']),
                'grossweight' => stripslashes($row['grossweight']),
                'diamondweight' => stripslashes($row['diamondweight']),
                'shape' => stripslashes($row['shape']),
                'color' => stripslashes($row['color']),
                'clarity' => stripslashes($row['clarity']),
                'image' => $row['image'] ?? ''
            ];
        }

        return $infoArr;
    }

    function single($id, $link)
    {
        $query = "SELECT * FROM `vision` WHERE `c_no`='$id'";
        $res = mysqli_query($link, $query);
        $infoArr = [];

        while ($row = mysqli_fetch_assoc($res)) {
            $infoArr[] = [
                'ID' => $row['ID'],
                'category' => stripslashes($row['category']),
                'c_no' => stripslashes($row['c_no']),
                'description' => stripslashes($row['description']),
                'grossweight' => stripslashes($row['grossweight']),
                'diamondweight' => stripslashes($row['diamondweight']),
                'shape' => stripslashes($row['shape']),
                'color' => stripslashes($row['color']),
                'clarity' => stripslashes($row['clarity']),
                'supplier' => stripslashes($row['supplier']),
                'design_no' => stripslashes($row['design_no']),
                'no_of_diamon' => stripslashes($row['no_of_diamon']),
                'comment' => stripslashes($row['comment']),
                'image' => $row['image'] ?? ''
            ];
        }

        return $infoArr;
    }

    function add($data, $link)
    {
        $c_no = mysqli_real_escape_string($link, $data['c_no']);
        $category = mysqli_real_escape_string($link, $data['category']);
        $description = mysqli_real_escape_string($link, $data['description']);
        $grossweight = mysqli_real_escape_string($link, $data['grossweight']);
        $diamondweight = mysqli_real_escape_string($link, $data['diamondweight']);
        $shape = mysqli_real_escape_string($link, $data['shape']);
        $color = mysqli_real_escape_string($link, $data['color']);
        $clarity = mysqli_real_escape_string($link, $data['clarity']);
        $comment = mysqli_real_escape_string($link, $data['comment']);
        $imagefile = '';

        if (!empty($_FILES['image']['name'])) {
            $img_name = $_FILES['image']['name'];
            $temp = $_FILES['image']['tmp_name'];
            $ext = pathinfo($img_name, PATHINFO_EXTENSION);
            $imagefile = time().'.'.$ext;
            $target = "../uploads/".$imagefile;
            move_uploaded_file($temp, $target);
        }

        $query = "INSERT INTO `vision` (`c_no`, `description`, `grossweight`, `diamondweight`, `shape`, `color`, `clarity`, `category`, `comment`, `image`) 
                  VALUES ('$c_no', '$description', '$grossweight', '$diamondweight', '$shape', '$color', '$clarity', '$category', '$comment', '$imagefile')";

        $res = mysqli_query($link, $query);

        if ($res) {
            $_SESSION['msg'] = "Added Successfully";
            header('location:view-certificates.php');
            exit;
        } else {
            echo "<script>alert('Data Insertion failed');</script>";
        }
    }

    function edit($data, $link)
    {
        $editID = base64_decode($data);
        $query = "SELECT * FROM `vision` WHERE ID='$editID'";
        $res = mysqli_query($link, $query);
        $infoArr = [];

        while ($row = mysqli_fetch_assoc($res)) {
            $infoArr[] = [
                'ID' => $row['ID'],
                'c_no' => stripslashes($row['c_no']),
                'description' => stripslashes($row['description']),
                'grossweight' => stripslashes($row['grossweight']),
                'diamondweight' => stripslashes($row['diamondweight']),
                'shape' => stripslashes($row['shape']),
                'color' => stripslashes($row['color']),
                'clarity' => stripslashes($row['clarity']),
                'category' => stripslashes($row['category']),
                'supplier' => stripslashes($row['supplier']),
                'design_no' => stripslashes($row['design_no']),
                'no_of_diamon' => stripslashes($row['no_of_diamon']),
                'image' => $row['image'] ?? '',
                'comment' => stripslashes($row['comment'])
            ];
        }

        return $infoArr;
    }

    function update($data, $link)
    {
        $id = base64_decode($data['editid']);
        $c_no = mysqli_real_escape_string($link, $data['c_no']);
        $description = mysqli_real_escape_string($link, $data['description']);
        $grossweight = mysqli_real_escape_string($link, $data['grossweight']);
        $diamondweight = mysqli_real_escape_string($link, $data['diamondweight']);
        $category = mysqli_real_escape_string($link, $data['category']);
        $shape = mysqli_real_escape_string($link, $data['shape']);
        $color = mysqli_real_escape_string($link, $data['color']);
        $clarity = mysqli_real_escape_string($link, $data['clarity']);
        $comment = mysqli_real_escape_string($link, $data['comment']);

        // Get existing image info
        $existing = $this->edit($data['editid'], $link);
        $existingImage = $existing[0]['image'] ?? '';

        if (!empty($_FILES['image']['name'])) {
            // Delete old image if exists
            if (!empty($existingImage)) {
                $oldFilePath = "../uploads/".$existingImage;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            
            // Upload new image
            $img_name = $_FILES['image']['name'];
            $temp = $_FILES['image']['tmp_name'];
            $ext = pathinfo($img_name, PATHINFO_EXTENSION);
            $imagefile = time().'.'.$ext;
            $target = "../uploads/".$imagefile;
            move_uploaded_file($temp, $target);

            $query = "UPDATE `vision` SET `c_no`='$c_no', `description`='$description', `grossweight`='$grossweight', `diamondweight`='$diamondweight',
                     `shape`='$shape', `color`='$color', `clarity`='$clarity', `category`='$category', `comment`='$comment', `image`='$imagefile' 
                      WHERE ID='$id'";
        } else {
            $query = "UPDATE `vision` SET `c_no`='$c_no', `description`='$description', `grossweight`='$grossweight', `diamondweight`='$diamondweight',
                     `shape`='$shape', `color`='$color', `clarity`='$clarity', `category`='$category', `comment`='$comment'
                      WHERE ID='$id'";
        }

        $res = mysqli_query($link, $query);

        if ($res) {
            $_SESSION['msg'] = "Updated Successfully";
            header('location:view-certificates.php');
            exit;
        } else {
            echo "<script>alert('Data Updation failed');</script>";
        }
    }

    function delete($data, $link)
    {   
        $deleteID = base64_decode($data);
        
        // Get image info before deletion
        $query = "SELECT image FROM `vision` WHERE ID='$deleteID'";
        $res = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($res);
        $image = $row['image'] ?? '';
        
        // Delete the record
        $query = "DELETE FROM `vision` WHERE ID='$deleteID'";
        $res = mysqli_query($link, $query);

        if ($res) {
            // Delete the image file if exists
            if (!empty($image)) {
                $filePath = "../uploads/".$image;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            $_SESSION['msg'] = "Deleted Successfully";
            header('location:view-certificates.php');
            exit;
        } else {
            echo "<script>alert('Data Deletion failed');</script>";
        }
    }
}
?>