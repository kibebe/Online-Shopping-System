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
<title>Manager View</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="project.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootstrap.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/notify.min.js"></script>

</head>

<body>
<h1><img src="tumaini.png"/></h1>
<div class="header">
<table border="0">
  <tr>
    <td width="60"><a href="index.html"</a>Home</td>
    <td width="130"><a href="managerLogin.php">Manager Login</a></td>
	<td width="100"><a href="contact.php">Contact us</a></td>
    <td>&nbsp;</td>
	<td><a href="logout.php">logout</a></td>
  </tr>
</table>
</div>
<a style="color:#000000" href="managerLogin.php">Manager login ></a>
<a style="color:#000000" href="manager_view.php">Manager View ></a>
<a style="color:#000000" href="viewOrders.php">Orders ></a>
<div style="position:absolute;top:170pt;left:650pt">
<form role="form" name="formsearch">
<div class="form-group">
<table id="search_order">
<tr>
<td>
Name:
</td>
<td>
<input class="form-control"  type="text" name="textorder" id="textorder" /></td>
<td>
<input class="btn btn-info"  type="button" value="Search" id="btnsearch" /></td>
</tr>
</table>
</div>
</form>
</div>
<h2 style="color:#33FF00">ORDERS PLACED</h2>
<?php
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);
$sql="SELECT orders.customers_name, products.description, products.branch, products.price,orders.quantity, orders.subtotal,orders.order_number,
orders.total_order
FROM products
INNER JOIN orders
ON products.P_ID=orders.P_ID";
$result = mysql_query($sql,$con);



echo '<table  border=\'1\' class="table table-striped table-hover" id="vieworders">
<tr bgcolor=grey>
<th>Customers Name</th>
<th>Description</th>
<th>Branch</th>
<th>Price</th>
<th>Quantity</th>
<th>Total</th>
<th>Order Id</th>
<th>&nbsp;</th>
</tr>';
while($row = mysql_fetch_assoc($result))
  {
  echo '<tr data-order="' . $row['order_number'] .'">';
  echo "<td>" . $row['customers_name'] . "</td>";  
  echo "<td>" . $row['description'] . "</td>";
  echo "<td>" . $row['branch'] . "</td>";
  echo "<td>" . $row['price'] . "</td>";
  echo "<td>" . $row['quantity'] . "</td>";
  echo "<td>" . $row['subtotal'] . "</td>";
  echo "<td>" . $row['order_number'] . "</td>";
  echo "<td>" . '<input class="btn btn-info state" type="button"  value="Status" />' . "</td>";
  echo "</tr>";
  }
  
echo "</table>"; 
}
?>

<script>
var  $table=$('#vieworders');
var tablecontents=$table.html();
//function to search orders
function searchOrders(str)
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
	$('#textorder').focus().select();
	$('#btnsearch').notify('That order is not placed!');
	document.getElementById("vieworders").innerHTML="";
	$('h2').html("No  order placed by '"+str+"'");
	return;
	}
    document.getElementById("vieworders").innerHTML=response;
	$('h2').html("Order placed by '"+str+"'");
    }
  }
xmlhttp.open("GET","searchorder.php?q="+str,true);
xmlhttp.send();
}
//function of order status
function orderStatus(str,obj)
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
	
	obj.notify('PENDING!');
	
	}
	else
	{
    obj.notify('DELIVERED!');
	}
    }
  }
xmlhttp.open("GET","status.php?q="+str,true);
xmlhttp.send();
}
$('#btnsearch').click(function(){
var name= document.formsearch.textorder.value;
$this=$(this);
if(!name){
$('#textorder').focus();
document.getElementById("vieworders").innerHTML=tablecontents;
$this.notify("Specify a name!");
$('h2').html("ORDERS PLACED");
return;
}
searchOrders(name);
});
$(document).on("click",".state",function(){
var $this=$(this),$parent = $this.parents('tr').first();
var orderid=$parent.data('order');
orderStatus(orderid,$this);
});

</script>
</body>
</html>