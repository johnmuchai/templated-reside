<?php
		if ($set['enablePayments'] == '1') {
		$leaseId = $mysqli->real_escape_string($_GET['leaseId']);
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$count = 0;

		// Record a Payment Received
		if (isset($_POST['submit']) && $_POST['submit'] == 'recordPay') {
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
				$rentMonth = htmlspecialchars($_POST['rentMonth']);
				$rentYear = htmlspecialchars($_POST['rentYear']);
				$notes = htmlspecialchars($_POST['notes']);
				$propertyId = htmlspecialchars($_POST['propertyId']);
				$propertyName = htmlspecialchars($_POST['propertyName']);
				$userId = htmlspecialchars($_POST['userId']);

				if ($_POST['penaltyFee'] == '') { $penaltyFee = null; } else { $penaltyFee = htmlspecialchars($_POST['penaltyFee']); }
				if ($rentMonth == '...') {
					$isRent = '0';
					$rntMonth = null;
				} else {
					$isRent = '1';
					$rntMonth = $rentMonth;
				}
				if ($rentYear == '') {
					$rntYear = null;
				} else {
					$rntYear = $rentYear;
				}

				$stmt = $mysqli->prepare("
									INSERT INTO
										payments(
											leaseId,
											propertyId,
											adminId,
											userId,
											paymentDate,
											amountPaid,
											penaltyFee,
											paymentFor,
											paymentType,
											isRent,
											rentMonth,
											rentYear,
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
											?,
											?,
											?,
											NOW(),
											?
										)
				");
				$stmt->bind_param('ssssssssssssss',
					$leaseId,
					$propertyId,
					$rs_adminId,
					$userId,
					$paymentDate,
					$amountPaid,
					$penaltyFee,
					$paymentFor,
					$paymentType,
					$isRent,
					$rntMonth,
					$rntYear,
					$notes,
					$ipAddress
				);
				$stmt->execute();
				$stmt->close();

				// Add Recent Activity
				$activityType = '2';
				$rs_uid = '0';
				$activityTitle = $rs_adminName.' '.$savePayAct.' "'.$propertyName.'"';
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

				$msgBox = alertBox($savePayMsg." \"".$propertyName."\" ".$newDiscCmtMsg2, "<i class='fa fa-check-square'></i>", "success");

				// Clear the Form of values
				$_POST['paymentDate'] = $_POST['paymentFor'] = $_POST['amountPaid'] = $_POST['penaltyFee'] = $_POST['paymentType'] = $_POST['notes'] = '';
			}
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
				// Clear the Form of values
				$_POST['refundDate'] = $_POST['refundAmount'] = $_POST['refundFor'] = $_POST['notes'] = '';
			}
		}

		// Delete Refund
		if (isset($_POST['submit']) && $_POST['submit'] == 'deleteRefund') {
			$deleteId = htmlspecialchars($_POST['deleteId']);
			$payId = htmlspecialchars($_POST['payId']);
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

			$msgBox = alertBox($editRefMsg." \"".$refundFor."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");
		}

		// Get Payment Data
		$qry = "SELECT * FROM payments WHERE leaseId = ".$leaseId;
		$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());

		// Get the Totals
		$totals = "SELECT
					SUM(amountPaid) AS totalPaid,
					SUM(penaltyFee) AS totalFee
				FROM
					payments
				WHERE
					leaseId = ".$leaseId;
		$total = mysqli_query($mysqli, $totals) or die('-2' . mysqli_error());
		$tot = mysqli_fetch_assoc($total);

		$reftotals = "SELECT
						SUM(refundAmount) AS refundAmount
					FROM
						refunds
					WHERE
						leaseId = ".$leaseId;
		$totRef = mysqli_query($mysqli, $reftotals) or die('-3' . mysqli_error());
		$tr = mysqli_fetch_assoc($totRef);

		// Format the Amounts
		$totreceived = $tot['totalPaid'] + $tot['totalFee'] - $tr['refundAmount'];
		$totalReceived = formatCurrency($totreceived,$currCode);

		// Get Refund Data
		$sql = "SELECT * FROM refunds WHERE leaseId = ".$leaseId;
		$results = mysqli_query($mysqli, $sql) or die('-4' . mysqli_error());

		// Get Property, Lease & User Data
		$sql = "SELECT
					users.userId,
					CONCAT(users.userFirstName,' ',users.userLastName) AS user,
					properties.propertyId,
					properties.propertyName,
					leases.leaseId,
					leases.leaseTerm,
					leases.leaseStart,
					leases.leaseEnd,
					leases.closed
				FROM
					users
					LEFT JOIN properties ON users.propertyId = properties.propertyId
					LEFT JOIN leases ON users.leaseId = leases.leaseId
				WHERE
					users.leaseId = ".$leaseId." AND
					users.isResident = 0";
		$result = mysqli_query($mysqli, $sql) or die('-5' . mysqli_error());
		$rows = mysqli_fetch_assoc($result);

		if ($rows['closed'] == '0') { $status = $activeTabTitle; } else { $status = $inactClosedText; }

		if (isset($_GET['deleted']) && $_GET['deleted'] == 'true') {
			$msgBox = alertBox("The Payment for \"".clean($rows['propertyName'])."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");
		}
	}

	$propPage = 'true';
	$pageTitle = $viewPaymentsPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet"><link rel="stylesheet" type="text/css" href="../css/datetimepicker.css" /><link href="../css/chosen.css" rel="stylesheet">';
	$dataTables = 'true';
	$datePicker = 'true';
	$chosen = 'true';
	$jsFile = 'viewPayments';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ($set['enablePayments'] == '1') {
			if($rs_managerId!=""){ //	if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<input type="hidden" id="weekStart" value="<?php echo $set['weekStart']; ?>" />

				<div class="row mb-20">
					<div class="col-md-3">
						<ul class="list-group mt-20">
							<li class="list-group-item"><strong><?php echo $newPaymentEmail2; ?></strong>
								<a href="index.php?action=viewProperty&propertyId=<?php echo $rows['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
									<?php echo clean($rows['propertyName']); ?> - <?php echo clean($row['unitName']); ?>
								</a>
							</li>
							<li class="list-group-item"><strong><?php echo $tenantNameText; ?>:</strong>
								<a href="index.php?action=viewTenant&userId=<?php echo $rows['userId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewTenantText; ?>">
									<?php echo clean($rows['user']); ?>
								</a>
							</li>
							<li class="list-group-item"><strong><?php echo $leaseStatusText; ?>:</strong> <?php echo $status; ?></li>
							<li class="list-group-item">
								<strong><?php echo $leaseTermText; ?></strong>
								<?php echo clean($rows['leaseTerm']); ?><br />
								<small><?php echo shortDateFormat($rows['leaseStart']).' &mdash; '.shortDateFormat($rows['leaseEnd']); ?></small>
							</li>
						</ul>

						<a data-toggle="modal" href="#recordPay" class="btn btn-sm btn-success btn-icon"><i class="fa fa-credit-card"></i> <?php echo $recPayRecvdBtn; ?></a>
						<div class="modal fade" id="recordPay" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
										<h4 class="modal-title"><?php echo $recPayRecvdText; ?></h4>
									</div>
									<form action="" method="post">
										<div class="modal-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="paymentDate"><?php echo $datePayRcvdField; ?></label>
														<input type="text" class="form-control" name="paymentDate" id="paymentDate" required="required" value="<?php echo isset($_POST['paymentDate']) ? $_POST['paymentDate'] : ''; ?>" />
														<span class="help-block"><?php echo $datePayRcvdFieldHelp; ?></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="paymentFor"><?php echo $paymentForHead; ?></label>
														<input type="text" class="form-control" name="paymentFor" id="paymentFor" required="required" value="<?php echo isset($_POST['paymentFor']) ? $_POST['paymentFor'] : ''; ?>" />
														<span class="help-block"><?php echo $payForFieldHelp; ?></span>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="amountPaid"><?php echo $paymentAmtField; ?></label>
														<input type="text" class="form-control" name="amountPaid" id="amountPaid" required="required" value="<?php echo isset($_POST['amountPaid']) ? $_POST['amountPaid'] : ''; ?>" />
														<span class="help-block"><?php echo $payAmtHelp; ?></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="penaltyFee"><?php echo $latePayFeeField; ?></label>
														<input type="text" class="form-control" name="penaltyFee" id="penaltyFee" value="<?php echo isset($_POST['penaltyFee']) ? $_POST['penaltyFee'] : ''; ?>" />
														<span class="help-block"><?php echo $latePayFeeFieldHelp; ?></span>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="paymentType"><?php echo $payTypeField; ?></label>
														<input type="text" class="form-control" name="paymentType" id="paymentType" required="required" value="<?php echo isset($_POST['paymentType']) ? $_POST['paymentType'] : ''; ?>" />
														<span class="help-block"><?php echo $payTypeFieldHelp; ?></span>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="rentMonth"><?php echo $rentMonthField; ?></label>
														<select class="form-control chosen-select" name="rentMonth" id="rentMonth">
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
														<input type="text" class="form-control" name="rentYear" id="rentYear" value="<?php echo isset($_POST['rentYear']) ? $_POST['rentYear'] : ''; ?>" />
														<span class="help-block"><?php echo $rentYearFeildHelp; ?></span>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label for="notes"><?php echo $paymentNotesText; ?></label>
												<textarea class="form-control" name="notes" id="notes" rows="3"><?php echo isset($_POST['notes']) ? $_POST['notes'] : ''; ?></textarea>
												<span class="help-block"><?php echo $payNotesQuip; ?></span>
											</div>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="propertyId" value="<?php echo clean($rows['propertyId']); ?>" />
											<input type="hidden" name="propertyName" value="<?php echo clean($rows['propertyName']); ?>" />
											<input type="hidden" name="userId" value="<?php echo clean($rows['userId']); ?>" />
											<button type="input" name="submit" value="recordPay" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $savePaymentBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-9">
						<h3><?php echo $propPayRecvdH3; ?></h3>
						<table id="payments" class="display" cellspacing="0">
							<thead>
								<tr>
									<th><?php echo $paymentDateHead; ?></th>
									<th class="text-center"><?php echo $paymentForHead; ?></th>
									<th class="text-center"><?php echo $renatlMonthHead; ?></th>
									<th class="text-center"><?php echo $amountHead; ?></th>
									<th class="text-center"><?php echo $lateFeePaidHead; ?></th>
									<th class="text-center"><?php echo $totalPaidHead; ?></th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								<?php
									while ($row = mysqli_fetch_assoc($res)) {
										// Format the Amounts
										$paymentAmount = formatCurrency($row['amountPaid'],$currCode);
										if ($row['penaltyFee'] != '') { $penaltyFee = formatCurrency($row['penaltyFee'],$currCode); } else { $penaltyFee = ''; }
										$total = $row['amountPaid'] + $row['penaltyFee'];
										$totalPaid = formatCurrency($total,$currCode);

										// Check for Refunds
										$refunds = "SELECT
														SUM(refundAmount) AS refundAmount
													FROM
														refunds
													WHERE
														payId = ".$row['payId'];
										$refTotal = mysqli_query($mysqli, $refunds) or die('-6' . mysqli_error());
										$refTot = mysqli_fetch_assoc($refTotal);
										// Format the Amount
										$newTotal = $row['amountPaid'] + $row['penaltyFee'] - $refTot['refundAmount'];
										$newAmt = formatCurrency($newTotal,$currCode);

										if ($row['hasRefund'] == '1') {
											$totPaid = '<span data-toggle="tooltip" data-placement="left" title="'.$amtReflectsRefText.'">'.$newAmt.' <sup><i class="fa fa-asterisk text-warning"></i></sup></span>';
										} else {
											$totPaid = $totalPaid;
										}
								?>
										<tr>
											<td><?php echo dateFormat($row['paymentDate']); ?></td>
											<td class="text-center">
												<a href="index.php?action=paymentDetail&payId=<?php echo $row['payId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $payDetailsOptText; ?>">
													<?php echo clean($row['paymentFor']); ?>
												</a>
											</td>
											<td class="text-center"><?php echo clean($row['rentMonth']); ?></td>
											<td class="text-center"><?php echo $paymentAmount; ?></td>
											<td class="text-center"><?php echo $penaltyFee; ?></td>
											<td class="text-center"><?php echo $totPaid; ?></td>
											<td class="text-right">
												<a href="index.php?action=receipt&payId=<?php echo $row['payId']; ?>" target="_blank">
													<i class="fa fa-print text-info" data-toggle="tooltip" data-placement="left"title="<?php echo $receiptText; ?>"></i>
												</a>
											</td>
										</tr>
								<?php } ?>
							</tbody>
						</table>
						<span class="reportTotal"><strong><?php echo $totRecvdforLease; ?>:</strong> <?php echo $totalReceived; ?></span>

						<hr />
						<h3><?php echo $propRefIssH3; ?></h3>
						<?php if(mysqli_num_rows($results) < 1) { ?>
							<div class="alertMsg default mb-20">
								<div class="msgIcon pull-left">
									<i class="fa fa-info-circle"></i>
								</div>
								<?php echo $noRefIssLeaseMsg; ?>
							</div>
						<?php } else { ?>
							<table id="refunds" class="display" cellspacing="0">
								<thead>
									<tr>
										<th><?php echo $refundDateHead; ?></th>
										<th class="text-center"><?php echo $refunfForHead; ?></th>
										<th class="text-center"><?php echo $refundAmtHead; ?></th>
										<th></th>
									</tr>
								</thead>

								<tbody>
									<?php
										while ($col = mysqli_fetch_assoc($results)) {
											// Format the Amounts
											$paymentAmount = formatCurrency($row['amountPaid'],$currCode);
											if ($row['penaltyFee'] != '') { $penaltyFee = formatCurrency($row['penaltyFee'],$currCode); } else { $penaltyFee = ''; }
											$total = $row['amountPaid'] + $row['penaltyFee'];
											$totalPaid = formatCurrency($total,$currCode);
									?>
											<tr>
												<td><?php echo dateFormat($col['refundDate']); ?></td>
												<td class="text-center"><?php echo clean($col['refundFor']); ?></td>
												<td class="text-center"><?php echo formatCurrency($col['refundAmount'],$currCode); ?></td>
												<td class="text-right">
													<a data-toggle="modal" href="#editRefund<?php echo $col['refundId']; ?>" class="text-warning">
														<i class="fa fa-pencil" data-toggle="tooltip" data-placement="left" title="<?php echo $editRefBtn; ?>"></i>
													</a>
													&nbsp;
													<a data-toggle="modal" href="#deleteRefund<?php echo $col['refundId']; ?>" class="text-danger">
														<i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="<?php echo $deleteRefBtn; ?>"></i>
													</a>

													<div class="modal fade" id="editRefund<?php echo $col['refundId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-lg text-left">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
																	<h4 class="modal-title"><?php echo $editRefH4; ?> <?php echo clean($col['refundFor']); ?></h4>
																</div>
																<form action="" method="post">
																	<div class="modal-body">
																		<div class="row">
																			<div class="col-md-4">
																				<div class="form-group">
																					<label for="refundDate_<?php echo $count; ?>"><?php echo $refDateField; ?></label>
																					<input type="text" class="form-control" name="refundDate" id="refundDate_<?php echo $count; ?>" required="required" value="<?php echo dbDateFormat($col['refundDate']); ?>">
																					<span class="help-block"><?php echo $refDateFieldHelp; ?></span>
																				</div>
																			</div>
																			<div class="col-md-4">
																				<div class="form-group">
																					<label for="refundAmount"><?php echo $refAmtField; ?></label>
																					<input type="text" class="form-control" name="refundAmount" required="required" value="<?php echo $col['refundAmount']; ?>">
																					<span class="help-block"><?php echo $numbersOnlyHelp; ?></span>
																				</div>
																			</div>
																			<div class="col-md-4">
																				<div class="form-group">
																					<label for="refundFor"><?php echo $refForField; ?></label>
																					<input type="text" class="form-control" name="refundFor" required="required" value="<?php echo clean($col['refundFor']); ?>">
																					<span class="help-block"><?php echo $refForFieldHelp; ?></span>
																				</div>
																			</div>
																		</div>
																		<div class="form-group">
																			<label for="notes"><?php echo $refundNotesField; ?></label>
																			<textarea class="form-control" name="notes" rows="3"><?php echo clean($col['notes']); ?></textarea>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<input name="refundId" type="hidden" value="<?php echo $col['refundId']; ?>" />
																		<button type="input" name="submit" value="editRefund" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
																		<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
																	</div>
																</form>
															</div>
														</div>
													</div>

													<div class="modal fade" id="deleteRefund<?php echo $col['refundId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog text-left">
															<div class="modal-content">
																<form action="" method="post">
																	<div class="modal-body">
																		<p class="lead"><?php echo $deleteRefConf; ?> "<?php echo clean($col['refundFor']); ?>"?</p>
																	</div>
																	<div class="modal-footer">
																		<input type="hidden" name="deleteId" value="<?php echo $col['refundId']; ?>" />
																		<input type="hidden" name="payId" value="<?php echo $col['payId']; ?>" />
																		<input type="hidden" name="refundFor" value="<?php echo clean($col['refundFor']); ?>" />
																		<button type="input" name="submit" value="deleteRefund" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
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
						<?php } ?>
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
