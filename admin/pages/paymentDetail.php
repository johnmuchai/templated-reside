<?php
	if ($set['enablePayments'] == '1') {
		$payId = $mysqli->real_escape_string($_GET['payId']);
		$ipAddress = $_SERVER['REMOTE_ADDR'];

		// Update Payment
		if (isset($_POST['submit']) && $_POST['submit'] == 'updatePay') {
			// User Validations
			if($_POST['paymentDate'] == '') {
				$msgBox = alertBox($payDateReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else if($_POST['paymentFor'] == '') {
				$msgBox = alertBox($payForReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else if($_POST['amountPaid'] == '') {
				$msgBox = alertBox($payAmtReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else if($_POST['paymentType'] == '') {
				$msgBox = alertBox($payTypeReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else {
				$paymentDate = htmlspecialchars($_POST['paymentDate']);
				$paymentFor = htmlspecialchars($_POST['paymentFor']);
				$amountPaid = htmlspecialchars($_POST['amountPaid']);
				$paymentType = htmlspecialchars($_POST['paymentType']);
				$notes = htmlspecialchars($_POST['notes']);
				$propertyId = htmlspecialchars($_POST['propertyId']);
				$propertyName = htmlspecialchars($_POST['propertyName']);
				$userId = htmlspecialchars($_POST['userId']);

				if ($_POST['penaltyFee'] == '') { $penaltyFee = null; } else { $penaltyFee = htmlspecialchars($_POST['penaltyFee']); }
				if ($_POST['rentMonth'] == '...') {
					$isRent = '0';
					$rntMonth = null;
				} else {
					$isRent = '1';
					$rntMonth = htmlspecialchars($_POST['rentMonth']);
				}
				if ($_POST['rentYear'] == '') {
					$rntYear = null;
				} else {
					$rntYear = htmlspecialchars($_POST['rentYear']);
				}

				$stmt = $mysqli->prepare("UPDATE
											payments
										SET
											paymentDate = ?,
											amountPaid = ?,
											penaltyFee = ?,
											paymentFor = ?,
											paymentType = ?,
											isRent = ?,
											rentMonth = ?,
											rentYear = ?,
											notes = ?,
											lastUpdated = NOW()
										WHERE
											payId = ?"
				);
				$stmt->bind_param('ssssssssss',
										$paymentDate,
										$amountPaid,
										$penaltyFee,
										$paymentFor,
										$paymentType,
										$isRent,
										$rntMonth,
										$rntYear,
										$notes,
										$payId
				);
				$stmt->execute();
				$stmt->close();

				// Add Recent Activity
				$activityType = '2';
				$rs_uid = '0';
				$activityTitle = $rs_adminName.' '.$updPaymentAct.' "'.$paymentFor.'"';
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

				$msgBox = alertBox($updPaymentMsg." \"".$paymentFor."\" ".$updPaymentMsg1, "<i class='fa fa-check-square'></i>", "success");
				// Clear the Form of values
				$_POST['paymentDate'] = $_POST['paymentFor'] = $_POST['amountPaid'] = $_POST['penaltyFee'] = $_POST['paymentType'] = $_POST['rentYear'] = $_POST['notes'] = '';
			}
		}

		// Issue Refund
		if (isset($_POST['submit']) && $_POST['submit'] == 'issRefund') {
			// User Validations
			if($_POST['refundDate'] == '') {
				$msgBox = alertBox($refDateReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else if($_POST['refundAmount'] == '') {
				$msgBox = alertBox($refAmtReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else if($_POST['refundFor'] == '') {
				$msgBox = alertBox($refForReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else if($_POST['refundAmount'] > $_POST['maxRefund']) {
				$msgBox = alertBox($refExceedsMsg, "<i class='fa fa-times-circle'></i>", "danger");
			} else {
				$refundDate = htmlspecialchars($_POST['refundDate']);
				$refundAmount = htmlspecialchars($_POST['refundAmount']);
				$refundFor = htmlspecialchars($_POST['refundFor']);
				$notes = htmlspecialchars($_POST['notes']);
				$leaseId = htmlspecialchars($_POST['leaseId']);
				$propertyId = htmlspecialchars($_POST['propertyId']);
				$userId = htmlspecialchars($_POST['userId']);
				$propertyName = htmlspecialchars($_POST['propertyName']);

				if ($notes == '') {
					$refNotes = null;
				} else {
					$refNotes = $notes;
				}

				// Add the refund Record
				$stmt = $mysqli->prepare("
									INSERT INTO
										refunds(
											payId,
											leaseId,
											propertyId,
											adminId,
											userId,
											refundDate,
											refundAmount,
											refundFor,
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
											NOW(),
											?
										)
				");
				$stmt->bind_param('ssssssssss',
					$payId,
					$leaseId,
					$propertyId,
					$rs_adminId,
					$userId,
					$refundDate,
					$refundAmount,
					$refundFor,
					$refNotes,
					$ipAddress
				);
				$stmt->execute();
				$stmt->close();

				// Update the Payment Record
				$stmt = $mysqli->prepare("UPDATE
											payments
										SET
											hasRefund = 1,
											lastUpdated = NOW()
										WHERE
											payId = ?"
				);
				$stmt->bind_param('s', $payId);
				$stmt->execute();
				$stmt->close();

				// Add Recent Activity
				$activityType = '2';
				$rs_uid = '0';
				$activityTitle = $rs_adminName.' '.$issRefundAct.' "'.$propertyName.'"';
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

				$msgBox = alertBox($issRefundMsg." \"".$propertyName."\" ".$newDiscCmtMsg2, "<i class='fa fa-check-square'></i>", "success");

				// Clear the Form of values
				$_POST['refundDate'] = $_POST['refundAmount'] = $_POST['refundFor'] = $_POST['notes'] = '';
			}
		}

		// Delete Payment
		if (isset($_POST['submit']) && $_POST['submit'] == 'deletePayment') {
			$deleteId = htmlspecialchars($_POST['deleteId']);
			$refundId = htmlspecialchars($_POST['refundId']);
			$leaseId = htmlspecialchars($_POST['leaseId']);
			$propertyName = htmlspecialchars($_POST['propertyName']);

			// Delete the Payment Record
			$stmt = $mysqli->prepare("DELETE FROM payments WHERE payId = ?");
			$stmt->bind_param('s', $deleteId);
			$stmt->execute();
			$stmt->close();

			// Delete the Refund Record (if there is one)
			$stmt = $mysqli->prepare("DELETE FROM refunds WHERE refundId = ?");
			$stmt->bind_param('s', $refundId);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delPayRecAct.' "'.$propertyName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			// Redirect to the Properties Payment History
			header ('Location: index.php?action=viewPayments&leaseId='.$leaseId.'&deleted=true');
		}

		// Update Refund
		if (isset($_POST['submit']) && $_POST['submit'] == 'editRefund') {
			// User Validations
			if($_POST['refundDate'] == '') {
				$msgBox = alertBox($refDateReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else if($_POST['refundAmount'] == '') {
				$msgBox = alertBox($refAmtReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else if($_POST['refundFor'] == '') {
				$msgBox = alertBox($refForReq, "<i class='fa fa-times-circle'></i>", "danger");
			} else {
				$refundDate = htmlspecialchars($_POST['refundDate']);
				$refundAmount = htmlspecialchars($_POST['refundAmount']);
				$refundFor = htmlspecialchars($_POST['refundFor']);
				$notes = htmlspecialchars($_POST['notes']);
				$refundId = htmlspecialchars($_POST['refundId']);

				if ($notes == '') {
					$refNotes = null;
				} else {
					$refNotes = $notes;
				}

				$stmt = $mysqli->prepare("UPDATE
											refunds
										SET
											refundDate = ?,
											refundAmount = ?,
											refundFor = ?,
											notes = ?,
											lastUpdated = NOW()
										WHERE
											refundId = ?"
				);
				$stmt->bind_param('sssss',
										$refundDate,
										$refundAmount,
										$refundFor,
										$refNotes,
										$refundId
				);
				$stmt->execute();
				$stmt->close();

				// Add Recent Activity
				$activityType = '2';
				$rs_uid = '0';
				$activityTitle = $rs_adminName.' '.$editRefAct.' "'.$refundFor.'"';
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

				$msgBox = alertBox($editRefMsg." \"".$refundFor."\" ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");
			}
		}

		// Delete Refund
		if (isset($_POST['submit']) && $_POST['submit'] == 'deleteRefund') {
			$deleteId = htmlspecialchars($_POST['deleteId']);
			$refundFor = htmlspecialchars($_POST['refundFor']);

			// Delete the Refund Record
			$stmt = $mysqli->prepare("DELETE FROM refunds WHERE refundId = ?");
			$stmt->bind_param('s', $deleteId);
			$stmt->execute();
			$stmt->close();

			// Update the Payment Record
			$stmt = $mysqli->prepare("UPDATE
										payments
									SET
										hasRefund = 0,
										lastUpdated = NOW()
									WHERE
										payId = ?"
			);
			$stmt->bind_param('s', $payId);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delRefundAct.' "'.$refundFor.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($delRefundMsg." \"".$refundFor."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");
		}

		$qry = "SELECT
					payments.*,
					payments.notes AS paymentNotes,
					refunds.*,
					refunds.notes AS refundNotes,
					admins.adminName,
					users.userId,
					users.userEmail,
					CONCAT(users.userFirstName,' ',users.userLastName) AS user,
					users.userAddress,
					properties.propertyId,
					properties.propertyName,
					leases.leaseId,
					leases.leaseTerm,
					leases.leaseStart,
					leases.leaseEnd,
					leases.closed
				FROM
					payments
					LEFT JOIN refunds ON payments.payId = refunds.payId
					LEFT JOIN admins ON refunds.adminId = admins.adminId
					LEFT JOIN users ON payments.userId = users.userId
					LEFT JOIN properties ON payments.propertyId = properties.propertyId
					LEFT JOIN leases ON payments.leaseId = leases.leaseId
				WHERE payments.payId = ".$payId;
		$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
		$row = mysqli_fetch_assoc($res);

		if ($row['closed'] == '0') { $status = $activeTabTitle; } else { $status = $inactClosedText; }
		if ($row['penaltyFee'] != '') { $penaltyFee = formatCurrency($row['penaltyFee'],$currCode); } else { $penaltyFee = ''; }
		if ($row['rentMonth'] == '') { $rentMonth = $noneText; } else { $rentMonth = clean($row['rentMonth']); }

		// Format the Amounts
		$totreceived = $row['amountPaid'] + $row['penaltyFee'] - $row['refundAmount'];
		$totalReceived = formatCurrency($totreceived,$currCode);

		$total = $row['amountPaid'] + $row['penaltyFee'];
		$totDue = formatCurrency($total,$currCode);

		$maxRefund = $row['amountPaid'] + $row['penaltyFee'];

		// Email Receipt
		if (isset($_POST['submit']) && $_POST['submit'] == 'emailRcpt') {
			$paymentDate = $row['paymentDate'];
			$tenantsName = htmlspecialchars($row['user']);
			$tenantsEmail = $row['userEmail'];
			$tenantsAddress = nl2br(decryptIt($row['userAddress']));
			$propertyName = htmlspecialchars($row['propertyName']);
			$paymentFor = htmlspecialchars($row['paymentFor']);
			$paymentType = htmlspecialchars($row['paymentType']);
			$amountPaid = formatCurrency($row['amountPaid'],$currCode);
			$penaltyFee = formatCurrency($row['penaltyFee'],$currCode);
			$totalDue = $totDue;
			$refundAmt = formatCurrency($row['refundAmount'],$currCode);
			$totalPaid = $totalReceived;

			if ($row['hasRefund'] == '1') {
				if ($row['refundAmount'] == $total) {
					$paymentNotes = $paymentRefundedMsg;
				} else {
					$paymentNotes = $paymentRefundedMsg1;
				}
			} else {
				$paymentNotes = '';
			}

			$installUrl = htmlspecialchars($set['installUrl']);
			$siteName = htmlspecialchars($set['siteName']);
			$businessAddress = nl2br(htmlspecialchars($set['businessAddress']));
			$siteEmail = htmlspecialchars($set['siteEmail']);

			$emailvars = array();

			$emailvars['installUrl'] 		= $installUrl;
			$emailvars['payId'] 			= $payId;
			$emailvars['paymentDate'] 		= $paymentDate;
			$emailvars['tenantsName'] 		= $tenantsName;
			$emailvars['tenantsAddress'] 	= htmlspecialchars_decode($tenantsAddress);
			$emailvars['propertyName'] 		= $propertyName;
			$emailvars['paymentFor'] 		= $paymentFor;
			$emailvars['paymentType'] 		= $paymentType;
			$emailvars['amountPaid'] 		= $amountPaid;
			$emailvars['penaltyFee'] 		= $penaltyFee;
			$emailvars['totalDue'] 			= $totalDue;
			$emailvars['refundAmt'] 		= $refundAmt;
			$emailvars['totalPaid'] 		= $totalPaid;
			$emailvars['paymentNotes'] 		= htmlspecialchars($paymentNotes);
			$emailvars['siteName']			= $siteName;
			$emailvars['businessAddress']	= $businessAddress;

			$email_tmpl = file_get_contents("includes/receipt_tmpl.php");

			foreach($emailvars as $k => $v) {
				$email_tmpl = str_replace('{{'.$k.'}}', $v, $email_tmpl);
			}

			$subject = $payReceiptEmailSubject.' '.$siteName;

			$headers = "From: ".$siteName." <".$siteEmail.">\r\n";
			$headers .= "Reply-To: ".$siteEmail."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			// Send the Receipt
			mail($tenantsEmail, $subject, $email_tmpl, $headers);

			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$receiptEmailedAct.' '.$tenantsName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($receiptEmailedMsg." ".$tenantsName, "<i class='fa fa-check-square'></i>", "success");
		}
	}

	$propPage = 'true';
	$pageTitle = $paymentDetailPageTitle;
	$addCss = '<link rel="stylesheet" type="text/css" href="../css/datetimepicker.css" /><link href="../css/chosen.css" rel="stylesheet">';
	$datePicker = 'true';
	$chosen = 'true';
	$jsFile = 'paymentDetail';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ($set['enablePayments'] == '1') {
				if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
					if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo clean($row['propertyName']).' '.$pageTitle; ?></h3>
				<input type="hidden" id="weekStart" value="<?php echo $set['weekStart']; ?>" />

				<div class="row mb-20">
					<div class="col-md-3">
						<ul class="list-group">
							<li class="list-group-item"><strong><?php echo $newPaymentEmail2; ?></strong>
								<a href="index.php?action=viewPayments&leaseId=<?php echo $row['leaseId']; ?>" data-toggle="tooltip" data-placement="top" title="View Payment History">
									<?php echo clean($row['propertyName']); ?>
								</a>
							</li>
							<li class="list-group-item"><strong><?php echo $tenantNameText; ?>:</strong>
								<a href="index.php?action=viewTenant&userId=<?php echo $row['userId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewTenantText; ?>">
									<?php echo clean($row['user']); ?>
								</a>
							</li>
							<li class="list-group-item"><strong><?php echo $leaseStatusText; ?>:</strong>
								<a href="index.php?action=viewLease&leaseId=<?php echo $row['leaseId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewLeaseText; ?>">
									<?php echo $status; ?>
								</a>
							</li>
							<li class="list-group-item">
								<strong><?php echo $leaseTermText; ?></strong>
								<?php echo clean($row['leaseTerm']); ?><br />
								<small><?php echo shortDateFormat($row['leaseStart']).' &mdash; '.shortDateFormat($row['leaseEnd']); ?></small>
							</li>
						</ul>

					</div>
					<div class="col-md-9">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th><?php echo $descriptionHead; ?></th>
									<th><?php echo $paymentDateHead; ?></th>
									<th><?php echo $paidByHead; ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo clean($row['paymentFor']); ?></td>
									<td><?php echo $row['paymentDate']; ?></td>
									<td><?php echo clean($row['paymentType']); ?></td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th><?php echo $amountHead; ?></th>
									<th><?php echo $lateFeeHead; ?></th>
									<th><?php echo $rentMonthText; ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo formatCurrency($row['amountPaid'],$currCode); ?></td>
									<td><?php echo $penaltyFee; ?></td>
									<td><?php echo clean($row['rentMonth']).' '.clean($row['rentYear']); ?></td>
								</tr>
								<tr>
									<td colspan="3"><strong><?php echo $paymentNotesText; ?>:</strong> <?php echo nl2br(htmlspecialchars_decode($row['paymentNotes'])); ?></td>
								</tr>
							</tbody>
						</table>

						<a data-toggle="modal" href="#editPayment" class="btn btn-default btn-xs btn-icon"><i class="fa fa-edit"></i> <?php echo $editPaymentBtn; ?></a>
						<div class="modal fade" id="editPayment" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
										<h4 class="modal-title"><?php echo $editPaymentBtn; ?></h4>
									</div>
									<form action="" method="post">
										<div class="modal-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="paymentDate"><?php echo $datePayRcvdField; ?></label>
														<input type="text" class="form-control" name="paymentDate" id="paymentDate" required="required" value="<?php echo dbDateFormat($row['paymentDate']); ?>" />
														<span class="help-block"><?php echo $datePayRcvdFieldHelp; ?></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="paymentFor"><?php echo $paymentForHead; ?></label>
														<input type="text" class="form-control" name="paymentFor" id="paymentFor" required="required" value="<?php echo clean($row['paymentFor']); ?>" />
														<span class="help-block"><?php echo $payForFieldHelp; ?></span>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="amountPaid"><?php echo $paymentAmtField; ?></label>
														<input type="text" class="form-control" name="amountPaid" id="amountPaid" required="required" value="<?php echo $row['amountPaid']; ?>" />
														<span class="help-block"><?php echo $payAmtHelp; ?></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="penaltyFee"><?php echo $latePayFeeField; ?></label>
														<input type="text" class="form-control" name="penaltyFee" id="penaltyFee" value="<?php echo $row['penaltyFee']; ?>" />
														<span class="help-block"><?php echo $latePayFeeFieldHelp; ?></span>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="paymentType"><?php echo $payTypeField; ?></label>
														<input type="text" class="form-control" name="paymentType" id="paymentType" required="required" value="<?php echo clean($row['paymentType']); ?>" />
														<span class="help-block"><?php echo $payTypeFieldHelp; ?></span>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="rentMonth"><?php echo $rentMonthField; ?></label>
														<select class="form-control chosen-select" name="rentMonth" id="rentMonth" style="width:100% !important;">
															<option value="..."><?php echo $noneOption; ?></option>
															<option value="January"><?php echo $janText; ?></option>
															<option value="February"><?php echo $febText; ?></option>
															<option value="March"><?php echo $marText; ?></option>
															<option value="April"><?php echo $aprText; ?></option>
															<option value="May"><?php echo $mayText; ?></option>
															<option value="June"><?php echo $junText; ?></option>
															<option value="July"><?php echo $julText; ?></option>
															<option value="August"><?php echo $augText; ?></option>
															<option value="September"><?php echo $septText; ?></option>
															<option value="October"><?php echo $octText; ?></option>
															<option value="November"><?php echo $novText; ?></option>
															<option value="December"><?php echo $decText; ?></option>
														</select>
														<span class="help-block"><?php echo $rentMonthFieldHelp; ?></span>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="rentYear"><?php echo $rentYearFeild; ?></label>
														<input type="text" class="form-control" name="rentYear" id="rentYear" value="<?php echo clean($row['rentYear']); ?>" />
														<span class="help-block"><?php echo $rentYearFeildHelp; ?></span>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label for="notes"><?php echo $paymentNotesText; ?></label>
												<textarea class="form-control" name="notes" id="notes" rows="3"><?php echo clean($row['paymentNotes']); ?></textarea>
												<span class="help-block"><?php echo $payNotesFieldHelp; ?></span>
											</div>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="propertyId" value="<?php echo clean($row['propertyId']); ?>" />
											<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
											<input type="hidden" name="userId" value="<?php echo clean($row['userId']); ?>" />
											<input type="hidden" id="theMonth" value="<?php echo $rentMonth; ?>" />
											<button type="input" name="submit" value="updatePay" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<?php if ($row['hasRefund'] == '0') { ?>
							<a data-toggle="modal" href="#issRefund" class="btn btn-default btn-xs btn-icon"><i class="fa fa-credit-card"></i> <?php echo $issueRefBtn; ?></a>
							<div class="modal fade" id="issRefund" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
											<h4 class="modal-title"><?php echo $issueRefH4; ?></h4>
										</div>
										<form action="" method="post">
											<div class="modal-body">
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="refundDate"><?php echo $refDateField; ?></label>
															<input type="text" class="form-control" name="refundDate" id="refundDate" required="required" value="<?php echo isset($_POST['refundDate']) ? $_POST['refundDate'] : ''; ?>">
															<span class="help-block"><?php echo $refDateFieldHelp; ?></span>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="refundAmount"><?php echo $refAmtField; ?></label>
															<input type="text" class="form-control" name="refundAmount" required="required" value="<?php echo isset($_POST['refundAmount']) ? $_POST['refundAmount'] : ''; ?>">
															<span class="help-block"><?php echo $numbersOnlyHelp; ?></span>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="refundFor"><?php echo $refForField; ?></label>
															<input type="text" class="form-control" name="refundFor" required="required" value="<?php echo isset($_POST['refundFor']) ? $_POST['refundFor'] : ''; ?>">
															<span class="help-block"><?php echo $refForFieldHelp; ?></span>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label for="notes"><?php echo $refundNotesField; ?></label>
													<textarea class="form-control" name="notes" rows="3"><?php echo isset($_POST['notes']) ? $_POST['notes'] : ''; ?></textarea>
												</div>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="leaseId" value="<?php echo $row['leaseId']; ?>" />
												<input type="hidden" name="propertyId" value="<?php echo $row['propertyId']; ?>" />
												<input type="hidden" name="userId" value="<?php echo $row['userId']; ?>" />
												<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
												<input type="hidden" name="maxRefund" value="<?php echo $maxRefund; ?>" />
												<button type="input" name="submit" value="issRefund" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $issueRefundBtn; ?></button>
												<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>
						<?php } ?>

						<a data-toggle="modal" href="#deletePayment" class="btn btn-default btn-xs btn-icon"><i class="fa fa-trash"></i> <?php echo $deletePayBtn; ?></a>
						<div class="modal fade" id="deletePayment" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog text-left">
								<div class="modal-content">
									<form action="" method="post">
										<div class="modal-body">
											<p class="lead">
												<?php echo $deletePayConf; ?> "<?php echo clean($row['paymentFor']); ?>"?<br />
												<small><?php echo $deletePayConf1; ?></small>
											</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="deleteId" value="<?php echo $payId; ?>" />
											<input type="hidden" name="refundId" value="<?php echo clean($row['refundId']); ?>" />
											<input type="hidden" name="leaseId" value="<?php echo clean($row['leaseId']); ?>" />
											<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
											<button type="input" name="submit" value="deletePayment" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<a href="index.php?action=receipt&payId=<?php echo $payId; ?>" target="_blank" class="btn btn-default btn-xs btn-icon"><i class="fa fa-print"></i> <?php echo $viewReceiptBtn; ?></a>

						<a data-toggle="modal" href="#emailRcpt" class="btn btn-default btn-xs btn-icon"><i class="fa fa-envelope-o"></i> <?php echo $emailReceiptBtn; ?></a>
						<div class="modal fade" id="emailRcpt" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog text-left">
								<div class="modal-content">
									<form action="" method="post">
										<div class="modal-body">
											<p class="lead">
												<?php echo $emailReceiptConf; ?> <?php echo clean($row['user']); ?>?
											</p>
										</div>
										<div class="modal-footer">
											<button type="input" name="submit" value="emailRcpt" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<?php if ($row['hasRefund'] == '1') { ?>
							<hr />
							<h3><?php echo $refundIssuedH3; ?></h3>

							<table class="table table-bordered">
								<thead>
									<tr>
										<th><?php echo $refundDateHead; ?></th>
										<th><?php echo $refunfForHead; ?></th>
										<th><?php echo $refundAmtHead; ?></th>
										<th><?php echo $issuedByHead; ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $row['refundDate']; ?></td>
										<td><?php echo clean($row['refundFor']); ?></td>
										<td><?php echo formatCurrency($row['refundAmount'],$currCode); ?></td>
										<td><?php echo clean($row['adminName']); ?></td>
									</tr>
								</tbody>
							</table>

							<a data-toggle="modal" href="#editRefund" class="btn btn-xs btn-default btn-icon"><i class="fa fa-edit"></i> <?php echo $editRefundBtn; ?></a>
							<div class="modal fade" id="editRefund" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-lg text-left">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
											<h4 class="modal-title"><?php echo $editRefundForH4.' '.clean($row['refundFor']); ?></h4>
										</div>
										<form action="" method="post">
											<div class="modal-body">
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="refundDate_edit"><?php echo $refDateField; ?></label>
															<input type="text" class="form-control" name="refundDate" id="refundDate_edit" required="required" value="<?php echo dbDateFormat($row['refundDate']); ?>">
															<span class="help-block"><?php echo $refDateFieldHelp; ?></span>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="refundAmount"><?php echo $refAmtField; ?></label>
															<input type="text" class="form-control" name="refundAmount" required="required" value="<?php echo $row['refundAmount']; ?>">
															<span class="help-block"><?php echo $numbersOnlyHelp; ?></span>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="refundFor"><?php echo $refForField; ?></label>
															<input type="text" class="form-control" name="refundFor" required="required" value="<?php echo clean($row['refundFor']); ?>">
															<span class="help-block"><?php echo $refForFieldHelp; ?></span>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label for="notes"><?php echo $refundNotesField; ?></label>
													<textarea class="form-control" name="notes" rows="3"><?php echo clean($row['refundNotes']); ?></textarea>
												</div>
											</div>
											<div class="modal-footer">
												<input name="refundId" type="hidden" value="<?php echo $row['refundId']; ?>" />
												<button type="input" name="submit" value="editRefund" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
												<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>

							<a data-toggle="modal" href="#deleteRefund" class="btn btn-xs btn-default btn-icon"><i class="fa fa-trash"></i> <?php echo $deleteRefundBtn; ?></a>
							<div class="modal fade" id="deleteRefund" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog text-left">
									<div class="modal-content">
										<form action="" method="post">
											<div class="modal-body">
												<p class="lead"><?php echo $deleteRefundConf; ?> "<?php echo clean($row['refundFor']); ?>"?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="deleteId" value="<?php echo clean($row['refundId']); ?>" />
												<input type="hidden" name="refundFor" value="<?php echo clean($row['refundFor']); ?>" />
												<button type="input" name="submit" value="deleteRefund" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
												<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>
						<?php } ?>

						<div class="total-Amount"><span class="well well-sm lead"><strong><?php echo $totalReceivedText; ?></strong> <?php echo $totalReceived; ?></span></div>

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
		<?php
				}
			} else {
		?>
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
