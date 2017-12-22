<?php
	$templateId = $mysqli->real_escape_string($_GET['templateId']);
	$ipAddress = $_SERVER['REMOTE_ADDR'];

	// Get the Templates Directory
	$templatesPath = $set['templatesPath'];

	// Update Template
	if (isset($_POST['submit']) && $_POST['submit'] == 'editTemplate') {
		// User Validations
		if($_POST['templateName'] == '') {
			$msgBox = alertBox($templNameReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['templateDesc'] == '') {
			$msgBox = alertBox($templDescReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$templateName = htmlspecialchars($_POST['templateName']);
			$templateDesc = htmlspecialchars($_POST['templateDesc']);

			$stmt = $mysqli->prepare("UPDATE
										sitetemplates
									SET
										templateName = ?,
										templateDesc = ?
									WHERE
										templateId = ?"
			);
			$stmt->bind_param('sss',
									$templateName,
									$templateDesc,
									$templateId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '7';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$updTemplAct.' "'.$templateName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($updTemplMsg." \"".$templateName."\" ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");
		}
	}
	
	// Delete Template
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteTemplate') {
		$templateName = htmlspecialchars($_POST['templateName']);
		$templateUrl = htmlspecialchars($_POST['templateUrl']);
		
		$filePath = '../'.$templatesPath.$templateUrl;
		
		if (file_exists($filePath)) {
			unlink($filePath);

			// Delete the Template record
			$stmt = $mysqli->prepare("DELETE FROM sitetemplates WHERE templateId = ?");
			$stmt->bind_param('s', $templateId);
			$stmt->execute();
			$stmt->close();
			
			$msgBox = alertBox($updTemplMsg." \"".$templateName."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");

			// Add Recent Activity
			$activityType = '7';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delTemplAct.' '.$templateName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
			
			// Redirect to the Properties Payment History
			header ('Location: index.php?action=forms&deleted=yes');
		} else {
			$msgBox = alertBox($delTemplError, "<i class='fa fa-warning'></i>", "warning");

			// Add Recent Activity
			$activityType = '7';
			$rs_uid = '0';
			$activityTitle = $delTemplErrAct.' '.$templateName.' '.$deleteFileAct2;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}
	}

	// Get Data
	$qry = "SELECT
				sitetemplates.*,
				admins.adminName
			FROM
				sitetemplates
				LEFT JOIN admins ON sitetemplates.adminId = admins.adminId
			WHERE templateId = ".$templateId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);

	$managePage = 'true';
	$pageTitle = $viewTemplatePageName;

	include 'includes/header.php';
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