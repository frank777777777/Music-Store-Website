<!DOCTYPE html>
<html>

<head>
<meata charset = "utf-8">
<title>Online Music Store</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body> 
<?php 
/*
if (session_id() == '') {
    session_start();
}
*/
session_start();

if ($_SESSION["CUSTOMERID"] == -1){

?>
<div id="topbar">The CS366 Music Store
	<div id="login"> <a href="login.php">Login</a></div>
	<div id="signup"> <a href="signup.php">Register</a></div>
</div>
</div>
<?php 
}else{
?>
<div id="topbar">The CS366 Music Store
	<div id="logout"> <a href="logout.php">Logout</a></div>
	<div id="orders"> <a href="orders.php">View Orders</a></div>
	<div id="welcome"> Welcome, <?php echo $_SESSION["CUSTOMERNAME"]; ?>!  </div>
</div>	
</div>

<?php
}
// connection string
$conn = oci_connect('marckost', '5boat90CAR', '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(Host=db1.chpc.ndsu.nodak.edu)(Port=1521)))(CONNECT_DATA=(SID=cs)))');

?>
<div id="search">Search for music: 
<form action="musicstore.php">
<input type="text" name="SearchQuery" value="Search by song/album/artist name">
<select name = "searchBy">
	<option value="song">Song</option>
	<option value="album">Album</option>
	<option value="artist">Artist</option>
	<option value="genre">Genre</option>
</select>

<input type = "submit" value = "Search">

</form>
</div>


<div id="songlist">
<div id="wrapper">
<form action="shopping_cart.php" method="post">

<table width="75%" class="view" border="1">
      <thead>
        <tr>	
 		  <th width="100">SongID</th>	
          <th width="100">Song Name</th>
          <th width="100">Artist</th>
          <th width="100">Album</th>
		  <th width="100">Genre</th>
<?php if($_SESSION['CUSTOMERID'] != -1){   ?>
		  <th width="50">Buy</th>	
<?php } ?>	
        </tr>
      </thead>
<tbody>
<?php

$searchby =  addslashes(htmlspecialchars($_GET['searchBy']));
$searchwords = addslashes(htmlspecialchars($_GET['SearchQuery']));
$words = explode(' ',$searchwords);
if ($searchby == "artist"){
$searchstring = "artistName LIKE '%$searchwords%'";
}
elseif ($searchby == "song"){
$searchstring = "songName LIKE '%$searchwords%'";
}
elseif ($searchby == "album") {
$searchstring = "albumName LIKE '%$searchwords%'";
}
elseif ($searchby == "genre") {
$searchstring = "genre LIKE '%$searchwords%'";
}

// sql queryproin
$query = "SELECT songID, songName, artistName, albumName, genre FROM song, artist, album WHERE artist.artistID = song.artistID AND album.albumID = song.albumID AND $searchstring";


$stid = oci_parse($conn,$query);
oci_execute($stid,OCI_DEFAULT);

// iterate through each row


while ($row = oci_fetch_array($stid,OCI_ASSOC))
{
	echo "<tr>";
   foreach ($row as $item) 
   { 
		?>
		<td> <?php echo $item.'' ?></td> 
		<?php
	}
	
	if($_SESSION['CUSTOMERID'] != -1){
?>
	<td><input type='checkbox' name='checkbox[]' value="<?php echo $row['SONGID'] ?>" /></td>​ 

	<?php }
	echo "</tr>";
}

/*
if(!empty($_POST['checkbox'])) {
	$count = 0;
	foreach($_POST['checkbox'] as $id){
			$_SESSION["Z"][$count] = $id;  
			print_r($_SESSION); //print all checked elements
			count++;
	 	}
}
*/

?>
</tbody>
</table>
<?php if($_SESSION["CUSTOMERID"] != -1){ ?>
	<input type = "submit" value = "Add to cart">
<?php } ?>
</form>
<?php
oci_free_statement($stid);
oci_close($conn);

?>
<?php 
	session_start();
?>
</div>

</body>
</html>
