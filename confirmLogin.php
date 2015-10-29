<html>
</div>

<?php
session_start();
$_SESSION = array();

// The connection string is loooooooong. It's easiest to copy/paste this line. Remember to replace 'username' and 'password'!
$conn = oci_connect('marckost', '5boat90CAR', '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(Host=db1.chpc.ndsu.nodak.edu)(Port=1521)))(CONNECT_DATA=(SID=cs)))');


//put your query in here
$query = 'SELECT Count(CUSTOMERNAME) from CUSTOMER where customerName = \'' . $_GET["username"] . '\' AND customerPassword = \'' . $_GET["password"] . '\'';

$stid = oci_parse($conn,$query);
oci_execute($stid,OCI_DEFAULT);

//iterate through each row
while($row = oci_fetch_array($stid,OCI_ASSOC)){
	foreach($row as $item){
		$_SESSION["FOUNDLOGIN"] = $item;
	}
}



oci_free_statement($stid);
oci_close($conn);

?>


<?php
if ($_SESSION["FOUNDLOGIN"] != 0){
	
	$conn = oci_connect('marckost', '5boat90CAR', '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(Host=db1.chpc.ndsu.nodak.edu)(Port=1521)))(CONNECT_DATA=(SID=cs)))');


	//put your query in here
	$query = 'SELECT CUSTOMERID, CUSTOMERNAME from CUSTOMER where customerName = \'' . $_GET["username"] . '\' AND customerPassword = \'' . $_GET["password"] . '\'';

	$stid = oci_parse($conn,$query);
	oci_execute($stid,OCI_DEFAULT);

	//iterate through each row
	while($row = oci_fetch_array($stid,OCI_ASSOC)){
		
		$_SESSION["CUSTOMERID"] = $row["CUSTOMERID"];
		$_SESSION["CUSTOMERNAME"] = $row["CUSTOMERNAME"];
	}

	echo $_SESSION["CUSTOMERNAME"] . " logged in.";
	echo '<br/>';
	echo '<a href="musicstore.php">Go To Main Page</a>';
}
else{
	$_SESSION["CUSTOMERID"] = -1;
	echo "Username or password is incorrect.";
	echo '<br>';
	echo '<a href="login.php">Try again</a>';
}
?>

</hmtl>
