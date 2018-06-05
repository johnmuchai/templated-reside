<?php
// Add New Property
if (isset($_POST['submit']) && $_POST['submit'] == 'addProp') {
	// User Validations
	if($_POST['propertyName'] == '') {
		$msgBox = alertBox($propNameReq, "<i class='fa fa-times-circle'></i>", "danger");
	} else if($_POST['propertyAddress'] == '') {
		$msgBox = alertBox($propAddReq, "<i class='fa fa-times-circle'></i>", "danger");
	} else if($_POST['propertyRate'] == '') {
		$msgBox = alertBox($propRateReq, "<i class='fa fa-times-circle'></i>", "danger");
	} else if($_POST['propertyType'] == '') {
		$msgBox = alertBox($propTypeReq, "<i class='fa fa-times-circle'></i>", "danger");
	} else if($_POST['propertyStyle'] == '') {
		$msgBox = alertBox($propStyleReq, "<i class='fa fa-times-circle'></i>", "danger");
	} else {
		// Set some variables
		$propertyName = htmlspecialchars(strip($_POST['propertyName']));
		$propertyName = stripChar($propertyName);
		$propertyAddress = htmlspecialchars($_POST['propertyAddress']);
		$propertyDesc = htmlspecialchars($_POST['propertyDesc']);
		$propertyRate = htmlspecialchars($_POST['propertyRate']);
		$propertyDeposit = htmlspecialchars($_POST['propertyDeposit']);
		$latePenalty = htmlspecialchars($_POST['latePenalty']);
		$propertyType = htmlspecialchars($_POST['propertyType']);
		$propertyStyle = htmlspecialchars($_POST['propertyStyle']);
		$petsAllowed = htmlspecialchars($_POST['petsAllowed']);
		$yearBuilt = "";//htmlspecialchars($_POST['yearBuilt']);
		$propertySize = "";//htmlspecialchars($_POST['propertySize']);
		$bedrooms = htmlspecialchars($_POST['bedrooms']);
		$bathrooms = htmlspecialchars($_POST['bathrooms']);
		$parking = htmlspecialchars($_POST['parking']);
		$heating = "";//htmlspecialchars($_POST['heating']);
		$googleMap = htmlspecialchars($_POST['googleMap']);
		$propManager = htmlspecialchars($_POST['propManager']);
		$unitName = htmlspecialchars($_POST['unitName']);
		$courtName = "";//htmlspecialchars($_POST['courtName']);

		if(isset($_POST['noofunits'])){
			$noofunits = htmlspecialchars($_POST['noofunits']);
			$unitprefix = htmlspecialchars($_POST['unitprefix']);
		}

		/*if($propertyStyle=="Apartment"){

			for($x=1;$x<=(int)$noofunits;$x++){

				$unitName = $unitprefix.$x;

				$stmt = $mysqli->prepare("
				INSERT INTO
				properties(
					adminId,
					propertyName,
					propertyDesc,
					propertyAddress,
					propertyRate,
					latePenalty,
					propertyDeposit,
					petsAllowed,
					propertyType,
					propertyStyle,
					yearBuilt,
					propertySize,
					parking,
					heating,
					bedrooms,
					bathrooms,
					googleMap,
					lastUpdated,
					unitName,
					courtName,
					landlordId
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
						?,
						?
						)");
						$stmt->bind_param('ssssssssssssssssssss',
						$rs_adminId,
						$propertyName,
						$propertyDesc,
						$propertyAddress,
						$propertyRate,
						$latePenalty,
						$propertyDeposit,
						$petsAllowed,
						$propertyType,
						$propertyStyle,
						$yearBuilt,
						$propertySize,
						$parking,
						$heating,
						$bedrooms,
						$bathrooms,
						$googleMap,
						$unitName,
						$courtName,
						$propManager
					);
					$stmt->execute();

					echo $stmt->error;
					$stmt->close();


				$data =
				array(
					"createdBy" => "swiftcloudace",
					"invoiceNumber" => $unitName,
					"customerRef" => $unitName,
					"name" => $propertyName,
					"recurring" => "Y",
					"remarks" => $propertyName."payments",
					"status" => "ACTIVE",
					"serviceCode" => "01",
					"type" => "1",
					"merchantId" => "1002",
					"amount" => $propertyRate
				);
				$data_string = json_encode($data);

				$ch = curl_init('http://localhost:8094/invoice/create/v1');
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string))
				);

				$result = curl_exec($ch);
			}


			$msgBox = alertBox($newPropMsg, "<i class='fa fa-check-square'></i>", "success");

		}else{*/
			$stmt = $mysqli->prepare("
			INSERT INTO
			properties(
				adminId,
				propertyName,
				propertyDesc,
				propertyAddress,
				propertyRate,
				latePenalty,
				propertyDeposit,
				petsAllowed,
				propertyType,
				propertyStyle,
				yearBuilt,
				propertySize,
				parking,
				heating,
				bedrooms,
				bathrooms,
				googleMap,
				lastUpdated,
				unitName,
				courtName,
				landlordId
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
					?,
					?
					)");
					$stmt->bind_param('ssssssssssssssssssss',
					$rs_managerId,
					$propertyName,
					$propertyDesc,
					$propertyAddress,
					$propertyRate,
					$latePenalty,
					$propertyDeposit,
					$petsAllowed,
					$propertyType,
					$propertyStyle,
					$yearBuilt,
					$propertySize,
					$parking,
					$heating,
					$bedrooms,
					$bathrooms,
					$googleMap,
					$unitName,
					$courtName,
					$rs_managerId
				);
				$stmt->execute();

				echo $stmt->error;
				$stmt->close();

				// Add Recent Activity
				$activityType = '2';
				$rs_uid = '0';
				$activityTitle = $rs_managerId.' '.$newPropAct.' "'.$propertyName.'"';
				updateActivity($rs_managerId,$rs_uid,$activityType,$activityTitle);

				// Clear the form of Values
				$_POST['userFirstName'] = $_POST['userLastName'] = $_POST['userEmail'] = $_POST['userEmail_r'] = $_POST['primaryPhone'] = $_POST['altPhone'] = '';

				///generate invoice in the payment gateway


				$data =
				array(
					"createdBy" => "swiftcloudace",
					"invoiceNumber" => $unitName,
					"customerRef" => $unitName,
					"name" => $propertyName,
					"recurring" => "Y",
					"remarks" => $propertyName."payments",
					"status" => "ACTIVE",
					"serviceCode" => "01",
					"type" => "1",
					"merchantId" => "1002",
					"amount" => $propertyRate
				);
				$data_string = json_encode($data);

				$ch = curl_init('http://localhost:8094/invoice/create/v1');
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string))
				);

				$result = curl_exec($ch);


				$msgBox = alertBox($newPropMsg, "<i class='fa fa-check-square'></i>", "success");



		}
	}

	$propPage = 'true';
	$pageTitle = $newPropertyPageTitle;
	$addCss = '<link href="../css/chosen.css" rel="stylesheet">';
	$chosen = 'true';

	include 'includes/header.php';
	?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
	if($rs_managerId!=""){ //	if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
			if ($msgBox) { echo $msgBox; }
			?>
			<h3><?php echo $pageTitle; ?></h3>

			<form action="" method="post" class="mb-20">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="propertyName"><?php echo $propNameField; ?></label>
							<input type="text" class="form-control" name="propertyName" id="propertyName" required="required" value="<?php echo isset($_POST['propertyName']) ? $_POST['paymentDate'] : ''; ?>" />
						</div>
					</div>
					<div class="col-md-6">

					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="unitName"><?php echo $propUnitNameField; ?></label>
							<input type="text" class="form-control" name="unitName" id="unitName" required="required" value="<?php echo isset($_POST['unitName']) ? $_POST['paymentDate'] : ''; ?>" />
						</div>
					</div>
					<div class="col-md-6">
						<!-- <div class="form-group">
							<label for="courtName"><?php echo $propCourtNameField; ?></label>
							<input type="text" class="form-control" name="courtName" id="courtName" required="required" value="<?php echo isset($_POST['courtName']) ? $_POST['paymentDate'] : ''; ?>" />
						</div> -->
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="propertyAddress"><?php echo $propAddressField; ?></label>
							<textarea class="form-control" name="propertyAddress" id="propertyAddress" required="required" rows="3"><?php echo isset($_POST['propertyAddress']) ? $_POST['paymentDate'] : ''; ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="propertyDesc"><?php echo $propDescField; ?></label>
							<textarea class="form-control" name="propertyDesc" id="propertyDesc" rows="3"><?php echo isset($_POST['paymentDate']) ? $_POST['paymentDate'] : ''; ?></textarea>
						</div>
					</div>
				</div>


				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="propertyRate"><?php echo $propRateField; ?></label>
							<input type="text" class="form-control" name="propertyRate" id="propertyRate" onkeypress="return isNumberKey(event)" required="required" value="<?php echo isset($_POST['paymentDate']) ? $_POST['paymentDate'] : ''; ?>" />
							<span class="help-block"><?php echo $numbersOnlyHelp; ?></span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="propertyDeposit"><?php echo $propDepAmtField; ?></label>
							<input type="text" class="form-control" name="propertyDeposit" id="propertyDeposit" onkeypress="return isNumberKey(event)" value="<?php echo isset($_POST['paymentDate']) ? $_POST['paymentDate'] : ''; ?>" />
							<span class="help-block"><?php echo $numbersOnlyHelp; ?></span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="latePenalty"><?php echo $propLateFeeField; ?></label>
							<input type="text" class="form-control" name="latePenalty" id="latePenalty" onkeypress="return isNumberKey(event)" value="<?php echo isset($_POST['latePenalty']) ? $_POST['latePenalty'] : ''; ?>" />
							<span class="help-block"><?php echo $numbersOnlyHelp; ?></span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="propertyType"><?php echo $propTypeField; ?></label>
							<input type="text" class="form-control" name="propertyType" id="propertyType" required="required" value="<?php echo isset($_POST['propertyType']) ? $_POST['propertyType'] : ''; ?>" />
							<span class="help-block"><?php echo $propTypeFieldHelp; ?></span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="propertyStyle"><?php echo $propStyleField; ?></label>
							<select class="form-control chosen-select" name="propertyStyle" id="propertyStyle">
								<option value="Apartment">Apartment</option>
								<option value="Bungalow">Bungalow</option>
								<option value="Mansion">Mansion</option>
								<option value="Town House">Town House</option>
							</select>

						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="petsAllowed"><?php echo $petsAllowedHead; ?></label>
							<select class="form-control chosen-select" name="petsAllowed" id="petsAllowed">
								<option value="0"><?php echo $noBtn; ?></option>
								<option value="1"><?php echo $yesBtn; ?></option>
							</select>
						</div>
					</div>
				</div>

				<!--<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="propertyStyle"><?php echo $propStyleField; ?></label>
							<select class="form-control chosen-select" name="propertyStyle" id="propertyStyle">
								<option value="Apartment">Apartment</option>
								<option value="Bungalow">Bungalow</option>
								<option value="Mansion">Mansion</option>
								<option value="Town House">Town House</option>
							</select>

						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="noofunits">Number of Units</label>
							<input class="form-control" name="noofunits" id="noofunits" value="<?php echo isset($_POST['noofunits']) ? $_POST['noofunits'] : ''; ?>" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="unitprefix">Unit Prefix</label>
							<input class="form-control" name="unitprefix" id="unitprefix" value="<?php echo isset($_POST['unitprefix']) ? $_POST['unitprefix'] : ''; ?>" />
						</div>
					</div>
				</div>-->
				<div class="row">
					<!-- <div class="col-md-3">
						<div class="form-group">
							<label for="yearBuilt"><?php echo $yearBuiltText; ?></label>
							<input type="text" class="form-control" name="yearBuilt" id="yearBuilt" value="<?php echo isset($_POST['paymentDate']) ? $_POST['paymentDate'] : ''; ?>" />
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="propertySize"><?php echo $propSizeField; ?></label>
							<input type="text" class="form-control" name="propertySize" id="propertySize" value="<?php echo isset($_POST['paymentDate']) ? $_POST['paymentDate'] : ''; ?>" />
						</div>
					</div> -->
					<div class="col-md-6">
						<div class="form-group">
							<label for="bedrooms"><?php echo $propBedsField; ?></label>
							<input type="text" class="form-control" name="bedrooms" id="bedrooms" value="<?php echo isset($_POST['paymentDate']) ? $_POST['paymentDate'] : ''; ?>" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="bathrooms"><?php echo $propBathsField; ?></label>
							<input type="text" class="form-control" name="bathrooms" id="bathrooms" value="<?php echo isset($_POST['paymentDate']) ? $_POST['paymentDate'] : ''; ?>" />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="parking"><?php echo $propParkField; ?></label>
							<input type="text" class="form-control" name="parking" id="parking" value="<?php echo isset($_POST['paymentDate']) ? $_POST['paymentDate'] : ''; ?>" />
						</div>
					</div>
					<div class="col-md-6">
						<!-- <div class="form-group">
							<label for="heating"><?php echo $propHeatingField; ?></label>
							<input type="text" class="form-control" name="heating" id="heating" value="<?php echo isset($_POST['paymentDate']) ? $_POST['paymentDate'] : ''; ?>" />
						</div> -->
					</div>
				</div>

				<div class="form-group">
					<label for="googleMap"><?php echo $propGoogleMapField; ?></label>
					<textarea class="form-control" name="googleMap" id="googleMap" rows="3"><?php echo isset($_POST['googleMap']) ? $_POST['googleMap'] : ''; ?></textarea>
					<span class="help-block"><?php echo $propGoogleMapFieldHelp; ?></span>
				</div>

				<button type="input" name="submit" value="addProp" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveNewPropBtn; ?></button>
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
