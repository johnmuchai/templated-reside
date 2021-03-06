<?php
$currentYear	= date('Y');			// Get the Current Year
$currentMonth	= date('F');			// Get the Current Month
$currentDay		= date('d');			// Get the Current Day
$avatarDir		= $set['avatarFolder'];	// Get Avatar Folder from Site Settings

// Get Admin's Role & Avatar
$sql = "SELECT
adminRole,
adminAvatar
FROM
admins
WHERE
adminId = ".$rs_userId;
$res = mysqli_query($mysqli, $sql) or die('-1' . mysqli_error());
$row = mysqli_fetch_assoc($res);

// Get Site Alert Data
$alert = "SELECT
*,
UNIX_TIMESTAMP(alertDate) AS orderDate
FROM
sitealerts
WHERE
alertStart <= DATE_SUB(CURDATE(),INTERVAL 0 DAY) AND
alertExpires >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) OR
isActive = 1
ORDER BY
orderDate DESC";
$alertres = mysqli_query($mysqli, $alert) or die('-2' . mysqli_error());

// Get Leased Tenants Count
$at = "SELECT 'X' FROM users u inner join properties p on u.propertyId=p.propertyId WHERE u.isActive = 1 AND u.isLeased != 0 AND u.isResident = 0 AND p.landlordId=".$rs_managerId;
$atres = mysqli_query($mysqli, $at) or die('-3' . mysqli_error($mysqli)." qry=".$at);
$atcount = mysqli_num_rows($atres);
if ($atcount == 1) { $atcountText = $leasedTenText; } else { $atcountText = $leasedTensText; }

// Get Available Properties Count
$ap = "SELECT 'X' FROM properties WHERE isLeased = 0 and landlordId=".$rs_managerId;
$apres = mysqli_query($mysqli, $ap) or die('-4' . mysqli_error($mysqli));
$apcount = mysqli_num_rows($apres);
if ($apcount == 1) { $apcountText = $availaPropText; } else { $apcountText = $availPropsText; }

// Get Open Service Requests Count
$sr = "SELECT 'X' FROM servicerequests inner join properties on servicerequests.propertyId= properties.propertyId WHERE servicerequests.isClosed = 0 and properties.landlordId=".$rs_managerId;;
$srres = mysqli_query($mysqli, $sr) or die('-5' . mysqli_error($mysqli));
$srcount = mysqli_num_rows($srres);
if ($srcount == 1) { $srcountText = $openServReqText; } else { $srcountText = $openServReqsText; }

