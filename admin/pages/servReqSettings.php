<?php
	// Add a Priority Option
	if (isset($_POST['submit']) && $_POST['submit'] == 'newPriority') {
		// User Validations
		if($_POST['priorityTitle'] == '') {
			$msgBox = alertBox($priTitleReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$priorityTitle = htmlspecialchars($_POST['priorityTitle']);

			$stmt = $mysqli->prepare("
								INSERT INTO
									servicepriority(
										priorityTitle,
										createDate
									) VALUES (
										?,
										NOW()
									)");
			$stmt->bind_param('s',$priorityTitle);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '8';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$newPriOptionAct.' "'.$priorityTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($newPriOptionMsg." \"".$priorityTitle."\" ".$newDiscCmtMsg2, "<i class='fa fa-check-square'></i>", "success");

			// Clear the Form of values
			$_POST['priorityTitle'] = '';
		}
	}
	
	// Update Priority Option
	if (isset($_POST['submit']) && $_POST['submit'] == 'editPriority') {
		// User Validations
		if($_POST['priorityTitle'] == '') {
			$msgBox = alertBox($priTitleReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$priorityId = htmlspecialchars($_POST['priorityId']);
			$priorityTitle = htmlspecialchars($_POST['priorityTitle']);

			$stmt = $mysqli->prepare("UPDATE
										servicepriority
									SET
										priorityTitle = ?
									WHERE
										priorityId = ?"
			);
			$stmt->bind_param('ss',
									$priorityTitle,
									$priorityId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '8';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$editPriOptionAct.' "'.$priorityTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($editPriOptionMsg." \"".$priorityTitle."\" ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");
			// Clear the Form of values
			$_POST['priorityTitle'] = '';
		}
	}
	
	// Delete Priority Option
	if (isset($_POST['submit']) && $_POST['submit'] == 'deletePriority') {
		$deleteId = htmlspecialchars($_POST['deleteId']);
		$priorityTitle = htmlspecialchars($_POST['priorityTitle']);

		$stmt = $mysqli->prepare("DELETE FROM servicepriority WHERE priorityId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '8';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$deletPriOptionAct.' "'.$priorityTitle.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($deletPriOptionMsg." \"".$priorityTitle."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");
		// Clear the Form of values
		$_POST['priorityTitle'] = '';
	}
	
	// Add a Status Option
	if (isset($_POST['submit']) && $_POST['submit'] == 'newStatus') {
		// User Validations
		if($_POST['statusTitle'] == '') {
			$msgBox = alertBox($staTitleReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$statusTitle = htmlspecialchars($_POST['statusTitle']);

			$stmt = $mysqli->prepare("
								INSERT INTO
									servicestatus(
										statusTitle,
										createDate
									) VALUES (
										?,
										NOW()
									)");
			$stmt->bind_param('s',$statusTitle);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '8';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$newStaOptionAct.' "'.$statusTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($newStaOptionMsg." \"".$statusTitle."\" ".$newDiscCmtMsg2, "<i class='fa fa-check-square'></i>", "success");

			// Clear the Form of values
			$_POST['statusTitle'] = '';
		}
	}
	
	// Update Status Option
	if (isset($_POST['submit']) && $_POST['submit'] == 'editStatus') {
		// User Validations
		if($_POST['statusTitle'] == '') {
			$msgBox = alertBox($staTitleReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$statusId = htmlspecialchars($_POST['statusId']);
			$statusTitle = htmlspecialchars($_POST['statusTitle']);

			$stmt = $mysqli->prepare("UPDATE
										servicestatus
									SET
										statusTitle = ?
									WHERE
										statusId = ?"
			);
			$stmt->bind_param('ss',
									$statusTitle,
									$statusId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '8';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$editStaOptionAct.' "'.$statusTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($editStaOptionMsg." \"".$statusTitle."\" ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");
			// Clear the Form of values
			$_POST['statusTitle'] = '';
		}
	}
	
	// Delete Status Option
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteStatus') {
		$deleteId = htmlspecialchars($_POST['deleteId']);
		$statusTitle = htmlspecialchars($_POST['statusTitle']);

		$stmt = $mysqli->prepare("DELETE FROM servicestatus WHERE statusId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '8';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$delStaOptionAct.' "'.$statusTitle.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($delStaOptionMsg." \"".$statusTitle."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");
		// Clear the Form of values
		$_POST['statusTitle'] = '';
	}

	// Get Data
    $qry = "SELECT * FROM servicepriority";
    $res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	
	// Get Data
    $sql = "SELECT * FROM servicestatus";
    $result = mysqli_query($mysqli, $sql) or die('-2' . mysqli_error());

	$managePage = 'true';
	$pageTitle = $serReqSettingsPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'servReqSettings';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('SITESET', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle; ?></h3>
		
				<div class="row">
					<div class="col-md-6">
						<h4><?php echo $servPriSelOptions; ?></h4>
						<hr class="mt-0 mb-10" />
						<p class="text-muted">
							<?php echo $servPriQuip; ?>
							<a data-toggle="modal" href="#newPriority" class="btn btn-info btn-xs btn-icon pull-right"><i class="fa fa-plus"></i> <?php echo $newPriOptBtn; ?></a>
						</p>

						<div class="modal fade" id="newPriority" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
										<h4 class="modal-title"><?php echo $newPriOptionH4; ?></h4>
									</div>
									<form action="" method="post">
										<div class="modal-body">
											<div class="form-group">
												<label for="priorityTitle"><?php echo $priTitleField; ?></label>
												<input type="text" class="form-control" name="priorityTitle" required="required" value="<?php echo isset($_POST['priorityTitle']) ? $_POST['priorityTitle'] : ''; ?>" />
											</div>
										</div>
										<div class="modal-footer">
											<button type="input" name="submit" value="newPriority" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
						
						<?php if(mysqli_num_rows($res) > 0) { ?>
							<table id="servPriority" class="display" cellspacing="0">
								<thead>
									<tr>
										<th><?php echo $priTitleField; ?></th>
										<th class="text-center"><?php echo $dateCreatedHead; ?></th>
										<th class="text-center"></th>
									</tr>
								</thead>
								<tbody>
									<?php while ($row = mysqli_fetch_assoc($res)) { ?>
										<tr>
											<td><?php echo clean($row['priorityTitle']); ?></td>
											<td class="text-center"><?php echo dateFormat($row['createDate']); ?></td>
											<td class="text-right">
												<a data-toggle="modal" href="#editPriority<?php echo $row['priorityId']; ?>" class="text-warning">
													<i class="fa fa-pencil" data-toggle="tooltip" data-placement="left" title="<?php echo $editPriTitleText; ?>"></i>
												</a>
												&nbsp;
												<a data-toggle="modal" href="#deletePriority<?php echo $row['priorityId']; ?>" class="text-danger">
													<i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="<?php echo $delPriTitleText; ?>"></i>
												</a>

												<div class="modal fade" id="editPriority<?php echo $row['priorityId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog text-left">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
																<h4 class="modal-title"><?php echo $editPriTitleText.' '.clean($row['priorityTitle']); ?></h4>
															</div>
															<form action="" method="post">
																<div class="modal-body">
																	<div class="form-group">
																		<label for="priorityTitle"><?php echo $priTitleField; ?></label>
																		<input type="text" class="form-control" name="priorityTitle" required="required" value="<?php echo clean($row['priorityTitle']); ?>" />
																	</div>
																</div>
																<div class="modal-footer">
																	<input name="priorityId" type="hidden" value="<?php echo $row['priorityId']; ?>" />
																	<button type="input" name="submit" value="editPriority" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
																	<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
																</div>
															</form>
														</div>
													</div>
												</div>

												<div class="modal fade" id="deletePriority<?php echo $row['priorityId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog text-left">
														<div class="modal-content">
															<form action="" method="post">
																<div class="modal-body">
																	<p class="lead"><?php echo $delPriOptionConf; ?> "<?php echo clean($row['priorityTitle']); ?>"?</p>
																</div>
																<div class="modal-footer">
																	<input type="hidden" name="deleteId" value="<?php echo $row['priorityId']; ?>" />
																	<input type="hidden" name="priorityTitle" value="<?php echo clean($row['priorityTitle']); ?>" />
																	<button type="input" name="submit" value="deletePriority" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
																	<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
																</div>
															</form>
														</div>
													</div>
												</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						<?php } else { ?>
							<div class="alertMsg default mb-20">
								<div class="msgIcon pull-left">
									<i class="fa fa-info-circle"></i>
								</div>
								<?php echo $noPriOptFoundMsg; ?>
							</div>
						<?php } ?>
					</div>
					<div class="col-md-6">
						<h4><?php echo $servStaOptionH4; ?></h4>
						<hr class="mt-0 mb-10" />
						<p class="text-muted">
							<?php echo $servStaOptionsQuip; ?>
							<a data-toggle="modal" href="#newStatus" class="btn btn-info btn-xs btn-icon pull-right"><i class="fa fa-plus"></i> <?php echo $newStaOptionBtn; ?></a>
						</p>

						<div class="modal fade" id="newStatus" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
										<h4 class="modal-title"><?php echo $newStaOptH4; ?></h4>
									</div>
									<form action="" method="post">
										<div class="modal-body">
											<div class="form-group">
												<label for="statusTitle"><?php echo $staTitleField; ?></label>
												<input type="text" class="form-control" name="statusTitle" required="required" value="<?php echo isset($_POST['statusTitle']) ? $_POST['statusTitle'] : ''; ?>" />
											</div>
										</div>
										<div class="modal-footer">
											<button type="input" name="submit" value="newStatus" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
						
						<?php if(mysqli_num_rows($result) > 0) { ?>
							<table id="servStatus" class="display" cellspacing="0">
								<thead>
									<tr>
										<th><?php echo $staTitleField; ?></th>
										<th class="text-center"><?php echo $dateCreatedHead; ?></th>
										<th class="text-center"></th>
									</tr>
								</thead>
								<tbody>
									<?php while ($rows = mysqli_fetch_assoc($result)) { ?>
										<tr>
											<td><?php echo clean($rows['statusTitle']); ?></td>
											<td class="text-center"><?php echo dateFormat($rows['createDate']); ?></td>
											<td class="text-right">
												<a data-toggle="modal" href="#editStatus<?php echo $rows['statusId']; ?>" class="text-warning">
													<i class="fa fa-pencil" data-toggle="tooltip" data-placement="left" title="<?php echo $editStaTitleText; ?>"></i>
												</a>
												&nbsp;
												<a data-toggle="modal" href="#deleteStatus<?php echo $rows['statusId']; ?>" class="text-danger">
													<i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="Delete Status Option"></i>
												</a>

												<div class="modal fade" id="editStatus<?php echo $rows['statusId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog text-left">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
																<h4 class="modal-title"><?php echo $editStaTitleText.' '.clean($rows['statusTitle']); ?></h4>
															</div>
															<form action="" method="post">
																<div class="modal-body">
																	<div class="form-group">
																		<label for="statusTitle"><?php echo $staTitleField; ?></label>
																		<input type="text" class="form-control" name="statusTitle" required="required" value="<?php echo clean($rows['statusTitle']); ?>" />
																	</div>
																</div>
																<div class="modal-footer">
																	<input name="statusId" type="hidden" value="<?php echo $rows['statusId']; ?>" />
																	<button type="input" name="submit" value="editStatus" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
																	<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
																</div>
															</form>
														</div>
													</div>
												</div>

												<div class="modal fade" id="deleteStatus<?php echo $rows['statusId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog text-left">
														<div class="modal-content">
															<form action="" method="post">
																<div class="modal-body">
																	<p class="lead"><?php echo $delStatusOptConf; ?> "<?php echo clean($rows['statusTitle']); ?>"?</p>
																</div>
																<div class="modal-footer">
																	<input type="hidden" name="deleteId" value="<?php echo $rows['statusId']; ?>" />
																	<input type="hidden" name="statusTitle" value="<?php echo clean($rows['statusTitle']); ?>" />
																	<button type="input" name="submit" value="deleteStatus" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
																	<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
																</div>
															</form>
														</div>
													</div>
												</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						<?php } else { ?>
							<div class="alertMsg default mb-20">
								<div class="msgIcon pull-left">
									<i class="fa fa-info-circle"></i>
								</div>
								<?php echo $noStatusOptionsFound; ?>
							</div>
						<?php } ?>
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