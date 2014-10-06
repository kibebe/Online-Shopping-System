<?PHP

$uname = "";
$pword = "";
$errorMessage = "";

//	ESCAPE DANGEROUS SQL CHARACTERS

function quote_smart($value, $handle) {

   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }

   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value, $handle) . "'";
   }
   return $value;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['username'];
	$pword = $_POST['password'];

	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);

	
	//	CONNECT TO THE LOCAL DATABASE

	
	$database = "tumaini";
	
	$db_handle = mysql_connect("localhost","cik","mzuka");
	$db_found = mysql_select_db($database, $db_handle);

	if ($db_found) {

		$uname = quote_smart($uname, $db_handle);
		$pword = quote_smart($pword, $db_handle);

		$SQL = "SELECT * FROM login WHERE username = $uname AND password = md5($pword)";
		$result = mysql_query($SQL);
		$num_rows = mysql_num_rows($result);

	//====================================================
	//	CHECK TO SEE IF THE $result VARIABLE IS TRUE
	//====================================================

		if ($result) {
			if ($num_rows > 0) {
			
				session_start();
				$_SESSION['login'] = "1";
				header ("Location: manager_view.php");
			}
			else {
			$errorMessage = "Invalid Login";
            session_start();
            $_SESSION['login'] = '';
			}
			
				
		}
		else {
			$errorMessage = "Error logging on";
			
		}

	mysql_close($db_handle);

	}

	else {
		$errorMessage = "Error logging on";
	}

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manager Login</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootstrap.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/notify.min.js"></script>
<link href="project.css" rel="stylesheet" type="text/css">

</head>

<body>
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
<h2 style="color:#33FF33">Manager Login</h2>
<FORM  role="form" NAME ="form1" METHOD ="POST" ACTION ="managerLogin.php">
<div class="form-group">
<table id="mlogin-table">
<tr>
<td>
Username: <INPUT class="form-control" TYPE = 'TEXT' Name ='username' value=""   maxlength="20" id="login-username"></td>
</tr>
<tr>
<td>
Password: <INPUT class="form-control" TYPE = 'password' Name ='password' value=""   maxlength="40" id="login-pword"></td>
</tr>
<tr>
<td>
<INPUT class="btn btn-info" TYPE = "Submit" Name = "Submit1"  VALUE = "Login" id="submit-login">

<?PHP echo '<p>'.$errorMessage.'</p>';?>
</td>
</tr>
</table>

</div>
</FORM>




</body>
</html>
