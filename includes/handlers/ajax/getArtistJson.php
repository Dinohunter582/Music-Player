<?php
// our ajax call
include("../../config.php");

if(isset($_POST['artistId'])) {
	$artistId = $_POST['artistId'];

	$query = mysqli_query($con, "SELECT * FROM artists WHERE id='$artistId'");

	$resultArray = mysqli_fetch_array($query);
    
//all ajax calls must be passed through an echo statment to be read 
	echo json_encode($resultArray);
}


?>