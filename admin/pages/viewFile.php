<?php
	$fileId = $mysqli->real_escape_string($_GET['fileId']);
	$assignCheck = $assignedId = '';
	
	// Get the File Uploads Folder from the Site Settings
	$uploadsDir = $set['uploadPath'];
	
	// Delete File
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteFile') {
		$propertyId = htmlspecialchars($_POST['propertyId']);
		$fileName = htmlspecialchars($_POST['fileName']);
		$fileUrl = htmlspecialchars($_POST['fileUrl']);
		
		$filePath = '../'.$uploadsDir.$fileUrl;
		
		if (file_exists($filePath)) {
			unlink($filePath);

			// Delete the File record
			$stmt = $mysqli->prepare("DELETE FROM propfiles WHERE fileId = ?");
			$stmt->bind_param('s', $fileId);
			$stmt->execute();
			$stmt->close();
			
			// Add Recent Activity
			$activityType = '19';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$deleteFileAct.' '.$fileName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
			
			// Redirect to the Properties Page
			header ('Location: index.php?action=viewProperty&propertyId='.$propertyId.'&delFile=yes');
		} else {
			$msgBox = alertBox($deleteFileMsg, "<i class='fa fa-warning'></i>", "warning");

			// Add Recent Activity
			$activityType = '19';
			$rs_uid = '0';
			$activityTitle = $deleteFileAct1.' '.$fileName.' '.$deleteFileAct2;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}
	}

	$qry = "SELECT
				propfiles.*,
				properties.propertyName,
				admins.adminId,
				admins.adminName
			FROM
				propfiles
				LEFT JOIN properties ON propfiles.propertyId = properties.propertyId
				LEFT JOIN admins ON propfiles.adminId = admins.adminId
			WHERE
				propfiles.fileId = ".$fileId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);
	
	$checkAssigned = "SELECT
						propfiles.propertyId,
						assigned.adminId AS assignedId,
						admins.adminName AS assignedTo
					FROM
						propfiles
						LEFT JOIN assigned ON propfiles.propertyId = assigned.propertyId
						LEFT JOIN admins ON assigned.adminId = admins.adminId
					WHERE
						propfiles.fileId = ".$fileId;
	$caRes = mysqli_query($mysqli, $checkAssigned) or die('-2' . mysqli_error());
	$carow = mysqli_fetch_assoc($caRes);

	if ($rs_isAdmin == '') {
		// Not a superuser
		if ($carow['assignedId'] != '') {
			// If the Property is Assigned
			if ($carow['assignedId'] == $rs_adminId) {
				// Set to true
				$assignCheck = 'true';
			} else {
				// Keep it empty
				$assignCheck = '';
			}
		} else {
			// Set to true
			$assignCheck = 'true';
		}
	} else {
		// Is a superuser - set to true
		$assignCheck = 'true';
	}

	$propPage = 'true';
	$pageTitle = $viewFilePageTitle;

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
				// If the Property is assigned, is it assigned to the logged in manager?
				if (($assignCheck == 'true') || ($assignedId == $rs_adminId)) {
					if ($msgBox) { echo $msgBox; }
		?>
					<h3><?php echo $pageTitle; ?></h3>
		
					<div class="row mb-10">
						<div class="col-md-4">
							<ul class="list-group">
								<li class="list-group-item"><strong><?php echo $titleText; ?></strong> <?php echo clean($row['fileName']); ?></li>
								<li class="list-group-item"><strong><?php echo $newPaymentEmail2; ?></strong>
									<a href="index.php?action=viewProperty&propertyId=<?php echo $row['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
										<?php echo clean($row['propertyName']); ?>
									</a>
								</li>
								<li class="list-group-item"><strong><?php echo $uploadedByText; ?></strong> <?php echo clean($row['adminName']); ?></li>
								<li class="list-group-item"><strong><?php echo $uploadedOnText; ?></strong> <?php echo dateFormat($row['uploadDate']); ?></li>
							</ul>
							
							<a data-toggle="modal" href="#deleteFile" class="btn btn-default btn-xs btn-icon"><i class="fa fa-trash"></i> <?php echo $deleteFileBtn; ?></a>
							<div class="modal fade" id="deleteFile" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog text-left">
									<div class="modal-content">
										<form action="" method="post">
											<div class="modal-body">
												<p class="lead"><?php echo $deleteFileConf; ?> "<?php echo clean($row['fileName']); ?>"?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="propertyId" value="<?php echo clean($row['propertyId']); ?>" />
												<input type="hidden" name="fileName" value="<?php echo clean($row['fileName']); ?>" />
												<input type="hidden" name="fileUrl" value="<?php echo clean($row['fileUrl']); ?>" />
												<button type="input" name="submit" value="deleteFile" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
												<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<p><strong><?php echo $fileDescText; ?></strong> <?php echo clean($row['fileDesc']); ?></p>

							<hr />

							<?php
								//Get File Extension
								$ext = substr(strrchr($row['fileUrl'],'.'), 1);
								$imgExts = array('gif','GIF','jpg','JPG','jpeg','JPEG','png','PNG','tiff','TIFF','tif','TIF','bmp','BMP');

								if (in_array($ext, $imgExts)) {
									echo '
											<p>
												<a href="../'.$uploadsDir.$row['fileUrl'].'" target="_blank">
													<img alt="'.clean($row['fileName']).'" src="../'.$uploadsDir.$row['fileUrl'].'" class="img-responsive" />
												</a>
											</p>
										';
								} else {
									echo '
											<div class="alertMsg default mb-20">
												<div class="msgIcon pull-left">
													<i class="fa fa-info-circle"></i>
												</div>
												'.$noPreviewAvailText.' '.clean($row['fileName']).'
											</div>
											<p>
												<a href="../'.$uploadsDir.$row['fileUrl'].'" class="btn btn-success btn-icon" target="_blank">
												<i class="fa fa-download"></i> '.$downloadFileText.' '.$row['fileName'].'</a>
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
		<?php
				}
			} else {
		?>
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