<?php

session_start();

 class image

 {

	 function selectContent($link)

		{

			  $query="select * from images";

			 $res=mysqli_query($link, $query);

			 $infoArr=array();

			 $i=0;

			 while($row=mysqli_fetch_assoc($res))

			 {

				$infoArr[$i]['ID']=$row['id']; 

				$infoArr[$i]['image']=stripslashes($row['image']); 

				

				 

				$i++;	

			 }
	 return ($infoArr);

		}

		

	function add($data, $link)

		{
			
		$img_name   = $_FILES['image']['name'];

		$temp       = $_FILES['image']['tmp_name'];

		$ext = pathinfo($img_name, PATHINFO_EXTENSION);

		$imagefile=time().'.'.$ext;

		$target="uploads/".$imagefile;

		move_uploaded_file($temp,$target);

			$query="insert into `images`( `image`) values('$imagefile')";

 

			 $res=mysqli_query($link, $query);

			 if($res)

				 {

					    $_SESSION['msg']="Added  Successfully";

echo "<script>location='view-images.php'</script>";					

				 }

			 else

			 	 {

					 	echo "<script>alert('Data Insertion failed');</script>";

		

				 }

		 }	

		function delete($data, $link)

			{	

			    $deleteID=base64_decode($data);

				$query="delete from `images` where ID='$deleteID'";

				$res=mysqli_query($link, $query);

				if($res)

					{

						$_SESSION['msg']="Deleted Successfully";

						header('location:view-images.php');

					}

				else

					{

						echo "<script>alert('Data Deletion failed');</script>";

					}

			}

			

		

			

		

 }

 ?>