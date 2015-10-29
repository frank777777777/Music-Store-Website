<!DOCTYPE html>
<html>
<body>
<link rel="stylesheet" type="text/css" href="style.css">
<div  id = "topbar">
 Shopping Cart 
</div>

<table width="75%" class="view" border="1">
      <thead>
		<tr>
          <th width="100">Song Name</th>
          <th width="100">Song Price</th>
		</tr>
      </thead>
<tbody>


<?php

session_start();
$purchased_songID = $_POST['checkbox'];  //replace to $_SESSION

$_SESSION['purchasing'] = $_POST['checkbox'];



// The connection string is loooooooong. It's easiest to copy/paste this line. Remember to replace 'username' and 'password'!
$conn = oci_connect('marckost', '5boat90CAR', '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(Host=db1.chpc.ndsu.nodak.edu)(Port=1521)))(CONNECT_DATA=(SID=cs)))');

//length of the array
$arrlength = count($purchased_songID);
//to count the total price
$total_price = 0;
for($x = 0; $x < $arrlength; $x++)
{
	//put your query in here
	$query = 'Select songName,songPrice from song where songID = ' . $purchased_songID[$x]. '';

	$stid = oci_parse($conn,$query);
	oci_execute($stid,OCI_DEFAULT);

	while ($row = oci_fetch_array($stid,OCI_ASSOC)) 
	{
echo "<tr>";
   		//iterate through each item in the row and echo it
   		foreach ($row as $item) 
   		{
?>
	<td> <?php echo $item.'' ?></td> 
<?php	
		
   		}
	
	$total_price = $total_price + $item;
echo "</tr>";
	}

	oci_free_statement($stid);
	
}
oci_close($conn);

echo "Total Price: ". $total_price;
echo '<br/>';

$_SESSION['totalPrice'] = $total_price;


?>
</tbody>
</table>
<form action = "checkout.php">
<input type = "submit" value = "Confirm Purchase">
</form>





</body>
</html>
