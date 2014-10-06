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
<div style="position:absolute;top:158pt;left:650pt">
<form role="form" name="formsearch">
<div class="form-group">
<table id="search-product">
<tr>

<td>
<input class="form-control"  type="text" name="textproduct" id="textproduct" /></td>
<td>
<input class="btn btn-info"  type="button" value="Search" id="btnsearch" /></td>
<td>
<select id="productlist" name="productlist">
<option selected value="">Searh Criteria</option>
<option value="desc">Product Description</option>
<option value="branch">Product Branch</option>
</select>
</td>
</tr>
</table>
</div>
</form>
</div>


<h2> PRODUCTS AVAILABLE IN STORES </h2>
<?php
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);
$sql="SELECT * FROM products";
$result = mysql_query($sql,$con);


echo '<div class="table-container">';
echo '<table border=\'1\' class="table table-striped table-hover" id="tableproducts">
<tr bgcolor=grey>
<th>Item No:</th>
<th>Description</th>
<th>Unit</th>
<th>Price</th>
<th>Branch</th>
</tr>';
while($row = mysql_fetch_assoc($result))
  {
  echo "<tr>";
  echo "<td>" . $row['P_ID'] . "</td>";
  echo "<td>" . $row['description'] . "</td>";
  echo "<td>" . $row['unit'] . "</td>";  
  echo "<td>" . $row['price'] . "</td>";
  echo "<td>" . $row['branch'] . "</td>";
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
var $tablecontents=$('#tableproducts').html();
var $h2=$('h2').html();
function searchProduct(str,str1)
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
	$('#textproduct').focus().select();
	if(str1==='desc'){
	$('h2').html("'0' results for "+str);
	$('#btnsearch').notify('That product is not in stores!');
	}
	else{
	$('#btnsearch').notify('No such branch!');
	$('h2').html('Branch does not exist!');
	}
	document.getElementById("tableproducts").innerHTML="";
	return;
	}
	if(str1==='branch')
	$('h2').html('products available in '+str);
	else
	$('h2').html('Search results for '+str);
    document.getElementById("tableproducts").innerHTML=response;
    }
  }
xmlhttp.open("GET","searchproduct.php?q="+str+"&p="+str1,true);
xmlhttp.send();
}
$('#btnsearch').click(function(){
var name= document.formsearch.textproduct.value;
var criteria=document.formsearch.productlist.value;

$this=$(this);
if(!name){
$('#textproduct').focus();
document.getElementById("tableproducts").innerHTML=$tablecontents;
$('h2').html($h2);
$this.notify("Specify a branch or description!");
return;
}
if(!criteria){

document.getElementById("tableproducts").innerHTML=$tablecontents;
$this.notify("Choose the criteria of search!");
return;
}
searchProduct(name,criteria);
});
</script>
</body>
</html>
