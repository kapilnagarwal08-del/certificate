<?php class user_class
 {	 	 	 function selectContent()		{			  $query="select * from user";			 $res=mysql_query($query);			 $infoArr=array();			 $i=0;			 while($row=mysql_fetch_assoc($res))			 {				$infoArr[$i]['ID']=$row['ID']; 				$infoArr[$i]['fname']=stripslashes($row['fname']); 				$infoArr[$i]['lname']=stripslashes($row['lname']); 				$infoArr[$i]['email']=stripslashes($row['email']); 				$infoArr[$i]['password']=stripslashes($row['password']); 				$infoArr[$i]['status']=stripslashes($row['status']); 								$i++;				 }		// echo '<pre>'; print_r($infoArr); exit;			 return ($infoArr);		}				function checkLogin($data)
		{
			
			 $name=$data['username'];
			 $pass=$data['password'];
			 $name=mysql_real_escape_string($name);
			 $passinc=mysql_real_escape_string($pass);
			
			$query="SELECT * FROM admin WHERE username = '".$name."' AND password = '".$passinc."'";
			$result=mysql_query($query);
			$numrows=mysql_num_rows($result);
			if($numrows>0)
				{
					
             $_SESSION['name']=$data['username'];
             header("location:index.php");
				}
			else
				{
					 echo "<script>alert('Incorrect username or password');</script>";
				} 
		}
		
		
		
       function changepwd($data)
	{
	
		 $oldpwd=$data['old_password'];
		 $newpwd=$data['password'];
		 $query="select * from admin where password='$oldpwd'";
		
		$res=mysql_query($query);
		$numrows=mysql_num_rows($res);
		
		
		if($numrows>0)
			{
				 $query1="update admin set password='$newpwd'";
				$res1=mysql_query($query1);
				if($res1)
				{
					echo "<script>alert('password has changed');</script>";
				}
				else
				{
					echo "<script>alert('Error occured!');</script>";
				}
			}
			else 
			{
				echo "<script>alert('Old password is not correct');</script>";
			}
	}
	
	 function logout()
		{
			$_SESSION = array();
			unset($_SESSION);
		}
		
		
		function registeruser($data)
			{
			
				 $fname		=	$data['fname'];				 $lname		=	$data['lname'];                 $email		=	$data['email'];                $pass1		=	$data['password'];
				$query="SELECT * FROM user WHERE email= ".$email."'";
				$result=mysql_query($query);
				$numrows=mysql_num_rows($result);
				if($numrows>0)
					{
						$_SESSION['msg']="Sorry user already registered with us ! to get password click on forgot password link";						echo "<script>alert('Sorry user already registered with us ! to get password click on forgot password link'); location='index.php';</script>";
					//	header("location:index.php");
					}
					
				else
					{
						$queryresult==mysql_query("insert into user(`fname`,`lname`,`email`,`password`) values ('$fname','$lname','$email','$pass1')");
						
						if($queryresult)
						{echo "<script> location='email-varification.php';</script>";
						}
						
					} 
			}
		function edit($data)			{					$editID=base64_decode($data);				    $query="select * from `user` where ID='$editID'";					$res=mysql_query($query);					$infoArr=array();					$i=0;					while($row=mysql_fetch_assoc($res))					{					$infoArr[$i]['ID']=$row['ID'];					$infoArr[$i]['fname']=$row['fname'];					$infoArr[$i]['lname']=$row['lname'];					 					$infoArr[$i]['email']=$row['email']; 					$infoArr[$i]['password']=$row['password']; 					$infoArr[$i]['status']=$row['status']; 											$i++;						}				    // echo '<pre>'; print_r($infoArr); exit;				    return ($infoArr);			}						function update($data)			{						 $id=base64_decode($data['editid']);			 $fname=$data['fname'];			 $lname=mysql_real_escape_string($data['lname']);			$email=mysql_real_escape_string($data['email']);			 			 $password=mysql_real_escape_string($data['password']);			 			 $status=mysql_real_escape_string($data['status']);			 				 $query="update `user` set `fname`='$fname',`lname`='$lname',`email`='$email',`password`='$password',`status`='$status' where ID='$id'";														$res=mysql_query($query);										if($res)							{								$_SESSION['msg']="Updated Successfully";							   header('location:viewusers.php');							}							else							{								echo "<script>alert('Data Updation failed');</script>";							}				}												function delete($data)			{				    $deleteID=base64_decode($data);				$query="delete from `user` where ID='$deleteID'";				$res=mysql_query($query);				if($res)					{						$_SESSION['msg']="Deleted Successfully";						header('location:viewusers.php');					}				else					{						echo "<script>alert('Data Deletion failed');</script>";					}			}											
 }
 ?>