 <!doctype html>
<html>
<head>
<title>Contact us</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootstrap.min.js"></script>
<link href="project.css" rel="stylesheet" type="text/css">

</head>
<body  onLoad="imageSlide()">
<p>


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
</p>

<?php
// display form if user has not clicked submit
if (!isset($_POST["submit"]))
  {
  ?>
  <h1>Contact us</h1>
  <form role="form" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
  <div class="form-group">
  <table>
  <tr>
 <td> From:</td> <td> <input class="form-control" type="text" name="from"><br></td></tr>
 <tr>
 <td> Subject:</td><td> <input class="form-control" type="text" name="subject"><br></td></tr>
 <tr>
 <td> Message:</td><td> <textarea class="form-control" rows="10" cols="40" name="message"></textarea><br></td></tr>
 <tr>
 <td> <input class="btn btn-info" type="submit" name="submit" value="Submit Feedback"></td></tr>
 </table>
 </div>
  </form>
  <?php
  }
else
  // the user has submitted the form
  {
  // Check if the "from" input field is filled out
  if (isset($_POST["from"]))
    {
    $from = $_POST["from"]; // sender
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    // send mail
    mail("cik.cir@gmail.com",$subject,$message,"From: $from\n");
    echo "Thank you for sending us feedback";
    }
  }
?>
</body>
</html>