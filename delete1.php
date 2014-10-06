<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {header ("Location: managerLogin.php");}
else
{
$q = $_GET['q'];


$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);




$sql="DELETE FROM products WHERE P_ID ='".$q."'";
$result = mysql_query($sql,$con);
$num_rows=mysql_affected_rows();
if (!$result)
  {
  die(mysql_error());
  }
  if($num_rows==1){
 echo "Deleted";
  }
  
  }
?>