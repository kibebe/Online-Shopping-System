<?PHP

session_start();
session_destroy();
header ("Location: managerLogin.php");
?>
