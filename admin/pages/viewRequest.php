<?php
	$requestId = $mysqli->real_escape_string($_GET['requestId']);
	$ipAddress = $_SERVER['REMOTE_ADDR'];

	$rqst = 'active';
	$notes = $resolution = $expense = '';
	$count = 0;

	// Update Service Request
	if (isset($_POST['submit']) && $_POST['submit'] == 'editRequest') {
		// Validation
		if($_POST['requestTitle'] == "") {
            $msgBox = alertBox($reqTitleReqMsg, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['requestText'] == "") {
            $msgBox = alertBox($reqTextReqMsg, "<i class='fa fa-times-circle'></i>", "danger");
        } else {
			$requestTitle = htmlspecialchars($_POST['requestTitle']);
			$requestPriority = htmlspecialchars($_POST['requestPriority']);
			$requestStatus = htmlspecialchars($_POST['requestStatus']);
			$requestText = htmlspecialchars($_POST['requestText']);

			$stmt = $mysqli->prepare("UPDATE
										servicerequests
									SET
										requestTitle = ?,
										requestText = ?,
										requestPriority = ?,
										requestStatus = ?,
										lastUpdated = NOW()
									WHERE
										requestId = ?"
			);
			$stmt->bind_param('sssss',
									$requestTitle,
									$requestText,
									$requestPriority,
									$requestStatus,
									$requestId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '3';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$updReqAct.' "'.$requestTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($servReqUpdatedMsg1." \"".$requestTitle."\" ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");
		}
    }

	// Assign Service Request
	if (isset($_POST['submit']) && $_POST['submit'] == 'assignRequest') {
		// Validation
		if($_POST['adminId'] == "...") {
            $msgBox = alertBox($assignReqAdminReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else {
			$adminId = htmlspecialchars($_POST['adminId']);
			$admName = htmlspecialchars($_POST['admName']);
			$requestTitle = htmlspecialchars($_POST['requestTitle']);

			$stmt = $mysqli->prepare("UPDATE
										servicerequests
									SET
										assignedTo = ?,
										lastUpdated = NOW()
									WHERE
										requestId = ?"
			);
			$stmt->bind_param('ss',
									$adminId,
									$requestId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '3';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$assignReqAct.' "'.$requestTitle.'" to '.$admName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($servReqUpdatedMsg1." \"".$requestTitle."\" ".$assignReqMsg." ".$admName.".", "<i class='fa fa-check-square'></i>", "success");
		}
    }

	// Update Discussion Comment
	if (isset($_POST['submit']) && $_POST['submit'] == 'editComment') {
		// Validation
		if($_POST['noteText'] == "") {
            $msgBox = alertBox($discCmtReqMsg, "<i class='fa fa-times-circle'></i>", "danger");
        } else {
			$noteText = htmlspecialchars($_POST['noteText']);
			$noteId = htmlspecialchars($_POST['noteId']);
			$requestTitle = htmlspecialchars($_POST['requestTitle']);

			$stmt = $mysqli->prepare("UPDATE
										servicenotes
									SET
										noteText = ?,
										lastUpdated = NOW()
									WHERE
										noteId = ?"
			);
			$stmt->bind_param('ss',
									$noteText,
									$noteId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '3';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$editCommentAct.' "'.$requestTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($editCommentMsg." \"".$requestTitle."\" ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");

			// Clear the form of Values
			$_POST['noteText'] = '';
		}
    }

	// Delete Discussion Comment
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteComment') {
		$deleteId = htmlspecialchars($_POST['deleteId']);
		$requestTitle = htmlspecialchars($_POST['requestTitle']);

		$stmt = $mysqli->prepare("DELETE FROM servicenotes WHERE noteId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '3';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$delCommentAct.' "'.$requestTitle.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($delCommentMsg." \"".$requestTitle."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");
	}

	// Close Service Request
	if (isset($_POST['submit']) && $_POST['submit'] == 'closeRequest') {
		// Validation
		if($_POST['resolutionText'] == "") {
            $msgBox = alertBox($resTextReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['resolutionDate'] == "") {
            $msgBox = alertBox($reqDateCompReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else {
			$resolutionText = htmlspecialchars($_POST['resolutionText']);
			$resolutionDate = htmlspecialchars($_POST['resolutionDate']);
			$needsFollowUp = htmlspecialchars($_POST['needsFollowUp']);
			$followUpText = htmlspecialchars($_POST['followUpText']);
			$requestTitle = htmlspecialchars($_POST['requestTitle']);

			$stmt = $mysqli->prepare("UPDATE
										servicerequests
									SET
										isClosed = 1,
										resolutionText = ?,
										resolutionDate = ?,
										needsFollowUp = ?,
										followUpText = ?,
										dateCompleted = NOW(),
										lastUpdated = NOW()
									WHERE
										requestId = ?"
			);
			$stmt->bind_param('sssss',
									$resolutionText,
									$resolutionDate,
									$needsFollowUp,
									$followUpText,
									$requestId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '3';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$closeReqAct.' "'.$requestTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($servReqUpdatedMsg1." \"".$requestTitle."\" ".$closeReqMsg, "<i class='fa fa-check-square'></i>", "success");

			$resolution = 'active';
			$notes = $rqst = $expense = '';
		}
    }

	// Reopen Service Request
	if (isset($_POST['submit']) && $_POST['submit'] == 'reopenRequest') {
		$requestTitle = htmlspecialchars($_POST['requestTitle']);
		$resolutionDate = $dateCompleted = '0000-00-00 00:00:00';
		$followUpText = null;

		$stmt = $mysqli->prepare("UPDATE
									servicerequests
								SET
									isClosed = 0,
									resolutionDate = ?,
									needsFollowUp = 0,
									followUpText = ?,
									dateCompleted = ?,
									lastUpdated = NOW()
								WHERE
									requestId = ?"
		);
		$stmt->bind_param('ssss',
								$resolutionDate,
								$followUpText,
								$dateCompleted,
								$requestId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '3';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$reopnReqAct.' "'.$requestTitle.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($servReqUpdatedMsg1." \"".$requestTitle."\" ".$reopnReqMsg, "<i class='fa fa-check-square'></i>", "success");
    }

	// Add/Update Notes
	if (isset($_POST['submit']) && $_POST['submit'] == 'reqNotes') {
		$notes = htmlspecialchars($_POST['notes']);
		$requestTitle = htmlspecialchars($_POST['requestTitle']);

		$stmt = $mysqli->prepare("UPDATE
									servicerequests
								SET
									notes = ?,
									lastUpdated = NOW()
								WHERE
									requestId = ?"
		);
		$stmt->bind_param('ss',
								$notes,
								$requestId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '3';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$newReqNotesAct.' "'.$requestTitle.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($newReqNotesMsg." \"".$requestTitle."\" ".$admAuthsUpdMsg2, "<i class='fa fa-check-square'></i>", "success");

		$notes = 'active';
		$resolution = $rqst = $expense = '';
    }

	// Update Service Request Resolution
	if (isset($_POST['submit']) && $_POST['submit'] == 'editResolution') {
		// Validation
		if($_POST['resolutionText'] == "") {
            $msgBox = alertBox($resTextReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['resolutionDate'] == "") {
            $msgBox = alertBox($reqDateCompReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else {
			$resolutionText = htmlspecialchars($_POST['resolutionText']);
			$resolutionDate = htmlspecialchars($_POST['resolutionDate']);
			$needsFollowUp = htmlspecialchars($_POST['needsFollowUp']);
			$followUpText = htmlspecialchars($_POST['followUpText']);
			$requestTitle = htmlspecialchars($_POST['requestTitle']);

			$stmt = $mysqli->prepare("UPDATE
										servicerequests
									SET
										resolutionText = ?,
										resolutionDate = ?,
										needsFollowUp = ?,
										followUpText = ?,
										lastUpdated = NOW()
									WHERE
										requestId = ?"
			);
			$stmt->bind_param('sssss',
									$resolutionText,
									$resolutionDate,
									$needsFollowUp,
									$followUpText,
									$requestId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '3';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$updReqResAct.' "'.$requestTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($updReqResMsg." \"".$requestTitle."\" ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");

			$resolution = 'active';
			$notes = $rqst = $expense = '';
		}
    }

	// Save Expense
	if (isset($_POST['submit']) && $_POST['submit'] == 'newExpense') {
        // User Validations
		if($_POST['vendorName'] == '') {
			$msgBox = alertBox($vendorNameReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['expenseName'] == '') {
			$msgBox = alertBox($expenseNameReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['expenseCost'] == '') {
			$msgBox = alertBox($expenseCostReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['dateOfExpense'] == '') {
			$msgBox = alertBox($expenseDateReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['expenseDesc'] == '') {
			$msgBox = alertBox($expenseDescReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			// Set some variables
			$vendorName = htmlspecialchars($_POST['vendorName']);
			$expenseName = htmlspecialchars($_POST['expenseName']);
			$expenseCost = htmlspecialchars($_POST['expenseCost']);
			$dateOfExpense = htmlspecialchars($_POST['dateOfExpense']);
			$expenseDesc = htmlspecialchars($_POST['expenseDesc']);
			$notes = htmlspecialchars($_POST['notes']);
			$requestTitle = htmlspecialchars($_POST['requestTitle']);
			$leaseId = htmlspecialchars($_POST['leaseId']);
			$propertyId = htmlspecialchars($_POST['propertyId']);

			$stmt = $mysqli->prepare("
								INSERT INTO
									serviceexpense(
										requestId,
										leaseId,
										propertyId,
										adminId,
										vendorName,
										expenseName,
										expenseDesc,
										expenseCost,
										dateOfExpense,
										notes,
										lastUpdated,
										ipAddress
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
										NOW(),
										?
									)");
			$stmt->bind_param('sssssssssss',
				$requestId,
				$leaseId,
				$propertyId,
				$rs_adminId,
				$vendorName,
				$expenseName,
				$expenseDesc,
				$expenseCost,
				$dateOfExpense,
				$notes,
				$ipAddress
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '3';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$newExpenseAct.' "'.$requestTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			// Clear the form of Values
			$_POST['vendorName'] = $_POST['expenseName'] = $_POST['expenseCost'] = $_POST['dateOfExpense'] = $_POST['expenseDesc'] = $_POST['notes'] = '';

			$msgBox = alertBox($newExpenseMsg." ".$requestTitle." ".$newDiscCmtMsg2, "<i class='fa fa-check-square'></i>", "success");

			$expense = 'active';
			$notes = $rqst = $resolution = '';
		}
	}

	// Update Expense
	if (isset($_POST['submit']) && $_POST['submit'] == 'editExpense') {
		// User Validations
		if($_POST['vendorName'] == '') {
			$msgBox = alertBox($vendorNameReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['expenseName'] == '') {
			$msgBox = alertBox($expenseNameReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['expenseCost'] == '') {
			$msgBox = alertBox($expenseCostReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['dateOfExpense'] == '') {
			$msgBox = alertBox($expenseDateReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['expenseDesc'] == '') {
			$msgBox = alertBox($expenseDescReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$vendorName = htmlspecialchars($_POST['vendorName']);
			$expenseName = htmlspecialchars($_POST['expenseName']);
			$expenseCost = htmlspecialchars($_POST['expenseCost']);
			$dateOfExpense = htmlspecialchars($_POST['dateOfExpense']);
			$expenseDesc = htmlspecialchars($_POST['expenseDesc']);
			$notes = htmlspecialchars($_POST['notes']);
			$expenseId = htmlspecialchars($_POST['expenseId']);

			$stmt = $mysqli->prepare("UPDATE
										serviceexpense
									SET
										vendorName = ?,
										expenseName = ?,
										expenseDesc = ?,
										expenseCost = ?,
										dateOfExpense = ?,
										notes = ?,
										lastUpdated = NOW()
									WHERE
										expenseId = ?"
			);
			$stmt->bind_param('sssssss',
									$vendorName,
									$expenseName,
									$expenseDesc,
									$expenseCost,
									$dateOfExpense,
									$notes,
									$expenseId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '3';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$updExpenseAct.' "'.$expenseName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			// Clear the form of Values
			$_POST['vendorName'] = $_POST['expenseName'] = $_POST['expenseCost'] = $_POST['dateOfExpense'] = $_POST['expenseDesc'] = $_POST['notes'] = '';

			$msgBox = alertBox($updExpenseMsg." \"".$expenseName."\" ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");

			$expense = 'active';
			$notes = $rqst = $resolution = '';
		}
    }

	// Delete Expense
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteExpense') {
		$deleteId = htmlspecialchars($_POST['deleteId']);
		$requestTitle = htmlspecialchars($_POST['requestTitle']);

		$stmt = $mysqli->prepare("DELETE FROM serviceexpense WHERE expenseId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '3';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$delExpenseAct.' "'.$requestTitle.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($delExpenseMsg." \"".$requestTitle."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");

		$expense = 'active';
		$notes = $rqst = $resolution = '';
	}

	// Save Comment
	if (isset($_POST['submit']) && $_POST['submit'] == 'addComment') {
        // User Validations
		if($_POST['noteText'] == '') {
			$msgBox = alertBox($discCmtReqMsg, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			// Set some variables
			$noteText = htmlspecialchars($_POST['noteText']);
			$leaseId = htmlspecialchars($_POST['leaseId']);
			$propertyId = htmlspecialchars($_POST['propertyId']);
			$requestTitle = htmlspecialchars($_POST['requestTitle']);
			$userEmail = htmlspecialchars($_POST['userEmail']);

			$stmt = $mysqli->prepare("
								INSERT INTO
									servicenotes(
										requestId,
										leaseId,
										propertyId,
										adminId,
										userId,
										noteText,
										noteDate,
										ipAddress
									) VALUES (
										?,
										?,
										?,
										?,
										0,
										?,
										NOW(),
										?
									)");
			$stmt->bind_param('ssssss',
				$requestId,
				$leaseId,
				$propertyId,
				$rs_adminId,
				$noteText,
				$ipAddress
			);
			$stmt->execute();
			$stmt->close();

			$siteName = $set['siteName'];
			$siteEmail = $set['siteEmail'];

			$subject = $siteName.' '.$newCommentEmailSubject.' '.$requestTitle;

			$message = '<html><body>';
			$message .= '<h3>'.$subject.'</h3>';
			$message .= '<p><strong>'.$newCommentEmail1.'</strong> '.$rs_adminName.'</p>';
			$message .= '<p><strong>'.$newReqEmail2.'</strong> '.$requestTitle.'</p>';
			$message .= '<p><strong>'.$newReqEmail3.'</strong><br>'.nl2br($noteText).'</p>';
			$message .= '<hr>';
			$message .= '<p>'.$emailTankYouTxt.'<br>'.$siteName.'</p>';
			$message .= '</body></html>';

			$headers = "From: ".$siteName." <".$siteEmail.">\r\n";
			$headers .= "Reply-To: ".$siteEmail."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			mailer($userEmail, $subject, $message, $headers);

			// Add Recent Activity
			$activityType = '3';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$newCommentAct.' "'.$requestTitle.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			// Clear the form of Values
			$_POST['noteText'] = '';

			$msgBox = alertBox($newCommentMsg." ".$requestTitle." ".$newDiscCmtMsg2, "<i class='fa fa-check-square'></i>", "success");
		}
	}

	// Get Data
	$qry = "SELECT
				servicerequests.*,
				properties.propertyName,
				servicepriority.priorityTitle,
				servicestatus.statusTitle,
				admins.adminName,
				CONCAT(users.userFirstName,' ',users.userLastName) AS user,
				users.userEmail
			FROM
				servicerequests
				LEFT JOIN properties ON servicerequests.propertyId = properties.propertyId
				LEFT JOIN servicepriority ON servicerequests.requestPriority = servicepriority.priorityId
				LEFT JOIN servicestatus ON servicerequests.requestStatus = servicestatus.statusId
				LEFT JOIN admins ON servicerequests.adminId = admins.adminId
				LEFT JOIN users ON servicerequests.userId = users.userId
			WHERE servicerequests.requestId = ".$requestId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);

	if ($row['needsFollowUp'] == '1') { $needsFollowUp = $yesBtn; } else { $needsFollowUp =  $noBtn; }

	// Get Assigned To
	$stmt = "SELECT
				admins.adminName
			FROM
				servicerequests
				LEFT JOIN admins ON servicerequests.assignedTo = admins.adminId
			WHERE servicerequests.requestId = ".$requestId;
	$result = mysqli_query($mysqli, $stmt) or die('-2' . mysqli_error());
	$stmtrow = mysqli_fetch_assoc($result);

	if (is_null($stmtrow['adminName'])) { $assignedAdmin = '<em>'.$unassignedText.'</em>'; } else { $assignedAdmin = clean($stmtrow['adminName']); }

	// Get Comment Data
	$sql = "SELECT
				servicenotes.*,
				UNIX_TIMESTAMP(servicenotes.noteDate) AS orderDate,
				admins.adminName,
				admins.adminAvatar,
				CONCAT(users.userFirstName,' ',users.userLastName) AS user,
				users.userAvatar
			FROM
				servicenotes
				LEFT JOIN admins ON servicenotes.adminId = admins.adminId
				LEFT JOIN users ON servicenotes.userId = users.userId
			WHERE servicenotes.requestId = ".$requestId."
			ORDER BY orderDate";
	$results = mysqli_query($mysqli, $sql) or die('-3' . mysqli_error());

	// Get Service Expenses
	$exp = "SELECT * FROM serviceexpense WHERE requestId = ".$requestId;
	$expres = mysqli_query($mysqli, $exp) or die('-4' . mysqli_error());

	if(mysqli_num_rows($expres) > 0) {
		// Get the Totals
		$totals = "SELECT
					SUM(expenseCost) AS totalPaid
				FROM
					serviceexpense
				WHERE
					requestId = '".$requestId."'";
		$total = mysqli_query($mysqli, $totals) or die('-7' . mysqli_error());
		$tot = mysqli_fetch_assoc($total);

		// Format the Amounts
		$totalExp = formatCurrency($tot['totalPaid'],$currCode);
	} else {
		$totalExp = '';
	}

	$servPage = 'true';
	$pageTitle = $viewRequestPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet"><link rel="stylesheet" type="text/css" href="../css/datetimepicker.css" /><link href="../css/chosen.css" rel="stylesheet">';
	$dataTables = 'true';
	$datePicker = 'true';
	$chosen = 'true';
	$jsFile = 'viewRequest';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('SRVREQ', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<input type="hidden" id="weekStart" value="<?php echo $set['weekStart']; ?>" />

				<h3><?php echo $pageTitle; ?></h3>

				<div class="row mb-10">
					<div class="col-md-4">
						<ul class="list-group">
							<li class="list-group-item"><strong><?php echo $newReqEmail2; ?></strong> <?php echo clean($row['requestTitle']); ?></li>
							<li class="list-group-item"><strong><?php echo $newPaymentEmail2; ?></strong>
								<a href="index.php?action=viewProperty&propertyId=<?php echo $row['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
									<?php echo clean($row['propertyName']); ?>
								</a>
							</li>
							<li class="list-group-item"><strong><?php echo $reqPriorityText; ?></strong> <?php echo clean($row['priorityTitle']); ?></li>
							<li class="list-group-item"><strong><?php echo $reqStatusText; ?></strong> <?php echo clean($row['statusTitle']); ?></li>
							<li class="list-group-item"><strong><?php echo $reqAssignedToText; ?></strong> <?php echo $assignedAdmin; ?></li>
							<li class="list-group-item"><strong><?php echo $servReqDateText; ?></strong> <?php echo dateFormat($row['requestDate']); ?></li>
							<li class="list-group-item"><strong><?php echo $servReqByText; ?></strong>
								<?php
									if ($row['adminId'] != '0') {
										echo clean($row['adminName']);
									} else {
										echo clean($row['user']);
									}
								?>
							</li>
							<?php if ($row['isClosed'] == '1') { ?>
								<li class="list-group-item"><strong><?php echo $reqComplDateText; ?></strong> <?php echo dateFormat($row['resolutionDate']); ?></li>
							<?php } ?>
						</ul>
						<?php if ($row['isClosed'] == '1') { ?>
							<div class="alertMsg success">
								<div class="msgIcon pull-left">
									<i class="fa fa-check"></i>
								</div>
								<?php echo $reqClosedServReqMsg; ?>
							</div>
						<?php } ?>
					</div>
					<div class="col-md-8">
						<div class="tabs mt-0">
							<ul class="tabsBody">
								<li class="<?php echo $rqst; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $requestHead; ?></h4>
									<section class="tabContent" id="request">
										<h3><?php echo $servReqTabTitle; ?></h3>
										<div class="well well-sm"><p class="lead mb-0"><?php echo nl2br(htmlspecialchars_decode($row['requestText'])); ?></p></div>

										<?php if ($row['isClosed'] == '0') { ?>
											<a href="index.php?action=workOrder&requestId=<?php echo $requestId; ?>" target="_blank" class="btn btn-xs btn-default btn-icon"><i class="fa fa-clipboard"></i> <?php echo $printWorkOrderBtn; ?></a>
										<?php } ?>

										<a data-toggle="modal" href="#editRequest" class="btn btn-xs btn-default btn-icon"><i class="fa fa-pencil"></i> <?php echo $editReqBtn; ?></a>
										<div class="modal fade" id="editRequest" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
														<h4 class="modal-title"><?php echo $editReqH4; ?></h4>
													</div>
													<form action="" method="post">
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group">
																		<label for="requestTitle"><?php echo $requestTitleField; ?></label>
																		<input type="text" class="form-control" name="requestTitle" id="requestTitle" required="required" value="<?php echo clean($row['requestTitle']); ?>" />
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label for="requestPriority"><?php echo $priorityField; ?></label>
																		<select class="form-control chosen-select" name="requestPriority" id="requestPriority">
																			<?php
																				$pri = "SELECT * FROM servicepriority";
																				$prires = mysqli_query($mysqli, $pri) or die('-5'.mysqli_error());
																				while ($prirow = mysqli_fetch_assoc($prires)) {
																					echo '<option value="'.$prirow['priorityId'].'">'.$prirow['priorityTitle'].'</option>';
																				}
																			?>
																		</select>
																		<input type="hidden" id="priTitle" value="<?php echo $row['priorityTitle']; ?>" />
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group">
																		<label for="requestStatus"><?php echo $statusHead; ?></label>
																		<select class="form-control chosen-select" name="requestStatus" id="requestStatus">
																			<?php
																				$sta = "SELECT * FROM servicestatus";
																				$stares = mysqli_query($mysqli, $sta) or die('-6'.mysqli_error());
																				while ($starow = mysqli_fetch_assoc($stares)) {
																					echo '<option value="'.$starow['statusId'].'">'.$starow['statusTitle'].'</option>';
																				}
																			?>
																		</select>
																		<input type="hidden" id="staTitle" value="<?php echo $row['statusTitle']; ?>" />
																	</div>
																</div>
															</div>

															<div class="form-group">
																<label for="requestText"><?php echo $requestDescField; ?></label>
																<textarea class="form-control" name="requestText" id="requestText" required="required" rows="8"><?php echo clean($row['requestText']); ?></textarea>
																<span class="help-block"><?php echo $requestDescFieldHelp; ?></span>
															</div>
														</div>
														<div class="modal-footer">
															<button type="input" name="submit" value="editRequest" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
															<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
														</div>
													</form>
												</div>
											</div>
										</div>

										<a data-toggle="modal" href="#assignRequest" class="btn btn-xs btn-default btn-icon"><i class="fa fa-clipboard"></i> <?php echo $assignReqBtn; ?></a>
										<div class="modal fade" id="assignRequest" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
														<h4 class="modal-title"><?php echo $assignServReqBtn; ?></h4>
													</div>
													<form action="" method="post">
														<div class="modal-body">
															<div class="form-group">
																<label for="adminId"><?php echo $selectAdmMngField; ?></label>
																<select class="form-control chosen-select" name="adminId" id="adminId">
																	<option value="..."><?php echo $selectOption; ?></option>
																	<?php
																		$adm = "SELECT adminId, adminName FROM admins WHERE isActive = 1";
																		$admres = mysqli_query($mysqli, $adm) or die('-7'.mysqli_error());
																		while ($admrow = mysqli_fetch_assoc($admres)) {
																			echo '<option value="'.$admrow['adminId'].'">'.$admrow['adminName'].'</option>';
																		}
																	?>
																</select>
																<input type="hidden" name="admName" id="admName" value="" />
																<input type="hidden" id="assignedAdm" value="<?php echo $assignedAdmin; ?>" />
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="requestTitle" value="<?php echo clean($row['requestTitle']); ?>" />
															<button type="input" name="submit" value="assignRequest" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
															<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
														</div>
													</form>
												</div>
											</div>
										</div>

										<?php if ($row['isClosed'] == '0') { ?>
											<a data-toggle="modal" href="#closeRequest" class="btn btn-xs btn-default btn-icon"><i class="fa fa-check"></i> Close Request</a>
											<div class="modal fade" id="closeRequest" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
															<h4 class="modal-title"><?php echo $closeCmpServReqH4; ?></h4>
														</div>
														<form action="" method="post">
															<div class="modal-body">
																<div class="form-group">
																	<label for="resolutionText"><?php echo $resDescField; ?></label>
																	<?php if ($row['resolutionText'] != '') { ?>
																		<textarea class="form-control" name="resolutionText" required="required" rows="8"><?php echo clean($row['resolutionText']); ?></textarea>
																	<?php } else { ?>
																		<textarea class="form-control" name="resolutionText" required="required" rows="8"><?php echo isset($_POST['resolutionText']) ? $_POST['resolutionText'] : ''; ?></textarea>
																	<?php } ?>
																	<span class="help-block"><?php echo $requestDescFieldHelp; ?></span>
																</div>

																<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="resolutionDate"><?php echo $resDateCmplField; ?></label>
																			<input type="text" class="form-control" name="resolutionDate" id="resolutionDate" required="required" value="<?php echo isset($_POST['resolutionDate']) ? $_POST['resolutionDate'] : ''; ?>" />
																			<span class="help-block"><?php echo $resDateCmplFieldHelp; ?></span>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="needsFollowUp"><?php echo $needsFollowupField; ?></label>
																			<select class="form-control chosen-select" name="needsFollowUp">
																				<option value="0"><?php echo $noBtn; ?></option>
																				<option value="1"><?php echo $yesBtn; ?></option>
																			</select>
																			<span class="help-block"><?php echo $needsFollowupFieldHelp; ?></span>
																		</div>
																	</div>
																</div>

																<div class="form-group">
																	<label for="followUpText"><?php echo $followupDescField; ?></label>
																	<textarea class="form-control" name="followUpText" rows="4"><?php echo isset($_POST['followUpText']) ? $_POST['followUpText'] : ''; ?></textarea>
																	<span class="help-block"><?php echo $followupDescFieldHelp; ?></span>
																</div>
															</div>
															<div class="modal-footer">
																<input type="hidden" name="requestTitle" value="<?php echo clean($row['requestTitle']); ?>" />
																<button type="input" name="submit" value="closeRequest" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
																<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
															</div>
														</form>
													</div>
												</div>
											</div>
										<?php } else { ?>
											<a data-toggle="modal" href="#reopenRequest" class="btn btn-xs btn-default btn-icon"><i class="fa fa-reply"></i> <?php echo $reoprenReqBtn; ?></a>
											<div class="modal fade" id="reopenRequest" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<form action="" method="post">
															<div class="modal-body">
																<p class="lead"><?php echo $reoprenReqConf; ?> "<?php echo clean($row['requestTitle']); ?>" <?php echo $forText.' '.clean($row['propertyName']); ?>?</p>
															</div>
															<div class="modal-footer">
																<input type="hidden" name="requestTitle" value="<?php echo clean($row['requestTitle']); ?>" />
																<button type="input" name="submit" value="reopenRequest" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
																<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
															</div>
														</form>
													</div>
												</div>
											</div>
										<?php } ?>
									</section>
								</li>
								<li class="<?php echo $notes; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $notesTabText; ?></h4>
									<section class="tabContent" id="notes">
										<h3><?php echo $servReqNotesH3; ?></h3>
										<?php if (!is_null($row['notes'])) { ?>
											<div class="well well-sm mb-0"><?php echo nl2br(htmlspecialchars_decode($row['notes'])); ?></div>
											<p><small><?php echo $servReqNotesQuip; ?></small></p>
											<a data-toggle="modal" href="#reqNotes" class="btn btn-xs btn-default btn-icon"><i class="fa fa-pencil"></i> <?php echo $updNotesBtn; ?></a>
										<?php } else { ?>
											<a data-toggle="modal" href="#reqNotes" class="btn btn-xs btn-default btn-icon"><i class="fa fa-pencil"></i> <?php echo $addNotesBtn; ?></a>
										<?php } ?>
										<div class="modal fade" id="reqNotes" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
														<h4 class="modal-title"><?php echo $servReqNotesH3; ?></h4>
													</div>
													<form action="" method="post">
														<div class="modal-body">
															<div class="form-group">
																<label for="notes"><?php echo $notesTabText; ?></label>
																<textarea class="form-control" name="notes" rows="8"><?php echo clean($row['notes']); ?></textarea>
																<span class="help-block"><?php echo $servReqNotesQuip; ?></span>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="requestTitle" value="<?php echo clean($row['requestTitle']); ?>" />
															<button type="input" name="submit" value="reqNotes" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
															<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</section>
								</li>
								<?php if ($row['isClosed'] == '1') { ?>
									<li class="<?php echo $resolution; ?>">
										<h4 class="tabHeader" tabindex="0"><?php echo $resolutionTabText; ?></h4>
										<section class="tabContent" id="resolution">
											<h3><?php echo $servReqResH3; ?></h3>
											<div class="well well-sm"><strong><?php echo $resDescText; ?></strong><br /><?php echo nl2br(htmlspecialchars_decode($row['resolutionText'])); ?></div>
											<div class="row mb-10">
												<div class="col-md-6">
													<ul class="list-group mb-10">
														<li class="list-group-item"><strong><?php echo $dateClosedText; ?></strong> <?php echo dateFormat($row['resolutionDate']); ?></li>
													</ul>
												</div>
												<div class="col-md-6">
													<ul class="list-group mb-10">
														<li class="list-group-item"><strong><?php echo $followUpText; ?></strong> <?php echo $needsFollowUp; ?></li>
													</ul>
												</div>
											</div>

											<?php if ($row['needsFollowUp'] == '1') { ?>
												<div class="well well-sm"><strong><?php echo $followupExpText; ?></strong><br /><?php echo nl2br(htmlspecialchars_decode($row['followUpText'])); ?></div>
											<?php } ?>

											<a data-toggle="modal" href="#editResolution" class="btn btn-xs btn-info btn-icon"><i class="fa fa-pencil"></i> <?php echo $editResBtn; ?></a>
											<div class="modal fade" id="editResolution" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
															<h4 class="modal-title"><?php echo $editResH4; ?></h4>
														</div>
														<form action="" method="post">
															<div class="modal-body">
																<div class="form-group">
																	<label for="resolutionText"><?php echo $resDescField; ?></label>
																	<textarea class="form-control" name="resolutionText" required="required" rows="8"><?php echo clean($row['resolutionText']); ?></textarea>
																	<span class="help-block"><?php echo $requestDescFieldHelp; ?></span>
																</div>

																<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="resolutionDate"><?php echo $resDateCmplField; ?></label>
																			<input type="text" class="form-control" name="resolutionDate" id="edit_resolutionDate" required="required" value="<?php echo dbDateFormat($row['resolutionDate']); ?>" />
																			<span class="help-block"><?php echo $resDateCmplFieldHelp; ?></span>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="needsFollowUp"><?php echo $needsFollowupField; ?></label>
																			<select class="form-control chosen-select" name="needsFollowUp" id="edit_needsFollowUp">
																				<option value="0"><?php echo $noBtn; ?></option>
																				<option value="1"><?php echo $yesBtn; ?></option>
																			</select>
																			<span class="help-block"><?php echo $needsFollowupFieldHelp; ?></span>
																			<input type="hidden" id="followUp" value="<?php echo $needsFollowUp; ?>" />
																		</div>
																	</div>
																</div>

																<div class="form-group">
																	<label for="followUpText"><?php echo $followupDescField; ?></label>
																	<textarea class="form-control" name="followUpText" rows="4"><?php echo clean($row['followUpText']); ?></textarea>
																	<span class="help-block"><?php echo $followupDescFieldHelp; ?></span>
																</div>
															</div>
															<div class="modal-footer">
																<input type="hidden" name="requestTitle" value="<?php echo clean($row['requestTitle']); ?>" />
																<button type="input" name="submit" value="editResolution" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
																<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</section>
									</li>
								<?php } ?>
								<li class="<?php echo $expense; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $expensesTabText; ?></h4>
									<section class="tabContent" id="expenses">
										<h3><?php echo $servReqLegend; ?></h3>
										<p class="text-right mt-5">
											<a data-toggle="modal" href="#newExpense" class="btn btn-warning btn-xs btn-icon mt-0 mb-10"><i class="fa fa-credit-card"></i> <?php echo $addExpenseBtn; ?></a>
										</p>
										<div class="modal fade" id="newExpense" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
														<h4 class="modal-title"><?php echo $addExpenseH4; ?></h4>
													</div>
													<form action="" method="post">
														<div class="modal-body">
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="vendorName"><?php echo $vendorNameField; ?></label>
																		<input type="text" class="form-control" name="vendorName" required="required" value="<?php echo isset($_POST['vendorName']) ? $_POST['vendorName'] : ''; ?>" />
																		<span class="help-block"><?php echo $vendorNameFieldHelp; ?></span>
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="expenseName"><?php echo $expenseNameField; ?></label>
																		<input type="text" class="form-control" name="expenseName" required="required" value="<?php echo isset($_POST['expenseName']) ? $_POST['expenseName'] : ''; ?>" />
																		<span class="help-block"><?php echo $expenseNameFieldHelp; ?></span>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="expenseCost"><?php echo $expenseAmtField; ?></label>
																		<input type="text" class="form-control" name="expenseCost" required="required" value="<?php echo isset($_POST['expenseCost']) ? $_POST['expenseCost'] : ''; ?>" />
																		<span class="help-block"><?php echo $expenseAmtFieldHelp; ?></span>
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="dateOfExpense"><?php echo $dateofExpenseField; ?></label>
																		<input type="text" class="form-control" name="dateOfExpense" id="dateOfExpense" required="required" value="<?php echo isset($_POST['dateOfExpense']) ? $_POST['dateOfExpense'] : ''; ?>" />
																		<span class="help-block"><?php echo $dateofExpenseFieldHelp; ?></span>
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="expenseDesc"><?php echo $expenseDescField; ?></label>
																		<textarea class="form-control" name="expenseDesc" required="required" rows="4"><?php echo isset($_POST['expenseDesc']) ? $_POST['expenseDesc'] : ''; ?></textarea>
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="notes"><?php echo $expenseNotesField; ?></label>
																		<textarea class="form-control" name="notes" rows="4"><?php echo isset($_POST['notes']) ? $_POST['notes'] : ''; ?></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="requestTitle" value="<?php echo clean($row['requestTitle']); ?>" />
															<input type="hidden" name="leaseId" value="<?php echo clean($row['leaseId']); ?>" />
															<input type="hidden" name="propertyId" value="<?php echo clean($row['propertyId']); ?>" />
															<button type="input" name="submit" value="newExpense" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
															<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
														</div>
													</form>
												</div>
											</div>
										</div>

										<?php if(mysqli_num_rows($expres) > 0) { ?>
											<table id="servExpense" class="display" cellspacing="0">
												<thead>
													<tr>
														<th><?php echo $nameHead; ?></th>
														<th><?php echo $vendorHead; ?></th>
														<th class="text-center"><?php echo $expenseDateHead; ?></th>
														<th class="text-center"><?php echo $expenceAmtHead; ?></th>
														<th class="text-right"></th>
													</tr>
												</thead>

												<tbody>
												<?php while ($ex = mysqli_fetch_assoc($expres)) { ?>
														<tr>
															<td><?php echo clean($ex['expenseName']); ?></td>
															<td><?php echo clean($ex['vendorName']); ?></td>
															<td class="text-center"><?php echo dateFormat($ex['dateOfExpense']); ?></td>
															<td class="text-center"><?php echo formatCurrency($ex['expenseCost'],$currCode); ?></td>
															<td class="text-right">
																<a data-toggle="modal" href="#editExpense<?php echo $ex['expenseId']; ?>" class="text-warning">
																	<i class="fa fa-pencil" data-toggle="tooltip" data-placement="left" title="<?php echo $editExpenseBtn; ?>"></i>
																</a>
																&nbsp;
																<a data-toggle="modal" href="#deleteExpense<?php echo $ex['expenseId']; ?>" class="text-danger">
																	<i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="<?php echo $delExpenseBtn; ?>"></i>
																</a>

																<div class="modal fade" id="editExpense<?php echo $ex['expenseId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
																	<div class="modal-dialog modal-lg text-left">
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
																				<h4 class="modal-title"><?php echo $editExpenseH4; ?></h4>
																			</div>
																			<form action="" method="post">
																				<div class="modal-body">
																					<div class="row">
																						<div class="col-md-6">
																							<div class="form-group">
																								<label for="vendorName"><?php echo $vendorNameField; ?></label>
																								<input type="text" class="form-control" name="vendorName" required="required" value="<?php echo clean($ex['vendorName']); ?>" />
																								<span class="help-block"><?php echo $vendorNameFieldHelp; ?></span>
																							</div>
																						</div>
																						<div class="col-md-6">
																							<div class="form-group">
																								<label for="expenseName"><?php echo $expenseNameField; ?></label>
																								<input type="text" class="form-control" name="expenseName" required="required" value="<?php echo clean($ex['expenseName']); ?>" />
																								<span class="help-block"><?php echo $expenseNameFieldHelp; ?></span>
																							</div>
																						</div>
																					</div>
																					<div class="row">
																						<div class="col-md-6">
																							<div class="form-group">
																								<label for="expenseCost"><?php echo $expenseAmtField; ?></label>
																								<input type="text" class="form-control" name="expenseCost" required="required" value="<?php echo clean($ex['expenseCost']); ?>" />
																								<span class="help-block"><?php echo $expenseAmtFieldHelp; ?></span>
																							</div>
																						</div>
																						<div class="col-md-6">
																							<div class="form-group">
																								<label for="dateOfExpense"><?php echo $dateofExpenseField; ?></label>
																								<input type="text" class="form-control" name="dateOfExpense" id="dateOfExpense_<?php echo $count; ?>" required="required" value="<?php echo dbDateFormat($ex['dateOfExpense']); ?>" />
																								<span class="help-block"><?php echo $dateofExpenseFieldHelp; ?></span>
																							</div>
																						</div>
																					</div>

																					<div class="row">
																						<div class="col-md-6">
																							<div class="form-group">
																								<label for="expenseDesc"><?php echo $expenseDescField; ?></label>
																								<textarea class="form-control" name="expenseDesc" required="required" rows="4"><?php echo clean($ex['expenseDesc']); ?></textarea>
																							</div>
																						</div>
																						<div class="col-md-6">
																							<div class="form-group">
																								<label for="notes"><?php echo $expenseNotesField; ?></label>
																								<textarea class="form-control" name="notes" rows="4"><?php echo clean($ex['notes']); ?></textarea>
																							</div>
																						</div>
																					</div>
																				</div>
																				<div class="modal-footer">
																					<input name="expenseId" type="hidden" value="<?php echo $ex['expenseId']; ?>" />
																					<button type="input" name="submit" value="editExpense" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
																					<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
																				</div>
																			</form>
																		</div>
																	</div>
																</div>

																<div class="modal fade" id="deleteExpense<?php echo $ex['expenseId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
																	<div class="modal-dialog text-left">
																		<div class="modal-content">
																			<form action="" method="post">
																				<div class="modal-body">
																					<p class="lead"><?php echo $delExpenseConf; ?> "<?php echo clean($ex['expenseName']); ?>"?</p>
																				</div>
																				<div class="modal-footer">
																					<input name="deleteId" type="hidden" value="<?php echo $ex['expenseId']; ?>" />
																					<input type="hidden" name="requestTitle" value="<?php echo clean($row['requestTitle']); ?>" />
																					<button type="input" name="submit" value="deleteExpense" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
																					<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
																				</div>
																			</form>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
												<?php
														$count++;
													}
												?>
												</tbody>
											</table>

											<span class="reportTotal"><strong><?php echo $totalExpensesPaidText; ?></strong> <?php echo $totalExp; ?></span>
										<?php } else { ?>
											<div class="alertMsg default mb-20">
												<div class="msgIcon pull-left">
													<i class="fa fa-info-circle"></i>
												</div>
												<?php echo $noExpensesFoundMsg; ?>
											</div>
										<?php } ?>
									</section>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<hr />

				<h3><?php echo $servReqDiscH3; ?></h3>
				<?php if(mysqli_num_rows($results) > 0) { ?>
					<ul class="commentsBox">
						<?php
							while ($rows = mysqli_fetch_assoc($results)) {
								if ($rows['adminId'] != '0') {
									$cmtType = 'cmtRight';
									$avatarImg = $avatarDir.$rows['adminAvatar'];
									$postedBy = clean($rows['adminName']);
								} else {
									$cmtType = 'cmtLeft';
									$avatarImg = $avatarDir.$rows['userAvatar'];
									$postedBy = clean($rows['user']);
								}
						?>
								<li class="<?php echo $cmtType; ?>">
									<div class="cmtAvatar">
										<img alt="<?php echo $postedByText; ?>" src="../<?php echo $avatarImg; ?>" />
									</div>
									<div class="cmtText">
										<p><?php echo nl2br(htmlspecialchars_decode($rows['noteText'])); ?></p>
										<div class="cmtFooter">
											<span class="cmtTextUser"><?php echo $postedByText; ?> <?php echo $postedBy; ?></span>
											<span class="cmtTextDate">on <?php echo dateFormat($rows['noteDate']); ?> <?php echo $atText; ?> <?php echo timeFormat($rows['noteDate']); ?></span>&nbsp;
											<small>
												<a data-toggle="modal" href="#editComment<?php echo $rows['noteId']; ?>"><i class="fa fa-pencil text-warning" data-toggle="tooltip" data-placement="left"title="<?php echo $editCommentBtn; ?>"></i></a>&nbsp;
												<a data-toggle="modal" href="#deleteComment<?php echo $rows['noteId']; ?>"><i class="fa fa-trash text-danger" data-toggle="tooltip" data-placement="left" title="<?php echo $delCommentBtn; ?>"></i></a>
											</small>
										</div>
									</div>

									<div class="modal fade" id="editComment<?php echo $rows['noteId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
													<h4 class="modal-title"><?php echo $editDiscCmtH3; ?></h4>
												</div>
												<form action="" method="post">
													<div class="modal-body">
														<div class="form-group">
															<textarea class="form-control" name="noteText" rows="8"><?php echo clean($rows['noteText']); ?></textarea>
														</div>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="noteId" value="<?php echo $rows['noteId']; ?>" />
														<input type="hidden" name="requestTitle" value="<?php echo clean($row['requestTitle']); ?>" />
														<button type="input" name="submit" value="editComment" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
														<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<div class="modal fade" id="deleteComment<?php echo $rows['noteId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<form action="" method="post">
													<div class="modal-body">
														<p class="lead"><?php echo $delCommentConf; ?></p>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="deleteId" value="<?php echo $rows['noteId']; ?>" />
														<input type="hidden" name="requestTitle" value="<?php echo clean($row['requestTitle']); ?>" />
														<button type="input" name="submit" value="deleteComment" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
														<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</li>
						<?php } ?>
					</ul>
				<?php } else { ?>
					<div class="alertMsg default mb-20">
						<div class="msgIcon pull-left">
							<i class="fa fa-info-circle"></i>
						</div>
						<?php echo $noCommentsFoundMsg; ?>
					</div>
				<?php } ?>

				<hr />

				<h3><?php echo $addDiscCmtH3; ?></h3>
				<form action="" method="post" class="mb-20">
					<div class="form-group">
						<textarea class="form-control" name="noteText" id="noteText" required="required" rows="8"><?php echo isset($_POST['noteText']) ? $_POST['noteText'] : ''; ?></textarea>
					</div>
					<input type="hidden" name="leaseId" value="<?php echo $row['leaseId']; ?>" />
					<input type="hidden" name="propertyId" value="<?php echo $row['propertyId']; ?>" />
					<input type="hidden" name="requestTitle" value="<?php echo clean($row['requestTitle']); ?>" />
					<input type="hidden" name="userEmail" value="<?php echo clean($row['userEmail']); ?>" />
					<button type="input" name="submit" value="addComment" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
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
