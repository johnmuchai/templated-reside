<?php
	// Add New Admin Account
	if (isset($_POST['submit']) && $_POST['submit'] == 'newAdmin') {
        // Validation
        if($_POST['adminName'] == "") {
            $msgBox = alertBox($admNameReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['adminEmail'] == "") {
            $msgBox = alertBox($admEmailReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['adminEmail'] != $_POST['adminEmail_r']) {
			$msgBox = alertBox($admEmailNoMatch, "<i class='fa fa-warning'></i>", "warning");
        } else if($_POST['password1'] == "") {
            $msgBox = alertBox($admPassReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['password1'] != $_POST['password2']) {
			$msgBox = alertBox($accPassNoMatch, "<i class='fa fa-warning'></i>", "warning");
        } else {
			// Set some variables
			$dupEmail = '';
			$isActive = htmlspecialchars($_POST['isActive']);
			$isAdmin = htmlspecialchars($_POST['isAdmin']);
			$adminName = htmlspecialchars($_POST['adminName']);
			$adminRole = htmlspecialchars($_POST['adminRole']);
			$adminEmail = htmlspecialchars($_POST['adminEmail']);
			$primaryPhone = encryptIt($_POST['primaryPhone']);
			$altPhone = encryptIt($_POST['altPhone']);

			// Check for Duplicate email
			$check = $mysqli->query("SELECT 'X' FROM admins WHERE adminEmail = '".$adminEmail."'");
			if ($check->num_rows) {
				$dupEmail = 'true';
			}

			// If duplicates are found
			if ($dupEmail != '') {
				$msgBox = alertBox($dupAccountMsg, "<i class='fa fa-warning'></i>", "warning");
			} else {
				$hash = md5(rand(0,1000));
				$password = encryptIt($_POST['password1']);

				$stmt = $mysqli->prepare("
									INSERT INTO
										admins(
											isActive,
											isAdmin,
											adminName,
											adminRole,
											adminEmail,
											password,
											primaryPhone,
											altPhone,
											createDate,
											hash
										) VALUES (
											?,
											?,
											?,
											?,
											?,
											?,
											?,
											?,
											NOW(),
											?
										)");
				$stmt->bind_param('sssssssss',
					$isActive,
					$isAdmin,
					$adminName,
					$adminRole,
					$adminEmail,
					$password,
					$primaryPhone,
					$altPhone,
					$hash
				);
				$stmt->execute();
				$stmt->close();

				// Clear the form of Values
				$_POST['adminName'] = $_POST['adminRole'] = $_POST['adminEmail'] = $_POST['adminEmail_r'] = $_POST['primaryPhone'] = $_POST['altPhone'] = '';

				// Add Recent Activity
				$activityType = '17';
				$rs_uid = '0';
				$activityTitle = $rs_adminName.' '.$newAdmAccAct.' "'.$adminName.'"';
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

				$msgBox = alertBox($newAdmAccMsg, "<i class='fa fa-check-square'></i>", "success");
			}
		}
	}

	$adminPage = 'true';
	$pageTitle = $newAdminPageTitle;
	$addCss = '<link href="../css/chosen.css" rel="stylesheet">';
	$chosen = 'true';
	$jsFile = 'newAdmin';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('MNGADMINS', $auths)) || $rs_isAdmin != '') {
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
									<option value="1" selected><?php echo $yesBtn; ?></option>
								</select>
								<span class="help-block"><?php echo $setAccActiveFieldHelp; ?></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="isAdmin"><?php echo $accountTypeField; ?></label>
								<select class="form-control chosen-select" name="isAdmin">
									<option value="0"><?php echo $limitedAccOpt; ?></option>
									<option value="1"><?php echo $superAccOpt; ?></option>
								</select>
								<span class="help-block"><?php echo $accountTypeFieldHelp; ?></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="adminName"><?php echo $adminsNameField; ?></label>
								<input type="text" class="form-control" name="adminName" required="required" value="<?php echo isset($_POST['adminName']) ? $_POST['adminName'] : ''; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="adminRole"><?php echo $adminsTitleField; ?></label>
								<input type="text" class="form-control" name="adminRole" value="<?php echo isset($_POST['adminRole']) ? $_POST['adminRole'] : ''; ?>" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="adminEmail"><?php echo $adminsEmailAddField; ?></label>
								<input type="email" class="form-control" name="adminEmail" required="required" value="<?php echo isset($_POST['adminEmail']) ? $_POST['adminEmail'] : ''; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="adminEmail_r"><?php echo $repAdminEmailAddField; ?></label>
								<input type="email" class="form-control" name="adminEmail_r" required="required" value="<?php echo isset($_POST['adminEmail_r']) ? $_POST['adminEmail_r'] : ''; ?>" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="password1"><?php echo $adminAccPassField; ?></label>
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
								<label for="primaryPhone"><?php echo $adminPriPhoneField; ?></label>
								<input type="text" class="form-control" name="primaryPhone" value="<?php echo isset($_POST['primaryPhone']) ? $_POST['primaryPhone'] : ''; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="altPhone"><?php echo $adminAltPhoneField; ?></label>
								<input type="text" class="form-control" name="altPhone" value="<?php echo isset($_POST['altPhone']) ? $_POST['altPhone'] : ''; ?>" />
							</div>
						</div>
					</div>
					<button type="input" name="submit" value="newAdmin" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $createAccBtn; ?></button>
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