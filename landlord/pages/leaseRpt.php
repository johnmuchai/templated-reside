<?php
	$rptError = $reportType = '';
	$where = array();
	
	$leaseType = $mysqli->real_escape_string($_POST['leaseType']);
			
	if ($leaseType == 'all') {
		$where[] = 'closed IN ("1","0")';
		$reportType = $leaseRptTitle;
	} else if ($leaseType == 'active') {
		$where[] = 'closed IN ("0")';
		$reportType = $leaseRptTitle1;
	} else if ($leaseType == 'inactive') {
		$where[] = 'closed IN ("1")';
		$reportType = $leaseRptTitle2;
	} else {
		$rptError = 'true';
		$reportType = $reportErrorH3;
	}
	
	if (!empty($where)) {
		$whereSql = "WHERE\n" . implode("\nOR ",$where);
	}
	
	if ($rptError == '') {
		// Get Data
		$qry = 'SELECT * FROM leases '.$whereSql;
		$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());

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
	$pageTitle = $leaseRptPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'leaseRpt';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ($rptError == '') {
				if ((checkArray('LEASERPT', $auths)) || $rs_isAdmin != '') {
					if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle; ?></h3>
				<p class="lead mb-0"><?php echo $reportType; ?></p>

				<?php if(mysqli_num_rows($res) < 1) { ?>
					<div class="alertMsg default mb-20">
						<div class="msgIcon pull-left">
							<i class="fa fa-info-circle"></i>
						</div>
						<?php echo $nothingToRptMsg; ?>
					</div>
				<?php } else { ?>
					<table id="rpt" class="display" cellspacing="0">
						<thead>
							<tr>
								<th><?php echo $propertyHead; ?></th>
								<th><?php echo $tenantHead; ?></th>
								<th class="text-center"><?php echo $leaseTermHead; ?></th>
								<th class="text-center"><?php echo $statusHead; ?></th>
								<th class="text-center"><?php echo $startDateHead; ?></th>
								<th class="text-center"><?php echo $endDateHead; ?></th>
							</tr>
						</thead>

						<tbody>
							<?php
								while ($row = mysqli_fetch_assoc($res)) {
									if ($row['closed'] == '1') { $closed = $inactClosedText; } else { $closed = $activeTabTitle; }
									
									// Get Property & Tenant Data
									$sql = 'SELECT
												users.userFirstName,
												users.userLastName,
												properties.propertyName
											FROM
												users
												LEFT JOIN properties ON users.propertyId = properties.propertyId
											WHERE
												users.userId = '.$row['userId'];
									$result = mysqli_query($mysqli, $sql) or die('-2' . mysqli_error());
									$rows = mysqli_fetch_assoc($result);
							?>
									<tr>
										<td><?php echo clean($rows['propertyName']); ?></td>
										<td><?php echo clean($rows['userFirstName']).' '.clean($rows['userLastName']); ?></td>
										<td class="text-center"><?php echo clean($row['leaseTerm']); ?></td>
										<td class="text-center"><?php echo $closed; ?></td>
										<td class="text-center"><?php echo dateFormat($row['leaseStart']); ?></td>
										<td class="text-center"><?php echo dateFormat($row['leaseEnd']); ?></td>
									</tr>
							<?php } ?>
						</tbody>
					</table>
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