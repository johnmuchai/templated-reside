<?php

function generateRandStr_md5 ($length,$prefix) {
	// Perfect for: PASSWORD GENERATION
	// Generate a random string based on an md5 hash
	$randStr = strtoupper(md5(rand(0, 1000000))); // Create md5 hash
	$rand_start = rand(5,strlen($randStr)); // Get random start point
	if($rand_start+$length > strlen($randStr)) {
		$rand_start -= $length; // make sure it will always be $length long
	} if($rand_start == strlen($randStr)) {
		$rand_start = 1; // otherwise start at beginning!
	}
	// Extract the 'random string' of the required length
	$randStr = strtoupper(substr(md5($randStr), $rand_start, $length));
	return $prefix.$randStr; // Return the string
}

	$propertyId = $mysqli->real_escape_string($_GET['propertyId']);
	$ipAddress = $_SERVER['REMOTE_ADDR'];
	$leaseCreated = '';

	// Create New Lease
	if (isset($_POST['submit']) && $_POST['submit'] == 'createLease') {
		// User Validations
		if($_POST['userId'] == '...') {
			$msgBox = alertBox($tenLeaseReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['leaseTerm'] == '') {
			$msgBox = alertBox($leaseTermReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['leaseStart'] == '') {
			$msgBox = alertBox($leaseStartDateReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['leaseEnd'] == '') {
			$msgBox = alertBox($leaseEndDateReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$userId = htmlspecialchars($_POST['userId']);
			$leaseTerm = htmlspecialchars($_POST['leaseTerm']);
			$leaseStart = htmlspecialchars($_POST['leaseStart']);
			$leaseEnd = htmlspecialchars($_POST['leaseEnd']);
			$notes = htmlspecialchars($_POST['notes']);
			$nextLeaseId = htmlspecialchars($_POST['nextLeaseId']);
			$propertyName = htmlspecialchars($_POST['propertyName']);

			$leaseNo = generateRandStr_md5 (6,$propertyId);
			// Create the Lease Record
			$stmt = $mysqli->prepare("
								INSERT INTO
									leases(
										leaseId,
										propertyId,
										adminId,
										userId,
										leaseTerm,
										leaseStart,
										leaseEnd,
										notes,
										closed,
										ipAddress,
										leaseNo
									) VALUES (
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										0,
										?,
										?
									)");
			$stmt->bind_param('ssssssssss',
				$nextLeaseId,
				$propertyId,
				$rs_adminId,
				$userId,
				$leaseTerm,
				$leaseStart,
				$leaseEnd,
				$notes,
				$ipAddress,
				$leaseNo
			);
			$stmt->execute();
			$stmt->close();

			// Update the Property as Leased
			$stmt = $mysqli->prepare("UPDATE
										properties
									SET
										isLeased = 1
									WHERE
										propertyId = ?"
			);
			$stmt->bind_param('s',$propertyId);
			$stmt->execute();
			$stmt->close();

			// Update the User as Leased
			$stmt = $mysqli->prepare("UPDATE
										users
									SET
										isLeased = 1,
										propertyId = ?,
										leaseId = ?
									WHERE
										userId = ?"
			);
			$stmt->bind_param('sss',
								$propertyId,
								$nextLeaseId,
								$userId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '20';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$createLeaseAct.' '.$propertyName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($newLeaseMsg." ".$propertyName." ".$newLeaseMsg1, "<i class='fa fa-check-square'></i>", "success");

			// Clear the Form of values
			$_POST['leaseTerm'] = $_POST['leaseStart'] = $_POST['leaseEnd'] = $_POST['notes'] = '';
			$leaseCreated = 'true';
		}
	}

	$qry = "SELECT * FROM properties WHERE propertyId = ".$propertyId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);

	if ($row['petsAllowed'] == '1') { $petsAllowed = $yesBtn; } else { $petsAllowed = $noBtn; }

	$sql = "SHOW TABLE STATUS LIKE 'leases'";
	$result = mysqli_query($mysqli, $sql) or die('-2' . mysqli_error());
	$rows = mysqli_fetch_assoc($result);
	$nextLeaseId = $rows['Auto_increment'];

	$propPage = 'true';
	$pageTitle = $leasePropPageTitle;
	$addCss = '<link rel="stylesheet" type="text/css" href="../css/datetimepicker.css" /><link href="../css/chosen.css" rel="stylesheet">';
	$chosen = 'true';
	$datePicker = 'true';
	$jsFile = 'leaseProperty';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle.' '.clean($row['propertyName']); ?> - <?php echo clean($row['unitName']); ?></h3>

				<input type="hidden" id="weekStart" value="<?php echo $set['weekStart']; ?>" />

				<?php if ($row['isLeased'] == '0') { ?>
					<p class="lead"><?php echo $createLeaseQuip; ?></p>
					<div class="alertMsg default">
						<div class="msgIcon pull-left">
							<i class="fa fa-info-circle"></i>
						</div>
						<?php echo $createLeaseMsg; ?>
					</div>

					<hr />

					<div class="row">
						<div class="col-md-4">
							<ul class="list-group">
								<li class="list-group-item">
									<strong><?php echo $newPaymentEmail2; ?></strong>
									<a href="index.php?action=viewProperty&propertyId=<?php echo $row['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
										<?php echo clean($row['propertyName']); ?>
									</a>
								</li>
								<li class="list-group-item"><strong><?php echo $monthlyRateText; ?>:</strong> <?php echo formatCurrency($row['propertyRate'],$currCode); ?></li>
								<li class="list-group-item"><strong><?php echo $lateFeeText; ?>:</strong> <?php echo formatCurrency($row['latePenalty'],$currCode); ?></li>
								<li class="list-group-item"><strong><?php echo $depositText; ?>:</strong> <?php echo formatCurrency($row['propertyDeposit'],$currCode); ?></li>
								<li class="list-group-item"><strong><?php echo $petsAllowedHead; ?>:</strong> <?php echo $petsAllowed; ?></li>
							</ul>
						</div>
						<div class="col-md-8">
							<?php if ($leaseCreated == '') { ?>
								<form action="" method="post" class="mb-20">
									<div class="row">
										<div class="col-md-6">
											<?php
												$tenqry = "SELECT userId, CONCAT(userFirstName,' ',userLastName) AS user FROM users WHERE leaseId = 0 AND isActive = 1 AND isResident = 0";
												$tenres = mysqli_query($mysqli, $tenqry) or die('-3'.mysqli_error());
											?>
											<div class="form-group">
												<label for="userId"><?php echo $tenantHead; ?></label>
												<select class="form-control chosen-select" id="userId" name="userId">
													<option value="..."><?php echo $selectTenOpt; ?></option>
													<?php
														while ($ten = mysqli_fetch_assoc($tenres)) {
															echo '<option value="'.$ten['userId'].'">'.$ten['user'].'</option>';
														}
													?>
												</select>
												<span class="help-block"><?php echo $selectTenOptHelp; ?></span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="leaseTerm"><?php echo $termOfLeaseField; ?></label>
												<input type="text" class="form-control" name="leaseTerm" id="leaseTerm" required="required" value="<?php echo isset($_POST['leaseTerm']) ? $_POST['leaseTerm'] : ''; ?>" />
												<span class="help-block"><?php echo $termOfLeaseFieldHelp; ?></span>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="leaseStart"><?php echo $leaseStartDateField; ?></label>
												<input type="text" class="form-control" name="leaseStart" id="leaseStart" required="required" value="<?php echo isset($_POST['leaseStart']) ? $_POST['leaseStart'] : ''; ?>" />
												<span class="help-block"><?php echo $leaseStartDateFieldHelp; ?></span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="leaseEnd"><?php echo $leaseEndDateField; ?></label>
												<input type="text" class="form-control" name="leaseEnd" id="leaseEnd" required="required" value="<?php echo isset($_POST['leaseEnd']) ? $_POST['leaseEnd'] : ''; ?>" />
												<span class="help-block"><?php echo $leaseEndDateFieldHelp; ?></span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="notes"><?php echo $leaseNotesField; ?></label>
										<textarea class="form-control" name="notes" id="notes" rows="3"><?php echo isset($_POST['notes']) ? $_POST['notes'] : ''; ?></textarea>
										<span class="help-block"><?php echo $leaseNotesFieldHelp; ?></span>
									</div>

									<input type="hidden" name="nextLeaseId" value="<?php echo $nextLeaseId; ?>" />
									<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
									<button type="input" name="submit" value="createLease" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $createLeaseBtn; ?></button>
								</form>
							<?php } else { ?>
								<div class="alertMsg default">
									<div class="msgIcon pull-left">
										<i class="fa fa-info-circle"></i>
									</div>
									<?php echo $newLeaseCreatedMsg.' '.clean($row['propertyName']).' '.$newLeaseCreatedMsg1; ?>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php } else { ?>
					<div class="alertMsg info mb-20">
						<div class="msgIcon pull-left">
							<i class="fa fa-info-circle"></i>
						</div>
						<?php echo $allreadyLeasedMsg; ?>
					</div>
				<?php } ?>
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
