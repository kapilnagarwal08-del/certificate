<?php 
$link = mysql_connect('111.118.177.43','kws_hfs_admin','data2020##');
if($link)
{
mysql_select_db('hiitindi_hfs');
}
else {
echo "<script>alert('connection falied')</script>";
}	
?>