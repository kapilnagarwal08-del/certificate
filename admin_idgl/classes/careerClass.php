<?php
 session_start();
 class career
 {
    function select()
		{
			 $query="select * from career";
			 $res=mysql_query($query);
			 $infoArr=array();
			 $i=0;
			 while($row=mysql_fetch_assoc($res))
			 {
				$infoArr[$i]['ID']=$row['ID']; 
				$infoArr[$i]['content']=$row['content']; 
				$i++;	
			 }
			//  echo '<pre>'; print_r($infoArr); exit;
			 return ($infoArr);
		}
		
	
		
		function update($data)
			{
				$id				=	$data['editid'];
				$content		=	mysql_real_escape_string($data['content']);
				 $query="update career set `content`='$content' where ID='$id'";

				 $res=mysql_query($query);
				 if($res)
					 {
						  $_SESSION['msg']="Content Updated Successfully";
						  header('location:add-career.php');
					 }
				 else
					 {
							echo "<script>alert('Data Updation failed');</script>";
					 }	
			}
			
		
			
		function delete($data)
			{	
				$deleteID = base64_decode($data);
				$query="delete from content where ID='$deleteID'";
				$res=mysql_query($query);
				if($res)
					{
						$_SESSION['msg']="Content Deleted Successfully";
										 header('location:view-content.php');
					}
				else
					{
						echo "<script>alert('Data Deletion failed');</script>";
					}
			}
			
			
			
			
			
			
			function catName($id)
			{
				$query=mysql_query("select * from category where ID='$id'");
				$row=mysql_fetch_array($query);
				echo $row['category'];
			}
			
			function subcatName($id)
			{
				$query=mysql_query("select * from subcategory where ID='$id'");
				$row=mysql_fetch_array($query);
				echo $row['subcategory'];
			}
			
			
			
			function getContent($catID,$subcatID)
				{
					 $query="select * from content where catID='$catID' and subcatID='$subcatID'";
					 $res=mysql_query($query);
					 $infoArr=array();
					 $i=0;
					 $count=mysql_num_rows($res);
					 
					 if($count>0)
					 {
					 while($row=mysql_fetch_assoc($res))
					 {
						$infoArr[$i]['ID']		=$row['ID']; 
						$infoArr[$i]['catID']	=$row['catID']; 
						$infoArr[$i]['subcatID']=$row['subcatID']; 
						$infoArr[$i]['image']	=$row['image']; 
						$infoArr[$i]['content'] =stripslashes($row['content']);
						$infoArr[$i]['meta_title']=stripslashes($row['meta_title']);
						$infoArr[$i]['meta_keyword']=stripslashes($row['meta_keyword']);
						$infoArr[$i]['meta_description']=stripslashes($row['meta_description']);
						$i++;	
					 }
					//  echo '<pre>'; print_r($infoArr); exit;
					return ($infoArr);
					}
					else
					{
						$_SESSION['msg']="Coming Soon";
					}
		}
 }
 ?>