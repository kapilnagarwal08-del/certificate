<?php
session_start();
class Userclass
{
	
	
	 function selectUser()
		{
			  $query="select * from user";
			 $res=mysql_query($query);
			 $infoArr=array();
			 $i=0;
			 while($row=mysql_fetch_assoc($res))
			 {
				$infoArr[$i]['ID']=$row['ID']; 
				$infoArr[$i]['name']=$row['name']; 
				$infoArr[$i]['phone']=$row['phone'];
				$infoArr[$i]['email']=$row['email'];
				$infoArr[$i]['password']=$row['password'];
				$infoArr[$i]['city']=$row['city'];
				$i++;	
			 }
		// echo '<pre>'; print_r($infoArr); exit;
			 return ($infoArr);
		}
	
	function selectregisteredUser()
		{
			  $query="select * from user where status=1";
			 $res=mysql_query($query);
			 $infoArr=array();
			 $i=0;
			 while($row=mysql_fetch_assoc($res))
			 {
				$infoArr[$i]['ID']=$row['ID']; 
				$infoArr[$i]['name']=$row['name']; 
				$infoArr[$i]['phone']=$row['phone'];
				$infoArr[$i]['email']=$row['email'];
				$infoArr[$i]['password']=$row['password'];
				$infoArr[$i]['city']=$row['city'];
				$i++;	
			 }
		// echo '<pre>'; print_r($infoArr); exit;
			 return ($infoArr);
		}
	
	
	
	function checkLogin($data)
	{
 
	    $query="select * from admin where username='$data[username]' and password='$data[password]'";
        $result=  mysql_query($query);
        $num=  mysql_num_rows($result);
        if($num>0)
        {
             $_SESSION['name']=$data['username'];
         echo   "<script> location.replace('index.php'); </script>";
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
				echo "<script>alert('password doesnt match');</script>";
			}
	}
	
	
	function registeruser($data)
		{
			$name		=	$data['name'];
			$phone		=	$data['phone'];
			$city		=	$data['city'];
			$address	=	$data['address'];
			$email		=	$data['email'];
			$password	=	$data['password'];
			$password1	=	$data['password1'];
		
		    $checkemail=mysql_query("select * from user where `email`='$email'");
			$numrows=mysql_num_rows($checkemail);
			
			
			if($numrows>0)
			{
				echo "<script>alert('Sorry EmailID already registered !')</script>";
			}
				
			else
			{
				$query=mysql_query("insert into user (`name`,`phone`,`city`,`address`,`email`,`password`,`status`) values ('$name','$phone','$city','$address','$email','$password','0')");
			
			if($query)
			{
				
		
$to = $email;
$fromemail="info@articence.com";
$subject = "Verify your Registration";

$message = "
<html>
<head>
<title>Account Verification</title>
</head>
<body>
<p>This is an automated email.Please Do Not reply to this email. Click below or paste it into your browser http://kawill.in/articence/success.php?articence_user=$email</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <info@articence.com>' . "\r\n";

$mailres=mail($to,$subject,$message,$headers);

if($mailres)
{
	echo "<script>alert('Please check your email to verify your registration.')</script>";
}

			}
			
				else
					{
						echo "<script>alert('Sorry unable to process ! Try Again')</script>";
					}
			
				}
			}
		
		
		function userlogin($data)
		{
			$email 		= $data['email'];
			$password   = $data['password'];
			
			$query=mysql_query("select * from user where email='$email' and password='$password' and status='1'");
			
			$count=mysql_num_rows($query);
			if($count>0)
			{
				$_SESSION['articence_user']=$email;
				header('location:index.php');
			}
			
			else
			{
				echo "<script>alert('Incorrect Email or Password . Try Again')</script>";
			}
		}

		function resetpassword($data)
		{

			$email 		= $data['email'];
			$query=mysql_query("select * from user where email='$email'");
			$count=mysql_num_rows($query);
			$row=mysql_fetch_array($query);
			if($count>0)
			{
				$password=$row['password'];

				$to = $row['email'];
				$subject="Articence Login Password";
				$message="Your Password for Login : $password";
				$headers = "From: info@articence.com" . "\r\n";
                $delivery=mail($to,$subject,$message,$headers);

					
					if($delivery)
					{
						echo "<script>alert('Please check your mail to get password.')</script>";
					}
				}
			else
				{
					echo "<script>alert('Please Enter Registered Email-ID')</script>";
				}
		     }
			 
			 
			 function deactivateuser($data)
			 {
				 
				 
				 
				
				 $res = mysql_query("update `user` set `status`=0 where ID=$data");
				 if($res)
				 {
					 echo "<script>alert('User Deactivated successfully.')</script>";
				 }
				 else
				 {
					  echo "<script>alert('Operation Failed')</script>";
				 }
			 }
         }
?> 