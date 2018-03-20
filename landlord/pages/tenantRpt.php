<?php
	$rptError = $reportType = '';
	$where = array();

	switch ($_POST['rptType']) {
		case "tenantRpt1":
			$accType1 = $mysqli->real_escape_string($_POST['accType1']);
			
			if ($accType1 == 'all') {
				$where[] = 'isActive IN ("1","0")';
				$reportType = $tenantRptType1;
			} else if ($accType1 == 'active') {
				$where[] = 'isActive IN ("1")';
				$reportType = $tenantRptType2;
			} else if ($accType1 == 'inactive') {
				$where[] = 'isActive IN ("0")';
				$reportType = $tenantRptType3;
			} else {
				$rptError = 'true';
				$reportType = $reportErrorH3;
			}
		break;
		case "tenantRpt2":
			$accType2 = $mysqli->real_escape_string($_POST['accType2']);
			
			if ($accType2 == 'all') {
				$where[] = '(isArchived IN ("1") OR isDisabled IN ("1") AND isActive IN ("0"))';
				$reportType = $tenantRptType4;
			} else if ($accType2 == 'archived') {
				$where[] = 'isArchived IN ("1")';
				$reportType = $tenantRptType5;
			} else if ($accType2 == 'disabled') {
				$where[] = 'isDisabled IN ("1")';
				$reportType = $tenantRptType6;
			} else {
				$rptError = 'true';
				$reportType = $reportErrorH3;
			}
		break;
		default:
			$rptError = 'true';
			$reportType = $reportErrorH3;
		break;
	}
	
	if ($rptError == '') {
		if (!empty($where)) {
			$whereSql = "WHERE\n" . implode("\nOR ",$where);
		}

		// Get Tenant/Resident Data
		$qry = 'SELECT * FROM users '.$whereSql;
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
	$pageTitle = $tenantRptPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'tenantRpt';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ($rptError == '') {
				if ((checkArray('TENRPT', $auths)) || $rs_isAdmin != '') {
					if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle; ?></h3>
				<p class="lead"><?php echo $reportType; ?></p>

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
								<th><?php echo $tenantHead; ?></th>
								<th class="text-center"><?php echo $typeHead; ?></th>
								<th class="text-center"><?php echo $statusHead; ?></th>
								<th class="text-center"><?php echo $propertyHead; ?></th>
								<th class="text-center"><?php echo $emailAddyText; ?></th>
								<th class="text-center"><?php echo $contUsFormPhone; ?></th>
								<th class="text-center"><?php echo $leaseEndHead; ?></th>
							</tr>
						</thead>

						<tbody>
							<?php
								while ($row = mysqli_fetch_assoc($res)) {
									if ($row['isActive'] == '1') { $status1 = $activeTabTitle; } else { $status1= $inactiveText; }
									if ($row['isDisabled'] == '1') { $status2 = $disabledText;  } else { $status2 = ''; }
									if ($row['isResident'] == '1') { $accType = $residentText; } else { $accType = $priTenantopt; }
									// Decrypt data for display
									if ($row['primaryPhone'] != '') { $tenantPhone = decryptIt($row['primaryPhone']); } else { $tenantPhone = ''; }
									
									// Get Property Name
									$sql = 'SELECT
												leases.leaseEnd,
												properties.propertyName
											FROM
												leases
												LEFT JOIN properties ON leases.propertyId = properties.propertyId
												LEFT JOIN users ON properties.propertyId = users.propertyId
											WHERE
												users.userId = '.$row['userId'].' AND
												leases.closed = 0';
									$result = mysqli_query($mysqli, $sql) or die('-2' . mysqli_error());
									$rows = mysqli_fetch_assoc($result);
									
									if (!is_null($rows['leaseEnd'])) { $leaseEnd = dateFormat($rows['leaseEnd']); } else { $leaseEnd = ''; }
							?>
									<tr>
										<td><?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?></td>
										<td class="text-center"><?php echo $accType; ?></td>
										<td class="text-center"><?php echo $status1.' '.$status2; ?></td>
										<td class="text-center"><?php echo clean($rows['propertyName']); ?></td>
										<td class="text-center"><?php echo clean($row['userEmail']); ?></td>
										<td class="text-center"><?php echo $tenantPhone; ?></td>
										<td class="text-center"><?php echo $leaseEnd; ?></td>
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