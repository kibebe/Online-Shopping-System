<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {header ("Location: managerLogin.php");}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Delete Rcords</title>
<script type="text/javascript" src="jquery.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="js/bootstrap.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/notify.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootbox.min.js"></script>
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
<a style="color:#000000" href="delete.php">Delete form > </a>

<h2 style="color:#66FF33">
Enter the item no to delete the product from the database.
</h2>

<form role="form" name="formdelete">
<div class="form-group">
<table id="delete-table">
   <tr>
   <td>
   Item no:
   </td>
   <td>
  <input  class="form-control" type="text" name="txtitem" id="txtdelete">
  </td>
  </tr>
  <tr>
  <td>
  <input class="btn btn-info" type="button" name="Submit" value="Delete Product"  id="deleterec">
   </td>
   </tr>
   </table>
   </div> 
  
</form>

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
var status=false;
function deleterecords(str)
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
	$('#deleterec').notify("The record specified does not exist");
	$('#txtdelete').focus().select();
	
	}
	else{
   $('#deleterec').notify("Record deleted!");
   $('#txtdelete').focus().select();
   }
    }
  }
xmlhttp.open("GET","delete1.php?q="+str,true);
xmlhttp.send();
}
$('#deleterec').on("click",function(){
var itemno= document.formdelete.txtitem.value;
$this=$(this);
if(!itemno){
$('#txtdelete').focus();
$('#deleterec').notify("Specify item no:!");
}
else if(!(parseInt(itemno, 10))){
$('#txtdelete').focus();
$('#deleterec').notify("Item no should be a digit:!");
}
else
{
status=confirm("Are you sure you want to delete?");
if(!!status){
deleterecords(itemno);
}
else{
$('#txtdelete').focus().select();
}
}
});
</script>
</body>
</html>
