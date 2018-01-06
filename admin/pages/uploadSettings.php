<?php
	// Get the Max Upload Size allowed
    $maxUpload = (int)(ini_get('upload_max_filesize'));

	// Get the File Types allowed
	$fileExt = $set['propPicsAllowed'];
	$allowed = preg_replace('/,/', ', ', $fileExt);
	$ftypes = array($fileExt);
	$ftypes_data = explode( ',', $fileExt );

	// Update File/Image Upload Settings
	if (isset($_POST['submit']) && $_POST['submit'] == 'uploadSettings') {
		if($_POST['uploadPath'] == "") {
            $msgBox = alertBox($propUplDirReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['userDocsPath'] == "") {
            $msgBox = alertBox($tntDocDirReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['avatarFolder'] == "") {
            $msgBox = alertBox($avatarDirReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['propPicsPath'] == "") {
            $msgBox = alertBox($propPicDirReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['templatesPath'] == "") {
            $msgBox = alertBox($templDirReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['fileTypesAllowed'] == "") {
            $msgBox = alertBox($uplFileTypesReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['avatarTypesAllowed'] == "") {
            $msgBox = alertBox($avatarFileTypesReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['propPicsAllowed'] == "") {
            $msgBox = alertBox($propPicFileTypesReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$uploadPath = htmlspecialchars($_POST['uploadPath']);
			if(substr($uploadPath, -1) != '/') {
				$upPath = $uploadPath.'/';
			} else {
				$upPath = $uploadPath;
			}

			$userDocsPath = htmlspecialchars($_POST['userDocsPath']);
			if(substr($userDocsPath, -1) != '/') {
				$tDocsPath = $userDocsPath.'/';
			} else {
				$tDocsPath = $userDocsPath;
			}

			$avatarFolder = htmlspecialchars($_POST['avatarFolder']);
			if(substr($avatarFolder, -1) != '/') {
				$avatarFold = $avatarFolder.'/';
			} else {
				$avatarFold = $avatarFolder;
			}

			$propPicsPath = htmlspecialchars($_POST['propPicsPath']);
			if(substr($propPicsPath, -1) != '/') {
				$propPicPath = $propPicsPath.'/';
			} else {
				$propPicPath = $propPicsPath;
			}

			$templatesPath = htmlspecialchars($_POST['templatesPath']);
			if(substr($templatesPath, -1) != '/') {
				$templPath = $templatesPath.'/';
			} else {
				$templPath = $templatesPath;
			}

			$fileTypesAllowed = htmlspecialchars($_POST['fileTypesAllowed']);
			$avatarTypesAllowed = htmlspecialchars($_POST['avatarTypesAllowed']);
			$propPicsAllowed = htmlspecialchars($_POST['propPicsAllowed']);

			$stmt = $mysqli->prepare("UPDATE
										sitesettings
									SET
										uploadPath = ?,
										userDocsPath = ?,
										avatarFolder = ?,
										propPicsPath = ?,
										templatesPath = ?,
										fileTypesAllowed = ?,
										avatarTypesAllowed = ?,
										propPicsAllowed = ?
			");
			$stmt->bind_param('ssssssss',
								$upPath,
								$tDocsPath,
								$avatarFold,
								$propPicPath,
								$templPath,
								$fileTypesAllowed,
								$avatarTypesAllowed,
								$propPicsAllowed
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '8';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$uplSetAct;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($uplSetMsg, "<i class='fa fa-check-square'></i>", "success");
		}
	}

	// Get Data
    $qry = "SELECT * FROM sitesettings";
    $res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);

	$managePage = 'true';
	$pageTitle = $uploadSettingsPageTitle;

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('SITESET', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>

		<h3><?php echo $pageTitle; ?></h3>
		<form action="" method="post">
			<div class="row mt-10">
				<div class="col-md-4">
					<div class="form-group">
						<label for="uploadPath"><?php echo $propUplDirField; ?></label>
						<input type="text" class="form-control" required="required" name="uploadPath" id="uploadPath" value="<?php echo $row['uploadPath']; ?>" />
						<span class="help-block"><?php echo $propUplDirFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="userDocsPath"><?php echo $tntDocDirField; ?></label>
						<input type="text" class="form-control" required="required" name="userDocsPath" id="userDocsPath" value="<?php echo $row['userDocsPath']; ?>" />
						<span class="help-block"><?php echo $tntDocDirFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="avatarFolder"><?php echo $avatarDirField; ?></label>
						<input type="text" class="form-control" required="required" name="avatarFolder" id="avatarFolder" value="<?php echo $row['avatarFolder']; ?>" />
						<span class="help-block"><?php echo $avatarDirFieldHelp; ?></span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="propPicsPath"><?php echo $propPicDirField; ?></label>
						<input type="text" class="form-control" required="required" name="propPicsPath" id="propPicsPath" value="<?php echo $row['propPicsPath']; ?>" />
						<span class="help-block"><?php echo $propPicDirFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="templatesPath"><?php echo $tmplDirField; ?></label>
						<input type="text" class="form-control" required="required" name="templatesPath" id="templatesPath" value="<?php echo $row['templatesPath']; ?>" />
						<span class="help-block"><?php echo $tmplDirFieldHelp; ?></span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="fileTypesAllowed"><?php echo $fileTpsAllwdField; ?></label>
						<input type="text" class="form-control" required="required" name="fileTypesAllowed" id="fileTypesAllowed" value="<?php echo $row['fileTypesAllowed']; ?>" />
						<span class="help-block"><?php echo $fileTpsAllwdFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="avatarTypesAllowed"><?php echo $avatarTpsAllwdField; ?></label>
						<input type="text" class="form-control" required="required" name="avatarTypesAllowed" id="avatarTypesAllowed" value="<?php echo $row['avatarTypesAllowed']; ?>" />
						<span class="help-block"><?php echo $avatarTpsAllwdFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="propPicsAllowed"><?php echo $propPicTpsAllwdField; ?></label>
						<input type="text" class="form-control" required="required" name="propPicsAllowed" id="propPicsAllowed" value="<?php echo $row['propPicsAllowed']; ?>" />
						<span class="help-block"><?php echo $propPicTpsAllwdFieldHelp; ?></span>
					</div>
				</div>
			</div>
			<button type="input" name="submit" value="uploadSettings" class="btn btn-success btn-icon mt-20 mb-20"><i class="fa fa-check-square-o"></i> <?php echo $saveUplSetBtn; ?></button>
		</form>

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