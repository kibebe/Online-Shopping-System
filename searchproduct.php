<?php
$q = $_GET['q'];
$p = $_GET['p'];

$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);
if($p=='desc')
{
$sql="SELECT * FROM products WHERE description = '".$q."'";
}
else{
$sql="SELECT * FROM products WHERE branch = '".$q."'";
}
$result = mysql_query($sql,$con);
$num_rows = mysql_num_rows($result);
if($num_rows>0){
echo '<div class="table-container">';
echo '<table border=\'1\' class="table table-striped table-hover" id="tableproducts">
<tr bgcolor=grey>
<th >Item No:</th>
<th >Description</th>
<th>Price</th>
<th>Branch</th>
</tr>';
while($row = mysql_fetch_assoc($result))
  {
  echo "<tr>";
  echo "<td>" . $row['P_ID'] . "</td>";
  echo "<td>" . $row['description'] . "</td>";  
  echo "<td>" . $row['price'] . "</td>";
  echo "<td>" . $row['branch'] . "</td>";
  echo "</tr>";
  }
echo "</table>"; 
echo "</div>";
}
?>