<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {header ("Location: managerLogin.php");}
?>
<html>
<head>
<title>Insert Records</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootstrap.min.js"></script>
<link href="project.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="js/notify.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootbox.min.js"></script>

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
<a style="color:#000000" href="add.php">Add ></a>
<h2 style="color:#66FF66"><b> Enter the product to be added below </h2>
<form id="form-add" role="form" name="formadd">
<div class="form-group">
<table id="add-table">
<tr>
  <td><label>description</label></td>
 <td> <input class="form-control" type="text" name="textdescribe" id="textdescribe"></td>
 </tr>
 <tr>
  <td><label>Unit</label></td>
 <td> <input class="form-control" type="text" name="textunit" id="textunit"></td>
 </tr>
 <tr>
  <td><label>price</label></td>
  <td><input class="form-control" type="text" name="textprice" id="textprice"></td>
  </tr>
  <tr>
  <td><label>branch</label></td>
  <td><input class="form-control" type="text" name="textbranch" id="textbranch"></td>
  </tr>
  <tr>
 
   <td> <label>
    <input class="btn btn-info" id="txtsubmit"  type="button" name="Submit" value="Add Record">
    </label></td>
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
<script type="text/javascript">

function addrecords(str,str1,str2,str3)
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
	bootbox.alert(response);
    }
  }
xmlhttp.open("GET","add1.php?q="+str+"&p="+str1+"&r="+str2+"&u="+str3,true);
xmlhttp.send();
}
$('#txtsubmit').on("click",function(){
var $describe=$('#textdescribe').val(),$price=$('#textprice').val(),$branch=$('#textbranch').val(),$unit=$('#textunit').val();
$price=parseInt($price,10);
if(!$describe||!$price||!$branch||!$unit){
$(this).notify("Fields must be filled!");
}
else if(typeof $price!='number'){
$(this).notify("Price should be numeric!");
$('#textprice').focus().select();
}
else{
addrecords($describe,$price,$branch,$unit);
}
})
  </script>
</body>
</html>