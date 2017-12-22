<?php
	$adminId = $mysqli->real_escape_string($_GET['adminId']);
	$avatarDir = $set['avatarFolder'];
	$acctTab = 'active';
	$emailTab = $passTab = $picTab = $avatarTab = $statusTab = $socialTab = '';
	
	// Update Account
	if (isset($_POST['submit']) && $_POST['submit'] == 'accInfo') {
		// Validation
		if($_POST['adminName'] == "") {
            $msgBox = alertBox($admNameReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['primaryPhone'] == "") {
            $msgBox = alertBox($admPriPhoneReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['adminAddress'] == "") {
            $msgBox = alertBox($admMailAddReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['adminRole'] == "") {
            $msgBox = alertBox($admTitleReq, "<i class='fa fa-times-circle'></i>", "danger");
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
			$adminRole = htmlspecialchars($_POST['adminRole']);
			$personalQuip = htmlspecialchars($_POST['personalQuip']);

			$stmt = $mysqli->prepare("UPDATE
										admins
									SET
										adminName = ?,
										primaryPhone = ?,
										altPhone = ?,
										adminAddress = ?,
										location = ?,
										personalQuip = ?,
										adminRole = ?
									WHERE
										adminId = ?"
			);
			$stmt->bind_param('ssssssss',
									$adminName,
									$primaryPhone,
									$altPhone,
									$adminAddress,
									$location,
									$personalQuip,
									$adminRole,
									$adminId
			);
			$stmt->execute();
			$stmt->close();
			
			// Add Recent Activity
			$activityType = '17';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$admAccUpdAct.' '.$adminName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($admAccUpdMsg." ".$adminName." ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");
		}
    }
	
	// Update Email
	if (isset($_POST['submit']) && $_POST['submit'] == 'accEmail') {
		// Validation
		if($_POST['newEmail'] == "") {
            $msgBox = alertBox($admNewEmailAddReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['newEmail'] != $_POST['newEmailr']) {
            $msgBox = alertBox($newEmailsNotMatchMsg, "<i class='fa fa-times-circle'></i>", "danger");
        } else {
			$newEmail = htmlspecialchars($_POST['newEmail']);
			$adminsName = htmlspecialchars($_POST['adminsName']);

			$stmt = $mysqli->prepare("UPDATE
										admins
									SET
										adminEmail = ?
									WHERE
										adminId = ?"
			);
			$stmt->bind_param('ss',
									$newEmail,
									$adminId
			);
			$stmt->execute();
			$stmt->close();
			
			// Add Recent Activity
			$activityType = '17';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$admAccEmailUpdAct.' '.$adminsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($admAccEmailUpdMsg, "<i class='fa fa-check-square'></i>", "success");
			
			$_POST['newEmail'] = $_POST['newEmailr'] = '';
		}
		
		$emailTab = 'active';
		$acctTab = $passTab = $picTab = $avatarTab = $statusTab = $socialTab = '';
    }
	
	// Change Password
	if (isset($_POST['submit']) && $_POST['submit'] == 'cngePass') {
		// Validation
		if($_POST['password'] == '') {
			$msgBox = alertBox($adminPassReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['password_r'] == '') {
			$msgBox = alertBox($adminPassRepeatReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['password'] != $_POST['password_r']) {
			$msgBox = alertBox($passwordsNoMatch, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			if(isset($_POST['password']) && $_POST['password'] != "") {
				$password = encryptIt($_POST['password']);
			} else {
				$password = $_POST['passwordOld'];
			}
			$adminsName = htmlspecialchars($_POST['adminsName']);

			$stmt = $mysqli->prepare("UPDATE
										admins
									SET
										password = ?
									WHERE
										adminId = ?"
			);
			$stmt->bind_param('ss',
									$password,
									$adminId
			);
			$stmt->execute();
			$stmt->close();
			
			// Add Recent Activity
			$activityType = '17';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$adminPassUpdAct.' '.$adminsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($adminPassUpdMsg, "<i class='fa fa-check-square'></i>", "success");
		}
		
		$passTab = 'active';
		$acctTab = $emailTab = $picTab = $avatarTab = $statusTab = $socialTab = '';
    }
	
	// Delete Picture
	if (isset($_POST['submit']) && $_POST['submit'] == 'deletePic') {
		$adminPhoto = htmlspecialchars($_POST['adminPhoto']);
		$adminsName = htmlspecialchars($_POST['adminsName']);

		$filePath = '../'.$avatarDir.$adminPhoto;
		// Delete the Admin's image from the server
		if (file_exists($filePath)) {
			unlink($filePath);

			// Update the Admin record
			$picImage = 'defaultPhoto.png';
			$stmt = $mysqli->prepare("UPDATE
										admins
									SET
										adminPhoto = ?
									WHERE
										adminId = ?"
			);
			$stmt->bind_param('ss',
								   $picImage,
								   $adminId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '17';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delAdmPicAct.' '.$adminsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
			
			$msgBox = alertBox($delAdmPicMsg, "<i class='fa fa-check-square'></i>", "success");
		} else {
			$msgBox = alertBox($delAdmPicMsg1, "<i class='fa fa-warning'></i>", "warning");

			// Add Recent Activity
			$activityType = '17';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delAdmPicAct1.' '.$adminsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}
		
		$picTab = 'active';
		$acctTab = $emailTab = $passTab = $avatarTab = $statusTab = $socialTab = '';
	}
	
	// Delete Avatar Image
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteAvatar') {
		$adminAvatar = htmlspecialchars($_POST['adminAvatar']);
		$adminsName = htmlspecialchars($_POST['adminsName']);

		$filePath = '../'.$avatarDir.$adminAvatar;
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
							   $adminId);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '17';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delAdmAvatarAct.' '.$adminsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
			
			$msgBox = alertBox($delAdmAvatarMsg, "<i class='fa fa-check-square'></i>", "success");
		} else {
			$msgBox = alertBox($delAdmAvatarMsg1, "<i class='fa fa-warning'></i>", "warning");

			// Add Recent Activity
			$activityType = '17';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delAdmAvatarAct1.' '.$adminsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}
		
		$avatarTab = 'active';
		$acctTab = $emailTab = $passTab = $picTab = $statusTab = $socialTab = '';
	}
	
	// Update Account Status
	if (isset($_POST['submit']) && $_POST['submit'] == 'accStatus') {
		$isDisabled = htmlspecialchars($_POST['isDisabled']);
		$adminsName = htmlspecialchars($_POST['adminsName']);

		$stmt = $mysqli->prepare("UPDATE
									admins
								SET
									isDisabled = ?
								WHERE
									adminId = ?"
		);
		$stmt->bind_param('ss',
								$isDisabled,
								$adminId
		);
		$stmt->execute();
		$stmt->close();
		
		// Add Recent Activity
		$activityType = '16';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$dsbAdmAccAct.' '.$adminsName;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($dsbAdmAccMsg, "<i class='fa fa-check-square'></i>", "success");

		$statusTab = 'active';
		$acctTab = $emailTab = $passTab = $picTab = $avatarTab = $socialTab = '';
    }
	
	// Update Social Links
	if (isset($_POST['submit']) && $_POST['submit'] == 'socLinks') {
		$facebook = htmlspecialchars($_POST['facebook']);
		$google = htmlspecialchars($_POST['google']);
		$linkedin = htmlspecialchars($_POST['linkedin']);
		$pinterest = htmlspecialchars($_POST['pinterest']);
		$twitter = htmlspecialchars($_POST['twitter']);
		$youtube = htmlspecialchars($_POST['youtube']);
		$adminsName = htmlspecialchars($_POST['adminsName']);

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
								$adminId
		);
		$stmt->execute();
		$stmt->close();
		
		// Add Recent Activity
		$activityType = '17';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$updAdmSocLinksAct.' '.$adminsName;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($updAdmSocLinksMsg." ".$adminsName." ".$admAuthsUpdMsg2, "<i class='fa fa-check-square'></i>", "success");
		
		$socialTab = 'active';
		$acctTab = $emailTab = $passTab = $picTab = $avatarTab = $statusTab = '';
    }
	
	// Get Data
	$qry = "SELECT * FROM admins WHERE adminId = ".$adminId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);
	
	// Decrypt data
	if ($row['primaryPhone'] != '') { $primaryPhone = decryptIt($row['primaryPhone']); } else { $primaryPhone = '';  }
	if ($row['altPhone'] != '') { $altPhone = decryptIt($row['altPhone']); } else { $altPhone = '';  }
	if ($row['adminAddress'] != '') { $adminAddress = decryptIt($row['adminAddress']); } else { $adminAddress = '';  }
	
	if ($row['lastVisited'] == '0000-00-00 00:00:00') { $lastVisited = $noneText; } else { $lastVisited = dateFormat($row['lastVisited']); }
	if ($row['isDisabled'] == '1') {
		$isDisabled = 'selected';
		$actAcc = $disabledAccText;
	} else {
		$isDisabled = '';
		$actAcc = $enabledAccText;
	}
	
	$profileurl = preg_replace('/ /', '-', clean($row['adminName']));
	
	if (!empty($row['facebook'])) {
		$afacebook = '<li data-toggle="tooltip" data-placement="top" title="'.$facebookText.'"><a href="'.clean($row['facebook']).'" class="facebook"><i class="fa fa-facebook"></i></a></li>';
	} else { $afacebook = ''; }
	if (!empty($row['google'])) {
		$agoogle = '<li data-toggle="tooltip" data-placement="top" title="'.$googleText.'"><a href="'.clean($row['google']).'" class="google"><i class="fa fa-google"></i></a></li>';
	} else { $agoogle = ''; }
	if (!empty($row['linkedin'])) {
		$alinkedin = '<li data-toggle="tooltip" data-placement="top" title="'.$linkedinText.'"><a href="'.clean($row['linkedin']).'" class="linkedin"><i class="fa fa-linkedin"></i></a></li>';
	} else { $alinkedin = ''; }
	if (!empty($row['pinterest'])) {
		$apinterest = '<li data-toggle="tooltip" data-placement="top" title="'.$pinterestText.'"><a href="'.clean($row['pinterest']).'" class="pinterest"><i class="fa fa-pinterest"></i></a></li>';
	} else { $apinterest = ''; }
	if (!empty($row['twitter'])) {
		$atwitter = '<li data-toggle="tooltip" data-placement="top" title="'.$twitterText.'"><a href="'.clean($row['twitter']).'" class="twitter"><i class="fa fa-twitter"></i></a></li>';
	} else { $atwitter = ''; }
	if (!empty($row['youtube'])) {
		$ayoutube = '<li data-toggle="tooltip" data-placement="top" title="'.$youtubeText.'"><a href="'.clean($row['youtube']).'" class="youtube"><i class="fa fa-youtube"></i></a></li>';
	} else { $ayoutube = ''; }

	$adminPage = 'true';
	$pageTitle = $viewAdminPageTitle;
	$addCss = '<link href="../css/chosen.css" rel="stylesheet">';
	$chosen = 'true';
	$jsFile = 'viewAdmin';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('MNGADMINS', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>

				<div class="row mt-20">
					<div class="col-md-4">
						<div class="profileBox">
							<div class="cover">
								<div class="profilePic">
									<img src="../<?php echo $avatarDir.$row['adminPhoto']; ?>" class="publicPic" />
								</div>
							</div>

							<div class="profileBody border">
								<h1>
									<a href="../profile.php?profile=<?php echo $profileurl; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $viewPubProfileText; ?>">
										<?php echo clean($row['adminName']); ?>
									</a>
								</h1>
								<h4 class="mt-10">
									<?php echo clean($row['adminRole']); ?><br />
									<small>
										<?php echo $actAcc; ?><br />
										<?php echo $memberSinceText.' '.dateFormat($row['createDate']); ?><br />
										<?php echo $lastSigninHead; ?>: <?php echo dateTimeFormat($row['lastVisited']); ?>
									</small>
								</h3>
								<p class="mt-10"><i class="fa fa-quote-left icon-quote"></i> <?php echo clean($row['personalQuip']); ?> <i class="fa fa-quote-right icon-quote"></i></p>
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
						<div class="tabs mt-0">
							<ul class="tabsBody">
								<li class="<?php echo $acctTab; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $accountTabTitle; ?></h4>
									<section class="tabContent" id="account">
										<h3><?php echo $manageAdminAccH3; ?></h3>
										<form action="" method="post" class="form-horizontal">
											<div class="form-group">
												<label for="adminName" class="col-sm-3 control-label"><?php echo $admNameField; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="adminName" id="adminName" required="required" value="<?php echo clean($row['adminName']); ?>" />
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
												<label for="adminRole" class="col-sm-3 control-label"><?php echo $titleField; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="adminRole" id="adminRole" value="<?php echo clean($row['adminRole']); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="location" class="col-sm-3 control-label"><?php echo $locationField; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="location" id="location" value="<?php echo clean($row['location']); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="personalQuip" class="col-sm-3 control-label"><?php echo $persQuoteField; ?></label>
												<div class="col-sm-9">
													<textarea class="form-control" name="personalQuip" id="personalQuip" required="required" rows="3"><?php echo clean($row['personalQuip']); ?></textarea>
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
								<li class="<?php echo $emailTab; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $emailTabTitle; ?></h4>
									<section class="tabContent" id="email">
										<h3><?php echo $changeAdmEmailH3; ?></h3>
										<form action="" method="post" class="form-horizontal">
											<div class="form-group">
												<label for="currEmail" class="col-sm-3 control-label"><?php echo $admCurrEmailField; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" disabled="" value="<?php echo clean($row['adminEmail']); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="newEmail" class="col-sm-3 control-label"><?php echo $admNewEmailField; ?></label>
												<div class="col-sm-9">
													<input type="email" class="form-control" name="newEmail" id="newEmail" required="required" value="<?php echo isset($_POST['newEmail']) ? $_POST['newEmail'] : ''; ?>" />
													<span class="help-block"><?php echo $newEmailAddrFieldHelp; ?></span>
												</div>
											</div>
											<div class="form-group">
												<label for="newEmailr" class="col-sm-3 control-label"><?php echo $admRepeatEmailField;?></label>
												<div class="col-sm-9">
													<input type="email" class="form-control" name="newEmailr" id="newEmailr" required="required" value="<?php echo isset($_POST['newEmailr']) ? $_POST['newEmailr'] : ''; ?>" />
													<span class="help-block"><?php echo $rptEmailAddrFieldHelp; ?></span>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<input type="hidden" name="adminsName" value="<?php echo clean($row['adminName']); ?>" />
													<button type="input" name="submit" value="accEmail" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
												</div>
											</div>
										</form>
									</section>
								</li>
								<li class="<?php echo $passTab; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $passwordText; ?></h4>
									<section class="tabContent" id="password">
										<h3><?php echo $changeAdmPassH3; ?></h3>
										<form action="" method="post" class="form-horizontal">
											<div class="form-group">
												<label for="password" class="col-sm-3 control-label"><?php echo $newPasswordField; ?></label>
												<div class="col-sm-9">
													<input type="password" class="form-control" name="password" id="password" required="required" value="" />
													<span class="help-block"><?php echo $admNewPassFieldHelp; ?></span>
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
													<input type="hidden" name="passwordOld" value="<?php echo $row['password']; ?>" />
													<input type="hidden" name="adminsName" value="<?php echo clean($row['adminName']); ?>" />
													<button type="input" name="submit" value="cngePass" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
												</div>
											</div>
										</form>
									</section>
								</li>
								<li class="<?php echo $picTab; ?>">
									<h4 class="tabHeader" tabindex="0">Picture</h4>
									<section class="tabContent" id="picture">
										<h3><?php echo $mngAdmAccPicH3; ?></h3>
										<?php if ($row['adminPhoto'] == 'defaultPhoto.png') { ?>
											<p><?php echo $mngAdmAccRicQuip; ?></p>
										<?php } else { ?>
											<p><?php echo $mngAdmAccRicQuip1; ?></p>
											<a data-toggle="modal" href="#deletePic" class="btn btn-warning btn-icon mt-20" data-dismiss="modal"><i class="fa fa-ban"></i> <?php echo $remAdmPicBtn; ?></a>
											
											<div id="deletePic" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<form action="" method="post">
															<div class="modal-body">
																<p class="lead"><?php echo $remAdmPicConf; ?></p>
															</div>
															<div class="modal-footer">
																<input type="hidden" name="adminPhoto" value="<?php echo clean($row['adminPhoto']); ?>" />
																<input type="hidden" name="adminsName" value="<?php echo clean($row['adminName']); ?>" />
																<button type="input" name="submit" value="deletePic" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $delAdmPicBtn; ?></button>
																<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
															</div>
														</form>
													</div>
												</div>
											</div>
										<?php } ?>
									</section>
								</li>
								<li class="<?php echo $avatarTab; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $avatarTabTitle; ?></h4>
									<section class="tabContent" id="avatar">
										<h3><?php echo $mngAdmAvatarH3; ?></h3>
										<?php if ($row['adminAvatar'] == 'adminDefault.png') { ?>
											<p><?php echo $mngAdmAvatarQuip; ?></p>
										<?php } else { ?>
											<p>
												<img alt="<?php echo $row['adminName']; ?>" src="../<?php echo $avatarDir.$row['adminAvatar']; ?>" class="avatarImage pull-left" />
												<?php echo $mngAdmAvatarQuip1; ?>
											</p>
											<div class="clearfix"></div>
											<a data-toggle="modal" href="#deleteAvatar" class="btn btn-warning btn-icon mt-20" data-dismiss="modal"><i class="fa fa-ban"></i> <?php echo $remAvatarBtn; ?></a>
											
											<div id="deleteAvatar" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<form action="" method="post">
															<div class="modal-body">
																<p class="lead"><?php echo $mngAdmAvatarConf; ?></p>
															</div>
															<div class="modal-footer">
																<input type="hidden" name="adminAvatar" value="<?php echo clean($row['adminAvatar']); ?>" />
																<input type="hidden" name="adminsName" value="<?php echo clean($row['adminName']); ?>" />
																<button type="input" name="submit" value="deleteAvatar" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $delAdmAvatarBtn; ?></button>
																<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
															</div>
														</form>
													</div>
												</div>
											</div>
										<?php } ?>
									</section>
								</li>
								<li class="<?php echo $statusTab; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $accountStatusTabH4; ?></h4>
									<section class="tabContent" id="status">
										<h3>Change the Administrator's Account Status</h3>
										<?php if ($row['adminId'] == '1') { ?>
											<div class="alertMsg warning mb-20">
												<div class="msgIcon pull-left">
													<i class="fa fa-warning"></i>
												</div>
												<?php echo $accStatusNoModifyMsg; ?>
											</div>
										<?php } else { ?>
											<form action="" method="post" class="form-horizontal mt-20">
												<div class="form-group">
													<label for="isDisabled" class="col-sm-3 control-label"><?php echo $dsbAccField; ?></label>
													<div class="col-sm-9">
														<select class="form-control chosen-select" name="isDisabled">
															<option value="0"><?php echo $noBtn; ?></option>
															<option value="1" <?php echo $isDisabled; ?>><?php echo $yesBtn; ?></option>
														</select>
														<span class="help-block"><?php echo $dsbAdmAccFieldHelp; ?></span>
													</div>
												</div>
												
												<div class="form-group">
													<div class="col-sm-offset-3 col-sm-9">
														<input type="hidden" name="adminsName" value="<?php echo clean($row['adminName']); ?>" />
												<button type="input" name="submit" value="accStatus" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
													</div>
												</div>
											</form>
										<?php } ?>
									</section>
								</li>
								<li class="<?php echo $socialTab; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $socialTabH4; ?></h4>
									<section class="tabContent" id="notes">
										<h3><?php echo $socialTabH3; ?></h3>
										<form action="" method="post" class="form-horizontal mt-20">
											<div class="form-group">
												<label for="facebook" class="col-sm-3 control-label"><?php echo $facebookProfField; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="facebook" id="facebook" value="<?php echo clean($row['facebook']); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="google" class="col-sm-3 control-label"><?php echo $googleProfField; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="google" id="google" value="<?php echo clean($row['google']); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="linkedin" class="col-sm-3 control-label"><?php echo $limkedinProField; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="linkedin" id="linkedin" value="<?php echo clean($row['linkedin']); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="pinterest" class="col-sm-3 control-label"><?php echo $pinterestProfField; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="pinterest" id="pinterest" value="<?php echo clean($row['pinterest']); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="twitter" class="col-sm-3 control-label"><?php echo $twitterProfField; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="twitter" id="twitter" value="<?php echo clean($row['twitter']); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="youtube" class="col-sm-3 control-label"><?php echo $youtubeProfField; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="youtube" id="youtube" value="<?php echo clean($row['youtube']); ?>" />
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<input type="hidden" name="adminsName" value="<?php echo clean($row['adminName']); ?>" />
													<button type="input" name="submit" value="socLinks" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
												</div>
											</div>
										</form>
									</section>
								</li>
							</ul>
						</div>
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