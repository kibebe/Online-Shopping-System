<?php
require('FPDF\fpdf.php');

class PDF extends FPDF
{

// Page header
function Header()
{
    // Logo
    $this->Image('tumaini.png',30,6,150);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    
    // Line break
    $this->Ln(25);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}


//payment table
function paymentTable($header)
{
$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);
$sql="SELECT orders.customers_name,payments.phone_number,orders.subtotal
FROM orders
INNER JOIN payments
ON orders.O_ID=payments.O_ID";
$result = mysql_query($sql,$con);
   

    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255,0,0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
	$this->Cell(170,7,'PAYMENTS',0,1,'C',0);
	$this->Ln(5);
	$this->SetTextColor(255);
	$this->SetX(40);
    // Header
    $w = array(45, 45, 40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
	
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;

    while($row = mysql_fetch_assoc($result))
    {
        $this->SetX(40);
		$this->Cell($w[0],6,$row['customers_name'],'LR',0,'C',$fill);
		$this->Cell($w[1],6,$row['phone_number'],'LR',0,'C',$fill);
        $this->Cell($w[2],6,$row['subtotal'],'LR',0,'C',$fill);
         
       
        $this->Ln();
        $fill = !$fill;
		
    }
    // Closing line
	$this->SetX(40);
    $this->Cell(array_sum($w),0,'','T');
}

//product table
function ProductTable($header)
{
$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);
$sql="SELECT * FROM products ORDER BY branch";
$result = mysql_query($sql,$con);
   

    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255,0,0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
	$this->Cell(170,7,'PRODUCTS',0,1,'C',0);
	$this->Ln(5);
	$this->SetTextColor(255);
	$this->SetX(40);
    // Header
    $w = array(40, 35, 40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
	
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;

    while($row = mysql_fetch_assoc($result))
    {
        $this->SetX(40);
		$this->Cell($w[0],6,$row['description'],'LR',0,'C',$fill);
		$this->Cell($w[1],6,number_format($row['price']),'LR',0,'C',$fill);
        $this->Cell($w[2],6,$row['branch'],'LR',0,'C',$fill);
         
       
        $this->Ln();
        $fill = !$fill;
		
    }
    // Closing line
	$this->SetX(40);
    $this->Cell(array_sum($w),0,'','T');
}
//order table
function OrderTable($header)
{
$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);
$sql="SELECT orders.customers_name, products.description, products.branch, products.price,orders.quantity, orders.subtotal
FROM products
INNER JOIN orders
ON products.P_ID=orders.P_ID ORDER BY branch";
$result = mysql_query($sql,$con);
   

    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255,0,0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
	$this->Cell(170,7,'ORDERS',0,1,'C',0);
	$this->Ln(5);
	$this->SetTextColor(255);
	
    // Header
    $w = array(45,35,40,15,10,30);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
	
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;

    while($row = mysql_fetch_assoc($result))
    {
        
		$this->Cell($w[0],6,$row['customers_name'],'LR',0,'C',$fill);
		$this->Cell($w[1],6,$row['description'],'LR',0,'C',$fill);
        $this->Cell($w[2],6,$row['branch'],'LR',0,'C',$fill);
		$this->Cell($w[3],6,number_format($row['price']),'LR',0,'C',$fill);
		$this->Cell($w[4],6,number_format($row['quantity']),'LR',0,'C',$fill);
		$this->Cell($w[5],6,$row['subtotal'],'LR',0,'C',$fill);
        
       
        $this->Ln();
        $fill = !$fill;
		
    }
    // Closing line
	
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
$pdf->AliasNbPages();
// Column headings
$header = array('Description', 'Price', 'Branch');
$header1= array('Customers Name','Description','Branch','Price','Qty','Total');
$header2 = array('Customers Name', 'Phone Number', 'Total');
$pdf->SetFont('Arial','',14);

$pdf->AddPage();
$pdf->ProductTable($header);
$pdf->AddPage();
$pdf->OrderTable($header1);
$pdf->AddPage();
$pdf->paymentTable($header2);
$pdf->Output();
?>