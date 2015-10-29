<html>
<?php

session_start();

$conn = oci_connect('marckost', '5boat90CAR', '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(Host=db1.chpc.ndsu.nodak.edu)(Port=1521)))(CONNECT_DATA=(SID=cs)))');

//get number of orders to find new orderID
$query = "SELECT Count(ORDERNUMBER) from SHOPPINGCART";

$stid = oci_parse($conn,$query);
oci_execute($stid,OCI_DEFAULT);


//iterate through each row
while ($row = oci_fetch_array($stid,OCI_ASSOC)) 
{

	$newID = $row["COUNT(ORDERNUMBER)"] + 1;
	
}
oci_free_statement($stid);
oci_close($conn);
?>
<!--- Now to add the order into shoppingcart table --->

<?php


$conn = oci_connect('marckost', '5boat90CAR', '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(Host=db1.chpc.ndsu.nodak.edu)(Port=1521)))(CONNECT_DATA=(SID=cs)))');


$query = "INSERT INTO SHOPPINGCART VALUES ($newID, 235," . $_SESSION['totalPrice'] . "," . $_SESSION['CUSTOMERID'] .")";


$stid = oci_parse($conn,$query);
oci_execute($stid,OCI_DEFAULT);


//iterate through each row
while ($row = oci_fetch_array($stid,OCI_ASSOC)) 
{
   
}

oci_commit($conn);

oci_free_statement($stid);
oci_close($conn);

?>


<!--- Now add songID and ordernumber into items table--->
<?php




foreach($_SESSION["purchasing"] as $songID){

	
	$conn = oci_connect('marckost', '5boat90CAR', '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(Host=db1.chpc.ndsu.nodak.edu)(Port=1521)))(CONNECT_DATA=(SID=cs)))');
	$query = "INSERT INTO ITEM VALUES ( " . $newID . ", " . $songID . ")";

	$stid = oci_parse($conn,$query);
	oci_execute($stid,OCI_DEFAULT);


	//iterate through each row
	while ($row = oci_fetch_array($stid,OCI_ASSOC)) 
	{
	   
	}
	
	oci_commit($conn);	
	
	oci_free_statement($stid);
	oci_close($conn);

}

echo 'Purchase complete. Thank you!';

?>
<?php
$_SESSION['totalPrice'] = 0;
$_SESSION['purchasing'] = array();


?>

<form action = "musicstore.php">
<input type = "submit" value = "Return to music store">
</form>





</html>
