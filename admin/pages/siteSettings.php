<?php
	// Update Global Site Settings
	if (isset($_POST['submit']) && $_POST['submit'] == 'globalset') {
		if($_POST['installUrl'] == "") {
            $msgBox = alertBox($installUrlReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['siteName'] == "") {
            $msgBox = alertBox($siteNameReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['businessAddress'] == "") {
            $msgBox = alertBox($busAddReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['siteEmail'] == "") {
            $msgBox = alertBox($siteEmailReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['businessPhone'] == "") {
            $msgBox = alertBox($busPhoneReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['contactUsMap'] == "") {
            $msgBox = alertBox($googMapUrlReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$installUrl = htmlspecialchars($_POST['installUrl']);
			if(substr($installUrl, -1) != '/') {
				$install = $installUrl.'/';
			} else {
				$install = $installUrl;
			}

			$siteName = htmlspecialchars($_POST['siteName']);
			$siteEmail = htmlspecialchars($_POST['siteEmail']);
			$businessName = htmlspecialchars($_POST['businessName']);
			$localization = htmlspecialchars($_POST['localization']);
			$allowRegistrations = htmlspecialchars($_POST['allowRegistrations']);
			$enableHoa = htmlspecialchars($_POST['enableHoa']);
			$weekStart = htmlspecialchars($_POST['weekStart']);
			$businessPhone = htmlspecialchars($_POST['businessPhone']);
			$contactPhone = htmlspecialchars($_POST['contactPhone']);
			$siteQuip = htmlspecialchars($_POST['siteQuip']);
			$weatherLoc = htmlspecialchars($_POST['weatherLoc']);
			$businessAddress = htmlspecialchars($_POST['businessAddress']);
			$contactUsMap = htmlspecialchars($_POST['contactUsMap']);
			$analyticsCode = htmlspecialchars($_POST['analyticsCode']);

			$stmt = $mysqli->prepare("UPDATE
										sitesettings
									SET
										installUrl = ?,
										siteName = ?,
										siteEmail = ?,
										businessName = ?,
										localization = ?,
										allowRegistrations = ?,
										enableHoa = ?,
										weekStart = ?,
										businessPhone = ?,
										contactPhone = ?,
										siteQuip = ?,
										weatherLoc = ?,
										businessAddress = ?,
										contactUsMap = ?,
										analyticsCode = ?
			");
			$stmt->bind_param('sssssssssssssss',
								$install,
								$siteName,
								$siteEmail,
								$businessName,
								$localization,
								$allowRegistrations,
								$enableHoa,
								$weekStart,
								$businessPhone,
								$contactPhone,
								$siteQuip,
								$weatherLoc,
								$businessAddress,
								$contactUsMap,
								$analyticsCode
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '8';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$globSitSetAct;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($globSitSetMsg, "<i class='fa fa-check-square'></i>", "success");
		}
	}

	// Get Data
    $qry = "SELECT * FROM sitesettings";
    $res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);

	if ($row['allowRegistrations'] == '1') { $allowReg = 'selected'; } else { $allowReg = ''; }
	if ($row['weekStart'] == '1') { $startWk = 'selected'; } else { $startWk = ''; }
	if ($row['localization'] == 'custom') { $custom = 'selected'; } else { $custom = ''; }
	if ($row['enableHoa'] == '1') { $allowHOA = 'selected'; } else { $allowHOA = ''; }

	$managePage = 'true';
	$pageTitle = $siteSettingsPageTitle;
	$addCss = '<link href="../css/chosen.css" rel="stylesheet">';
	$chosen = 'true';

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
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="installUrl"><?php echo $installUrlField; ?></label>
						<input type="text" class="form-control" required="required" name="installUrl" id="installUrl" required="required" value="<?php echo $row['installUrl']; ?>" />
						<span class="help-block"><?php echo $installUrlFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="siteName"><?php echo $siteNameField; ?></label>
						<input type="text" class="form-control" required="required" name="siteName" id="siteName" required="required" value="<?php echo $row['siteName']; ?>" />
						<span class="help-block"><?php echo $siteNameFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="siteEmail"><?php echo $siteEmailField; ?></label>
						<input type="text" class="form-control" required="required" name="siteEmail" id="siteEmail" required="required" value="<?php echo $row['siteEmail']; ?>" />
						<span class="help-block"><?php echo $siteEmailFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="businessName"><?php echo $busiNameField; ?></label>
						<input type="text" class="form-control" name="businessName" id="businessName" required="required" value="<?php echo $row['businessName']; ?>" />
						<span class="help-block"><?php echo $busiNameFieldHelp; ?></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="localization"><?php echo $localField; ?></label>
						<select class="form-control chosen-select" name="localization" id="localization">
							<option value="english">English - language/english.php</option>
							<option value="custom" <?php echo $custom; ?>>Custom - language/custom.php</option>
						</select>
						<span class="help-block"><?php echo $localFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="allowRegistrations"><?php echo $enbRegField; ?></label>
						<select class="form-control chosen-select" name="allowRegistrations" id="allowRegistrations">
							<option value="0"><?php echo $noBtn; ?></option>
							<option value="1" <?php echo $allowReg; ?>><?php echo $yesBtn; ?></option>
						</select>
						<span class="help-block"><?php echo $enbRegFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="enableHoa"><?php echo $enbHoaField; ?></label>
						<select class="form-control chosen-select" name="enableHoa" id="enableHoa">
							<option value="0"><?php echo $noBtn; ?></option>
							<option value="1" <?php echo $allowHOA; ?>><?php echo $yesBtn; ?></option>
						</select>
						<span class="help-block"><?php echo $enbHoaFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="weekStart"><?php echo $weekStartField; ?></label>
						<select class="form-control chosen-select" name="weekStart" id="weekStart">
							<option value="0"><?php echo $sunText; ?></option>
							<option value="1" <?php echo $startWk; ?>><?php echo $monText; ?></option>
						</select>
						<span class="help-block"><?php echo $weekStartFieldHelp; ?></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="businessPhone"><?php echo $busPhoneField; ?></label>
						<input type="text" class="form-control" required="required" name="businessPhone" id="businessPhone" required="required" value="<?php echo clean($row['businessPhone']); ?>" />
						<span class="help-block"><?php echo $busPhoneFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="contactPhone"><?php echo $contPhoneField; ?></label>
						<input type="text" class="form-control" name="contactPhone" id="contactPhone" value="<?php echo clean($row['contactPhone']); ?>" />
						<span class="help-block"><?php echo $contPhoneFieldHelp; ?></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="siteQuip"><?php echo $siteTitleField; ?></label>
						<input type="text" class="form-control" name="siteQuip" id="siteQuip" value="<?php echo $row['siteQuip']; ?>" />
						<span class="help-block"><?php echo $busiNameFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="weatherLoc"><?php echo $weatherWidgLocField; ?></label>
						<input type="text" class="form-control" name="weatherLoc" value="<?php echo clean($row['weatherLoc']); ?>" />
						<span class="help-block"><?php echo $weatherWidgLocFieldHelp; ?></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="businessAddress"><?php echo $busiAddField; ?></label>
						<textarea class="form-control" required="required" name="businessAddress" id="businessAddress" required="required" rows="3"><?php echo $row['businessAddress']; ?></textarea>
						<span class="help-block"><?php echo $busiAddFieldHelp; ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="contactUsMap"><?php echo $googMapUrlField; ?></label>
						<textarea class="form-control" required="required" name="contactUsMap" id="contactUsMap" rows="3"><?php echo htmlspecialchars_decode($row['contactUsMap']); ?></textarea>
						<span class="help-block"><?php echo $googMapUrlFieldHelp; ?></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="analyticsCode"><?php echo $googAnalyticsField; ?></label>
				<textarea class="form-control" name="analyticsCode" id="analyticsCode" rows="6"><?php echo htmlspecialchars_decode($row['analyticsCode']); ?></textarea>
				<span class="help-block"><?php echo $googAnalyticsFieldHelp; ?></span>
			</div>
			<button type="input" name="submit" value="globalset" class="btn btn-success btn-icon mt-20 mb-20"><i class="fa fa-check-square-o"></i> <?php echo $saveGlobSetBtn; ?></button>
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