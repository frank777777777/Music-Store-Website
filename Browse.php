<html>

<body>
<h1>Your Information:</h1>
Welcome <?php echo $_GET["username"]; ?>
<br>Your password is: <?php echo $_GET["password"]; ?>




<?php
echo '<br>';
echo '<br>';

session_start();


// The connection string is loooooooong. It's easiest to copy/paste this line. Remember to replace 'username' and 'password'!
$conn = oci_connect('marckost', '5boat90CAR', '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(Host=db1.chpc.ndsu.nodak.edu)(Port=1521)))(CONNECT_DATA=(SID=cs)))');


//put your query in here
$query = 'SELECT Count(CUSTOMERNAME) from CUSTOMER where customerName = \'' . $_GET["username"] . '\' AND customerPassword = \'' . $_GET["password"] . '\'';

$stid = oci_parse($conn,$query);
oci_execute($stid,OCI_DEFAULT);

$_SESSION["FOUNDLOGIN"] = 0;

//iterate through each row
while($row = oci_fetch_array($stid,OCI_ASSOC)){
	foreach($row as $item){
		$_SESSION["FOUNDLOGIN"] = $item;
	}
}
   echo '<br/>';

oci_free_statement($stid);
oci_close($conn);



?>




<!-- get customerid and if customer is admin or not-->
<?php	



$conn = oci_connect('marckost', '5boat90CAR', '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(Host=db1.chpc.ndsu.nodak.edu)(Port=1521)))(CONNECT_DATA=(SID=cs)))');
	
//get customer ID and if customer is admin or not
$newquery = 'SELECT CUSTOMERID, ISADMIN FROM CUSTOMER where customerName = \'' . $_GET["username"] . '\' AND customerPassword = \'' . $_GET["password"] . '\'';


if($_SESSION["FOUNDLOGIN"] != 0){
	$stid = oci_parse($conn,$newquery);
	oci_execute($stid,OCI_DEFAULT);

			while ($row = oci_fetch_array($stid,OCI_ASSOC)) 
			{	
			
				$_SESSION["CUSTOMERID"] = $row["CUSTOMERID"];
				$_SESSION["ISADMIN"] = $row["ISADMIN"];
				/*
			   //iterate through each item in the row and echo it
			   foreach ($row as $item) 
			   {
					$_SESSION["customerID"] = $item; 
			   }
				*/
			   
			}
}
else{
	$_SESSION["CUSTOMERID"] = -1;
	$_SESSION["ISADMIN"] = 0;
}
echo '<br/>';
echo "CUSTOMERID: " . $_SESSION["CUSTOMERID"];
echo "<br>ISADMIN (0 is no, 1 is yes): " . $_SESSION["ISADMIN"];

?>













</body>
</html>
