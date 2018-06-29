<?php
	// Get Documents Folder from Site Settings
	$docUploadPath = $set['userDocsPath'];

	// Archive Tenant
	if (isset($_POST['submit']) && $_POST['submit'] == 'archiveTenant') {
		$actLease = '';
		$archiveId = htmlspecialchars($_POST['archiveId']);
		$tenantName = htmlspecialchars($_POST['tenantName']);

		// Check if the Tenant has an active lease
		$leaseCheck = $mysqli->query("SELECT 'X' FROM leases WHERE userId = ".$archiveId." AND closed = 0");
		if ($leaseCheck->num_rows) { $actLease = 'true'; }

		if ($actLease == '') {
			// No active leases - archive the account
			$stmt = $mysqli->prepare("UPDATE
										users
									SET
										isActive = 0,
										isArchived = 1,
										archiveDate = NOW()
									WHERE
										userId = ?"
			);
			$stmt->bind_param('s',
									$archiveId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '16';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$archTntAccAct.' "'.$tenantName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($reactTenAccMsg." \"".$tenantName."\" ".$archTntAccAct1, "<i class='fa fa-check-square'></i>", "success");
		} else {
			// Add Recent Activity
			$activityType = '16';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$archTntAccErrAct.' "'.$tenantName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($reactTenAccMsg2." \"".$tenantName."\" ".$archTntAccErrAct1, "<i class='fa fa-check-square'></i>", "success");
		}
	}

	// Delete Tenant
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteTenant') {
		$actLease = '';
		$deleteId = htmlspecialchars($_POST['deleteId']);
		$tenantName = htmlspecialchars($_POST['tenantName']);
		$userFolder = htmlspecialchars($_POST['userFolder']);

		$filePath = '../'.$docUploadPath.$userFolder;

		// Check if the Tenant has an active lease
		$leaseCheck = $mysqli->query("SELECT 'X' FROM leases WHERE userId = ".$deleteId." AND closed = 0");
		if ($leaseCheck->num_rows) { $actLease = 'true'; }

		if ($actLease == '') {
			// No active leases - delete the account
			$stmt = $mysqli->prepare("DELETE FROM users WHERE userId = ?");
			$stmt->bind_param('s', $deleteId);
			$stmt->execute();
			$stmt->close();

			// Delete the Tenant Account
			$stmt = $mysqli->prepare("DELETE FROM userdocs WHERE userId = ?");
			$stmt->bind_param('s', $deleteId);
			$stmt->execute();
			$stmt->close();

			// Delete the Tenant's Folder (and ALL files within) from the server
			array_map('unlink', glob("$filePath/*.*"));
			rmdir($filePath);

			// Add Recent Activity
			$activityType = '16';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delTntAccAct.' "'.$tenantName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($reactTenAccMsg." \"".$tenantName."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");
		} else {
			// Add Recent Activity
			$activityType = '16';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delTntAccAct1.' "'.$tenantName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($reactTenAccMsg2." \"".$tenantName."\" ".$delTntAccMsg, "<i class='fa fa-check-square'></i>", "success");
		}
	}

	// Get Data
	$qry = "SELECT * FROM users WHERE users.isActive = 1 AND users.leaseId = 0";
	$res = mysqli_query($mysqli, $qry) or die('-2' . mysqli_error());

	$tenPage = 'true';
	$pageTitle = $unlTntsPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'unleasedTenants';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if($rs_managerId!=""){ //if ((checkArray('MNGTEN', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
			<h3><?php echo $pageTitle; ?></h3>

			<?php if(mysqli_num_rows($res) < 1) { ?>
				<div class="alertMsg default mb-20">
					<div class="msgIcon pull-left">
						<i class="fa fa-info-circle"></i>
					</div>
					<?php echo $noUnlTntsFound; ?>
				</div>
			<?php } else { ?>
				<table id="unleasedTenants" class="display" cellspacing="0">
					<thead>
						<tr>
							<th><?php echo $tenantHead; ?></th>
							<th class="text-center"><?php echo $typeHead; ?></th>
							<th class="text-center"><?php echo $emailAddyText; ?></th>
							<th class="text-center"><?php echo $contUsFormPhone; ?></th>
							<th class="text-center"><?php echo $joinedOnText; ?></th>
							<th class="text-center"><?php echo $lastSigninHead; ?></th>
							<?php if ($rs_isAdmin != '') { ?>
								<th class="text-right"></th>
							<?php } ?>
						</tr>
					</thead>

					<tbody>
						<?php
							while ($row = mysqli_fetch_assoc($res)) {
								if ($row['isResident'] == '1') { $accType = $residentText; } else { $accType = $tenantText; }

								// Decrypt data for display
								if ($row['primaryPhone'] != '') { $tenantPhone = decryptIt($row['primaryPhone']); } else { $tenantPhone = ''; }

								if ($row['lastVisited'] == '0000-00-00 00:00:00') { $lastLogin = ''; } else { $lastLogin = dateFormat($row['lastVisited']); }
						?>
								<tr>
									<td>
										<a href="index.php?action=viewTenant&userId=<?php echo $row['userId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewTenantText; ?>">
											<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>
										</a>
									</td>
									<td class="text-center"><?php echo $accType; ?></td>
									<td class="text-center"><?php echo clean($row['userEmail']); ?></td>
									<td class="text-center"><?php echo $tenantPhone; ?></td>
									<td class="text-center"><?php echo dateFormat($row['createDate']); ?></td>
									<td class="text-center"><?php echo $lastLogin; ?></td>
									<?php if ($rs_isAdmin != '') { ?>
										<td class="text-right">
											<a data-toggle="modal" href="#archiveTenant<?php echo $row['userId']; ?>" class="text-warning">
												<i class="fa fa-archive" data-toggle="tooltip" data-placement="left" title="<?php echo $archTntAccBtn; ?>"></i>
											</a>
											&nbsp;
											<a data-toggle="modal" href="#deleteTenant<?php echo $row['userId']; ?>" class="text-danger">
												<i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="<?php echo $delTntAccBtn; ?>"></i>
											</a>

											<div class="modal fade" id="archiveTenant<?php echo $row['userId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog text-left">
													<div class="modal-content">
														<form action="" method="post">
															<div class="modal-body">
																<p class="lead">
																	<?php echo $archTntAccConf1.' '.clean($row['userFirstName']).' '.clean($row['userLastName']); ?>?<br />
																	<small><?php echo $archTntAccConf2; ?></small>
																</p>
															</div>
															<div class="modal-footer">
																<input name="archiveId" type="hidden" value="<?php echo $row['userId']; ?>" />
																<input name="tenantName" type="hidden" value="<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>" />
																<button type="input" name="submit" value="archiveTenant" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
																<button type="button" class="btn btn-light btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
															</div>
														</form>
													</div>
												</div>
											</div>

											<div class="modal fade" id="deleteTenant<?php echo $row['userId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog text-left">
													<div class="modal-content">
														<form action="" method="post">
															<div class="modal-body">
																<p class="lead">
																	<?php echo $delTntAccConf1.' '.clean($row['userFirstName']).' '.clean($row['userLastName']); ?>?<br />
																	<small><?php echo $delTntAccConf2; ?></small>
																</p>
															</div>
															<div class="modal-footer">
																<input name="deleteId" type="hidden" value="<?php echo $row['userId']; ?>" />
																<input name="tenantName" type="hidden" value="<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>" />
																<input name="userFolder" type="hidden" value="<?php echo clean($row['userFolder']); ?>" />
																<button type="input" name="submit" value="deleteTenant" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
																<button type="button" class="btn btn-light btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</td>
									<?php } ?>
								</tr>
						<?php } ?>
					</tbody>
				</table>
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