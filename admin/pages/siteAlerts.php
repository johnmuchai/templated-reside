<?php
	$count = 0;

	// Add a New Alert
	if (isset($_POST['submit']) && $_POST['submit'] == 'newAlert') {
		// User Validations
		if($_POST['alertTitle'] == '') {
			$msgBox = alertBox($alertTitleReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['alertText'] == '') {
			$msgBox = alertBox($alertTextReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$isActive = htmlspecialchars($_POST['isActive']);
			$alertType = htmlspecialchars($_POST['alertType']);
			$alertTitle = htmlspecialchars($_POST['alertTitle']);
			$alertText = allowedHTML(htmlspecialchars($_POST['alertText']));
			$alertStart = htmlspecialchars($_POST['alertStart']);
			if ($alertStart == '') {
				$alertStart = null;
			} else {
				$alertStart = htmlspecialchars($_POST['alertStart']);
			}
			$alertExpires = htmlspecialchars($_POST['alertExpires']);
			if ($alertExpires == '') {
				$alertExpires = null;
			} else {
				$alertExpires = htmlspecialchars($_POST['alertExpires']);
			}

			$stmt = $mysqli->prepare("
								INSERT INTO
									sitealerts(
										adminId,
										isActive,
										alertType,
										alertTitle,
										alertText,
										alertDate,
										alertStart,
										alertExpires
									) VALUES (
										?,
										?,
										?,
										?,
										?,
										NOW(),
										?,
										?
									)");
			$stmt->bind_param('sssssss',
				$rs_adminId,
				$isActive,
				$alertType,
				$alertTitle,
				$alertText,
				$alertStart,
				$alertExpires
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '6';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$newAlertAct.' "'.$alertTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($newAlertMsg." \"".$alertTitle."\" ".$newLeaseCreatedMsg1, "<i class='fa fa-check-square'></i>", "success");

			// Clear the Form of values
			$_POST['alertTitle'] = $_POST['alertText'] = $_POST['alertStart'] = $_POST['alertExpires'] = '';
		}
	}

	// Update Alert
	if (isset($_POST['submit']) && $_POST['submit'] == 'editAlert') {
		// User Validations
		if($_POST['alertTitle'] == '') {
			$msgBox = alertBox($alertTitleReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['alertText'] == '') {
			$msgBox = alertBox($alertTextReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$alertId = htmlspecialchars($_POST['alertId']);
			$isActive = htmlspecialchars($_POST['isActive']);
			$alertType = htmlspecialchars($_POST['alertType']);
			$alertTitle = htmlspecialchars($_POST['alertTitle']);
			$alertText = allowedHTML(htmlspecialchars($_POST['alertText']));
			$alertStart = htmlspecialchars($_POST['alertStart']);
			if ($alertStart == '') {
				$alertStart = null;
			} else {
				$alertStart = htmlspecialchars($_POST['alertStart']);
			}
			$alertExpires = $_POST['alertExpires'];
			if ($alertExpires == '') {
				$alertExpires = null;
			} else {
				$alertExpires = htmlspecialchars($_POST['alertExpires']);
			};

			$stmt = $mysqli->prepare("UPDATE
										sitealerts
									SET
										isActive = ?,
										alertType = ?,
										alertTitle = ?,
										alertText = ?,
										alertStart = ?,
										alertExpires = ?
									WHERE
										alertId = ?"
			);
			$stmt->bind_param('sssssss',
									$isActive,
									$alertType,
									$alertTitle,
									$alertText,
									$alertStart,
									$alertExpires,
									$alertId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '6';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$editAlertAct.' "'.$alertTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($editAlertMsg." \"".$alertTitle."\" ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");
			// Clear the Form of values
			$_POST['alertTitle'] = $_POST['alertText'] = $_POST['alertStart'] = $_POST['alertExpires'] = '';
		}
	}

	// Delete Alert
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteAlert') {
		$deleteId = htmlspecialchars($_POST['deleteId']);
		$alertTitle = htmlspecialchars($_POST['alertTitle']);

		$stmt = $mysqli->prepare("DELETE FROM sitealerts WHERE alertId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '6';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$delAlertAct.' "'.$alertTitle.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($delAlertMsg." \"".$alertTitle."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");
		// Clear the Form of values
		$_POST['alertTitle'] = $_POST['alertText'] = $_POST['alertStart'] = $_POST['alertExpires'] = '';
	}

	// Get Site Alert Data
    $qry = "SELECT
				sitealerts.*,
				admins.adminName
			FROM
				sitealerts
				LEFT JOIN admins ON sitealerts.adminId = admins.adminId";
    $res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());

	$managePage = 'true';
	$pageTitle = $siteAlertsPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet"><link rel="stylesheet" type="text/css" href="../css/datetimepicker.css" /><link href="../css/chosen.css" rel="stylesheet">';
	$dataTables = 'true';
	$datePicker = 'true';
	$chosen = 'true';
	$jsFile = 'siteAlerts';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('SITEALRTS', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<input type="hidden" id="weekStart" value="<?php echo $set['weekStart']; ?>" />

				<h3><?php echo $pageTitle; ?></h3>
				<p class="text-right mt-10">
					<a data-toggle="modal" href="#newAlert" class="btn btn-info btn-xs btn-icon mt-5 mb-10"><i class="fa fa-trash-o"></i> <?php echo $newSiteAlertBtn; ?></a>
				</p>

				<div class="modal fade" id="newAlert" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
								<h4 class="modal-title"><?php echo $newSiteAlertBtn; ?></h4>
							</div>
							<form action="" method="post">
								<div class="modal-body">
									<p><?php echo $siteAlertQuip; ?></p>

									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="isActive"><?php echo $alertStatField; ?></label>
												<select class="form-control chosen-select" name="isActive" id="isActive">
													<option value="0"><?php echo $inactiveText; ?></option>
													<option value="1"><?php echo $activeTabTitle; ?></option>
												</select>
												<span class="help-block"><?php echo $alertStatFieldHelp; ?></span>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="alertType"><?php echo $alertTypeField; ?></label>
												<select class="form-control chosen-select" name="alertType" id="alertType">
													<option value="0"><?php echo $publicOption; ?></option>
													<option value="1" selected><?php echo $privateOption; ?></option>
												</select>
												<span class="help-block"><?php echo $alertTypeFieldHelp; ?></span>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="alertStart"><?php echo $startDateHead; ?></label>
												<input type="text" class="form-control" name="alertStart" id="alertStart" value="<?php echo isset($_POST['alertStart']) ? $_POST['alertStart'] : ''; ?>" />
												<span class="help-block"><?php echo $alertStartHelp; ?></span>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="alertExpires"><?php echo $endDateHead; ?></label>
												<input type="text" class="form-control" name="alertExpires" id="alertExpires" value="<?php echo isset($_POST['alertExpires']) ? $_POST['alertExpires'] : ''; ?>" />
												<span class="help-block"><?php echo $alertEndHelp; ?></span>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="alertTitle"><?php echo $alertTitleField; ?></label>
										<input type="text" class="form-control" name="alertTitle" id="alertTitle" required="required" value="<?php echo isset($_POST['alertTitle']) ? $_POST['alertTitle'] : ''; ?>" />
									</div>
									<div class="form-group">
										<label for="alertText"><?php echo $alertTextField; ?></label>
										<textarea class="form-control" name="alertText" id="alertText" required="required" rows="4"><?php echo isset($_POST['alertText']) ? $_POST['alertText'] : ''; ?></textarea>
										<span class="help-block"><?php echo $htmlAllowed1; ?></span>
									</div>
								</div>
								<div class="modal-footer">
									<button type="input" name="submit" value="newAlert" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveNewAlertBtn; ?></button>
									<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<table id="sitealerts" class="display" cellspacing="0">
					<thead>
						<tr>
							<th><?php echo $createdByHead; ?></th>
							<th><?php echo $titleHead; ?></th>
							<th class="text-center"><?php echo $statusHead; ?></th>
							<th class="text-center"><?php echo $typeHead; ?></th>
							<th class="text-center"><?php echo $dateCreatedHead; ?></th>
							<th class="text-center"><?php echo $startDateHead; ?></th>
							<th class="text-center"><?php echo $endDateHead; ?></th>
							<th class="text-right"></th>
						</tr>
					</thead>

					<tbody>
					<?php
						while ($row = mysqli_fetch_assoc($res)) {
							if ($row['isActive'] == '1') { $isActive = $activeTabTitle; } else { $isActive= $inactiveText; }
							if ($row['isActive'] == '1') { $active = 'selected'; } else { $active = ''; }
							if ($row['alertType'] == '1') { $type = 'selected'; } else { $type = ''; }
							if ($row['alertType'] == '1') { $alertType = $privateOption; } else { $alertType = $publicOption; }
							if ($row['alertStart'] == null) { $alertStart = ''; } else { $alertStart = dbDateFormat($row['alertStart']); }
							if ($row['alertExpires'] == null) { $alertExpires = ''; } else { $alertExpires = dbDateFormat($row['alertExpires']); }
					?>
							<tr>
								<td><?php echo clean($row['adminName']); ?></td>
								<td><?php echo clean($row['alertTitle']); ?></td>
								<td class="text-center"><?php echo $isActive; ?></td>
								<td class="text-center"><?php echo $alertType; ?></td>
								<td class="text-center"><?php echo shortDateTimeFormat($row['alertDate']); ?></td>
								<td class="text-center"><?php echo $alertStart; ?></td>
								<td class="text-center"><?php echo $alertExpires; ?></td>
								<td class="text-right">
									<a data-toggle="modal" href="#editAlert<?php echo $row['alertId']; ?>" class="text-warning">
										<i class="fa fa-pencil" data-toggle="tooltip" data-placement="left" title="<?php echo $editAlertBtn; ?>"></i>
									</a>
									&nbsp;
									<a data-toggle="modal" href="#deleteAlert<?php echo $row['alertId']; ?>" class="text-danger">
										<i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="<?php echo $delAlertBtn; ?>"></i>
									</a>

									<div class="modal fade" id="editAlert<?php echo $row['alertId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-lg text-left">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
													<h4 class="modal-title"><?php echo $editAlertBtn.' '.clean($row['alertTitle']); ?></h4>
												</div>
												<form action="" method="post">
													<div class="modal-body">
														<p><?php echo $siteAlertQuip; ?></p>
														<div class="row">
															<div class="col-md-3">
																<div class="form-group">
																	<label for="isActive"><?php echo $alertStatField; ?></label>
																	<select class="form-control chosen-select" name="isActive" id="isActive">
																		<option value="0"><?php echo $inactiveText; ?></option>
																		<option value="1" <?php echo $active; ?>><?php echo $activeTabTitle; ?></option>
																	</select>
																	<span class="help-block"><?php echo $alertStatFieldHelp; ?></span>
																</div>
															</div>
															<div class="col-md-3">
																<div class="form-group">
																	<label for="alertType"><?php echo $alertTypeField; ?></label>
																	<select class="form-control chosen-select" name="alertType" id="alertType">
																		<option value="0"><?php echo $publicOption; ?></option>
																		<option value="1" <?php echo $type; ?>><?php echo $privateOption; ?></option>
																	</select>
																	<span class="help-block"><?php echo $alertTypeFieldHelp; ?></span>
																</div>
															</div>
															<div class="col-md-3">
																<div class="form-group">
																	<label for="alertStart_<?php echo $count; ?>"><?php echo $startDateHead; ?></label>
																	<input type="text" class="form-control" name="alertStart" id="alertStart_<?php echo $count; ?>" value="<?php echo $alertStart; ?>" />
																	<span class="help-block"><?php echo $alertStartHelp; ?></span>
																</div>
															</div>
															<div class="col-md-3">
																<div class="form-group">
																	<label for="alertExpires_<?php echo $count; ?>"><?php echo $endDateHead; ?></label>
																	<input type="text" class="form-control" name="alertExpires" id="alertExpires_<?php echo $count; ?>" value="<?php echo $alertExpires; ?>" />
																	<span class="help-block"><?php echo $alertEndHelp; ?></span>
																</div>
															</div>
														</div>

														<div class="form-group">
															<label for="alertTitle"><?php echo $alertTitleField; ?></label>
															<input type="text" class="form-control" name="alertTitle" id="alertTitle" required="required" value="<?php echo clean($row['alertTitle']); ?>" />
														</div>
														<div class="form-group">
															<label for="alertText"><?php echo $alertTextField; ?></label>
															<textarea class="form-control" name="alertText" id="alertText" required="required" rows="4"><?php echo htmlspecialchars_decode($row['alertText']); ?></textarea>
															<span class="help-block"><?php echo $htmlAllowed1; ?></span>
														</div>
													</div>
													<div class="modal-footer">
														<input name="alertId" type="hidden" value="<?php echo $row['alertId']; ?>" />
														<button type="input" name="submit" value="editAlert" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
														<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<div class="modal fade" id="deleteAlert<?php echo $row['alertId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog text-left">
											<div class="modal-content">
												<form action="" method="post">
													<div class="modal-body">
														<p class="lead"><?php echo $delAlertConf; ?> "<?php echo clean($row['alertTitle']); ?>"?</p>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="deleteId" value="<?php echo $row['alertId']; ?>" />
														<input type="hidden" name="alertTitle" value="<?php echo clean($row['alertTitle']); ?>" />
														<button type="input" name="submit" value="deleteAlert" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
														<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</td>
							</tr>
					<?php
							$count++;
						}
					?>
					</tbody>
				</table>

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