<?php
$data = json_decode($_POST['data'], TRUE);


$quantity= array();
$description=array();
$price= array();
$product_info=array();
$total_order=$data['total'];
$name=$data['name'];
$location=$data['location'];
$subtotal=array();
$total= $data['total'];
$branch=$data['branch'];
$order_id=md5($name.mt_rand(1,1000));
$row_oid=array();
foreach($data['items'] as $key => $value)
{

 $quantity[]=$value['quantity'];
 $description[]=$value['description'];
 $price[]=$value['price'];
 $subtotal[]=$value['subtotal'];
 $id[]=$value['pid'];  
}
//conect to the data base
$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
  
mysql_select_db("tumaini", $con);

for($j=0,$size=count($price);$j<$size;$j++)
{
$description1=$description[$j];
$price1=$price[$j];
$quantity1=$quantity[$j];
$p_id=$id[$j];
$subtotal1=$subtotal[$j];
$sql="INSERT INTO orders(customers_name,quantity,subtotal,order_number,location,P_ID,total_order)
VALUES
('$name','$quantity1','$subtotal1','$order_id','$location','$p_id','$total')";

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
<title>Check Out</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootstrap.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/notify.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.json-2.4.min.js"></script>
<link href="project.css" rel="stylesheet" type="text/css">

</head>

<body bgcolor='#CC99FF'>
<h1><img src="tumaini.png"/></h1>
<div class="header">
<table border="0">
  <tr>
    <td width="60"><a href="index.html">Home</a></td>
    <td width="130"><a href="managerLogin.php">Manager Login</a></td>
    <td><a href="contact.php">Contact us</a></td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<h2><?php echo $name?>:You have placed an order for:</h2>
<?php

$row=array($description,$price,$quantity,$subtotal);


 foreach ($row as $key=> $value)
 {
  foreach($value as $key1=>$value1 )
  {
  $product_info[]=$value1;
  }
  }
  
 
echo '<table id=\'orders_nairobi\' border=\'1\' class="table table-striped table-hover">
<tr bgcolor=grey>
<th >Description</th>
<th>Price</th>

<th>Quantity</th>

<th>Subtotal</th>
</tr>';

   for($j=0,$size=count($price);$j<$size;$j++)
  {
echo "<tr>";
  for ($i=$j,$size2=count($product_info);$i<$size2;$i+=count($description))
  {
  
  echo "<td>";
  echo $product_info[$i]; 
  echo "</td>";

  }
   echo "</tr>";
  
   
 
 }
 echo '<tr class="total"><td>Total:</td><td>&nbsp;</td><td>&nbsp;</td><td>'.$total.'</td></tr>';
 echo "</table>";
?>
<div class="checkout-heading">
<h3>
Pay via:
</h3>
</div>
<div>
<div class="checkout-heading">
<img src="mpesa.png"/>
</div>
<div class="checkout-heading">
<h4>
Paybill No: 444444
</h4>
</div>
<?php
 $sql1="SELECT * FROM orders WHERE order_number='$order_id'";
 $result1=mysql_query($sql1,$con);
 while($row = mysql_fetch_assoc($result1))
 {
 $row_oid[]=$row['O_ID'];
 }
 ?>
<form id="frmpayment" name="formpayment" role="form" action="thanx_kisumu.php" method="post">
<div class="form-group">
<table id="orders-table">
<?php echo '<div class="hiddenid">';
for($j=0,$idsize=count($row_oid);$j<$idsize;$j++)
{
echo '<input type="hidden" value="'.$row_oid[$j].'">';
}
echo '</div>';
 ?>

<div class="checkout-heading">
<tr>
<td>
<label>

Enter your Phone Number: </label></td>
<td>
<div class="col-xs-30">
<input class="form-control" type="text" name="phone"/>
</div>
</td>
<td>
<div class="checkout-heading">
<input class="btn btn-info payment" type="submit" value="Submit"/>
</div>
</td>
</tr>
<tr>
<td>
<label>
Enter the MPESA code:</label></td>
<td>
<div class="col-xs-30">
<input class="form-control" type="text" name="code"/>
</div>
</td>
</tr>
<tr>
<td>
<input type="hidden" name="data"/>
</td>
</tr>

</form>

<script type="text/javascript">
var ids={},i=0;
	$('.hiddenid')
	.children()
	.each(function(){
	
	ids[i]=($(this).val());
	i++;
	});
	
$('.payment').on(
'click',
function(evt)
{
    evt.preventDefault();
	
	
    var mpesacode=document.formpayment.code.value;
	var phoneno=document.formpayment.phone.value;
	
    var $this=$(this);
  var $form = $('#frmpayment'),$input = $form.find('input[name=data]');
     if(!phoneno)
    {
        $this.notify('Enter the phone number!!!');
        return;
    }
   if(!mpesacode)
    {
        $this.notify('Enter the mpesa code!!!');
        return;
    }
	var data={};
	
	data['iditems']=ids;
	data['mcode']=mpesacode;
	data['phonenumber']=phoneno;
	
	$input.val($.toJSON(data));
	$form.submit();
}
);
</script>
</body>
</html>