<?php
$q = $_GET['q'];
$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);

$sql="SELECT orders.customers_name, products.description, products.branch, products.price,orders.quantity, orders.subtotal,orders.order_number
FROM products
INNER JOIN orders
ON products.P_ID=orders.P_ID
WHERE customers_name = '".$q."'";
$result = mysql_query($sql,$con);
$num_rows = mysql_num_rows($result);
if($num_rows>0){
echo '<table  border=\'1\' class="table table-striped table-hover" id="vieworders">
<tr bgcolor=grey>
<th>Customers Name</th>
<th>Description</th>
<th>Branch</th>
<th>Price</th>
<th>Quantity</th>
<th>Total</th>
<th>Order Id</th>
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