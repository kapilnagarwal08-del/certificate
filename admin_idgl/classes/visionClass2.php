<?php
session_start();
class vision2
{
    function selectContent($link)
    {
        global $links;
        $query = "select * from gems";
        $res = mysqli_query($link, $query);
        $infoArr = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($res)) {
            $infoArr[$i] = [
                'ID' => $row['ID'],
                'category' => stripslashes($row['category']),
                'c_no' => stripslashes($row['c_no']),
                'supplier' => stripslashes($row['supplier']),
                'weight' => stripslashes($row['weight']),
                'shape' => stripslashes($row['shape']),
                'measurment' => stripslashes($row['measurment']),
                'color' => stripslashes($row['color']),
                'oc' => stripslashes($row['oc']),
                'rf' => stripslashes($row['rf']),
                'sg' => stripslashes($row['sg']),
                'mo' => stripslashes($row['mo']),
                'species' => stripslashes($row['species']),
                'variety' => stripslashes($row['variety']),
                'comment' => stripslashes($row['comment']),
                'stoneweight' => stripslashes($row['stoneweight']),
                'image' => $row['image'] ?? ''
            ];
            $i++;
        }
        return $infoArr;
    }

    function single($id, $link)
    {
        global $links;
        $query = "select * from `gems` where `c_no`='$id'";
        $res = mysqli_query($link, $query);
        $infoArr = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($res)) {
            $infoArr[$i] = [
                'ID' => $row['ID'],
                'category' => stripslashes($row['category']),
                'c_no' => stripslashes($row['c_no']),
                'supplier' => stripslashes($row['supplier']),
                'weight' => stripslashes($row['weight']),
                'shape' => stripslashes($row['shape']),
                'measurment' => stripslashes($row['measurment']),
                'color' => stripslashes($row['color']),
                'oc' => stripslashes($row['oc']),
                'rf' => stripslashes($row['rf']),
                'sg' => stripslashes($row['sg']),
                'mo' => stripslashes($row['mo']),
                'species' => stripslashes($row['species']),
                'variety' => stripslashes($row['variety']),
                'comment' => stripslashes($row['comment']),
                'stoneweight' => stripslashes($row['stoneweight']),
                'image' => $row['image'] ?? ''
            ];
            $i++;
        }
        return $infoArr;
    }

    function add($data, $link)
    {
        global $links;
        
        $c_no = mysqli_real_escape_string($link, $data['c_no']);
        $category = mysqli_real_escape_string($link, $data['category']);
        $weight = mysqli_real_escape_string($link, $data['weight']);
        $shape = mysqli_real_escape_string($link, $data['shape']);
        $measurment = mysqli_real_escape_string($link, $data['measurment']);
        $color = mysqli_real_escape_string($link, $data['color']);
        $oc = mysqli_real_escape_string($link, $data['oc']);
        $rf = mysqli_real_escape_string($link, $data['rf']);
        $sg = mysqli_real_escape_string($link, $data['sg']);
        $mo = mysqli_real_escape_string($link, $data['mo']);
        $species = mysqli_real_escape_string($link, $data['species']);
        $variety = mysqli_real_escape_string($link, $data['variety']);
        $comment = mysqli_real_escape_string($link, $data['comment']);
        $stoneweight = mysqli_real_escape_string($link, $data['stoneweight']);
        $imagefile = '';

        if (!empty($_FILES['image']['name'])) {
            $img_name = $_FILES['image']['name'];
            $temp = $_FILES['image']['tmp_name'];
            $ext = pathinfo($img_name, PATHINFO_EXTENSION);
            $imagefile = time().'.'.$ext;
            $target = "../uploads/".$imagefile;
            move_uploaded_file($temp, $target);
        }

        $query = "INSERT INTO `gems` (`c_no`, `category`, `weight`, `shape`, `measurment`, `color`, `oc`, `rf`, `sg`, `mo`, `species`, `variety`, `comment`, `stoneweight`, `image`) 
                  VALUES ('$c_no','$category', '$weight','$shape','$measurment','$color','$oc','$rf','$sg','$mo','$species','$variety','$comment','$stoneweight','$imagefile')";

        $res = mysqli_query($link, $query);
        if ($res) {
            $_SESSION['msg'] = "Added Successfully";
            echo "<script>location='view-certificates2.php'</script>";
        } else {
            echo "<script>alert('Data Insertion failed');</script>";
        }
    }

    function edit($data, $link)
    {
        global $links;
        $editID = base64_decode($data);
        $query = "select * from `gems` where ID='$editID'";
        $res = mysqli_query($link, $query);
        $infoArr = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($res)) {
            $infoArr[$i] = [
                'ID' => $row['ID'],
                'category' => stripslashes($row['category']),
                'c_no' => stripslashes($row['c_no']),
                'supplier' => stripslashes($row['supplier']),
                'weight' => stripslashes($row['weight']),
                'shape' => stripslashes($row['shape']),
                'measurment' => stripslashes($row['measurment']),
                'color' => stripslashes($row['color']),
                'oc' => stripslashes($row['oc']),
                'rf' => stripslashes($row['rf']),
                'sg' => stripslashes($row['sg']),
                'mo' => stripslashes($row['mo']),
                'species' => stripslashes($row['species']),
                'variety' => stripslashes($row['variety']),
                'comment' => stripslashes($row['comment']),
                'stoneweight' => stripslashes($row['stoneweight']),
                'image' => $row['image'] ?? ''
            ];
            $i++;
        }
        return $infoArr;
    }

    function update($data, $link)
    {
        global $links;
        
        $id = base64_decode($data['editid']);
        $c_no = mysqli_real_escape_string($link, $data['c_no']);
        $category = mysqli_real_escape_string($link, $data['category']);
        $weight = mysqli_real_escape_string($link, $data['weight']);
        $shape = mysqli_real_escape_string($link, $data['shape']);
        $measurment = mysqli_real_escape_string($link, $data['measurment']);
        $color = mysqli_real_escape_string($link, $data['color']);
        $oc = mysqli_real_escape_string($link, $data['oc']);
        $rf = mysqli_real_escape_string($link, $data['rf']);
        $sg = mysqli_real_escape_string($link, $data['sg']);
        $mo = mysqli_real_escape_string($link, $data['mo']);
        $species = mysqli_real_escape_string($link, $data['species']);
        $variety = mysqli_real_escape_string($link, $data['variety']);
        $comment = mysqli_real_escape_string($link, $data['comment']);
        $stoneweight = mysqli_real_escape_string($link, $data['stoneweight']);

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

            $query = "update `gems` set `c_no`='$c_no', `weight`='$weight',`shape`='$shape',`measurment`='$measurment',`color`='$color',`oc`='$oc',`rf`='$rf',`sg`='$sg',`mo`='$mo',`species`='$species',`variety`='$variety',`comment`='$comment',`stoneweight`='$stoneweight', `image`='$imagefile' where ID='$id'";
        } else {
            $query = "update `gems` set `c_no`='$c_no', `weight`='$weight',`shape`='$shape',`measurment`='$measurment',`color`='$color',`oc`='$oc',`rf`='$rf',`sg`='$sg',`mo`='$mo',`species`='$species',`variety`='$variety',`comment`='$comment',`stoneweight`='$stoneweight' where ID='$id'";
        }
        
        $res = mysqli_query($link, $query);
        
        if ($res) {
            $_SESSION['msg'] = "Updated Successfully";
            header('location:view-certificates2.php');
        } else {
            echo "<script>alert('Data Updation failed');</script>";
        }
    }

    function delete($data, $link)
    {   
        global $links;
        $deleteID = base64_decode($data);
        
        // Get image info before deletion
        $query = "SELECT image FROM `gems` WHERE ID='$deleteID'";
        $res = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($res);
        $image = $row['image'] ?? '';
        
        // Delete the record
        $query = "delete from `gems` where ID='$deleteID'";
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
            header('location:view-certificates2.php');
        } else {
            echo "<script>alert('Data Deletion failed');</script>";
        }
    }
}
?>