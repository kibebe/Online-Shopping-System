<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {header ("Location: managerLogin.php");}
else
{
$data = json_decode($_POST['data'], TRUE);
$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);

$description= $data['description'];
$branch= $data['branch'];
$price = $data['price'];
$sql="UPDATE products SET price = '$price' WHERE description = '$description' AND branch = '$branch'";
$result = mysql_query($sql,$con);
if (!$result)
  {
  die(mysql_error());
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recorded updated</title>
<head>
<script type="text/javascript" src="jquery.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="js/bootstrap.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/notify.min.js"></script>
<link href="project.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1><img src="tumaini.png"/></h1>
<div class="header">
<table border="0">
  <tr>
    <td width="60"><a href="index.html"</a>Home</td>
    <td width="130"><a href="managerLogin.php">Manager Login</a></td>
	<td width="100"><a href="contact.php">Contact us</a></td>
	<td><a href="logout.php">logout</a></td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<a style="color:#000000" href="managerLogin.php">Manager login ></a>
<a style="color:#000000" href="manager_view.php">Manager View ></a>
<a style="color:#000000" href="update.php">Update></a>
</br><p style="color:#FF0000;text-align:center"><strong>Record Updated. Thank you</strong></p>;

</body>
</html>
