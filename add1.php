<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {header ("Location: managerLogin.php");}

$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);


$description= $_GET['q'];
$branch= $_GET['r'];
$price = $_GET['p'];
$unit = $_GET['u'];
$sql="INSERT INTO products(description,unit,price,branch)
VALUES
('$description','$unit','$price','$branch')";
$result = mysql_query($sql,$con);
if (!$result)
  {
  die(mysql_error());
  }
  echo "Record succesfully added";
?>