if ($set['enablePayments'] == '1') {
	// Get latest payment data
	$payment = "SELECT
	payments.*,
	users.propertyId,
	users.userFirstName,
	users.userLastName,
	properties.propertyName
	FROM
	payments
	LEFT JOIN users ON payments.userId = users.userId
	LEFT JOIN properties ON users.propertyId = properties.propertyId
	WHERE
	properties.landlordId=".$rs_managerId." AND
	payments.isRent = 1 AND
	payments.rentMonth = '".$currentMonth."' AND
	payments.rentYear = '".$currentYear."'";
	$paymentres = mysqli_query($mysqli, $payment) or die('-6' . mysqli_error());

	if(mysqli_num_rows($paymentres) > 0) {
		// Get the Totals
		$totals = "SELECT
		SUM(payments.amountPaid) AS totalPaid,
		SUM(payments.penaltyFee) AS totalFee
		FROM
		payments inner join properties

		ON payments.propertyId = properties.propertyId

		WHERE
		properties.landlordId=".$rs_managerId." AND
		payments.isRent = 1 AND
		payments.rentMonth = '".$currentMonth."' AND
		payments.rentYear = '".$currentYear."'";
		$total = mysqli_query($mysqli, $totals) or die('-7' . mysqli_error());
		$tot = mysqli_fetch_assoc($total);

		// Format the Amounts
		$totreceived = $tot['totalPaid'] + $tot['totalFee'];
		$totalReceived = formatCurrency($totreceived,$currCode);
	} else {
		$totalReceived = '';
	}

	// Get Late Rent data
	// Note: This was a MAJOR Pain in the Arse -- No changes **Unless** you really know what you are doing.
	if($hasPaid = $mysqli->prepare(
		"SELECT
		users.propertyId
		FROM
		users
		LEFT JOIN payments ON users.userId = payments.userId
		LEFT JOIN properties ON users.propertyId=properties.propertyId
		WHERE
		properties.landlordId = ".$rs_managerId." AND
		payments.rentMonth = ? AND
		payments.rentYear = ?"
		))
		$hasPaid->bind_param('ss', $currentMonth, $currentYear);
		$hasPaid->execute();
		$hasPaid->bind_result($propertyId);
		$hasPaid->store_result();
		$totalrows = $hasPaid->num_rows;

		$propids = array();
		while($hasPaid->fetch()) {
			$propids[] = array(
				'propertyId' => $propertyId
			);
		}
		$hasPaid->close();

		// Get the Property ID list from the array
		foreach($propids as $v) $theIds[] = $v['propertyId'];

		if ($totalrows > 0) {
			$list = "'".implode("','",$theIds)."'";
		} else {
			$list = '0';
		}

		// Get the Property/Tenant info to display based on the array
		$today = date("Y-m-d");
		$latepay = "SELECT
		properties.propertyId,
		properties.propertyName,
		properties.propertyAddress,
		properties.propertyRate,
		properties.latePenalty,
properties.unitName,
		leases.leaseStart,
		users.userId,
		users.userFirstName,
		users.userLastName
		FROM
		properties
		LEFT JOIN leases ON properties.propertyId = leases.propertyId
		LEFT JOIN users ON properties.propertyId = users.propertyId
		WHERE
		properties.landlordId=".$rs_managerId." AND
		leases.closed = 0 AND
		users.isResident = 0 AND
		properties.isLeased = 1 AND
		'".$today."' >= leases.leaseStart AND
		properties.propertyId NOT IN (".$list.")";
		$latepayres = mysqli_query($mysqli, $latepay) or die('-8' . mysqli_error());

		// Get latest payment data
		$payment = "SELECT DISTINCT
		payments.*,
		users.propertyId,
		users.userFirstName,
		users.userLastName,
		properties.propertyName
		FROM
		payments
		LEFT JOIN users ON payments.userId = users.userId
		LEFT JOIN properties ON users.propertyId = properties.propertyId
		WHERE
		properties.landlordId=".$rs_managerId." AND
		payments.isRent = 1 AND
		payments.rentMonth = '".$currentMonth."' AND
		payments.rentYear = '".$currentYear."'
		GROUP BY users.propertyId";
		$paymentres = mysqli_query($mysqli, $payment) or die('-9' . mysqli_error($mysqli));

		if(mysqli_num_rows($paymentres) > 0) {
			// Get the Totals
			$totals = "SELECT
			SUM(amountPaid) AS totalPaid,
			SUM(penaltyFee) AS totalFee
			FROM
			payments
			LEFT JOIN users ON users.propertyId = payments.userId
			LEFT JOIN properties ON users.propertyId = properties.propertyId
			WHERE
			properties.landlordId=".$rs_managerId." AND
			payments.isRent = 1 AND
			payments.rentMonth = '".$currentMonth."' AND
			payments.rentYear = '".$currentYear."'";
			$total = mysqli_query($mysqli, $totals) or die('-10' . mysqli_error());
			$tot = mysqli_fetch_assoc($total);

			// Format the Amounts
			$totreceived = $tot['totalPaid'] + $tot['totalFee'];
			$totalReceived = formatCurrency($totreceived,$currCode);
		} else {
			$totalReceived = '';
		}
	}

	// Get Available Properties
	$avail = "SELECT * FROM properties WHERE isLeased = 0 AND properties.landlordId=".$rs_managerId;
	$availres = mysqli_query($mysqli, $avail) or die('-11' . mysqli_error());

	$dashPage = 'true';
	$pageTitle = $dashboardPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'dashboard';

	include 'includes/header.php';
	?>
	<div class="row">
            <div class="col-lg-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Orders</h4>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                            First name
                          </th>
                          <th>
                            Progress
                          </th>
                          <th>
                            Amount
                          </th>
                          <th>
                            Sales
                          </th>
                          <th>
                            Deadline
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="font-weight-medium">
                            1
                          </td>
                          <td>
                            Herman Beck
                          </td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div>
                          </td>
                          <td>
                            $ 77.99
                          </td>
                          <td class="text-danger"> 53.64%
                            <i class="mdi mdi-arrow-down"></i>
                          </td>
                          <td>
                            May 15, 2015
                          </td>
                        </tr>
                        <tr>
                          <td class="font-weight-medium">
                            2
                          </td>
                          <td>
                            Messsy Adam
                          </td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-danger progress-bar-striped" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div>
                          </td>
                          <td>
                            $245.30
                          </td>
                          <td class="text-success"> 24.56%
                            <i class="mdi mdi-arrow-up"></i>
                          </td>
                          <td>
                            July 1, 2015
                          </td>
                        </tr>
                        <tr>
                          <td class="font-weight-medium">
                            3
                          </td>
                          <td>
                            John Richards
                          </td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-warning progress-bar-striped" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div>
                          </td>
                          <td>
                            $138.00
                          </td>
                          <td class="text-danger"> 28.76%
                            <i class="mdi mdi-arrow-down"></i>
                          </td>
                          <td>
                            Apr 12, 2015
                          </td>
                        </tr>
                        <tr>
                          <td class="font-weight-medium">
                            4
                          </td>
                          <td>
                            Peter Meggik
                          </td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div>
                          </td>
                          <td>
                            $ 77.99
                          </td>
                          <td class="text-danger"> 53.45%
                            <i class="mdi mdi-arrow-down"></i>
                          </td>
                          <td>
                            May 15, 2015
                          </td>
                        </tr>
                        <tr>
                          <td class="font-weight-medium">
                            5
                          </td>
                          <td>
                            Edward
                          </td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-danger progress-bar-striped" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div>
                          </td>
                          <td>
                            $ 160.25
                          </td>
                          <td class="text-success"> 18.32%
                            <i class="mdi mdi-arrow-up"></i>
                          </td>
                          <td>
                            May 03, 2015
                          </td>
                        </tr>
                        <tr>
                          <td class="font-weight-medium">
                            6
                          </td>
                          <td>
                            Henry Tom
                          </td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-warning progress-bar-striped" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div>
                          </td>
                          <td>
                            $ 150.00
                          </td>
                          <td class="text-danger"> 24.67%
                            <i class="mdi mdi-arrow-down"></i>
                          </td>
                          <td>
                            June 16, 2015
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
	<div class="container page_block noTopBorder">
		<hr class="mt-0" />

		<?php if ($msgBox) { echo $msgBox; } ?>

		<div class="row">
			<div class="col-md-6">
				<p class="lead mb-0">
					<!-- <img alt="Admin Avatar" src="../<?php echo $avatarDir.$row['adminAvatar']; ?>" class="avatarImage pull-left mt-5" /> -->
					<?php echo $welcomeAdmText.' '.$row['adminRole'].' '.$rs_adminName; ?>
				</p>
				<p class="mt-0"><?php echo $theText.' '.$set['siteName'].' '.$welcomeAdmQuip; ?></p>
			</div>
			<div class="col-md-6">
				<?php
				if(mysqli_num_rows($alertres) > 0) {
					while ($rows = mysqli_fetch_assoc($alertres)) {
						// If Start Date is set, use the Start date, else the Date the Alert was created
						if (!is_null($rows['alertStart'])) { $noticeDate = dateFormat($rows['alertStart']); } else { $noticeDate = dateFormat($rows['alertDate']); }
						?>
						<div class="box">
							<span class="box-notify"><?php echo $noticeDate; ?></span>
							<h4 class="mt-0"><i class="fa fa-bullhorn"></i> &nbsp; <?php echo clean($rows['alertTitle']); ?></h4>
							<p><?php echo nl2br(htmlspecialchars_decode($rows['alertText'])); ?></p>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>

		<hr />

		<div class="row mb-10">
			<div class="col-sm-4">
				<div class="dashblocks info">
					<div class="dashblocksBody">
						<i class="boxIcon fa fa-group"></i>
						<span><?php echo $atcount; ?></span>
					</div>

					<div class="dashblocksFooter"><a href="index.php?action=leasedTenants"><?php echo $atcountText; ?></a></div>

				</div>
			</div>
			<div class="col-sm-4">
				<div class="dashblocks success">
					<div class="dashblocksBody">
						<i class="boxIcon fa fa-building"></i>
						<span><?php echo $apcount; ?></span>
					</div>

					<div class="dashblocksFooter"><a href="index.php?action=unleasedProperties"><?php echo $apcountText; ?></a></div>

				</div>
			</div>
			<div class="col-sm-4">
				<div class="dashblocks warning">
					<div class="dashblocksBody">
						<i class="boxIcon fa fa-wrench"></i>
						<span><?php echo $srcount; ?></span>
					</div>

					<div class="dashblocksFooter"><a href="index.php?action=activeRequests"><?php echo $srcountText; ?></a></div>

				</div>
			</div>
		</div>
	</div>

	

	<?php
	if ($set['enablePayments'] == '1') {
		if ($currentDay > '5') {
			?>
			<div class="row">
    			<div class="col-lg-12 grid-margin">
        			<div class="card">
            			<div class="card-body">
                			<div class="table-responsive">
				<h3><?php echo $lateRentH3.' '.$currentMonth; ?></h3>
				<?php if(mysqli_num_rows($latepayres) > 0) { ?>
					<table id="lateRent" class="display" cellspacing="0">
						<thead>
							<tr>
								<th><?php echo $unitHead; ?></th>
								<th><?php echo $propertyMother; ?></th>
								<th><?php echo $addressHead; ?></th>
								<th><?php echo $tenantHead; ?></th>
								<th class="text-center"><?php echo $rentAmtHead; ?></th>
								<th class="text-center"><?php echo $lateFeeHead; ?></th>
								<th class="text-center"><?php echo $totalDueHead; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							while ($late = mysqli_fetch_assoc($latepayres)) {
								// Get the Total Due for each Property
								$total = $late['propertyRate'] + $late['latePenalty'];
								$totalDue = formatCurrency($total,$currCode);
								?>
								<tr>
									<td>
										<a href="index.php?action=viewProperty&propertyId=<?php echo $late['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
											 <?php echo clean($late['unitName']); ?>
										</a>
									</td>
									<td>
										<a href="index.php?action=viewParent&propertyId=<?php echo $late['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
											<?php echo clean($late['propertyName']); ?>
										</a>
									</td>
									<td><?php echo clean($late['propertyAddress']); ?></td>
									<td>
										<a href="index.php?action=viewTenant&userId=<?php echo $late['userId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewTenantText; ?>">
											<?php echo clean($late['userFirstName']).' '.clean($late['userLastName']); ?>
										</a>
									</td>
									<td class="text-center"><?php echo formatCurrency($late['propertyRate'],$currCode); ?></td>
									<td class="text-center"><?php echo formatCurrency($late['latePenalty'],$currCode); ?></td>
									<td class="text-danger text-center">
										<strong data-toggle="tooltip" data-placement="left" title="Rent Amount + Late Fee"><?php echo $totalDue; ?></strong>
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				<?php } else { ?>
					<div class="alertMsg default mb-20">
						<div class="msgIcon pull-left">
							<i class="fa fa-info-circle"></i>
						</div>
						<?php echo $noLateRentMsg; ?>
					</div>
				<?php } ?>
				</div>
				</div>
				</div>
				</div>
				</div>
			<?php
		}
	}
	?>

	<?php
	if ($set['enablePayments'] == '1') {
		if ((checkArray('ACCTRPT', $auths)) || $rs_isAdmin != '') {
			?>
			<div class="container page_block mt-20">
				<h3><?php echo $rentRcvdForH3.' '.$currentMonth; ?></h3>
				<?php
				if(mysqli_num_rows($paymentres) > 0) {
					?>
					<table id="rentReceived" class="display" cellspacing="0">
						<thead>
							<tr>
								<th><?php echo $unitHead; ?></th>
								<th><?php echo $propertyMother; ?></th>
								<th><?php echo $tenantHead; ?></th>
								<th class="text-center"><?php echo $paymentDateHead; ?></th>
								<th class="text-center"><?php echo $renatlMonthHead; ?></th>
								<th class="text-center"><?php echo $amountHead; ?></th>
								<th class="text-center"><?php echo $lateFeePaidHead; ?></th>
								<th class="text-center"><?php echo $totalPaidHead; ?></th>
								<th></th>
							</tr>
						</thead>

						<tbody>
							<?php
							while ($pay = mysqli_fetch_assoc($paymentres)) {
								// Format the Amounts
								$paymentAmount = formatCurrency($pay['amountPaid'],$currCode);
								if ($pay['penaltyFee'] != '') { $penaltyFee = formatCurrency($pay['penaltyFee'],$currCode); } else { $penaltyFee = ''; }
								$total = $pay['amountPaid'] + $pay['penaltyFee'];
								$totalPaid = formatCurrency($total,$currCode);

								// Check for Refunds
								if ($pay['hasRefund'] == '1') { $hasRefund = '<sup><i class="fa fa-asterisk tool-tip text-info" title="'.$amtRefRefText.'"></i></sup>'; } else { $hasRefund = ''; }
								?>
								<tr>
									<td>
										<a href="index.php?action=viewProperty&propertyId=<?php echo $pay['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
											 <?php echo clean($pay['unitName']); ?>
										</a>
									</td>
									<td>
										<a href="index.php?action=viewParent&propertyId=<?php echo $pay['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
											<?php echo clean($pay['propertyName']); ?>
										</a>
									</td>
									<td>
										<a href="index.php?action=viewTenant&userId=<?php echo $pay['userId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewTenantText; ?>">
											<?php echo clean($pay['userFirstName']).' '.clean($pay['userLastName']); ?>
										</a>
									</td>
									<td class="text-center"><?php echo dateFormat($pay['paymentDate']); ?></td>
									<td class="text-center"><?php echo $pay['rentMonth']; ?></td>
									<td class="text-center"><?php echo $paymentAmount.' '.$hasRefund; ?></td>
									<td class="text-center"><?php echo $penaltyFee; ?></td>
									<td class="text-center"><?php echo $totalPaid." ".$hasRefund; ?></td>
									<td>
										<a href="index.php?action=receipt&payId=<?php echo $pay['payId']; ?>" target="_blank" data-toggle="tooltip" data-placement="left" title="<?php echo $receiptText; ?>">
											<i class="fa fa-print text-info"></i>
										</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>

					<span class="reportTotal"><strong><?php echo $totalRecvdForText.' '.$currentMonth; ?>:</strong> <?php echo $totalReceived; ?></span>
					<div class="clearfix mb-20"></div>
					<?php
				} else {
					?>
					<div class="alertMsg default mb-20">
						<div class="msgIcon pull-left">
							<i class="fa fa-info-circle"></i>
						</div>
						<?php echo $noPayMadeText; ?>
					</div>
					<?php
				}
				echo '</div>';
			}
		}
		?>
	</div>

	<div class="container page_block mt-20">
		<h3><?php echo $availPropH3; ?></h3>
		<?php if(mysqli_num_rows($availres) > 0) { ?>
			<table id="availProp" class="display" cellspacing="0">
				<thead>
					<tr>
						<th><?php echo $unitHead; ?></th>
						<th><?php echo $propertyMother; ?></th>
						<th><?php echo $addressHead; ?></th>
						<th class="text-center"><?php echo $rateText; ?></th>
						<th class="text-center"><?php echo $depositText; ?></th>
						<th class="text-center"><?php echo $petsText; ?></th>
						<th class="text-center"><?php echo $bedsText; ?></th>
						<th class="text-center"><?php echo $bathsText; ?></th>
						<th class="text-center"><?php echo $sixeText; ?></th>
					</tr>
				</thead>

				<tbody>
					<?php
					while ($ap = mysqli_fetch_assoc($availres)) {
						if ($ap['petsAllowed'] == '0') { $petsAllowed = $noBtn; } else { $petsAllowed = $yesBtn; }
						?>
						<tr>
							<td>
								<a href="index.php?action=viewProperty&propertyId=<?php echo $ap['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
									<?php echo clean($ap['unitName']); ?>
								</a>
							</td>
							<td>
								<a href="index.php?action=viewParent&propertyId=<?php echo $ap['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
									<?php echo clean($ap['propertyName']); ?>
								</a>
							</td>
							<td><?php echo clean($ap['propertyAddress']); ?></td>
							<td class="text-center"><?php echo formatCurrency($ap['propertyRate'],$currCode); ?></td>
							<td class="text-center"><?php echo formatCurrency($ap['propertyDeposit'],$currCode); ?></td>
							<td class="text-center"><?php echo $petsAllowed; ?></td>
							<td class="text-center"><?php echo clean($ap['bedrooms']); ?></td>
							<td class="text-center"><?php echo clean($ap['bathrooms']); ?></td>
							<td class="text-center"><?php echo clean($ap['propertySize']); ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } else { ?>
			<div class="alertMsg default mb-20">
				<div class="msgIcon pull-left">
					<i class="fa fa-info-circle"></i>
				</div>
				<?php echo $noPropFoundText; ?>
			</div>
		<?php } ?>
	</div>
