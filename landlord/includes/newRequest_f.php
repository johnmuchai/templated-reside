<?php
	// Access DB Info
	include('../../config.php');

	// Get the Property ID
	$propId = $mysqli->real_escape_string($_POST['propId']);

	$datasql = "SELECT 'X' FROM users WHERE propertyId = ".$propId." AND isResident = 0 LIMIT 1";
	$usrres = mysqli_query($mysqli, $datasql) or die('-189'.mysqli_error());
	$usrData = mysqli_num_rows($usrres);
	
	if ($usrData > 0) {
		$dataqry = "SELECT
						userId,
						CONCAT(userFirstName,' ',userLastName) AS user,
						leaseId
					FROM
						users
					WHERE propertyId = ".$propId." AND isResident = 0
					LIMIT 1";
		$datares = mysqli_query($mysqli, $dataqry) or die('Error: Retrieving User Info '.mysqli_error());
		$hasRes = mysqli_num_rows($datares);
		
		if ($hasRes > 0) {
			while($datarow = mysqli_fetch_assoc($datares)) {
				$datarows = array_map(null, $datarow);
				$resdata[] = $datarows;
			}
		
			echo json_encode($resdata);
		} else {
			while($datarow = mysqli_fetch_assoc($usrres)) {
				$datarows = array_map(null, $datarow);
				$resdata[] = $datarows;
			}
			
			echo 'Unleased Property';
		}
	}
?>