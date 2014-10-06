<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {header ("Location: managerLogin.php");}
else
{
$con = mysql_connect("localhost","cik","mzuka");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Payments</title>
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
    <td width="70"><a href="index.html"</a>Home</td>
    <td width="130"><a href="managerLogin.php">Manager Login</a></td>
	<td width="100"><a href="contact.php">Contact us</a></td>
    <td>&nbsp;</td>
	<td><a href="logout.php">logout</a></td>
  </tr>
</table>
</div>
<a style="color:#000000" href="managerLogin.php">Manager login ></a>
<a style="color:#000000" href="manager_view.php">Manager View ></a>
<a style="color:#000000" href="payment.php">Payment > </a>
<div style="position:absolute;top:170pt;left:650pt">
<form role="form" name="formsearch">
<div class="form-group">
<table id="search-payment">
<tr>
<td>
Name:
</td>
<td>
<input class="form-control"  type="text" name="textpayment" id="textpayment" /></td>
<td>
<input class="btn btn-info"  type="button" value="Search" id="btnsearch" /></td>
</tr>
</table>
</div>
</form>
</div>
<h2> PAYMENTS </h2>
<?php
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);
$sql="SELECT orders.customers_name,orders.order_number,payments.phone_number,orders.subtotal
FROM orders
INNER JOIN payments
ON orders.O_ID=payments.O_ID";
$result = mysql_query($sql,$con);


echo '<div class="table-container">';
echo '<table border=\'1\' class="table table-striped table-hover" id="payments">
<tr bgcolor=grey>
<th >Customers Name</th>
<th >Order Id</th>
<th>Phone Number</th>
<th>Cash Payed</th>
</tr>';
while($row = mysql_fetch_assoc($result))
  {
  echo "<tr>";
  echo "<td>" . $row['customers_name'] . "</td>";
  echo "<td>" . $row['order_number'] . "</td>";  
  echo "<td>" . $row['phone_number'] . "</td>";
  echo "<td>" . $row['subtotal'] . "</td>";
  echo "</tr>";
  }
echo "</table>"; 
echo "</div>";
}

?>

<div class="anchor-container">
<div style="background-color:#FF0000" align="center">
Services
</div><br />
<a href="add.php">Add Records</a><br />
<br />
<a href="updateform.php">Update Records</a><br />
<br/>
<a href="delete.php">Delete Records</a><br />
<br />
<a href="viewOrders.php">View Orders</a><br />
<br />
<a href="report.php">Reports</a><br />
<br />
<a href="payment.php">Payments</a><br />
</div>
<script>
var  $table=$('#payments');
var tablecontents=$table.html();
function searchPayment(str)
{

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	var response=xmlhttp.responseText;
	if(!response)
	{
	$('#textpayment').focus().select();
	$('#btnsearch').notify('No such payment record exist!');
	document.getElementById("payments").innerHTML="";
	$('h2').html("No payments by '"+str+"'");
	return;
	}
    document.getElementById("payments").innerHTML=response;
	$('h2').html("Payments by '"+str+"'");
    }
  }
xmlhttp.open("GET","searchpayment.php?q="+str,true);
xmlhttp.send();
}
$('#btnsearch').click(function(){
var name= document.formsearch.textpayment.value;
$this=$(this);
if(!name){
$('#textpayment').focus();
document.getElementById("payments").innerHTML=tablecontents;
$this.notify("Specify a name!");
$('h2').html("PAYMENTS");
return;
}
searchPayment(name);
});
</script>
</body>
</html>