<?php
	// Save New Request
	if (isset($_POST['submit']) && $_POST['submit'] == 'newRequest') {
        // User Validations
		if($_POST['propertyId'] == '...') {
			$msgBox = alertBox($reqPropReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['requestTitle'] == '') {
			$msgBox = alertBox($reqTitleReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['requestPriority'] == '...') {
			$msgBox = alertBox($reqPriorityReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['requestText'] == '') {
			$msgBox = alertBox($reqDescReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			// Set some variables
			$propertyId = htmlspecialchars($_POST['propertyId']);
			$theId = htmlspecialchars($_POST['theId']);
			$propName = htmlspecialchars($_POST['propName']);
			$leaseId = htmlspecialchars($_POST['leaseId']);
			$requestTitle = htmlspecialchars($_POST['requestTitle']);
			$requestPriority = htmlspecialchars($_POST['requestPriority']);
			$requestText = htmlspecialchars($_POST['requestText']);
			$ipAddress = $_SERVER['REMOTE_ADDR'];

			$stmt = $mysqli->prepare("
								INSERT INTO
									servicerequests(
										leaseId,
										propertyId,
										adminId,
										userId,
										adminCreated,
										requestTitle,
										requestText,
										requestDate,
										requestPriority,
										ipAddress
									) VALUES (
										?,
										?,
										?,
										?,
										1,
										?,
										?,
										NOW(),
										?,
										?
									)");
			$stmt->bind_param('ssssssss',
				$leaseId,
				$propertyId,
				$rs_adminId,
				$theId,
				$requestTitle,
				$requestText,
				$requestPriority,
				$ipAddress
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '3';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$newServReqAct.' "'.$propName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			// Clear the form of Values
			$_POST['requestTitle'] = $_POST['requestText'] = '';

			$msgBox = alertBox($newServReqMsg." ".$propName." ".$newDiscCmtMsg2, "<i class='fa fa-check-square'></i>", "success");
		}
	}

	// Get Property List
	$qry = "SELECT propertyId, propertyName FROM properties WHERE active = 1";
	$res = mysqli_query($mysqli, $qry) or die('-1'.mysqli_error());

	$servPage = 'true';
	$pageTitle = $newRequestPageTitle;
	$addCss = '<link href="../css/chosen.css" rel="stylesheet">';
	$chosen = 'true';
	$jsFile = 'newRequest';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('SRVREQ', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle; ?></h3>

				<form action="" method="post" class="mb-20">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="propertyId"><?php echo $selectPropField; ?></label>
								<select class="form-control chosen-select" id="propertyId" name="propertyId">
									<option value="..."><?php echo $selectOption; ?></option>
									<?php
										while ($row = mysqli_fetch_assoc($res)) {
											echo '<option value="'.$row['propertyId'].'">'.$row['propertyName'].'</option>';
										}
									?>
								</select>
								<span class="help-block"><?php echo $selectPropFieldHelp; ?></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="usersName"><?php echo $tenResField; ?></label>
								<input type="text" class="form-control" name="usersName" id="usersName" readonly value="" />
								<span class="help-block"><?php echo $tenResFieldHelp; ?></span>
							</div>

							<input type="hidden" name="theId" id="theId" value="" />
							<input type="hidden" name="propName" id="propName" value="" />
							<input type="hidden" name="leaseId" id="leaseId" value="" />
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="requestTitle"><?php echo $requestTitleField; ?></label>
								<input type="text" class="form-control" name="requestTitle" id="requestTitle" required="required" value="<?php echo isset($_POST['requestTitle']) ? $_POST['requestTitle'] : ''; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="requestPriority"><?php echo $priorityField; ?></label>
								<select class="form-control chosen-select" name="requestPriority">
									<option value="..."><?php echo $selectOption; ?></option>
									<?php
										$pri = "SELECT * FROM servicepriority";
										$prires = mysqli_query($mysqli, $pri) or die('-2'.mysqli_error());
										while ($prirow = mysqli_fetch_assoc($prires)) {
											echo '<option value="'.$prirow['priorityId'].'">'.$prirow['priorityTitle'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="requestText"><?php echo $requestDescField; ?></label>
						<textarea class="form-control" name="requestText" id="requestText" required="required" rows="8"><?php echo isset($_POST['requestText']) ? $_POST['requestText'] : ''; ?></textarea>
						<span class="help-block"><?php echo $requestDescFieldHelp; ?></span>
					</div>

					<button type="input" name="submit" value="newRequest" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
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