<html>
<body>


<form action = "musicstore.php" method = "get">
<?php session_start(); 
echo $_SESSION["CUSTOMERNAME"]; ?>, has logged out.
<?php $_SESSION["FOUNDLOGIN"] = 0;
$_SESSION["CUSTOMERID"] = -1;
$_SESSION["CUSTOMERNAME"] = ""; ?>
<input type = "submit" value = "Return">
</form>


</body>
</html>
