
<html>
<head>
<title>Update form</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootstrap.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/notify.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.json-2.4.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/notify.min.js"></script>
<link href="project.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor='#CC99FF'>

<p>


<h1><img src="tumaini.png"/></h1>
<div class="header">
<table border="0">
  <tr>
    <td width="60"><a href="index.html">Home</a></td>
    <td width="130"><a href="managerLogin.php">Manager Login</a></td>
	<td width="100"><a href="contact.php">Contact us</a></td>
	<td><a href="logout.php">logout</a></td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</p>
<h2>Enter the price and update the product</h2>
<a style="color:#000000" href="managerLogin.php">Manager login ></a>
<a style="color:#000000" href="manager_view.php">Manager View ></a>
<a style="color:#000000" href="update.php">Update></a>
<?php
//connect to the database
$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);
$sql="SELECT * FROM products";
$result = mysql_query($sql,$con);
//products table
echo '<div class="update-container">';
echo '<table id=\'products\' border=\'1\' class="table table-striped table-hover">
<tr bgcolor=grey>
<th >Description</th>
<th>Branch</th>
<th>Price</th>
<th>&nbsp;</th>
</tr>';
while($row = mysql_fetch_assoc($result))
  {
  echo '<tr data-description="' . $row['description'] . '" data-id="' . $row['P_ID'] . '"data-branch="' . $row['branch'].'">';
  echo "<td style='width:120px'>" . $row['description'] . "</td>";  
  echo "<td style='width:120px'>" . $row['branch'] . "</td>";
  echo "<td style='width:120px'>" . '<div><input class="form-control price" name="txtprice" type="text" /></div>' . "</td>";
  echo "<td style='width:120px'>" . '<input class="btn btn-info update" type="button"  value="Update" />' . "</td>";

  echo "</tr>";
  }
echo "</table>";
echo "</div>";
echo '<form id="update-form" action="update.php" method="post"><input name="data" type="hidden"/></form>';
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
<script type="text/javascript">

$('.update').on(
'click',
function(evt)
{
    evt.preventDefault();
    var $this = $(this), $parent = $this.parents('tr').first(), price = $parent.find('.price').val(),description=$parent.data('description'),
	branch=$parent.data('branch'),$form = $('#update-form'),$input = $form.find('input[name=data]');
    if(parseInt(price, 10))
    {
      var data = {};
	  data['branch']=branch;
	  data['description']=description;
	  data['price']=price;
	  $input.val($.toJSON(data));
	  $form.submit();
    }
	else{
	$(this).notify("Price must be numeric and not zero or empty!");
	$parent.find('.price').focus().select();
	}
}
);


</script>
</body>
</html>


