
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Auto Update</title>
//test

<body>
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "reside_prod");

// Check connection //<meta http-equiv="refresh" content="5" >
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}



//'Update rent balances after deadline is reached

$sql = "SELECT * FROM paymentspostage";// WHERE isLeased ='1' AND Posted=$Propertypostingvar";
if($result11 = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result11) > 0){
		$numrows = (mysqli_num_rows($result11));
			$i =$numrows;
			do {
				//$i++;
				$sdate = date('Y-m-d H:i:s');
				//echo $sdate;
				$todyasmonth = date("F", strtotime($sdate));
				//echo $todyasmonth;
				$Propertyid = $row['PropertyID'];
				//	echo $Propertyid;
				$Rent = $row['Rent_Amount'];
				//echo $Rent;

				$Penalty =  $row['Penalties'];

				//	echo $Penalty;

				$Prevdate = $row['PP_Date'];
				//echo $Prevdate;

				$Prevmonth =  $row['S_month'];
					//echo $Prevmonth;

				$todyasmonth2 = date("F", strtotime($sssdate));
					// echo $todyasmonth2;
				$sssdate =  date('Y-m-d');
				$todaysday = date('j');
				$deadlineday = $todaysday;

				echo 'iam deadline' . $deadlineday ;

				$rentbalance = $row['RentBalance'];
				$Totalarreas = $rentbalance + $Penalty ;
				echo 'iam deadline' . $Totalarreas;
				$notaccrued = 0 ;
				$accrued = 1 ;

    $time = date('H:i:s');
						//.update property table for every posted property

						$sql12 = "UPDATE paymentspostage SET RentBalance='$Totalarreas', accrued='$accrued' WHERE PropertyID='$Propertyid' and S_month = '$todyasmonth2' and Deadline = '$deadlineday' and accrued='$notaccrued'";
						if(mysqli_query($link, $sql12)){
							echo "Records were updated successfully.";
						} else {
						echo "ERROR: Could not able to execute $sql12. " . mysqli_error($link);
					}
						}
						while ($row = mysqli_fetch_array($result11));

        mysqli_free_result($result11);
		///die ;
    } else{
        echo "No records matching your query were found.";

    }
} else{
    echo "ERROR: Could not able to execute $sql10. " . mysqli_error($link);
}




//'Update rent balances

$sql = "SELECT * FROM paymentspostage";// WHERE isLeased ='1' AND Posted=$Propertypostingvar";
if($result11 = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result11) > 0){
		$numrows = (mysqli_num_rows($result11));
			$i =$numrows;
			do {
				//$i++;
				$sdate = date('Y-m-d H:i:s');
				//echo $sdate;
				$todyasmonth = date("F", strtotime($sdate));
				//echo $todyasmonth;
				$Propertyid = $row['PropertyID'];
				//	echo $Propertyid;
				$Rent = $row['Rent_Amount'];
				//echo $Rent;

				$Penalty =  $row['Penalties'];
				//	echo $Penalty;

				$Prevdate = $row['PP_Date'];
				//echo $Prevdate;

				$Prevmonth =  $row['S_month'];
					//echo $Prevmonth;

				$todyasmonth2 = date("F", strtotime($sssdate));
					// echo $todyasmonth2;
				$sssdate =  date('Y-m-d');
				$todaysday = date('j');
				$deadlineday = $todaysday + 5 ;
				$rentbalance = $row['RentBalance'];
				$Totalarreas = $rentbalance + $Rent;
				echo $Totalarreas;
				$notaccrued = 0 ;
				$accrued = 1	;

    $time = date('H:i:s');
						//.update property table for every posted property

						$sql12 = "UPDATE paymentspostage SET RentBalance='$Totalarreas', S_month='$todyasmonth2', PP_Date='$sssdate', accrued='notaccrued'
						WHERE PropertyID='$Propertyid' and S_month <> '$todyasmonth2' and PP_Date < '$sssdate'";
						if(mysqli_query($link, $sql12)){
							echo "Records were updated successfully.";
						} else {
						echo "ERROR: Could not able to execute $sql12. " . mysqli_error($link);
					}
						}
						while ($row = mysqli_fetch_array($result11));

        mysqli_free_result($result11);
		///die ;
    } else{
        echo "No records matching your query were found.";

    }
} else{
    echo "ERROR: Could not able to execute $sql10. " . mysqli_error($link);
}





