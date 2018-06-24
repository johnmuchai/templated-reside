<?php
	// Get Documents Folder from Site Settings
	$docUploadPath = $set['userDocsPath'];

	// Add New Tenant/Resident Account
	if (isset($_POST['submit']) && $_POST['submit'] == 'newTenant') {
        // Validation
        if($_POST['userFirstName'] == "") {
            $msgBox = alertBox($tntFirstNameReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['userLastName'] == "") {
            $msgBox = alertBox($tntLastNameReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['userEmail'] == "") {
            $msgBox = alertBox($tntEmailReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['userEmail'] != $_POST['userEmail_r']) {
			$msgBox = alertBox($tntEmailNoMatch, "<i class='fa fa-warning'></i>", "warning");
        } else if($_POST['password1'] == "") {
            $msgBox = alertBox($admPassReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['password1'] != $_POST['password2']) {
			$msgBox = alertBox($accPassNoMatch, "<i class='fa fa-warning'></i>", "warning");
        } else {
			// Set some variables
			$dupEmail = '';
			$isActive = htmlspecialchars($_POST['isActive']);
			$isResident = htmlspecialchars($_POST['isResident']);
			$userFirstName = htmlspecialchars($_POST['userFirstName']);
			$userLastName = htmlspecialchars($_POST['userLastName']);
			$userEmail = htmlspecialchars($_POST['userEmail']);
			$primaryPhone = encryptIt($_POST['primaryPhone']);
			$altPhone = encryptIt($_POST['altPhone']);

			if ($isResident == '1') { $accType = $residentText; } else { $accType = $tenantText; }

			// Check for Duplicate email
			$check = $mysqli->query("SELECT 'X' FROM users WHERE userEmail = '".$userEmail."'");
			if ($check->num_rows) {
				$dupEmail = 'true';
			}

			// If duplicates are found
			if ($dupEmail != '') {
				$msgBox = alertBox($dupAccountMsg, "<i class='fa fa-warning'></i>", "warning");
			} else {
				// Generate a RANDOM Hash
				$randomHash = uniqid(rand());
				// Take the first 8 hash digits
				$randHash = substr($randomHash, 0, 8);

				// Create the Tenant's Documents Folder
				// Replace any spaces with an underscore and set to all lower-case
				$docFolderName = $userFirstName.'_'.$userLastName;
				$tenantDocs = str_replace(' ', '_', $docFolderName);

				$tenantDocsFolder = strtolower($tenantDocs).'_'.$randHash;

				// Create the Tenant Document Directory
				if (mkdir('../'.$docUploadPath.$tenantDocsFolder, 0755, true)) {
					$newDir = '../'.$docUploadPath.$tenantDocsFolder;
				}

				$primaryTenantId = '0';

				if ($isActive == '0') {
					// Create the new account & send Activation Email
					$hash = md5(rand(0,1000));
					$password = encryptIt($_POST['password1']);

					$stmt = $mysqli->prepare("
										INSERT INTO
											users(
												isResident,
												primaryTenantId,
												userEmail,
												password,
												userFirstName,
												userLastName,
												primaryPhone,
												altPhone,
												userFolder,
												createDate,
												hash,
												isActive
											) VALUES (
												?,
												?,
												?,
												?,
												?,
												?,
												?,
												?,
												?,
												NOW(),
												?,
												?
											)");
					$stmt->bind_param('sssssssssss',
						$isResident,
						$primaryTenantId,
						$userEmail,
						$password,
						$userFirstName,
						$userLastName,
						$primaryPhone,
						$altPhone,
						$tenantDocsFolder,
						$hash,
						$isActive
					);
					$stmt->execute();
					$stmt->close();

					// Send out the email in HTML
					$installUrl = $set['installUrl'];
					$siteName = $set['siteName'];
					$siteEmail = $set['siteEmail'];
					$newPass = $_POST['password1'];

					$subject = $newTntEmailSubject.' '.$siteName.' '.$newTntEmailSubject1;

					$message = '<html><body>';
					$message .= '<h3>'.$subject.'</h3>';
					$message .= '<p>'.$newTntEmail.'</p>';
					$message .= '<hr>';
					$message .= '<p>'.$newTntEmail1.' '.$newPass.'</p>';
					$message .= '<p>'.$newTntEmail2.'<br> '.$installUrl.'activate.php?userEmail='.$userEmail.'&hash='.$hash.'</p>';
					$message .= '<hr>';
					$message .= '<p>'.$newTntEmail3.'</p>';
					$message .= '<p>'.$emailThankYou.'</p>';
					$message .= '</body></html>';

					$headers = "From: ".$siteName." <".$siteEmail.">\r\n";
					$headers .= "Reply-To: ".$siteEmail."\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

					if (mailer($userEmail, $subject, $message, $headers)) {
						$msgBox = alertBox($newTntCreatedMsg, "<i class='fa fa-check-square'></i>", "success");
					} else {
						$msgBox = alertBox($emailErrorMsg, "<i class='fa fa-times-circle'></i>", "danger");
					}

					// Clear the form of Values
					$_POST['userFirstName'] = $_POST['userLastName'] = $_POST['userEmail'] = $_POST['userEmail_r'] = $_POST['primaryPhone'] = $_POST['altPhone'] = '';

					// Add Recent Activity
					$activityType = '16';
					$rs_uid = '0';
					$activityTitle = $rs_adminName.' '.$newTntCreatedAct.' "'.$userFirstName.' '.$userLastName.'"';
					updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
				} else {
					// Create the new account and set it to Active
					$hash = md5(rand(0,1000));
					$password = encryptIt($_POST['password1']);

					$stmt = $mysqli->prepare("
										INSERT INTO
											users(
												isResident,
												primaryTenantId,
												userEmail,
												password,
												userFirstName,
												userLastName,
												primaryPhone,
												altPhone,
												userFolder,
												createDate,
												hash,
												isActive
											) VALUES (
												?,
												?,
												?,
												?,
												?,
												?,
												?,
												?,
												?,
												NOW(),
												?,
												?
											)");
					$stmt->bind_param('sssssssssss',
						$isResident,
						$primaryTenantId,
						$userEmail,
						$password,
						$userFirstName,
						$userLastName,
						$primaryPhone,
						$altPhone,
						$tenantDocsFolder,
						$hash,
						$isActive
					);
					$stmt->execute();
					$stmt->close();
					// Clear the form of Values
					$_POST['userFirstName'] = $_POST['userLastName'] = $_POST['userEmail'] = $_POST['userEmail_r'] = $_POST['primaryPhone'] = $_POST['altPhone'] = '';

					// Add Recent Activity
					$activityType = '16';
					$rs_uid = '0';
					$activityTitle = $rs_adminName.' '.$newTntCreatedAct1.' "'.$userFirstName.' '.$userLastName.'"';
					updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

					$msgBox = alertBox($newTntCreatedMsg1, "<i class='fa fa-check-square'></i>", "success");
				}
			}
		}
	}

	$tenPage = 'true';
	$pageTitle = $newTenantPageTitle;
	$addCss = '<link href="../css/chosen.css" rel="stylesheet">';
	$chosen = 'true';
	$jsFile = 'newTenant';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if($rs_managerId!=""){ //if ((checkArray('MNGTEN', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle; ?></h3>

				<form action="" method="post" class="mb-20">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="isActive"><?php echo $setAccActiveField; ?></label>
								<select class="form-control chosen-select" name="isActive">
									<option value="0"><?php echo $noBtn; ?></option>
									<option value="1"><?php echo $yesBtn; ?></option>
								</select>
								<span class="help-block"><?php echo $setTenActHelp; ?></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="isResident"><?php echo $accountTypeField; ?></label>
								<select class="form-control chosen-select" name="isResident">
									<option value="0"><?php echo $priTenantopt; ?></option>
									<option value="1"><?php echo $residentText; ?></option>
								</select>
								<span class="help-block"><?php echo $tntAccountTypeHelp; ?></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="userFirstName"><?php echo $tntFirstNameField; ?></label>
								<input type="text" class="form-control" name="userFirstName" required="required" value="<?php echo isset($_POST['userFirstName']) ? $_POST['userFirstName'] : ''; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="userLastName"><?php echo $tntLastNameField; ?></label>
								<input type="text" class="form-control" name="userLastName" required="required" value="<?php echo isset($_POST['userLastName']) ? $_POST['userLastName'] : ''; ?>" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="userEmail"><?php echo $tntEmalAddField; ?></label>
								<input type="email" class="form-control" name="userEmail" required="required" value="<?php echo isset($_POST['userEmail']) ? $_POST['userEmail'] : ''; ?>" />
								<span class="help-block"><?php echo $newEmailAddrFieldHelp; ?></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="userEmail_r"><?php echo $tntRepeatEmailField; ?></label>
								<input type="email" class="form-control" name="userEmail_r" required="required" value="<?php echo isset($_POST['userEmail_r']) ? $_POST['userEmail_r'] : ''; ?>" />
								<span class="help-block"><?php echo $rptEmailAddrFieldHelp; ?></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="password1"><?php echo $tntaccPassField; ?></label>
								<div class="input-group">
									<input type="password" class="form-control" required="required" name="password1" id="password1" value="" />
									<span class="input-group-addon"><a href="" id="generate" data-toggle="tooltip" data-placement="top" title="<?php echo $genPasswordBtn; ?>"><i class="fa fa-key"></i></a></span>
								</div>
								<span class="help-block">
									<a href="" id="showIt" class="btn btn-warning btn-xs"><?php echo $showPlainText; ?></a>
									<a href="" id="hideIt" class="btn btn-info btn-xs"><?php echo $hidePlainText; ?></a>
								</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="password2"><?php echo $repeatPassField; ?></label>
								<input type="password" class="form-control" required="required" name="password2" id="password2" value="" />
								<span class="help-block"><?php echo $repeatPassFieldHelp; ?></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="primaryPhone"><?php echo $tntPriPhoneField; ?></label>
								<input type="text" class="form-control" name="primaryPhone" value="<?php echo isset($_POST['primaryPhone']) ? $_POST['primaryPhone'] : ''; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="altPhone"><?php echo $tntAltPhoneField; ?></label>
								<input type="text" class="form-control" name="altPhone" value="<?php echo isset($_POST['altPhone']) ? $_POST['altPhone'] : ''; ?>" />
							</div>
						</div>
					</div>
					<button type="input" name="submit" value="newTenant" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $createAccBtn; ?></button>
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
