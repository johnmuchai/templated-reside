<?php
	$userId = $mysqli->real_escape_string($_GET['userId']);
	$avatarDir = $set['avatarFolder'];
	$acctTab = 'active';
	$emailTab = $passTab = $avatarTab = $statusTab = $notesTab = $docsTab = '';

	// Get the Max Upload Size allowed
    $maxUpload = (int)(ini_get('upload_max_filesize'));

	// Get the Uploads Directory
	$uploadPath = $set['userDocsPath'];

	// Get the file types allowed from Site Settings
	$filesAllowed = $set['fileTypesAllowed'];
	// Replace the commas with a comma space
	$fileTypesAllowed = preg_replace('/,/', ', ', $filesAllowed);

	$ipAddress = $_SERVER['REMOTE_ADDR'];

	// Update Account
	if (isset($_POST['submit']) && $_POST['submit'] == 'accInfo') {
		// Validation
		if($_POST['userFirstName'] == "") {
            $msgBox = alertBox($tntFirstNameReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['userLastName'] == "") {
            $msgBox = alertBox($tntLastNameReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['primaryPhone'] == "") {
            $msgBox = alertBox($tntPriPhoneReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['userAddress'] == "") {
            $msgBox = alertBox($tntMailAddReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else {
			$userFirstName = htmlspecialchars($_POST['userFirstName']);
			$userLastName = htmlspecialchars($_POST['userLastName']);
			$primaryPhone = encryptIt($_POST['primaryPhone']);
			if (isset($_POST['altPhone'])) {
				$altPhone = encryptIt($_POST['altPhone']);
			} else {
				$altPhone = null;
			}
			if (isset($_POST['userAddress'])) {
				$userAddress = encryptIt($_POST['userAddress']);
			} else {
				$userAddress = null;
			}
			if ($_POST['location'] == "") {
				$location = 'Washington, DC';
			} else {
				$location = htmlspecialchars($_POST['location']);
			}
			if (isset($_POST['pets'])) {
				$pets = htmlspecialchars($_POST['pets']);
			} else {
				$pets = null;
			}

			$stmt = $mysqli->prepare("UPDATE
										users
									SET
										userFirstName = ?,
										userLastName = ?,
										primaryPhone = ?,
										altPhone = ?,
										userAddress = ?,
										location = ?,
										pets = ?
									WHERE
										userId = ?"
			);
			$stmt->bind_param('ssssssss',
									$userFirstName,
									$userLastName,
									$primaryPhone,
									$altPhone,
									$userAddress,
									$location,
									$pets,
									$userId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '16';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$updTenatAccAct.' '.$userFirstName.' '.$userLastName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($updTenatAccMsg." ".$userFirstName.' '.$userLastName." ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");
		}
    }

	// Update Email
	if (isset($_POST['submit']) && $_POST['submit'] == 'accEmail') {
		// Validation
		if($_POST['newEmail'] == "") {
            $msgBox = alertBox($tntEmailAddyReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['newEmail'] != $_POST['newEmailr']) {
            $msgBox = alertBox($newEmailsNotMatchMsg, "<i class='fa fa-times-circle'></i>", "danger");
        } else {
			$newEmail = htmlspecialchars($_POST['newEmail']);
			$tenantsName = htmlspecialchars($_POST['tenantsName']);

			$stmt = $mysqli->prepare("UPDATE
										users
									SET
										userEmail = ?
									WHERE
										userId = ?"
			);
			$stmt->bind_param('ss',
									$newEmail,
									$userId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '16';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$updTenantEmailAct.' '.$tenantsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($updTenantEmailMsg, "<i class='fa fa-check-square'></i>", "success");

			$_POST['newEmail'] = $_POST['newEmailr'] = '';
		}

		$emailTab = 'active';
		$acctTab = $passTab = $avatarTab = $statusTab = $notesTab = $docsTab = '';
    }

	// Change Password
	if (isset($_POST['submit']) && $_POST['submit'] == 'cngePass') {
		// Validation
		if($_POST['password'] == '') {
			$msgBox = alertBox($tntNewPassReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['password_r'] == '') {
			$msgBox = alertBox($retypeTntNewPassReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['password'] != $_POST['password_r']) {
			$msgBox = alertBox($tntPassNoMatch, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			if(isset($_POST['password']) && $_POST['password'] != "") {
				$password = encryptIt($_POST['password']);
			} else {
				$password = $_POST['passwordOld'];
			}
			$tenantsName = htmlspecialchars($_POST['tenantsName']);

			$stmt = $mysqli->prepare("UPDATE
										users
									SET
										password = ?
									WHERE
										userId = ?"
			);
			$stmt->bind_param('ss',
									$password,
									$userId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '16';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$updTntPassAct.' '.$tenantsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($updTntPassMsg, "<i class='fa fa-check-square'></i>", "success");
		}

		$passTab = 'active';
		$acctTab = $emailTab = $avatarTab = $statusTab = $notesTab = $docsTab = '';
    }

	// Delete Avatar Image
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteAvatar') {
		$userAvatar = htmlspecialchars($_POST['userAvatar']);
		$tenantsName = htmlspecialchars($_POST['tenantsName']);

		$filePath = '../'.$avatarDir.$userAvatar;
		// Delete the Tenant's image from the server
		if (file_exists($filePath)) {
			unlink($filePath);

			// Update the Tenant record
			$avatarImage = 'userDefault.png';
			$stmt = $mysqli->prepare("
								UPDATE
									users
								SET
									userAvatar = ?
								WHERE
									userId = ?");
			$stmt->bind_param('ss',
							   $avatarImage,
							   $userId);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '16';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delTntAvatarAct.' '.$tenantsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($delTntAvatarMsg, "<i class='fa fa-check-square'></i>", "success");
		} else {
			$msgBox = alertBox($delTntAvatarError, "<i class='fa fa-warning'></i>", "warning");

			// Add Recent Activity
			$activityType = '16';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delTntAvatarAct2.' '.$tenantsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}

		$avatarTab = 'active';
		$acctTab = $emailTab = $passTab = $statusTab = $notesTab = $docsTab = '';
	}

	// Update Account Status
	if (isset($_POST['submit']) && $_POST['submit'] == 'accStatus') {
		$isDisabled = htmlspecialchars($_POST['isDisabled']);
		$isArchived = htmlspecialchars($_POST['isArchived']);
		$tenantsName = htmlspecialchars($_POST['tenantsName']);

		if ($isArchived == '1') { $archiveDate = date("Y-m-d H:i:s"); } else { $archiveDate = '0000-00-00 00:00:00'; }

		$stmt = $mysqli->prepare("UPDATE
									users
								SET
									isDisabled = ?,
									isArchived = ?,
									archiveDate = ?
								WHERE
									userId = ?"
		);
		$stmt->bind_param('ssss',
								$isDisabled,
								$isArchived,
								$archiveDate,
								$userId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '16';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$tntAccStaAct.' '.$tenantsName;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($tntAccStaMsg, "<i class='fa fa-check-square'></i>", "success");

		$statusTab = 'active';
		$acctTab = $emailTab = $passTab = $avatarTab = $notesTab = $docsTab = '';
    }

	// Update Tenant Notes
	if (isset($_POST['submit']) && $_POST['submit'] == 'tenNotes') {
		$notes = htmlspecialchars($_POST['notes']);
		$tenantsName = htmlspecialchars($_POST['tenantsName']);

		$stmt = $mysqli->prepare("UPDATE
									users
								SET
									notes = ?
								WHERE
									userId = ?"
		);
		$stmt->bind_param('ss',
								$notes,
								$userId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '16';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$opdTntNotesAct.' '.$tenantsName;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($opdTntNotesMsg, "<i class='fa fa-check-square'></i>", "success");

		$notesTab = 'active';
		$acctTab = $emailTab = $passTab = $avatarTab = $statusTab = $docsTab = '';
    }

	// Upload Document
	if (isset($_POST['submit']) && $_POST['submit'] == 'uploadDoc') {
		// User Validations
		if($_POST['docTitle'] == '') {
			$msgBox = alertBox($tntDocTitleReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['docDesc'] == '') {
			$msgBox = alertBox($tntDocDescReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$docTitle = htmlspecialchars($_POST['docTitle']);
			$docDesc = htmlspecialchars($_POST['docDesc']);
			$userFolder = htmlspecialchars($_POST['userFolder']);
			$tenantsName = htmlspecialchars($_POST['tenantsName']);

			// Get the File Types allowed
			$fileExt = $set['fileTypesAllowed'];
			$allowed = preg_replace('/,/', ', ', $fileExt); // Replace the commas with a comma space (, )
			$ftypes = array($fileExt);
			$ftypes_data = explode( ',', $fileExt );

			// Check file type
			$ext = substr(strrchr(basename($_FILES['file']['name']), '.'), 1);
			if (!in_array($ext, $ftypes_data)) {
				$msgBox = alertBox($tntDocFileTypeErr, "<i class='fa fa-times-circle'></i>", "danger");
			} else {
				// Rename the Document to the Tenant's Name
				$fName = clean($tenantsName);

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
				$movePath = '../'.$uploadPath.$userFolder.'/'.$newFileName;

				$stmt = $mysqli->prepare("
									INSERT INTO
										userdocs(
											adminId,
											userId,
											docTitle,
											docDesc,
											docUrl,
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
					$rs_adminId,
					$userId,
					$docTitle,
					$docDesc,
					$newFileName,
					$ipAddress
				);

				if (move_uploaded_file($_FILES['file']['tmp_name'], $movePath)) {
					$stmt->execute();
					$msgBox = alertBox($tntDocUplMsg." ".$docTitle." ".$hasBeenUplAct, "<i class='fa fa-check-square'></i>", "success");
					$stmt->close();

					$emailsql = "SELECT userEmail FROM users WHERE userId = ".$userId;
					$emailresult = mysqli_query($mysqli, $emailsql) or die('-0' . mysqli_error());
					$col = mysqli_fetch_assoc($emailresult);
					$userEmail = $col['userEmail'];

					$siteName = $set['siteName'];
					$siteEmail = $set['siteEmail'];

					$subject = $siteName.' '.$tntDocUplEmailSubject;

					$message = '<html><body>';
					$message .= '<h3>'.$subject.'</h3>';
					$message .= '<p><strong>'.$uploadedByText.'</strong> '.$rs_adminName.'</p>';
					$message .= '<p><strong>'.$tntDocUplEmail1.'</strong> '.$docTitle.'</p>';
					$message .= '<p><strong>'.$descriptionHead.':</strong><br>'.nl2br($docDesc).'</p>';
					$message .= '<hr>';
					$message .= '<p>'.$emailTankYouTxt.'<br>'.$siteName.'</p>';
					$message .= '</body></html>';

					$headers = "From: ".$siteName." <".$siteEmail.">\r\n";
					$headers .= "Reply-To: ".$siteEmail."\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

					mail($userEmail, $subject, $message, $headers);

					// Add Recent Activity
					$activityType = '16';
					$rs_uid = '0';
					$activityTitle = $rs_adminName.' '.$tntDocUplAct.' '.$tenantsName;
					updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
				} else {
					$msgBox = alertBox($tntDocUplErr, "<i class='fa fa-times-circle'></i>", "danger");

					// Add Recent Activity
					$activityType = '16';
					$rs_uid = '0';
					$activityTitle = $TntDocUplErr1.' '.$tenantsName.' '.$templUplActError1;
					updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
				}
			}
		}

		$docsTab = 'active';
		$acctTab = $emailTab = $passTab = $avatarTab = $statusTab = $notesTab = '';
	}

	// Delete Document
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteDoc') {
		$deleteId = htmlspecialchars($_POST['deleteId']);
		$docTitle = htmlspecialchars($_POST['docTitle']);
		$userFolder = htmlspecialchars($_POST['userFolder']);
		$tenantsName = htmlspecialchars($_POST['tenantsName']);
		$docUrl = htmlspecialchars($_POST['docUrl']);

		$filePath = '../'.$uploadPath.$userFolder.'/'.$docUrl;

		// Delete the Picture from the server
		if (file_exists($filePath)) {
			unlink($filePath);

			$stmt = $mysqli->prepare("DELETE FROM userdocs WHERE docId = ".$deleteId);
			$stmt->execute();
			$stmt->close();

			$msgBox = alertBox($tntDocUplMsg." \"".$docTitle."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");

			// Add Recent Activity
			$activityType = '16';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delTntDocAct.' "'.$docTitle.'" for '.$tenantsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		} else {
			$msgBox = alertBox($delTntDocErr, "<i class='fa fa-warning'></i>", "warning");

			// Add Recent Activity
			$activityType = '16';
			$rs_uid = '0';
			$activityTitle = $TntDocUplErr1.' '.$tenantsName.' '.$deleteFileAct2;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}

		$docsTab = 'active';
		$acctTab = $emailTab = $passTab = $avatarTab = $statusTab = $notesTab = '';
	}

	// Get Data
	$qry = "SELECT * FROM users WHERE userId = ".$userId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);

	// Decrypt data
	if ($row['primaryPhone'] != '') { $primaryPhone = decryptIt($row['primaryPhone']); } else { $primaryPhone = '';  }
	if ($row['altPhone'] != '') { $altPhone = decryptIt($row['altPhone']); } else { $altPhone = '';  }
	if ($row['userAddress'] != '') { $userAddress = decryptIt($row['userAddress']); } else { $userAddress = '';  }

	if ($row['lastVisited'] == '0000-00-00 00:00:00') { $lastVisited = $noneText; } else { $lastVisited = dateFormat($row['lastVisited']); }
	if ($row['isResident'] == '1') { $accType = $residentText; } else { $accType = $tenantText;  }
	if ($row['isDisabled'] == '1') {
		$isDisabled = 'selected';
		$actAcc = $disabledText;
	} else {
		$isDisabled = '';
		$actAcc = $tntEnabledText;
	}
	if ($row['isArchived'] == '1') {
		$isArchived = 'selected';
		$accArch = $tntArchivedText;
	} else {
		$isArchived = '';
		$accArch = '';
	}

	if ($row['isResident'] == '0') {
		if ($row['isLeased'] == '1') {
			// Get Property Data
			$sql = "SELECT
						properties.propertyId,
						properties.propertyName,
						leases.leaseTerm,
						leases.leaseStart,
						leases.leaseEnd
					FROM
						properties
						LEFT JOIN leases ON properties.propertyId = leases.propertyId
						LEFT JOIN users ON leases.leaseId = users.leaseId
					WHERE
						leases.userId = ".$userId." AND
						users.leaseId = ".$row['leaseId'];
			$result = mysqli_query($mysqli, $sql) or die('-2' . mysqli_error());
			$rows = mysqli_fetch_assoc($result);
		}
	}

	// Get Documents
	$qrystmt = "SELECT
					userdocs.*,
					admins.adminName
				FROM
					userdocs
					LEFT JOIN admins ON userdocs.adminId = admins.adminId
				WHERE
					userdocs.userId = ".$userId;
	$results = mysqli_query($mysqli, $qrystmt) or die('-3' . mysqli_error());

	$tenPage = 'true';
	$pageTitle = $viewTenantPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet"><link href="../css/chosen.css" rel="stylesheet">';
	$dataTables = 'true';
	$chosen = 'true';
	$jsFile = 'viewTenant';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if($rs_managerId!=""){ //if ((checkArray('MNGTEN', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle; ?></h3>

				<div class="row">
					<div class="col-md-4">
						<div class="profileBox">
							<div class="cover">
								<div class="profilePic">
									<img src="../<?php echo $avatarDir.$row['userAvatar']; ?>" class="publicPic" />
								</div>
							</div>

							<div class="profileBody">
								<h1>
									<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>
								</h1>
								<p class="lead" class="mt-10"><?php echo clean($row['userEmail']); ?></p>
								<p>
									<?php echo $primaryPhone; ?><br />
									<?php echo $actAcc.$accArch.' '.$accType; ?><br />
									<?php echo $memberSinceText.' '.dateFormat($row['createDate']); ?><br />
									<?php echo $lastSigninHead; ?>: <?php echo $lastVisited; ?>
								</p>
							</div>
						</div>

						<?php
							if ($row['isResident'] == '0') {
								if ($row['isLeased'] == '1') {
						?>
								<ul class="list-group">
									<li class="list-group-item">
										<strong><?php echo $leasedPropText; ?>:</strong>
										<a href="index.php?action=viewProperty&propertyId=<?php echo $rows['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
											<?php echo clean($rows['propertyName']); ?>
										</a>
									</li>
									<li class="list-group-item">
										<strong><?php echo $leaseTermText; ?></strong>
										<?php echo clean($rows['leaseTerm']); ?><br />
										<small><?php echo dateFormat($rows['leaseStart']).' &mdash; '.dateFormat($rows['leaseEnd']); ?></small>
									</li>
								</ul>
						<?php } else { ?>
								<div class="alertMsg default">
									<div class="msgIcon pull-left">
										<i class="fa fa-info-circle"></i>
									</div>
									<?php echo $noTntActLeaseFoundMsg.' '.$accType; ?>.
								</div>
						<?php
								}
							}
						?>
					</div>
					<div class="col-md-8">
						<div class="tabs mt-0">
							<ul class="tabsBody">
								<li class="<?php echo $acctTab; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $accountTabTitle; ?></h4>
									<section class="tabContent" id="account">
										<h3><?php echo $mngTntAccH3; ?> <?php echo $accType.$mngTntAccH31; ?></h3>
										<form action="" method="post" class="form-horizontal">
											<div class="form-group">
												<label for="userFirstName" class="col-sm-3 control-label"><?php echo $accType; ?> <?php echo $contUsFormFirstName; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="userFirstName" id="userFirstName" required="required" value="<?php echo clean($row['userFirstName']); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="userLastName" class="col-sm-3 control-label"><?php echo $accType; ?> <?php echo $contUsFormLastName; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="userLastName" id="userLastName" required="required" value="<?php echo clean($row['userLastName']); ?>" />
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
												<label for="userAddress" class="col-sm-3 control-label"><?php echo $mailingAddrField; ?></label>
												<div class="col-sm-9">
													<textarea class="form-control" name="userAddress" id="userAddress" required="required" rows="3"><?php echo $userAddress; ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label for="location" class="col-sm-3 control-label"><?php echo $locationField; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="location" id="location" value="<?php echo clean($row['location']); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="pets" class="col-sm-3 control-label"><?php echo $petsText; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" name="pets" id="pets" value="<?php echo clean($row['pets']); ?>" />
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
										<h3><?php echo $changeTheH3.' '.$accType.$changeTheH31; ?></h3>
										<form action="" method="post" class="form-horizontal">
											<div class="form-group">
												<label for="currEmail" class="col-sm-3 control-label"><?php echo $accType.$currEmailText; ?></label>
												<div class="col-sm-9">
													<input type="text" class="form-control" disabled="" value="<?php echo clean($row['userEmail']); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="newEmail" class="col-sm-3 control-label"><?php echo $accType.$newEmailText; ?></label>
												<div class="col-sm-9">
													<input type="email" class="form-control" name="newEmail" id="newEmail" required="required" value="<?php echo isset($_POST['newEmail']) ? $_POST['newEmail'] : ''; ?>" />
													<span class="help-block"><?php echo $newEmailAddrFieldHelp; ?></span>
												</div>
											</div>
											<div class="form-group">
												<label for="newEmailr" class="col-sm-3 control-label"><?php echo $repeatText.' '.$accType.$repeatText1; ?></label>
												<div class="col-sm-9">
													<input type="email" class="form-control" name="newEmailr" id="newEmailr" required="required" value="<?php echo isset($_POST['newEmailr']) ? $_POST['newEmailr'] : ''; ?>" />
													<span class="help-block"><?php echo $rptEmailAddrFieldHelp; ?></span>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<input type="hidden" name="tenantsName" value="<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>" />
													<button type="input" name="submit" value="accEmail" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
												</div>
											</div>
										</form>
									</section>
								</li>
								<li class="<?php echo $passTab; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $passwordText; ?></h4>
									<section class="tabContent" id="password">
										<h3><?php echo $repeatText1.' '.$accType.$accPassText; ?></h3>
										<form action="" method="post" class="form-horizontal">
											<div class="form-group">
												<label for="password" class="col-sm-3 control-label"><?php echo $newPasswordField; ?></label>
												<div class="col-sm-9">
													<input type="password" class="form-control" name="password" id="password" required="required" value="" />
													<span class="help-block"><?php echo $accPassText1.' '.$accType.$accPassText2; ?></span>
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
													<input type="hidden" name="tenantsName" value="<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>" />
													<button type="input" name="submit" value="cngePass" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
												</div>
											</div>
										</form>
									</section>
								</li>
								<li class="<?php echo $avatarTab; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $avatarTabTitle; ?></h4>
									<section class="tabContent" id="avatar">
										<h3><?php echo $mngTntAccH3.' '.$accType.$profAvatarText; ?></h3>
										<?php if ($row['userAvatar'] == 'userDefault.png') { ?>
											<p><?php echo $theText.' '.$accType; ?> <?php echo $profAvatarText1; ?></p>
										<?php } else { ?>
											<p><?php echo $profAvatarText2.' '.$accType; ?><?php echo $profAvatarText3; ?> <?php echo $accType.' '.$profAvatarText4; ?></p>
											<a data-toggle="modal" href="#deleteAvatar" class="btn btn-warning btn-icon mt-20" data-dismiss="modal"><i class="fa fa-ban"></i> <?php echo $remAvatarBtn; ?></a>

											<div id="deleteAvatar" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<form action="" method="post">
															<div class="modal-body">
																<p class="lead"><?php echo $profAvatarText5.' '.$accType.$profAvatarText6; ?></p>
															</div>
															<div class="modal-footer">
																<input type="hidden" name="userAvatar" value="<?php echo clean($row['userAvatar']); ?>" />
																<input type="hidden" name="tenantsName" value="<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>" />
																<button type="input" name="submit" value="deleteAvatar" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $profAvatarText7.' '.$accType.$profAvatarText8; ?></button>
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
										<h3><?php echo $changeTheH3.' '.$accType.' '.$accStatText; ?></h3>
										<?php if ($row['isLeased'] == '0' || $row['isResident'] == '1') { ?>
											<p><?php echo $accStatText1; ?></p>
											<form action="" method="post" class="form-horizontal mt-20">
												<div class="form-group">
													<label for="isDisabled" class="col-sm-3 control-label"><?php echo $dsbAccField; ?></label>
													<div class="col-sm-9">
														<select class="form-control chosen-select" name="isDisabled">
															<option value="0"><?php echo $noBtn; ?></option>
															<option value="1" <?php echo $isDisabled; ?>><?php echo $yesBtn; ?></option>
														</select>
														<span class="help-block"><?php echo $selectYesText.' '.$accType.$selectYesText1; ?></span>
													</div>
												</div>
												<div class="form-group">
													<label for="isArchived" class="col-sm-3 control-label"><?php echo $arcAccText; ?></label>
													<div class="col-sm-9">
														<select class="form-control chosen-select" name="isArchived">
															<option value="0"><?php echo $noBtn; ?></option>
															<option value="1" <?php echo $isArchived; ?>><?php echo $yesBtn; ?></option>
														</select>
														<span class="help-block"><?php echo $arcAccHelp.' '.$accType.$arcAccHelp1; ?></span>
													</div>
												</div>

												<div class="form-group">
													<div class="col-sm-offset-3 col-sm-9">
														<input type="hidden" name="tenantsName" value="<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>" />
														<button type="input" name="submit" value="accStatus" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
													</div>
												</div>
											</form>
										<?php } else { ?>
											<p><?php echo $tntAccStaQuip; ?></p>
										<?php } ?>
									</section>
								</li>
								<li class="<?php echo $notesTab; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $notesTabText; ?></h4>
									<section class="tabContent" id="notes">
										<h3><?php echo $mngTntAccH3.' '.$accType.$tntIntNotesText; ?></h3>
										<form action="" method="post" class="form-horizontal">
											<div class="form-group">
												<label for="userAddress" class="col-sm-3 control-label"><?php echo $intNotesField; ?></label>
												<div class="col-sm-9">
													<textarea class="form-control" name="notes" id="notes" rows="8"><?php echo clean($row['notes']); ?></textarea>
													<span class="help-block"><?php echo $intNotesFieldHelp1.' '.$accType.' '.$intNotesFieldHelp2; ?></span>
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<input type="hidden" name="tenantsName" value="<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>" />
													<button type="input" name="submit" value="tenNotes" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
												</div>
											</div>
										</form>
									</section>
								</li>
								<li class="<?php echo $docsTab; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $docsTabH4; ?></h4>
									<section class="tabContent" id="documents">
										<h3><?php echo $mngTntDocs.' '.$accType; ?></h3>
										<p class="text-right">
											<a data-toggle="modal" href="#uploadDoc" class="btn btn-success btn-xs btn-icon mb-10"><i class="fa fa-upload"></i> <?php echo $uplDocBtn; ?></a>
										</p>

										<div class="modal fade" id="uploadDoc" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
														<h4 class="modal-title"><?php echo $uplDoctntH4.' '.$accType; ?></h4>
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
																		<label for="docTitle"><?php echo $docTitleField; ?></label>
																		<input type="text" class="form-control" name="docTitle" id="docTitle" required="required" maxlength="50" value="<?php echo isset($_POST['docTitle']) ? $_POST['docTitle'] : ''; ?>" />
																		<span class="help-block"><?php echo $docTitleFieldHelp; ?></span>
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="docDesc"><?php echo $docDescField; ?></label>
																		<input type="text" class="form-control" name="docDesc" id="docDesc" required="required" value="<?php echo isset($_POST['docDesc']) ? $_POST['docDesc'] : ''; ?>" />
																		<span class="help-block"><?php echo $docDescFieldHelp; ?></span>
																	</div>
																</div>
															</div>

															<div class="form-group">
																<label for="file"><?php echo $selectDocField; ?></label>
																<input type="file" id="file" name="file" />
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="userFolder" value="<?php echo clean($row['userFolder']); ?>" />
															<input type="hidden" name="tenantsName" value="<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>" />
															<button type="input" name="submit" value="uploadDoc" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $uploadDocBtn; ?></button>
															<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
														</div>
													</form>
												</div>
											</div>
										</div>

										<?php if(mysqli_num_rows($results) < 1) { ?>
											<div class="alertMsg default mb-20">
												<div class="msgIcon pull-left">
													<i class="fa fa-info-circle"></i>
												</div>
												<?php echo $noDocsFoundMsg.' '.$accType; ?>.
											</div>
										<?php } else { ?>
											<table id="docs" class="display" cellspacing="0">
												<thead>
													<tr>
														<th><?php echo $docNameHead; ?></th>
														<th><?php echo $docDescHead; ?></th>
														<th class="text-center"><?php echo $uploadedByHead; ?></th>
														<th class="text-center"><?php echo $dateUploadedHead; ?></th>
														<th></th>
													</tr>
												</thead>

												<tbody>
													<?php while ($rows = mysqli_fetch_assoc($results)) { ?>
														<tr>
															<td>
																<a href="index.php?action=viewDocument&docId=<?php echo $rows['docId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewDocText; ?>">
																	<?php echo clean($rows['docTitle']); ?>
																</a>
															</td>
															<td><?php echo clean($rows['docDesc']); ?></td>
															<td class="text-center"><?php echo clean($rows['adminName']); ?></td>
															<td class="text-center"><?php echo dateFormat($rows['uploadDate']); ?></td>
															<td class="text-right">
																<a data-toggle="modal" href="#deleteDocument<?php echo $rows['docId']; ?>" class="text-danger">
																	<i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="<?php echo $delDocBtn; ?>"></i>
																</a>

																<div class="modal fade" id="deleteDocument<?php echo $rows['docId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
																	<div class="modal-dialog text-left">
																		<div class="modal-content">
																			<form action="" method="post">
																				<div class="modal-body">
																					<p class="lead"><?php echo $delDocConf; ?> "<?php echo clean($rows['docTitle']); ?>"?</p>
																				</div>
																				<div class="modal-footer">
																					<input type="hidden" name="deleteId" value="<?php echo $rows['docId']; ?>" />
																					<input type="hidden" name="docTitle" value="<?php echo clean($rows['docTitle']); ?>" />
																					<input type="hidden" name="docUrl" value="<?php echo clean($rows['docUrl']); ?>" />
																					<input type="hidden" name="userFolder" value="<?php echo clean($row['userFolder']); ?>" />
																					<input type="hidden" name="tenantsName" value="<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>" />
																					<button type="input" name="submit" value="deleteDoc" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
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
										<?php } ?>
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
