<?php
	$propertyId = $mysqli->real_escape_string($_GET['propertyId']);

	// Get the Max Upload Size allowed
    $maxUpload = (int)(ini_get('upload_max_filesize'));

	// Get the Uploads Directory
	$uploadPath = $set['uploadPath'];

	// Get the file types allowed from Site Settings
	$filesAllowed = $set['fileTypesAllowed'];
	// Replace the commas with a comma space
	$fileTypesAllowed = preg_replace('/,/', ', ', $filesAllowed);

	$ipAddress = $_SERVER['REMOTE_ADDR'];

	// Upload File
	if (isset($_POST['submit']) && $_POST['submit'] == 'uploadFile') {
		// User Validations
		if($_POST['fileName'] == '') {
			$msgBox = alertBox($fileTitleReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['fileDesc'] == '') {
			$msgBox = alertBox($fileDescReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$fileName = htmlspecialchars($_POST['fileName']);
			$fileDesc = htmlspecialchars($_POST['fileDesc']);
			$propertyName = htmlspecialchars($_POST['propertyName']);

			// Get the File Types allowed
			$fileExt = $set['fileTypesAllowed'];
			$ftypes = array($fileExt);
			$ftypes_data = explode( ',', $fileExt );

			// Check file type
			$ext = substr(strrchr(basename($_FILES['file']['name']), '.'), 1);
			if (!in_array($ext, $ftypes_data)) {
				$msgBox = alertBox($fileTypeNotAllowed, "<i class='fa fa-times-circle'></i>", "danger");
			} else {
				// Rename the File to the Properties Name
				$fName = clean(strip($propertyName));

				// Replace any spaces with an underscore
				// And set to all lower-case
				$newName = str_replace(' ', '-', $fName);
				$newFName = strtolower($newName);

				// Generate a RANDOM Hash
				$randomHash = uniqid(rand());
				// Take the first 8 hash digits and use them as part of the Image Name
				$randHash = substr($randomHash, 0, 8);

				$fullName = $newFName.'-'.$randHash;

				// set the upload path
				$fileUrl = basename($_FILES['file']['name']);

				// Get the files original Ext
				$extension = explode(".", $fileUrl);
				$extension = end($extension);

				// Set the files name to the name set in the form
				// And add the original Ext
				$newFileName = $fullName.'.'.$extension;
				$movePath = '../'.$uploadPath.$newFileName;

				$stmt = $mysqli->prepare("
									INSERT INTO
										propfiles(
											propertyId,
											adminId,
											fileName,
											fileDesc,
											fileUrl,
											uploadDate,
											ipAddress
										) VALUES (
											?,
											?,
											?,
											?,
											?,
											NOW(),
											?
										)");
				$stmt->bind_param('ssssss',
					$propertyId,
					$rs_adminId,
					$fileName,
					$fileDesc,
					$newFileName,
					$ipAddress
				);

				if (move_uploaded_file($_FILES['file']['tmp_name'], $movePath)) {
					$stmt->execute();
					$msgBox = alertBox($theFileText." ".$fileName." ".$hasBeenUplAct,"<i class='fa fa-check-square'></i>", "success");
					$stmt->close();

					// Add Recent Activity
					$activityType = '19';
					$rs_uid = '0';
					$activityTitle = $rs_adminName.' '.$propFileUplAct.' '.$propertyName;
					updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
				} else {
					$msgBox = alertBox($propFileUplError, "<i class='fa fa-times-circle'></i>", "danger");

					// Add Recent Activity
					$activityType = '19';
					$rs_uid = '0';
					$activityTitle = $aFileForText.' '.$propertyName.' '.$templUplActError1;
					updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
				}
			}
		}
	}

	// Delete File
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteFile') {
		$deleteId = htmlspecialchars($_POST['deleteId']);
		$fileName = htmlspecialchars($_POST['fileName']);
		$propertyName = htmlspecialchars($_POST['propertyName']);
		$fileUrl = htmlspecialchars($_POST['fileUrl']);

		$filePath = '../'.$uploadPath.$fileUrl;

		// Delete the Picture from the server
		if (file_exists($filePath)) {
			unlink($filePath);

			$stmt = $mysqli->prepare("DELETE FROM propfiles WHERE fileId = ".$deleteId);
			$stmt->execute();
			$stmt->close();

			$msgBox = alertBox($theFileText." \"".$fileName."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");

			// Add Recent Activity
			$activityType = '19';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delFileAct.' "'.$fileName.'" '.$forText.' '.$propertyName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		} else {
			$msgBox = alertBox($delFileError, "<i class='fa fa-warning'></i>", "warning");

			// Add Recent Activity
			$activityType = '19';
			$rs_uid = '0';
			$activityTitle = $aFileForText.' '.$propertyName.' '.$deleteFileAct2;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}
	}

	// get Upload Data
	$qry = "SELECT
				propfiles.*,
				admins.adminName
			FROM
				propfiles
				LEFT JOIN admins ON propfiles.adminId = admins.adminId
			WHERE
				propfiles.propertyId = ".$propertyId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());

	// get property Data
	$sql = "SELECT
				properties.propertyName,
				assigned.adminId AS assignedTo
			FROM
				properties
				LEFT JOIN assigned ON properties.propertyId = assigned.propertyId
				LEFT JOIN admins ON assigned.adminId = admins.adminId
			WHERE
				properties.propertyId = ".$propertyId;
	$result = mysqli_query($mysqli, $sql) or die('-2' . mysqli_error());
	$rows = mysqli_fetch_assoc($result);

	if ($rs_isAdmin == '') {
		$assignCheck = $rows['assignedTo'];
	} else {
		$assignCheck = '';
	}

	$propPage = 'true';
	$pageTitle = $propertyFilesH3;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'viewUploads';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
				// If the Property is assigned, is it assigned to the logged in manager?
				if ($assignCheck == '' || $assignCheck == $rs_adminId) {
					if ($msgBox) { echo $msgBox; }
		?>
					<h3>
						<a href="index.php?action=viewProperty&propertyId=<?php echo $propertyId; ?>"><?php echo clean($rows['propertyName']); ?> <?php echo $pageTitle; ?></a>
					</h3>
					<p class="text-right">
						<a data-toggle="modal" href="#uploadFile" class="btn btn-success btn-xs btn-icon mb-10"><i class="fa fa-upload"></i> <?php echo $uplFileBtn; ?></a>
					</p>

					<div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
									<h4 class="modal-title"><?php echo $uplFileH4; ?></h4>
								</div>
								<form enctype="multipart/form-data" action="" method="post">
									<div class="modal-body">
										<p>
											<small>
												<?php echo $propFileTypesAlld; ?>: <?php echo $fileTypesAllowed; ?><br />
												<?php echo $maxUploadSizeText.' '.$maxUpload; ?> mb.
											</small>
										</p>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="fileName"><?php echo $fileTitleField; ?></label>
													<input type="text" class="form-control" name="fileName" id="fileName" required="required" maxlength="50" value="<?php echo isset($_POST['fileName']) ? $_POST['fileName'] : ''; ?>" />
													<span class="help-block"><?php echo $fileTitleFieldHelp; ?></span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="fileDesc"><?php echo $fileDescText; ?></label>
													<input type="text" class="form-control" name="fileDesc" id="fileDesc" required="required" value="<?php echo isset($_POST['fileDesc']) ? $_POST['fileDesc'] : ''; ?>" />
													<span class="help-block"><?php echo $fileDescFieldHelp; ?></span>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="file"><?php echo $selFileField; ?></label>
											<input type="file" id="file" name="file" />
										</div>
									</div>
									<div class="modal-footer">
										<input type="hidden" name="propertyName" value="<?php echo clean($rows['propertyName']); ?>" />
										<button type="input" name="submit" value="uploadFile" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $uploadFileBtn; ?></button>
										<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<?php if(mysqli_num_rows($res) > 0) { ?>
						<table id="uploads" class="display" cellspacing="0">
							<thead>
								<tr>
									<th><?php echo $fileTitleHead; ?></th>
									<th><?php echo $descriptionHead; ?></th>
									<th class="text-center"><?php echo $uploadedByHead; ?></th>
									<th class="text-center"><?php echo $dateUploadedHead; ?></th>
									<th class="text-center"><?php echo $ipAddHead; ?></th>
									<th class="text-right"></th>
								</tr>
							</thead>

							<tbody>
							<?php
								while ($row = mysqli_fetch_assoc($res)) {
									if ($row['ipAddress'] == '::1') { $ipAddress = $localhostIpAdd; } else { $ipAddress = $row['ipAddress']; }
							?>
									<tr>
										<td>
											<a href="index.php?action=viewFile&fileId=<?php echo $row['fileId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewFileText; ?>">
												<?php echo clean($row['fileName']); ?>
											</a>
										</td>
										<td><?php echo clean($row['fileDesc']); ?></td>
										<td class="text-center"><?php echo clean($row['adminName']); ?></td>
										<td class="text-center"><?php echo shortDateTimeFormat($row['uploadDate']); ?></td>
										<td class="text-center"><?php echo $ipAddress; ?></td>
										<td class="text-right">
											<a data-toggle="modal" href="#deleteFile<?php echo $row['fileId']; ?>" class="text-danger">
												<i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="Delete File"></i>
											</a>

											<div class="modal fade" id="deleteFile<?php echo $row['fileId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog text-left">
													<div class="modal-content">
														<form action="" method="post">
															<div class="modal-body">
																<p class="lead"><?php echo $delFileConf; ?> "<?php echo clean($row['fileName']); ?>"?</p>
															</div>
															<div class="modal-footer">
																<input type="hidden" name="deleteId" value="<?php echo $row['fileId']; ?>" />
																<input type="hidden" name="fileName" value="<?php echo clean($row['fileName']); ?>" />
																<input type="hidden" name="fileUrl" value="<?php echo clean($row['fileUrl']); ?>" />
																<input type="hidden" name="propertyName" value="<?php echo clean($rows['propertyName']); ?>" />
																<button type="input" name="submit" value="deleteFile" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
																<button type="button" class="btn btn-light btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
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
							<?php echo $noPropFilesFoundMsg; ?>
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
	</div>