//populating Payments poastage table with leased properties
$Propertypostingvar = 0;
$sql10 = "SELECT * FROM properties WHERE isLeased ='1' AND Posted=$Propertypostingvar";
if($result10 = mysqli_query($link, $sql10)){
    if(mysqli_num_rows($result10) > 0){
		$numrows = (mysqli_num_rows($result10));
			$i =$numrows;
			do {
				//$i++;
				$sdate = date('Y-m-d H:i:s');
				//echo $sdate;
				$todyasmonth = date("F", strtotime($sdate));
				$Admin_ID = $row['adminId'];
				$propertyId = $row['propertyId'];
				$propertyName =  $row['propertyName'];
				$propertyRate = $row['propertyRate'];
				$latePenalty =  $row['latePenalty'];
				$propertyDeposit =  $row['propertyDeposit'];
				$unitName =  $row['unitName'];
				$unitName =  $row['unitName'];
				$deadlinedate = 6 ;
				$date = date('Y-m-d');
    $time = date('H:i:s');//echo $date;
//echo $time;
					//  insert Leased property into paymentspostage table
						$sql2 = "INSERT INTO paymentspostage (propertyId, propertyName, Rent_Amount, Penalties, propertyDeposit,
						Unit_Name, Admin_ID, PP_Date, PP_Time, S_month, Deadline) VALUES ('$propertyId', '$propertyName', '$propertyRate', '$latePenalty', '$propertyDeposit', '$unitName', '$Admin_ID', '$date', '$time', '$todyasmonth', '$deadlinedate')";
						if(mysqli_query($link, $sql2)){
							echo "Records inserted successfully.";
						} else{
							echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
						}
						//.update property table for every posted property
						$variable = 1;
							$sql3 = "UPDATE properties SET Posted='$variable' WHERE adminId=$Admin_ID";
						if(mysqli_query($link, $sql3)){
							echo "Records were updated successfully.";
						} else {
							echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
						}
						}
						while ($row = mysqli_fetch_array($result10));

        mysqli_free_result($result10);
		///die ;
    } else{
        echo "No records matching your query were found.";

    }
} else{
    echo "ERROR: Could not able to execute $sql10. " . mysqli_error($link);
}
 //populating Payments poastage table with leased tenants

 $sql4 = "SELECT * FROM leases";// WHERE isLeased ='1' AND Posted=$Propertypostingvar";
