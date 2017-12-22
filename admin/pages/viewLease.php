<?php
	$leaseId = $mysqli->real_escape_string($_GET['leaseId']);
	$weekStart = $set['weekStart'];
	$ipAddress = $_SERVER['REMOTE_ADDR'];

	// Update Lease
	if (isset($_POST['submit']) && $_POST['submit'] == 'updateLease') {
		if($_POST['leaseTerm'] == "") {
            $msgBox = alertBox($leaseTermReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['leaseStart'] == "") {
            $msgBox = alertBox($leaseStartDateReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['leaseEnd'] == "") {
            $msgBox = alertBox($leaseEndDateReq, "<i class='fa fa-times-circle'></i>", "danger");
		}  else {
			$property = htmlspecialchars($_POST['property']);
			$leaseTerm = htmlspecialchars($_POST['leaseTerm']);
			$leaseStart = htmlspecialchars($_POST['leaseStart']);
			$leaseEnd = htmlspecialchars($_POST['leaseEnd']);
			$notes = htmlspecialchars($_POST['notes']);

			$stmt = $mysqli->prepare("UPDATE
										leases
									SET
										leaseTerm = ?,
										leaseStart = ?,
										leaseEnd = ?,
										notes = ?,
										lastUpdated = NOW(),
										ipAddress = ?
									WHERE
										leaseId = ?"
			);
			$stmt->bind_param('ssssss',
									$leaseTerm,
									$leaseStart,
									$leaseEnd,
									$notes,
									$ipAddress,
									$leaseId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '20';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$updLeaseAct.' '.$property;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($updLeaseMsg." ".$property." ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");
		}
	}

	// Close Lease
	if (isset($_POST['submit']) && $_POST['submit'] == 'closeLease') {
		$propertyName = htmlspecialchars($_POST['propertyName']);
		$propertyId = htmlspecialchars($_POST['propertyId']);
		$user = htmlspecialchars($_POST['user']);
		$userId = htmlspecialchars($_POST['userId']);

		// Update the Lease
		$stmt = $mysqli->prepare("UPDATE
									leases
								SET
									closed = 1,
									lastUpdated = NOW(),
									ipAddress = ?
								WHERE
									leaseId = ?"
		);
		$stmt->bind_param('ss',
								$ipAddress,
								$leaseId
		);
		$stmt->execute();
		$stmt->close();

		// Update the Property
		$stmt = $mysqli->prepare("UPDATE
									properties
								SET
									isLeased = 0,
									lastUpdated = NOW()
								WHERE
									propertyId = ?"
		);
		$stmt->bind_param('s',
								$propertyId
		);
		$stmt->execute();
		$stmt->close();

		// Update the User
		$stmt = $mysqli->prepare("UPDATE
									users
								SET
									isLeased = 0,
									propertyId = 0,
									leaseId = 0
								WHERE
									userId = ?"
		);
		$stmt->bind_param('s',
								$userId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '20';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$closeLeaseAct.' '.$propertyName;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($closeLeaseMsg." ".$propertyName." ".$closeLeaseMsg1, "<i class='fa fa-check-square'></i>", "success");
	}

	// Get Data
	$qry = "SELECT
				leases.*,
				properties.propertyId,
				properties.propertyName,
				users.userId,
				CONCAT(users.userFirstName,' ',users.userLastName) AS user,
				admins.adminName
			FROM
				leases
				LEFT JOIN properties ON leases.propertyId = properties.propertyId
				LEFT JOIN users ON leases.userId = users.userId
				LEFT JOIN assigned ON properties.propertyId = assigned.propertyId
				LEFT JOIN admins ON assigned.adminId = admins.adminId
			WHERE
				leases.leaseId = ".$leaseId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);

	if ($row['closed'] == '0') { $status = $actLeaseText; } else { $status = $inactLeaseText; }
	if ($row['lastUpdated'] == '0000-00-00 00:00:00') { $lastUpdated = ''; } else { $lastUpdated = dateTimeFormat($row['lastUpdated']); }

	$propPage = 'true';
	$pageTitle = $viewLeasePageTitle;
	$addCss = '<link rel="stylesheet" type="text/css" href="../css/datetimepicker.css" />';
	$datePicker = 'true';
	$jsFile = 'viewLease';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle; ?></h3>

				<div class="row mb-10">
					<div class="col-md-4">
						<ul class="list-group mt-10">
							<li class="list-group-item"><strong><?php echo $newPaymentEmail2; ?></strong>
								<a href="index.php?action=viewProperty&propertyId=<?php echo $row['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
									<?php echo clean($row['propertyName']); ?>
								</a>
							</li>
							<li class="list-group-item"><strong><?php echo $tenantNameText; ?>:</strong>
								<a href="index.php?action=viewTenant&userId=<?php echo $row['userId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewTenantText; ?>">
									<?php echo clean($row['user']); ?>
								</a>
							</li>
							<li class="list-group-item"><strong><?php echo $leaseStatusText; ?>:</strong> <?php echo $status; ?></li>
							<li class="list-group-item"><strong><?php echo $lastUpdatedHead; ?>:</strong> <?php echo $lastUpdated; ?></li>
						</ul>
						<?php if ($row['closed'] == '0') { ?>
							<a data-toggle="modal" href="#closeLease" class="btn btn-info btn-icon"><i class="fa fa-archive"></i> <?php echo $closeLeaseBtn; ?></a>

							<div class="modal fade" id="closeLease" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<form action="" method="post">
											<div class="modal-body">
												<p class="lead"><?php echo $closeLeaseConf; ?></p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
												<input type="hidden" name="propertyId" value="<?php echo clean($row['propertyId']); ?>" />
												<input type="hidden" name="user" value="<?php echo clean($row['user']); ?>" />
												<input type="hidden" name="userId" value="<?php echo clean($row['userId']); ?>" />
												<button type="input" name="submit" value="closeLease" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $closeLeaseConfBtn; ?></button>
												<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>
						<?php } else { ?>
							<div class="alertMsg warning">
								<div class="msgIcon pull-left">
									<i class="fa fa-archive"></i>
								</div>
								<?php echo $leaseClosedMsg; ?>
							</div>
						<?php } ?>
					</div>
					<div class="col-md-8">
						<form action="" method="post" class="mb-20">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="leaseTerm"><?php echo $termOfLeaseField; ?></label>
										<input type="text" class="form-control" name="leaseTerm" id="leaseTerm" required="required" value="<?php echo clean($row['leaseTerm']); ?>" />
										<span class="help-block"><?php echo $termOfLeaseFieldHelp; ?></span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="leaseStart"><?php echo $leaseStartDateField; ?></label>
										<input type="text" class="form-control" name="leaseStart" id="leaseStart" required="required" value="<?php echo dbDateFormat($row['leaseStart']); ?>" />
										<span class="help-block"><?php echo $leaseStartDateFieldHelp; ?></span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="leaseEnd"><?php echo $leaseEndDateField; ?></label>
										<input type="text" class="form-control" name="leaseEnd" id="leaseEnd" required="required" value="<?php echo dbDateFormat($row['leaseEnd']); ?>" />
										<span class="help-block"><?php echo $leaseEndDateFieldHelp; ?></span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="notes"><?php echo $leaseNotesField; ?></label>
								<textarea class="form-control" name="notes" id="notes" rows="3"><?php echo clean($row['notes']); ?></textarea>
								<span class="help-block"><?php echo $leaseNotesFieldHelp; ?></span>
							</div>

							<button type="input" name="submit" value="updateLease" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
						</form>
					</div>
				</div>
				<input type="hidden" id="weekStart" value="<?php echo $weekStart; ?>" />

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