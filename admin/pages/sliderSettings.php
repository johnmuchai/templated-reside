<?php
	// Get the Max Upload Size allowed
    $maxUpload = (int)(ini_get('upload_max_filesize'));

	// Get the Pictures Directory
	$picsDir = $set['propPicsPath'];

	// Get the File Types allowed
	$fileExt = $set['propPicsAllowed'];
	$allowed = preg_replace('/,/', ', ', $fileExt);
	$ftypes = array($fileExt);
	$ftypes_data = explode( ',', $fileExt );

	// Update Home Page Slider Settings
	if (isset($_POST['submit']) && $_POST['submit'] == 'sliderSettings') {
		$enableSlider = htmlspecialchars($_POST['enableSlider']);

		$stmt = $mysqli->prepare("UPDATE sitesettings SET enableSlider = ?");
		$stmt->bind_param('s',$enableSlider);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '8';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$sliderSetUpdAct.'';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($sliderSetUpdMsg, "<i class='fa fa-check-square'></i>", "success");
	}

	// Update Slider Image Data
	if (isset($_POST['submit']) && $_POST['submit'] == 'editImage') {
		$slideTitle = htmlspecialchars($_POST['slideTitle']);
		$buttonUrl = htmlspecialchars($_POST['buttonUrl']);
		$btnText = htmlspecialchars($_POST['btnText']);
		$slideText = htmlspecialchars($_POST['slideText']);
		$editId = htmlspecialchars($_POST['editId']);

		$stmt = $mysqli->prepare("UPDATE
									sliderpics
								SET
									slideTitle = ?,
									buttonUrl = ?,
									btnText = ?,
									slideText = ?
								WHERE
									slideId = ?"
		);
		$stmt->bind_param('sssss',
								$slideTitle,
								$buttonUrl,
								$btnText,
								$slideText,
								$editId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '8';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$editSliderImgAct.'';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($editSliderImgMsg, "<i class='fa fa-check-square'></i>", "success");
	}

	// Delete Slider Image
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteImage') {
		$deleteId = htmlspecialchars($_POST['deleteId']);

		// Get the Image URL based on the ID
		$stmt = "SELECT slideUrl, slideTitle FROM sliderpics WHERE slideId = ".$deleteId;
		$stmtres = mysqli_query($mysqli, $stmt) or die('-1' . mysqli_error());
		$sid = mysqli_fetch_assoc($stmtres);
		$slideUrl = $sid['slideUrl'];
		$slideTitle = $sid['slideTitle'];

		// Delete the file from the server
		$filePath = '../'.$picsDir.'/'.$slideUrl;

		if (file_exists($filePath)) {
			// Delete the File
			unlink($filePath);

			// Delete the Record
			$stmt = $mysqli->prepare("DELETE FROM sliderpics WHERE slideId = ?");
			$stmt->bind_param('s', $deleteId);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '8';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$deleteSliderImgAct.'';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($deleteSliderImgMsg, "<i class='fa fa-check-square'></i>", "success");
		} else {
			// Add Recent Activity
			$activityType = '8';
			$rs_uid = '0';
			$activityTitle = $deleteSliderImgErrAct;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($deleteSliderImgMsgErr, "<i class='fa fa-times-circle'></i>", "danger");
		}
    }

	// Upload a New Slider Image
    if (isset($_POST['submit']) && $_POST['submit'] == 'uploadImage') {
		// Validation
        if(empty($_FILES['file']['name'])) {
            $msgBox = alertBox($sliderImgReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else {
			// Check file type
            $ext = substr(strrchr(basename($_FILES['file']['name']), '.'), 1);
            if (!in_array($ext, $ftypes_data)) {
                $msgBox = alertBox($sliderImgFileTypeErr, "<i class='fa fa-times-circle'></i>", "danger");
            } else {
				$slideUrl = $_FILES['file']['name'];
				$slideTitle = htmlspecialchars($_POST['slideTitle']);
				$buttonUrl = htmlspecialchars($_POST['buttonUrl']);
				$btnText = htmlspecialchars($_POST['btnText']);
				$slideText = htmlspecialchars($_POST['slideText']);

				// And add the original Ext
				$newfilename = $slideUrl;
				$movePath = '../'.$picsDir.$newfilename;

				$stmt = $mysqli->prepare("
                                    INSERT INTO
                                        sliderpics(
                                            adminId,
                                            slideUrl,
                                            slideTitle,
                                            slideText,
                                            buttonUrl,
                                            btnText
                                        ) VALUES (
                                            ?,
                                            ?,
                                            ?,
                                            ?,
                                            ?,
                                            ?
                                        )");
                $stmt->bind_param('ssssss',
                    $rs_adminId,
                    $slideUrl,
                    $slideTitle,
                    $slideText,
                    $buttonUrl,
                    $btnText
                );

                if (move_uploaded_file($_FILES['file']['tmp_name'], $movePath)) {
                    $stmt->execute();
					$stmt->close();

					// Add Recent Activity
					$activityType = '8';
					$rs_uid = '0';
					$activityTitle = $rs_adminName.' '.$uplSliderImgAct;
					updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

					$msgBox = alertBox($uplSliderImgMsg, "<i class='fa fa-check-square'></i>", "success");
				}
			}
		}
	}

	// Get Data
    $qry = "SELECT * FROM sitesettings";
    $res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);

	if ($row['enableSlider'] == '1') { $enableSlider = 'selected'; } else { $enableSlider = ''; }

	// Get Slider Data
	$qry = "SELECT * FROM sliderpics ORDER BY slideId";
	$result = mysqli_query($mysqli, $qry) or die('-2' . mysqli_error());

	$managePage = 'true';
	$pageTitle = $sliderSettingsPageTitle;
	$addCss = '<link href="../css/chosen.css" rel="stylesheet">';
	$chosen = 'true';
	$jsFile = 'sliderSettings';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('SITESET', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>

		<h3><?php echo $pageTitle; ?></h3>
		<div class="row mt-10">
			<div class="col-md-4">
				<form action="" method="post">
					<div class="form-group">
						<label for="enableSlider"><?php echo $enableSliderField; ?></label>
						<select class="form-control chosen-select" id="enableSlider" name="enableSlider">
							<option value="0"><?php echo $noBtn; ?></option>
							<option value="1" <?php echo $enableSlider; ?>><?php echo $yesBtn; ?></option>
						</select>
						<span class="help-block"><?php echo $enableSliderFieldHelp; ?></span>
					</div>
					<button type="input" name="submit" value="sliderSettings" class="btn btn-success btn-icon mt-20"><i class="fa fa-check-square-o"></i> <?php echo $enableSliderBtn; ?></button>
					<p id="sliderNote" class="mt-10"></p>
				</form>
			</div>
		</div>


		<div id="sliderSystem">
			<hr />
			<h3><?php echo $uplSliderImageText; ?></h3>

			<form action="" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="slideTitle"><?php echo $imgTitleField; ?></label>
							<input type="text" class="form-control" name="slideTitle" id="slideTitle" value="" />
							<span class="help-block"><?php echo $imgTitleFieldHelp; ?></span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="buttonUrl"><?php echo $btnUrlField; ?></label>
							<input type="text" class="form-control" name="buttonUrl" id="buttonUrl" value="" />
							<span class="help-block"><?php echo $btnUrlFieldHelp; ?></span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="btnText"><?php echo $btnTextField; ?></label>
							<input type="text" class="form-control" name="btnText" id="btnText" value="" />
							<span class="help-block"><?php echo $btnTextFieldHelp; ?></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="slideText"><?php echo $imgTextField; ?></label>
					<textarea class="form-control" name="slideText" id="slideText" rows="2"></textarea>
					<span class="help-block"><?php echo $imgTextFieldHelp; ?></span>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="file"><?php echo $selectImgField; ?></label>
							<input type="file" name="file" id="file" required="required" />
						</div>
						
						<button type="input" name="submit" value="uploadImage" class="btn btn-success btn-sm btn-icon"><i class="fa fa-upload"></i> <?php echo $uplImageBtn; ?></button>
					</div>
					<div class="col-md-8">
						<p>
							<strong><?php echo $selectImgFieldHelp1; ?></strong> <?php echo $allowed; ?>. &nbsp; <strong><?php echo $selectImgFieldHelp2; ?></strong> <?php echo $maxUpload; ?>mb.<br />
							<?php echo $selectImgFieldHelp3; ?>
						</p>
					</div>
				</div>
			</form>

			<hr />
			<h3><?php echo $currSliderImagesH3; ?></h3>

			<?php if(mysqli_num_rows($result) < 1) { ?>
				<p><?php echo $noSliderImagesFound; ?></p>
			<?php
				} else {
					while ($rows = mysqli_fetch_assoc($result)) {
			?>
						<div class="col-md-6 mb-20">
							<img src="<?php echo '../'.$picsDir.$rows['slideUrl']; ?>" class="img-responsive" />
							<div class="sliderImages text-center">
								<a data-toggle="modal" href="#editImage<?php echo $rows['slideId']; ?>" class="btn btn-info btn-sm btn-icon">
									<i class="fa fa-edit"></i> <?php echo $editSliderBtn; ?>
								</a>
								<a data-toggle="modal" href="#deleteImage<?php echo $rows['slideId']; ?>" class="btn btn-danger btn-sm btn-icon">
									<i class="fa fa-trash-o"></i> <?php echo $deleteSliderBtn; ?>
								</a>
							</div>
						</div>

						<div class="modal fade" id="editImage<?php echo $rows['slideId']; ?>" tabindex="-1" role="dialog" aria-labelledby="editImage<?php echo $rows['slideId']; ?>" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
										<h4 class="modal-title"><?php echo $editSliderdataH4; ?></h4>
									</div>
									<form action="" method="post">
										<div class="modal-body">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label for="slideTitle"><?php echo $imgTitleField; ?></label>
														<input type="text" class="form-control" name="slideTitle" required="required" value="<?php echo clean($rows['slideTitle']); ?>" />
														<span class="help-block"><?php echo $imgTitleFieldHelp; ?></span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label for="buttonUrl"><?php echo $btnUrlField; ?></label>
														<input type="text" class="form-control" name="buttonUrl" value="<?php echo clean($rows['buttonUrl']); ?>" />
														<span class="help-block"><?php echo $btnUrlFieldHelp; ?></span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label for="btnText"><?php echo $btnTextField; ?></label>
														<input type="text" class="form-control" name="btnText" value="<?php echo clean($rows['btnText']); ?>" />
														<span class="help-block"><?php echo $btnTextFieldHelp; ?></span>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="slideText"><?php echo $imgTextField; ?></label>
												<textarea class="form-control" name="slideText" rows="2"><?php echo clean($rows['slideText']); ?></textarea>
												<span class="help-block"><?php echo $imgTextFieldHelp; ?></span>
											</div>
										</div>
										<div class="modal-footer">
											<input name="editId" type="hidden" value="<?php echo $rows['slideId']; ?>" />
											<button type="input" name="submit" value="editImage" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<div class="modal fade" id="deleteImage<?php echo $rows['slideId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<form action="" method="post">
										<div class="modal-body">
											<p class="lead"><?php echo $delSliderImgConf; ?> "<?php echo clean($rows['slideTitle']); ?>"?</p>
										</div>
										<div class="modal-footer">
											<input name="deleteId" type="hidden" value="<?php echo $rows['slideId']; ?>" />
											<button type="input" name="submit" value="deleteImage" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
			<?php
					}
				}
			?>
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