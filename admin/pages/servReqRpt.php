<?php
	$rptError = $reportType = $runRpt = $fdate = $tdate = '';
	$where = array();
	
	switch ($_POST['rptType']) {
		case "srvRequests":
			$srvType = $mysqli->real_escape_string($_POST['srvType']);
			
			if ($srvType == 'all') {
				$where[] = 'servicerequests.isClosed IN ("1","0")';
				$reportType = $serviceReqRptTitle1;
			} else if ($srvType == 'open') {
				$where[] = 'servicerequests.isClosed IN ("0")';
				$reportType = $serviceReqRptTitle2;
			} else if ($srvType == 'closed') {
				$where[] = 'servicerequests.isClosed IN ("1")';
				$reportType = $serviceReqRptTitle3;
			} else {
				$rptError = 'true';
				$reportType = $reportErrorH3;
			}
			
			if (!empty($_POST['propertyId']) && is_array($_POST['propertyId']) && !in_array('all',$_POST['propertyId'])) {
				$pids = array();
				foreach ($_POST['propertyId'] as $propertyId) {
				  $pids[] = $mysqli->real_escape_string($propertyId);
				}
				$propIds = '"'.implode('", "', $pids).'"';
				$where[] = 'servicerequests.requestId IN ('.$propIds.')';
			}
			
			if (!empty($_POST['fromDate'])) {
				$fromDate = $mysqli->real_escape_string($_POST['fromDate']);
				$where[] = 'servicerequests.requestDate >= "'.$fromDate.'"';
				
				$fdate = dateFormat($fromDate);
			}
			if (!empty($_POST['toDate'])) {
				$toDate = $mysqli->real_escape_string($_POST['toDate']);
				$where[] = 'servicerequests.requestDate <= "'.$toDate.'"';
				
				$tdate = dateFormat($toDate);
			}
			
			
			if (!empty($where)) {
				$whereSql = "WHERE\n" . implode("\nAND ",$where);
			}
			
			// Get Open Service Request Data
			$qry = 'SELECT
						servicerequests.*,
						properties.propertyName,
						servicepriority.priorityTitle,
						servicestatus.statusTitle,
						users.userFirstName,
						users.userLastName,
						admins.adminName AS assignedAdmin,
						(
							SELECT admins.adminName
							FROM admins
							WHERE admins.adminId = servicerequests.adminId
							LIMIT 1
						) AS adminName
					FROM
						servicerequests
						LEFT JOIN properties ON servicerequests.propertyId = properties.propertyId
						LEFT JOIN servicepriority ON servicerequests.requestPriority = servicepriority.priorityId
						LEFT JOIN servicestatus ON servicerequests.requestStatus = servicestatus.statusId
						LEFT JOIN admins ON servicerequests.assignedTo = admins.adminId
						LEFT JOIN users ON servicerequests.userId = users.userId '.$whereSql;
			$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
			
			$runRpt = 'serviceReq';
		break;
		case "totalCosts":
			$reportType = $servReqRptType1;

			if (!empty($_POST['propertyId']) && is_array($_POST['propertyId']) && !in_array('all',$_POST['propertyId'])) {
				$pids = array();
				foreach ($_POST['propertyId'] as $propertyId) {
				  $pids[] = $mysqli->real_escape_string($propertyId);
				}
				$propIds = '"'.implode('", "', $pids).'"';
				$where[] = 'serviceexpense.propertyId IN ('.$propIds.')';
			}
			
			if (!empty($_POST['fromDate'])) {
				$fromDate = $mysqli->real_escape_string($_POST['fromDate']);
				$where[] = 'serviceexpense.dateOfExpense >= "'.$fromDate.'"';
				
				$fdate = dateFormat($fromDate);
			}
			if (!empty($_POST['toDate'])) {
				$toDate = $mysqli->real_escape_string($_POST['toDate']);
				$where[] = 'serviceexpense.dateOfExpense <= "'.$toDate.'"';
				
				$tdate = dateFormat($toDate);
			}
			
			
			if (!empty($where)) {
				$whereSql = "WHERE\n" . implode("\nAND ",$where);
			}
			
			// Get Service Expense Data
			$qry = 'SELECT
						serviceexpense.*,
						servicerequests.requestTitle,
						users.userFirstName,
						users.userLastName,
						properties.propertyName,
						admins.adminName
					FROM
						serviceexpense
						LEFT JOIN servicerequests on serviceexpense.requestId = servicerequests.requestId
						LEFT JOIN users ON servicerequests.userId = users.userId
						LEFT JOIN properties ON serviceexpense.propertyId = properties.propertyId
						LEFT JOIN admins ON serviceexpense.adminId = admins.adminId '.$whereSql;
			$res = mysqli_query($mysqli, $qry) or die('-2' . mysqli_error());
			
			$runRpt = 'expense';
		break;
		default:
			$rptError = 'true';
			$reportType = $reportErrorH3;
		break;
	}
	
	if ($rptError == '') {
		// Add Recent Activity
		$activityType = '23';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$adminRptAct1.' '.$reportType.' '.$adminRptAct2;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
	} else {
		// Add Recent Activity
		$activityType = '23';
		$rs_uid = '0';
		$activityTitle = $adminRptAct3.' '.$reportType.' '.$adminRptAct2;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
	}
	
	$managePage = 'true';
	$pageTitle = $serviceReqRptPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'servReqRpt';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ($rptError == '') {
				if ((checkArray('SERVRPT', $auths)) || $rs_isAdmin != '') {
					if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle; ?></h3>
				<p class="lead mb-0">
					<?php echo $reportType; ?><br />
					<small><?php echo $fromText; ?> <?php echo $fdate; ?> <?php echo $toText; ?> <?php echo $tdate; ?></small>
				</p>

				<?php if ($runRpt == 'serviceReq') { ?>
					<?php if(mysqli_num_rows($res) < 1) { ?>
						<div class="alertMsg default mb-20">
							<div class="msgIcon pull-left">
								<i class="fa fa-info-circle"></i>
							</div>
							<?php echo $nothingToRptMsg; ?>
						</div>
					<?php } else { ?>
						<table id="rpt1" class="display" cellspacing="0">
							<thead>
								<tr>
									<th><?php echo $propertyHead; ?></th>
									<th><?php echo $createdByHead; ?></th>
									<th><?php echo $assignedToHead; ?></th>
									<th><?php echo $requestHead; ?></th>
									<th class="text-center"><?php echo $openClosedHead; ?></th>
									<th class="text-center"><?php echo $statusHead; ?></th>
									<th class="text-center"><?php echo $dateSubmittedHead; ?></th>
									<th class="text-center"><?php echo $lastUpdatedHead; ?></th>
								</tr>
							</thead>

							<tbody>
								<?php
									while ($row = mysqli_fetch_assoc($res)) {
										if ($row['userId'] == '0') { $user = '<em>'.clean($row['adminName']).'</em>'; } else { $user = clean($row['userFirstName']).' '.clean($row['userLastName']); }
										if ($row['assignedTo'] == '0') { $assignedAdmin = '<em>'.$unassignedText.'</em>'; } else { $assignedAdmin = clean($row['assignedAdmin']); }
										if ($row['isClosed'] == '0') { $open = $openText; } else { $open = $closedText; }
										if ($row['lastUpdated'] == '0000-00-00 00:00:00') { $lastUpdated = ''; } else { $lastUpdated = dateFormat($row['lastUpdated']); }
								?>
										<tr>
											<td><?php echo clean($row['propertyName']); ?></td>
											<td><?php echo $user; ?></td>
											<td><?php echo $assignedAdmin; ?></td>
											<td><?php echo clean($row['requestTitle']); ?></td>
											<td class="text-center"><?php echo $open; ?></td>
											<td class="text-center"><?php echo clean($row['statusTitle']); ?></td>
											<td class="text-center"><?php echo dateFormat($row['requestDate']); ?></td>
											<td class="text-center"><?php echo $lastUpdated; ?></td>
										</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } ?>
				<?php } else if ($runRpt == 'expense') { ?>
					<?php if(mysqli_num_rows($res) < 1) { ?>
						<div class="alertMsg default mb-20">
							<div class="msgIcon pull-left">
								<i class="fa fa-info-circle"></i>
							</div>
							<?php echo $nothingToRptMsg; ?>
						</div>
					<?php } else { ?>
						<table id="rpt2" class="display" cellspacing="0">
							<thead>
								<tr>
									<th><?php echo $propertyHead; ?></th>
									<th><?php echo $requestHead; ?></th>
									<th class="text-center"><?php echo $expenseDateHead; ?></th>
									<th class="text-center"><?php echo $vendorHead; ?></th>
									<th class="text-center"><?php echo $forHead; ?></th>
									<th class="text-center"><?php echo $expenceAmtHead; ?></th>
									<th class="text-center"><?php echo $enteredByHead; ?></th>
								</tr>
							</thead>

							<tbody>
								<?php
									while ($row = mysqli_fetch_assoc($res)) {
										
								?>
										<tr>
											<td><?php echo clean($row['propertyName']); ?></td>
											<td><?php echo clean($row['requestTitle']); ?></td>
											<td class="text-center"><?php echo dateFormat($row['dateOfExpense']); ?></td>
											<td class="text-center"><?php echo clean($row['vendorName']); ?></td>
											<td class="text-center"><?php echo clean($row['expenseName']); ?></td>
											<td class="text-center"><?php echo formatCurrency($row['expenseCost'],$currCode); ?></td>
											<td class="text-center"><?php echo clean($row['adminName']); ?></td>
										</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } ?>
				<?php } ?>
				
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
			<h3><?php echo $reportErrorH3; ?></h3>
			<div class="alertMsg info mb-20">
				<div class="msgIcon pull-left">
					<i class="fa fa-info-circle"></i>
				</div>
				<?php echo $reportErrorQuip; ?>
			</div>
		<?php } ?>
	</div>