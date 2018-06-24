<?php
	$accSet = 'active';
	$emlSet = $pssSet = $socSet = $qteSet = $picSet = $avtSet = '';

	// Get the file types allowed from Site Settings
	$avatarTypes = $set['avatarTypesAllowed'];
	// Replace the commas with a comma space
	$avatarTypesAllowed = preg_replace('/,/', ', ', $avatarTypes);

	// Update Account
	if (isset($_POST['submit']) && $_POST['submit'] == 'accInfo') {
		// Validation
		if($_POST['adminName'] == "") {
            $msgBox = alertBox($firstLastNamesReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['primaryPhone'] == "") {
            $msgBox = alertBox($primPhoneReqMsg, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['adminAddress'] == "") {
            $msgBox = alertBox($mailingAddrReqMsg, "<i class='fa fa-times-circle'></i>", "danger");
        } else {
			$adminName = htmlspecialchars($_POST['adminName']);
			$primaryPhone = encryptIt($_POST['primaryPhone']);
			if (isset($_POST['altPhone'])) {
				$altPhone = encryptIt($_POST['altPhone']);
			} else {
				$altPhone = null;
			}
			$adminAddress = encryptIt($_POST['adminAddress']);
			if ($_POST['location'] == "") {
				$location = 'Washington, DC';
			} else {
				$location = htmlspecialchars($_POST['location']);
			}

			$stmt = $mysqli->prepare("UPDATE
										admins
									SET
										adminName = ?,
										primaryPhone = ?,
										altPhone = ?,
										adminAddress = ?,
										location = ?
									WHERE
										adminId = ?"
			);
			$stmt->bind_param('ssssss',
									$adminName,
									$primaryPhone,
									$altPhone,
									$adminAddress,
									$location,
									$rs_adminId
			);
			$stmt->execute();
			$stmt->close();

			// Update the SESSION Data
			$_SESSION['rs']['adminName'] = $adminName;
			$rs_adminName = $adminName;

			$_SESSION['rs']['location'] = $location;
			$rs_adminLoc = $location;

			// Add Recent Activity
			$activityType = '9';
			$rs_uid = '0';
			$activityTitle = $adminName.' '.$admProfileUpdAct;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($profileUpdatedMsg, "<i class='fa fa-check-square'></i>", "success");
		}

		$accSet = 'active';
		$emlSet = $pssSet = $socSet = $qteSet = $picSet = $avtSet = '';
    }

	// Update Email
	if (isset($_POST['submit']) && $_POST['submit'] == 'accEmail') {
		// Validation
		if($_POST['newEmail'] == "") {
            $msgBox = alertBox($newEmailAddrReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['newEmail'] != $_POST['newEmailr']) {
            $msgBox = alertBox($newEmailsNotMatchMsg, "<i class='fa fa-times-circle'></i>", "danger");
        } else {
			$newEmail = htmlspecialchars($_POST['newEmail']);

			$stmt = $mysqli->prepare("UPDATE
										admins
									SET
										adminEmail = ?
									WHERE
										adminId = ?"
			);
			$stmt->bind_param('ss',
									$newEmail,
									$rs_adminId
			);
			$stmt->execute();
			$stmt->close();

			// Update the SESSION Data
			$_SESSION['rs']['adminEmail'] = $newEmail;
			$rs_adminEmail = $newEmail;

			// Add Recent Activity
			$activityType = '9';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$admEmailUpdAct;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($emailAddrUpdatedMsg, "<i class='fa fa-check-square'></i>", "success");

			// Clear the Form of values
			$_POST['newEmail'] = $_POST['newEmailr'] = '';
		}

		$emlSet = 'active';
		$accSet = $pssSet = $socSet = $qteSet = $picSet = $avtSet = '';
    }

	// Change Password
	if (isset($_POST['submit']) && $_POST['submit'] == 'cngePass') {
		$currentPass = encryptIt($_POST['currentpass']);
		// Validation
		if($_POST['currentpass'] == "") {
            $msgBox = alertBox($accPasswordReqMsg, "<i class='fa fa-times-circle'></i>", "danger");
        } else if ($currentPass != $_POST['passwordOld']) {
			$msgBox = alertBox($curAccPassWrongMsg, "<i class='fa fa-warning'></i>", "warning");
		} else if($_POST['password'] == '') {
			$msgBox = alertBox($newPassReqMsg, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['password_r'] == '') {
			$msgBox = alertBox($retypeNewPassMsg, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['password'] != $_POST['password_r']) {
			$msgBox = alertBox($newPassNoMatchMsg, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			if(isset($_POST['password']) && $_POST['password'] != "") {
				$password = encryptIt($_POST['password']);
			} else {
				$password = $_POST['passwordOld'];
			}

			$stmt = $mysqli->prepare("UPDATE
										admins
									SET
										password = ?
									WHERE
										adminId = ?"
			);
			$stmt->bind_param('ss',
									$password,
									$rs_adminId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '9';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$admPassUpdAct;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($passChangedConf, "<i class='fa fa-check-square'></i>", "success");

			// Clear the Form of values
			$_POST['currentpass'] = $_POST['password'] = $_POST['password_r'] = '';
		}

		$pssSet = 'active';
		$accSet = $emlSet = $socSet = $qteSet = $picSet = $avtSet = '';
    }

	// Update Social Links
	if (isset($_POST['submit']) && $_POST['submit'] == 'mngSocial') {
		if ($_POST['facebook'] == "") { $facebook = null; } else { $facebook = htmlspecialchars($_POST['facebook']); }
		if ($_POST['google'] == "") { $google = null; } else { $google = htmlspecialchars($_POST['google']); }
		if ($_POST['linkedin'] == "") { $linkedin = null; } else { $linkedin = htmlspecialchars($_POST['linkedin']); }
		if ($_POST['pinterest'] == "") { $pinterest = null; } else { $pinterest = htmlspecialchars($_POST['pinterest']); }
		if ($_POST['twitter'] == "") { $twitter = null; } else { $twitter = htmlspecialchars($_POST['twitter']); }
		if ($_POST['youtube'] == "") { $youtube = null; } else { $youtube = htmlspecialchars($_POST['youtube']); }

		$stmt = $mysqli->prepare("UPDATE
									admins
								SET
									facebook = ?,
									google = ?,
									linkedin = ?,
									pinterest = ?,
									twitter = ?,
									youtube = ?
								WHERE
									adminId = ?"
		);
		$stmt->bind_param('sssssss',
								$facebook,
								$google,
								$linkedin,
								$pinterest,
								$twitter,
								$youtube,
								$rs_adminId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '9';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$admSocialLinksUpdAct;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($admSocialLinksUpdMsg, "<i class='fa fa-check-square'></i>", "success");

		$socSet = 'active';
		$accSet = $emlSet = $pssSet = $qteSet = $picSet = $avtSet = '';
    }

	// Update Personal Quote
	if (isset($_POST['submit']) && $_POST['submit'] == 'mngQuote') {
		$personalQuip = htmlspecialchars($_POST['personalQuip']);

		$stmt = $mysqli->prepare("UPDATE
									admins
								SET
									personalQuip = ?
								WHERE
									adminId = ?"
		);
		$stmt->bind_param('ss',
								$personalQuip,
								$rs_adminId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '9';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$persQuoteUpdAct;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($persQuoteUpdMsg, "<i class='fa fa-check-square'></i>", "success");

		$qteSet = 'active';
		$accSet = $emlSet = $pssSet = $socSet = $picSet = $avtSet = '';
    }

	// Upload Avatar Image
	if (isset($_POST['submit']) && $_POST['submit'] == 'newAvatar') {
		// Get the File Types allowed
		$fileExt = $set['avatarTypesAllowed'];
		$allowed = preg_replace('/,/', ', ', $fileExt); // Replace the commas with a comma space (, )
		$ftypes = array($fileExt);
		$ftypes_data = explode( ',', $fileExt );

		// Check file type
		$ext = substr(strrchr(basename($_FILES['file']['name']), '.'), 1);
		if (!in_array($ext, $ftypes_data)) {
			$msgBox = alertBox($avatarTypeErrMsg, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$avatarDir = $set['avatarFolder'];

			// Rename the Admin's Avatar to the Admin's Name
			$avatarName = clean($rs_adminName);

			// Replace any spaces with an underscore
			// And set to all lower-case
			$newName = str_replace(' ', '-', $avatarName);
			$fileName = strtolower($newName);

			// Generate a RANDOM Hash
			$randomHash = uniqid(rand());
			// Take the first 8 hash digits and use them as part of the Image Name
			$randHash = substr($randomHash, 0, 8);

			$fullName = $fileName.'-'.$randHash;

			// set the upload path
			$avatarUrl = basename($_FILES['file']['name']);

			// Get the files original Ext
			$extension = explode(".", $avatarUrl);
			$extension = end($extension);

			// Set the files name to the name set in the form
			// And add the original Ext
			$newAvatarName = $fullName.'.'.$extension;
			$movePath = '../'.$avatarDir.$newAvatarName;

			$stmt = $mysqli->prepare("
								UPDATE
									admins
								SET
									adminAvatar = ?
								WHERE
									adminId = ?");
			$stmt->bind_param('ss',
							   $newAvatarName,
							   $rs_adminId);

			if (move_uploaded_file($_FILES['file']['tmp_name'], $movePath)) {
				$stmt->execute();
				$msgBox = alertBox($avatarUplMsg, "<i class='fa fa-check-square'></i>", "success");
				$stmt->close();

				// Add Recent Activity
				$activityType = '9';
				$rs_uid = '0';
				$activityTitle = $rs_adminName.' '.$avatarUplAct;
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
			} else {
				$msgBox = alertBox($newAvatarUplErrMsg, "<i class='fa fa-times-circle'></i>", "danger");

				// Add Recent Activity
				$activityType = '9';
				$rs_uid = '0';
				$activityTitle = $rs_adminName.' '.$avatarUplAct1;
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
			}
		}

		$avtSet = 'active';
		$accSet = $emlSet = $pssSet = $socSet = $picSet = $qteSet = '';
	}

	// Delete Avatar Image
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteAvatar') {
		// Get the Admin's Avatar url
		$sql = "SELECT adminAvatar FROM admins WHERE adminId = ".$rs_adminId;
		$result = mysqli_query($mysqli, $sql) or die('-1'.mysqli_error());
		$r = mysqli_fetch_assoc($result);
		$avatarName = $r['adminAvatar'];

		$avatarDir = $set['avatarFolder'];
		$filePath = '../'.$avatarDir.$avatarName;
		// Delete the Admin's image from the server
		if (file_exists($filePath)) {
			unlink($filePath);

			// Update the Admin record
			$avatarImage = 'adminDefault.png';
			$stmt = $mysqli->prepare("
								UPDATE
									admins
								SET
									adminAvatar = ?
								WHERE
									adminId = ?");
			$stmt->bind_param('ss',
							   $avatarImage,
							   $rs_adminId);
			$stmt->execute();
			$msgBox = alertBox($delAvatarMsg, "<i class='fa fa-check-square'></i>", "success");
			$stmt->close();

			// Add Recent Activity
			$activityType = '9';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delAvatarAct;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		} else {
			$msgBox = alertBox($delAvatarErrMsg, "<i class='fa fa-warning'></i>", "warning");

			// Add Recent Activity
			$activityType = '9';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delAvatar1;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}

		$avtSet = 'active';
		$accSet = $emlSet = $pssSet = $socSet = $picSet = $qteSet = '';
	}

	// Upload Public Picture
	if (isset($_POST['submit']) && $_POST['submit'] == 'newPicture') {
		// Get the File Types allowed
		$fileExt = $set['avatarTypesAllowed'];
		$allowed = preg_replace('/,/', ', ', $fileExt); // Replace the commas with a comma space (, )
		$ftypes = array($fileExt);
		$ftypes_data = explode( ',', $fileExt );

		// Check file type
		$ext = substr(strrchr(basename($_FILES['file']['name']), '.'), 1);
		if (!in_array($ext, $ftypes_data)) {
			$msgBox = alertBox($pubPicFileError, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$avatarDir = $set['avatarFolder'];

			// Rename the Admin's Picture to the Admin's Name
			$pictureName = clean($rs_adminName);

			// Replace any spaces with an underscore
			// And set to all lower-case
			$newName = str_replace(' ', '-', $pictureName);
			$fileName = strtolower($newName);

			// Generate a RANDOM Hash
			$randomHash = uniqid(rand());
			// Take the first 8 hash digits and use them as part of the Image Name
			$randHash = substr($randomHash, 0, 8);

			$fullName = $fileName.'-'.$randHash;

			// set the upload path
			$avatarUrl = basename($_FILES['file']['name']);

			// Get the files original Ext
			$extension = explode(".", $avatarUrl);
			$extension = end($extension);

			// Set the files name to the name set in the form
			// And add the original Ext
			$newPictureName = $fullName.'.'.$extension;
			$movePath = '../'.$avatarDir.$newPictureName;

			$stmt = $mysqli->prepare("
								UPDATE
									admins
								SET
									adminPhoto = ?
								WHERE
									adminId = ?");
			$stmt->bind_param('ss',
							   $newPictureName,
							   $rs_adminId);

			if (move_uploaded_file($_FILES['file']['tmp_name'], $movePath)) {
				$stmt->execute();
				$msgBox = alertBox($pubPicUplMsg, "<i class='fa fa-check-square'></i>", "success");
				$stmt->close();

				// Add Recent Activity
				$activityType = '9';
				$rs_uid = '0';
				$activityTitle = $rs_adminName.' '.$pubPicUplAct;
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
			} else {
				$msgBox = alertBox($pubPicUplError, "<i class='fa fa-times-circle'></i>", "danger");

				// Add Recent Activity
				$activityType = '9';
				$rs_uid = '0';
				$activityTitle = $rs_adminName.' '.$pubPicUplErrorAct;
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
			}
		}

		$picSet = 'active';
		$accSet = $emlSet = $pssSet = $socSet = $avtSet = $qteSet = '';
	}

	// Delete Public Picture
	if (isset($_POST['submit']) && $_POST['submit'] == 'deletePicture') {
		// Get the Admin's Picture url
		$sql = "SELECT adminPhoto FROM admins WHERE adminId = ".$rs_adminId;
		$result = mysqli_query($mysqli, $sql) or die('-1'.mysqli_error());
		$r = mysqli_fetch_assoc($result);
		$pictureName = $r['adminPhoto'];

		$avatarDir = $set['avatarFolder'];
		$filePath = '../'.$avatarDir.$pictureName;
		// Delete the Admin's image from the server
		if (file_exists($filePath)) {
			unlink($filePath);

			// Update the Admin record
			$pictureImage = 'defaultPhoto.png';
			$stmt = $mysqli->prepare("
								UPDATE
									admins
								SET
									adminPhoto = ?
								WHERE
									adminId = ?");
			$stmt->bind_param('ss',
							   $pictureImage,
							   $rs_adminId);
			$stmt->execute();
			$msgBox = alertBox($delPubPicMsg, "<i class='fa fa-check-square'></i>", "success");
			$stmt->close();

			// Add Recent Activity
			$activityType = '9';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delPubPicAct;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		} else {
			$msgBox = alertBox($delPubPicErrorMsg, "<i class='fa fa-warning'></i>", "warning");

			// Add Recent Activity
			$activityType = '9';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delPubPicErrorAct;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}

		$picSet = 'active';
		$accSet = $emlSet = $pssSet = $socSet = $avtSet = $qteSet = '';
	}

	// Get Data
	$qry = "SELECT * FROM users WHERE userId = ".$rs_userId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$rows = mysqli_fetch_assoc($res);

	$profileurl = preg_replace('/ /', '-', clean($rows['userName']));

	// Decrypt data
	if ($rows['primaryPhone'] != '') { $primaryPhone = decryptIt($rows['primaryPhone']); } else { $primaryPhone = '';  }
	if ($rows['altPhone'] != '') { $altPhone = decryptIt($rows['altPhone']); } else { $altPhone = '';  }
	if ($rows['adminAddress'] != '') { $adminAddress = decryptIt($rows['adminAddress']); } else { $adminAddress = '';  }

	if (!empty($rows['facebook'])) {
		$afacebook = '<li data-toggle="tooltip" data-placement="top" title="'.$facebookText.'"><a href="'.clean($rows['facebook']).'" class="facebook"><i class="fa fa-facebook"></i></a></li>';
	} else { $afacebook = ''; }
	if (!empty($rows['google'])) {
		$agoogle = '<li data-toggle="tooltip" data-placement="top" title="'.$googleText.'"><a href="'.clean($rows['google']).'" class="google"><i class="fa fa-google"></i></a></li>';
	} else { $agoogle = ''; }
	if (!empty($rows['linkedin'])) {
		$alinkedin = '<li data-toggle="tooltip" data-placement="top" title="'.$linkedinText.'"><a href="'.clean($rows['linkedin']).'" class="linkedin"><i class="fa fa-linkedin"></i></a></li>';
	} else { $alinkedin = ''; }
	if (!empty($rows['pinterest'])) {
		$apinterest = '<li data-toggle="tooltip" data-placement="top" title="'.$pinterestText.'"><a href="'.clean($rows['pinterest']).'" class="pinterest"><i class="fa fa-pinterest"></i></a></li>';
	} else { $apinterest = ''; }
	if (!empty($rows['twitter'])) {
		$atwitter = '<li data-toggle="tooltip" data-placement="top" title="'.$twitterText.'"><a href="'.clean($rows['twitter']).'" class="twitter"><i class="fa fa-twitter"></i></a></li>';
	} else { $atwitter = ''; }
	if (!empty($rows['youtube'])) {
		$ayoutube = '<li data-toggle="tooltip" data-placement="top" title="'.$youtubeText.'"><a href="'.clean($rows['youtube']).'" class="youtube"><i class="fa fa-youtube"></i></a></li>';
	} else { $ayoutube = ''; }

	$pageTitle = $myProfilePageTitle;
	$jsFile = 'myProfile';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<div class="row">
			<div class="col-md-4">
				<div class="profileBox mt-20">
					<div class="cover">
						<div class="profilePic">
							<img src="../<?php echo $avatarDir.$rows['userPhoto']; ?>" class="publicPic" />
						</div>
					</div>

					<div class="profileBody border">
						<h1>
							<a href="../profile.php?profile=<?php echo $profileurl; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $viewPubProfileText; ?>">
								<?php echo clean($rows['adminName']); ?>
							</a>
						</h1>
						<h4 class="mt-10">
							<?php echo clean($rows['adminRole']); ?><br />
							<small><?php echo $memberSinceText.' '.dateFormat($rows['createDate']); ?></small>
						</h3>
						<p class="mt-10"><i class="fa fa-quote-left icon-quote"></i> <?php echo clean($rows['personalQuip']); ?> <i class="fa fa-quote-right icon-quote"></i></p>
						<ul class="socialLinks">
							<?php
								echo $afacebook;
								echo $agoogle;
								echo $alinkedin;
								echo $apinterest;
								echo $atwitter;
								echo $ayoutube;
							?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<?php if ($msgBox) { echo $msgBox; } ?>

				<div class="tabs">
					<ul class="tabsBody">
						<li class="<?php echo $accSet; ?>">
							<h4 class="tabHeader" tabindex="0"><?php echo $accountTabTitle; ?></h4>
							<section class="tabContent" id="account">
								<h3><?php echo $accountTabH3; ?></h3>
								<form action="" method="post" class="form-horizontal">
									<div class="form-group">
										<label for="adminName" class="col-sm-3 control-label"><?php echo $fullNameField; ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="adminName" id="adminName" required="required" value="<?php echo clean($rows['adminName']); ?>" />
										</div>
									</div>
									<div class="form-group">
										<label for="primaryPhone" class="col-sm-3 control-label"><?php echo $primaryPhoneField; ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="primaryPhone" id="primaryPhone" required="required" value="<?php echo $primaryPhone; ?>" />
										</div>
									</div>
									<div class="form-group">
										<label for="altPhone" class="col-sm-3 control-label"><?php echo $altPhoneField; ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="altPhone" id="altPhone" value="<?php echo $altPhone; ?>" />
										</div>
									</div>
									<div class="form-group">
										<label for="adminAddress" class="col-sm-3 control-label"><?php echo $mailingAddrField; ?></label>
										<div class="col-sm-9">
											<textarea class="form-control" name="adminAddress" id="adminAddress" required="required" rows="3"><?php echo $adminAddress; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="location" class="col-sm-3 control-label"><?php echo $locationField; ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="location" id="location" value="<?php echo clean($rows['location']); ?>" />
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
											<button type="input" name="submit" value="accInfo" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
										</div>
									</div>
								</form>
							</section>
						</li>
						<li class="<?php echo $emlSet; ?>">
							<h4 class="tabHeader" tabindex="0"><?php echo $emailTabTitle; ?></h4>
							<section class="tabContent" id="email">
								<h3><?php echo $accountEmailText; ?></h3>
								<form action="" method="post" class="form-horizontal">
									<div class="form-group">
										<label for="currEmail" class="col-sm-3 control-label"><?php echo $currEmailAddrField; ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" disabled="" value="<?php echo $rs_adminEmail; ?>" />
										</div>
									</div>
									<div class="form-group">
										<label for="newEmail" class="col-sm-3 control-label"><?php echo $newEmailAddrField; ?></label>
										<div class="col-sm-9">
											<input type="email" class="form-control" name="newEmail" id="newEmail" required="required" value="<?php echo isset($_POST['newEmail']) ? $_POST['newEmail'] : ''; ?>" />
											<span class="help-block"><?php echo $newEmailAddrFieldHelp; ?></span>
										</div>
									</div>
									<div class="form-group">
										<label for="newEmailr" class="col-sm-3 control-label"><?php echo $rptEmailAddrField; ?></label>
										<div class="col-sm-9">
											<input type="email" class="form-control" name="newEmailr" id="newEmailr" required="required" value="<?php echo isset($_POST['newEmailr']) ? $_POST['newEmailr'] : ''; ?>" />
											<span class="help-block"><?php echo $rptEmailAddrFieldHelp; ?></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
											<button type="input" name="submit" value="accEmail" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
										</div>
									</div>
								</form>
							</section>
						</li>
						<li class="<?php echo $pssSet; ?>">
							<h4 class="tabHeader" tabindex="0"><?php echo $passwordText; ?></h4>
							<section class="tabContent" id="password">
								<h3><?php echo $passwordTabH3; ?></h3>
								<form action="" method="post" class="form-horizontal">
									<div class="form-group">
										<label for="currentpass" class="col-sm-3 control-label"><?php echo $currPasswordField; ?></label>
										<div class="col-sm-9">
											<input type="password" class="form-control" name="currentpass" id="currentpass" required="required" value="" />
											<span class="help-block"><?php echo $currPasswordFieldHelp; ?></span>
										</div>
									</div>
									<div class="form-group">
										<label for="password" class="col-sm-3 control-label"><?php echo $newPasswordField; ?></label>
										<div class="col-sm-9">
											<input type="password" class="form-control" name="password" id="password" required="required" value="" />
											<span class="help-block"><?php echo $newPasswordFieldHelp; ?></span>
										</div>
									</div>
									<div class="form-group">
										<label for="password_r" class="col-sm-3 control-label"><?php echo $rptPasswordField; ?></label>
										<div class="col-sm-9">
											<input type="password" class="form-control" name="password_r" id="password_r" required="required" value="" />
											<span class="help-block"><?php echo $rptPasswordFieldHelp; ?></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
											<input type="hidden" name="passwordOld" value="<?php echo $rows['password']; ?>" />
											<button type="input" name="submit" value="cngePass" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
										</div>
									</div>
								</form>
							</section>
						</li>
						<li class="<?php echo $socSet; ?>">
							<h4 class="tabHeader" tabindex="0"><?php echo $socialLinksH4; ?></h4>
							<section class="tabContent" id="social">
								<h3><?php echo $manSocialLinksH3; ?></h3>
								<form action="" method="post" class="form-horizontal">
									<div class="form-group">
										<label for="facebook" class="col-sm-3 control-label"><?php echo $facebookProfField; ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="facebook" id="facebook" value="<?php echo clean($rows['facebook']); ?>" />
										</div>
									</div>
									<div class="form-group">
										<label for="google" class="col-sm-3 control-label"><?php echo $googleProfField; ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="google" id="google" value="<?php echo clean($rows['google']); ?>" />
										</div>
									</div>
									<div class="form-group">
										<label for="linkedin" class="col-sm-3 control-label"><?php echo $limkedinProField; ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="linkedin" id="linkedin" value="<?php echo clean($rows['linkedin']); ?>" />
										</div>
									</div>
									<div class="form-group">
										<label for="pinterest" class="col-sm-3 control-label"><?php echo $pinterestProfField; ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="pinterest" id="pinterest" value="<?php echo clean($rows['pinterest']); ?>" />
										</div>
									</div>
									<div class="form-group">
										<label for="twitter" class="col-sm-3 control-label"><?php echo $twitterProfField; ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="twitter" id="twitter" value="<?php echo clean($rows['twitter']); ?>" />
										</div>
									</div>
									<div class="form-group">
										<label for="youtube" class="col-sm-3 control-label"><?php echo $youtubeProfField; ?></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="youtube" id="youtube" value="<?php echo clean($rows['youtube']); ?>" />
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
											<button type="input" name="submit" value="mngSocial" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
										</div>
									</div>
								</form>
							</section>
						</li>
						<li class="<?php echo $qteSet; ?>">
							<h4 class="tabHeader" tabindex="0"><?php echo $quoteH4; ?></h4>
							<section class="tabContent" id="quote">
								<h3><?php echo $managePersQuoteH3; ?></h3>
								<form action="" method="post" class="form-horizontal">
									<div class="form-group">
										<label for="personalQuip" class="col-sm-3 control-label"><?php echo $persQuoteField; ?></label>
										<div class="col-sm-9">
											<textarea class="form-control" name="personalQuip" id="personalQuip" rows="2"><?php echo clean($rows['personalQuip']); ?></textarea>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
											<button type="input" name="submit" value="mngQuote" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
										</div>
									</div>
								</form>
							</section>
						</li>
						<li class="<?php echo $picSet; ?>">
							<h4 class="tabHeader" tabindex="0"><?php echo $pictureH4; ?></h4>
							<section class="tabContent" id="picture">
								<h3><?php echo $managePubPicH3; ?></h3>
								<p><?php echo $managePubPicQuip.' '.$avatarTypesAllowed; ?></p>
								<hr />
								<?php if ($rows['adminPhoto'] == 'defaultPhoto.png') { ?>
									<form enctype="multipart/form-data" action="" method="post">
										<div class="form-group">
											<label for="file"><?php echo $selectPicField; ?></label>
											<input type="file" id="file" name="file" required="required" />
										</div>

										<button type="input" name="submit" value="newPicture" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $uplPicBtn; ?></button>
									</form>
								<?php } else { ?>
									<p><?php echo $remPicQuip; ?></p>
									<a data-toggle="modal" href="#deletePicture" class="btn btn-warning btn-icon" data-dismiss="modal"><i class="fa fa-ban"></i> <?php echo $remPicBtn; ?></a>
								<?php } ?>
							</section>
						</li>
						<li class="<?php echo $avtSet; ?>">
							<h4 class="tabHeader" tabindex="0"><?php echo $avatarTabTitle; ?></h4>
							<section class="tabContent" id="avatar">
								<h3><?php echo $avatarTabH3; ?></h3>
								<p>
									<img alt="<?php echo $rows['adminName']; ?>" src="../<?php echo $avatarDir.$rows['adminAvatar']; ?>" class="avatarImage pull-left" />
									<?php echo $manageAvatarQuip.' '.$avatarTypesAllowed; ?>
								</p>
								<div class="clearfix"></div>
								<hr />
								<?php if ($rows['adminAvatar'] == 'adminDefault.png') { ?>
									<form enctype="multipart/form-data" action="" method="post">
										<div class="form-group">
											<label for="file"><?php echo $avatarField; ?></label>
											<input type="file" id="file" name="file" required="required" />
										</div>

										<button type="input" name="submit" value="newAvatar" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $uplAvatarBtn; ?></button>
									</form>
								<?php } else { ?>
									<p><?php echo $remAvatarQuip; ?></p>
									<a data-toggle="modal" href="#deleteAvatar" class="btn btn-warning btn-icon" data-dismiss="modal"><i class="fa fa-ban"></i> <?php echo $remAvatarBtn; ?></a>
								<?php } ?>
							</section>
						</li>
					</ul>
				</div>

				<?php if ($rows['adminAvatar'] != 'adminDefault.png') { ?>
					<div id="deleteAvatar" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<form action="" method="post">
									<div class="modal-body">
										<p class="lead"><?php echo $remAvatarConf; ?></p>
									</div>
									<div class="modal-footer">
										<button type="input" name="submit" value="deleteAvatar" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $delAvatarBtn; ?></button>
										<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				<?php } ?>

				<?php if ($rows['adminPhoto'] != 'defaultPhoto.png') { ?>
					<div id="deletePicture" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<form action="" method="post">
									<div class="modal-body">
										<p class="lead"><?php echo $delPubPicConf; ?></p>
									</div>
									<div class="modal-footer">
										<button type="input" name="submit" value="deletePicture" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $delPubPicBtn; ?></button>
										<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
