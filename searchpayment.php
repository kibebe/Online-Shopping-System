<?php
$q = $_GET['q'];
$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);

$sql="SELECT orders.customers_name,orders.order_number,payments.phone_number,orders.subtotal
FROM orders
INNER JOIN payments
ON orders.O_ID=payments.O_ID
WHERE customers_name = '".$q."'";
$result = mysql_query($sql,$con);
$num_rows = mysql_num_rows($result);
if($num_rows>0){
echo '<table  border=\'1\' class="table table-striped table-hover" id="payments">
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

}
?>