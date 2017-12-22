<?php
	// Payment System
	if (isset($_POST['submit']) && $_POST['submit'] == 'paySettings') {
		$enablePayments = htmlspecialchars($_POST['enablePayments']);
		
		$stmt = $mysqli->prepare("UPDATE sitesettings SET enablePayments = ?");
		$stmt->bind_param('s', $enablePayments);
		$stmt->execute();
		$stmt->close();

		if ($enablePayments == '1') {
			// Add Recent Activity
			$activityType = '8';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$paysettingsAct;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($paysettingsMsg, "<i class='fa fa-check-square'></i>", "success");
		} else {
			// Add Recent Activity
			$activityType = '8';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$paysettingsAct1;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($paysettingsMsg1, "<i class='fa fa-check-square'></i>", "success");

		}
	}
	
	if (isset($_POST['submit']) && $_POST['submit'] == 'paypalSettings') {
		$enablePaypal = htmlspecialchars($_POST['enablePaypal']);

		if ($enablePaypal == '1') {
			if($_POST['paymentEmail'] == "") {
				$msgBox = alertBox($paypalEmailReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else if($_POST['paymentItemName'] == "") {
				$msgBox = alertBox($paypalItemNameReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else if($_POST['paymentFee'] == "") {
				$msgBox = alertBox($paypalUseFeeReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else if($_POST['paymentCompleteMsg'] == "") {
				$msgBox = alertBox($paymentComplMsgReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else {
				$currencyCode = htmlspecialchars($_POST['currencyCode']);
				$paymentEmail = htmlspecialchars($_POST['paymentEmail']);
				$paymentItemName = htmlspecialchars($_POST['paymentItemName']);
				$paymentFee = htmlspecialchars($_POST['paymentFee']);
				$paymentCompleteMsg = htmlspecialchars($_POST['paymentCompleteMsg']);

				$stmt = $mysqli->prepare("UPDATE
											sitesettings
										SET
											enablePaypal = ?,
											currencyCode = ?,
											paymentEmail = ?,
											paymentItemName = ?,
											paymentFee = ?,
											paymentCompleteMsg = ?
				");
				$stmt->bind_param('ssssss',
									$enablePaypal,
									$currencyCode,
									$paymentEmail,
									$paymentItemName,
									$paymentFee,
									$paymentCompleteMsg
				);
				$stmt->execute();
				$stmt->close();

				// Add Recent Activity
				$activityType = '8';
				$rs_uid = '0';
				$activityTitle = $rs_adminName.' '.$paymentUpdAct;
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

				$msgBox = alertBox($paymentUpdMsg, "<i class='fa fa-check-square'></i>", "success");
			}
		} else {
			$stmt = $mysqli->prepare("UPDATE sitesettings SET enablePaypal = ?");
			$stmt->bind_param('s',$enablePaypal);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '8';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$paymentUpdAct1;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($paynentUpdMsg1, "<i class='fa fa-check-square'></i>", "success");
		}
	}

	// Get Data
    $qry = "SELECT * FROM sitesettings";
    $res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);

	if ($row['enablePayments'] == '1') { $enablePayments = 'selected'; } else { $enablePayments = ''; }
	if ($row['enablePaypal'] == '1') { $enablePaypal = 'selected'; } else { $enablePaypal = ''; }

	$managePage = 'true';
	$pageTitle = $paymentSettingsPageTitle;
	$addCss = '<link href="../css/chosen.css" rel="stylesheet">';
	$chosen = 'true';
	$jsFile = 'paymentSettings';

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
						<label for="enablePayments"><?php echo $enablePaySystemField; ?></label>
						<select class="form-control chosen-select" id="enablePayments" name="enablePayments">
							<option value="0"><?php echo $noBtn; ?></option>
							<option value="1" <?php echo $enablePayments; ?>><?php echo $yesBtn; ?></option>
						</select>
					</div>
					<button type="input" name="submit" value="paySettings" class="btn btn-success btn-icon mt-20 mb-20"><i class="fa fa-check-square-o"></i> <?php echo $enablePaySystemBtn; ?></button>
					<p id="notes"></p>
				</form>
			</div>
			<div class="col-md-8">
				<p class="mt-10"><?php echo $enablePaySystemQuip; ?></p>
			</div>
		</div>

		<div id="paymentSystem">
			<hr class="mt-0" />
			<form action="" method="post">
				<div class="row mt-10">
					<div class="col-md-4">
						<div class="form-group">
							<label for="enablePaypal"><?php echo $enablePaypalField; ?></label>
							<select class="form-control chosen-select" id="enablePaypal" name="enablePaypal">
								<option value="0"><?php echo $noBtn; ?></option>
								<option value="1" <?php echo $enablePaypal; ?>><?php echo $yesBtn; ?></option>
							</select>
						</div>
					</div>
					<div class="col-md-8">
						<p class="mt-10"><?php echo $enablePaypalQuip; ?></p>
					</div>
				</div>

				<div id="paypalSystem">
					<hr />
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="currencyCode"><?php echo $paypalCurrCodeField; ?></label>
								<select class="form-control chosen-select" id="currencyCode" name="currencyCode">
									<option value="USD">USD</option>
									<option value="AUD">AUD</option>
									<option value="CAD">CAD</option>
									<option value="CZK">CZK</option>
									<option value="DKK">DKK</option>
									<option value="EUR">EUR</option>
									<option value="HKD">HKD</option>
									<option value="ILS">ILS</option>
									<option value="MXN">MXN</option>
									<option value="NOK">NOK</option>
									<option value="NZD">NZD</option>
									<option value="PHP">PHP</option>
									<option value="PLN">PLN</option>
									<option value="GBP">GBP</option>
									<option value="SGD">SGD</option>
									<option value="SEK">SEK</option>
									<option value="CHF">CHF</option>
									<option value="THB">THB</option>
								</select>
								<span class="help-block"><?php echo $paypalCurrCodeFieldHelp; ?></span>
								<input type="hidden" id="currCodeVal" value="<?php echo $row['currencyCode']; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="paymentEmail"><?php echo $paypalEmailField; ?></label>
								<input type="text" class="form-control" name="paymentEmail" id="paymentEmail" value="<?php echo $row['paymentEmail']; ?>" />
								<span class="help-block"><?php echo $paypalEmailFieldHelp; ?></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="paymentItemName"><?php echo $paypalItemNameField; ?></label>
								<input type="text" class="form-control" name="paymentItemName" id="paymentItemName" value="<?php echo $row['paymentItemName']; ?>" />
								<span class="help-block"><?php echo $paypalItemNameFieldHelp; ?></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="paymentFee"><?php echo $paypalUseFeeField; ?></label>
								<input type="text" class="form-control" name="paymentFee" id="paymentFee" value="<?php echo $row['paymentFee']; ?>" />
								<span class="help-block"><?php echo $paypalUseFeeFieldHelp; ?></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="paymentCompleteMsg"><?php echo $paymntComplMsgField; ?></label>
						<input type="text" class="form-control" name="paymentCompleteMsg" id="paymentCompleteMsg" value="<?php echo $row['paymentCompleteMsg']; ?>" />
						<span class="help-block"><?php echo $paymntComplMsgFieldHelp; ?></span>
					</div>
				</div>
				<button type="input" name="submit" value="paypalSettings" class="btn btn-success btn-icon mt-20 mb-20"><i class="fa fa-check-square-o"></i> <?php echo $savePaypalSetBtn; ?></button>
			</form>
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