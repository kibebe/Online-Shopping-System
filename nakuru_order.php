<?php


$sql="INSERT INTO orders(customers_name,description,branch,price,quantity,total_order)
VALUES
('$_POST[txtcname]','$_POST[txtdescribe]','$_POST[txtbranch]','$_POST[txtprice]','$_POST[txtqty]')";
if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
  else{
echo "<strong>Your order has been placed. Thank you</strong>";
mysql_close($con);
}




?>