if($result2 = mysqli_query($link, $sql4)){
    if(mysqli_num_rows($result2) > 0){

	//$numrows = (mysqli_num_rows($result));


			do {


				$userId = $row['userId'];
				$propertyId = $row['propertyId'];

						//  insert Leased property into paymentspostage table
						//.update paymentspostage table for every posted property
						//$variable = 0;
							$sql6 = "UPDATE paymentspostage SET TenantsID='$userId' WHERE PropertyID=$propertyId";
						if(mysqli_query($link, $sql6)){
							echo "Records were updated successfully.";
						} else {
							echo "ERROR: Could not able to execute $sql6. " . mysqli_error($link);
						}
						}
						while ($row = mysqli_fetch_array($result2));

        mysqli_free_result($result2);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


 $sql5 = "SELECT * FROM users";// WHERE isLeased ='1' AND Posted=$Propertypostingvar";
if($result5 = mysqli_query($link, $sql5)){
    if(mysqli_num_rows($result5) > 0){

	$numrows5 = (mysqli_num_rows($result5));

			do {
				$userId = $row5['userId'];
				$userFirstName = $row5['userFirstName']; //+ ' ' + $row5['userLastName'];
				$userLastName = $row5['userLastName'];
// $Space = " ";
				$userfullName = '$userLastName' . '$userLastName';

				echo $userLastName ;

						//  insert Leased property into paymentspostage table
						//.update paymentspostage table for every posted property
					//	$variable = 1;
							$sql6 = "UPDATE paymentspostage SET TenantsName='$userLastName' WHERE TenantsID=$userId";
						if(mysqli_query($link, $sql6)){
							echo "Records were updated successfully.";
						} else {
							echo "ERROR: Could not able to execute $sql6. " . mysqli_error($link);
						}
						}
						while ($row5 = mysqli_fetch_array($result5));

        mysqli_free_result($result5);
    } else{
        echo "No records matching your query were found.";
    }
	} else{
    echo "ERROR: Could not able to execute $sql5. " . mysqli_error($link);
	}




	//mysqli_close($link);

?>








<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('FORMS', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle; ?></h3>
				<div class="row mb-20">
					<div class="col-md-4">
						<ul class="list-group mb-10">
							<li class="list-group-item"><strong><?php echo $tempNameField; ?></strong>: <?php echo clean($row['templateName']); ?></li>
							<li class="list-group-item"><strong><?php echo $uploadedByHead; ?></strong>: <?php echo clean($row['adminName']); ?></li>
							<li class="list-group-item"><strong><?php echo $dateUploadedHead; ?></strong>: <?php echo dateFormat($row['uploadDate']); ?></li>
							<li class="list-group-item"><strong><?php echo $descriptionHead; ?></strong>: <?php echo clean($row['templateDesc']); ?></li>
						</ul>

						<a data-toggle="modal" href="#editTemplate" class="btn btn-default btn-xs btn-icon"><i class="fa fa-edit"></i> <?php echo $editTemplBtn; ?></a>
						<div class="modal fade" id="editTemplate" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
										<h4 class="modal-title"><?php echo $editTemplBtn; ?></h4>
									</div>
									<form action="" method="post">
										<div class="modal-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="templateName"><?php echo $tempNameField; ?></label>
														<input type="text" class="form-control" name="templateName" id="templateName" required="required" value="<?php echo clean($row['templateName']); ?>" />
														<span class="help-block"><?php echo $tempNameHelp; ?></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="templateDesc"><?php echo $templDeacField; ?></label>
														<input type="text" class="form-control" name="templateDesc" id="templateDesc" required="required" value="<?php echo clean($row['templateDesc']); ?>" />
														<span class="help-block"><?php echo $templDeacFieldHelp; ?></span>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="input" name="submit" value="editTemplate" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<a data-toggle="modal" href="#deleteTemplate" class="btn btn-default btn-xs btn-icon"><i class="fa fa-trash"></i> <?php echo $delTemplBtn; ?></a>
						<div class="modal fade" id="deleteTemplate" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog text-left">
								<div class="modal-content">
									<form action="" method="post">
										<div class="modal-body">
											<p class="lead"><?php echo $delTemplConf; ?> "<?php echo clean($row['templateName']); ?>"?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="templateName" value="<?php echo clean($row['templateName']); ?>" />
											<input type="hidden" name="templateUrl" value="<?php echo clean($row['templateUrl']); ?>" />
											<button type="input" name="submit" value="deleteTemplate" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<p class="lead"><?php echo $viewTemplQuip; ?></p>
						<?php
							//Get Template Extension
							$ext = substr(strrchr($row['templateUrl'],'.'), 1);
							$imgExts = array('gif', 'GIF', 'jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'tiff', 'TIFF', 'tif', 'TIF', 'bmp', 'BMP');

							if (in_array($ext, $imgExts)) {
								echo '<p><img src="../'.$templatesPath.$row['templateUrl'].'" class="img-responsive" /></p>';
							} else {
								echo '
										<div class="alertMsg default mb-20">
											<div class="msgIcon pull-left">
												<i class="fa fa-info-circle"></i>
											</div>
											'.$noPreviewAvailMsg.'
										</div>
										<p>
											<a href="../'.$templatesPath.$row['templateUrl'].'" class="btn btn-success btn-icon" target="_blank">
											<i class="fa fa-download"></i> '.$dwnldTemplBtn.' '.$row['templateName'].'</a>
										</p>
									';
							}
						?>
					</div>
				</div>


		<?php } else { ?>
			<hr class="mt-0 mb-0" />
			<h3><?php echo $accessErrorHeader; ?></h3>
			<div class="alertMsg warning mb-20">
				<div class="msgIcon pull-left">
					<i class="fa fa-warning"></i>
				</div>
				<?php echo $permissionDenied; ?>
			</div>
		<?php } ?>
	</div>



  </head>



</body>
</html>
