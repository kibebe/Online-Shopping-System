<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Thank You</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootstrap.min.js"></script>
<link href="project.css" rel="stylesheet" type="text/css">

</head>

<body bgcolor='#CC99FF'>
<h1><img src="tumaini.png"/></h1>
<div class="header">
<table border="0">
  <tr>
    <td width="60"><a href="index.html"</a>Home</td>
    <td width="130"><a href="managerLogin.php">Manager Login</a></td>
	<td><a href="contact.php">Contact us</a></td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<?php
$data = json_decode($_POST['data'], TRUE);

$code=$data['mcode'];
$phone=$data['phonenumber'];
$order_id=$data['orderId'];


$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);


$sql="INSERT INTO payments(order_id,mpesa_code,phone_number)
VALUES
('$order_id','$code','$phone')";
$result = mysql_query($sql,$con);
if (!$result)
  {
  die(mysql_error());
  }
  else{
echo "<div class=\"checkout-heading\"><h2>Wait for an SMS confirmation</h2></div>";
exit;
}


?>
</body>
</html>
