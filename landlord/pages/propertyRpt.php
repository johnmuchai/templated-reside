<?php
	$rptError = $reportType = '';
	$where = array();
	
	$propType = $mysqli->real_escape_string($_POST['propType']);
			
	if ($propType == 'all') {
		$where[] = 'isLeased IN ("1","0") OR active IN ("1","0")';
		$reportType = $propertyRptTitle;
	} else if ($propType == 'leased') {
		$where[] = 'isLeased IN ("1")';
		$reportType = $propertyRptTitle1;
	} else if ($propType == 'available') {
		$where[] = 'isLeased IN ("0")';
		$reportType = $propertyRptTitle2;
	} else {
		$rptError = 'true';
		$reportType = $reportErrorH3;
	}
	
	if (!empty($where)) {
		$whereSql = "WHERE\n" . implode("\nOR ",$where);
	}
	
	if ($rptError == '') {
		// Get Data
		$qry = 'SELECT * FROM properties '.$whereSql;
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
	$pageTitle = $propertyReportsPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'propertyRpt';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ($rptError == '') {
				if ((checkArray('PROPRPT', $auths)) || $rs_isAdmin != '') {
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
								<th><?php echo $typeStyleHead; ?></th>
								<th class="text-center"><?php echo $sixeText; ?></th>
								<th class="text-center"><?php echo $bedsText; ?></th>
								<th class="text-center"><?php echo $bathsText; ?></th>
								<th class="text-center"><?php echo $statusHead; ?></th>
								<th class="text-center"><?php echo $rentalRateHead; ?></th>
								<th class="text-center"><?php echo $depositText; ?></th>
								<th class="text-center"><?php echo $lateFeeHead; ?></th>
								<th class="text-center"><?php echo $petsText; ?></th>
							</tr>
						</thead>

						<tbody>
							<?php
								while ($row = mysqli_fetch_assoc($res)) {
									if ($row['isLeased'] == '1') { $isLeased = $propLeasedOpt; } else { $isLeased = $propAvailOpt; }
									if ($row['petsAllowed'] == '1') { $petsAllowed = $yesBtn; } else { $petsAllowed = $noBtn; }
							?>
									<tr>
										<td><?php echo clean($row['propertyName']); ?></td>
										<td><?php echo clean($row['propertyType']).' '.clean($row['propertyStyle']); ?></td>
										<td class="text-center"><?php echo clean($row['propertySize']); ?></td>
										<td class="text-center"><?php echo clean($row['bedrooms']); ?></td>
										<td class="text-center"><?php echo clean($row['bathrooms']); ?></td>
										<td class="text-center"><?php echo $isLeased; ?></td>
										<td class="text-center"><?php echo formatCurrency($row['propertyRate'],$currCode); ?></td>
										<td class="text-center"><?php echo formatCurrency($row['propertyDeposit'],$currCode); ?></td>
										<td class="text-center"><?php echo formatCurrency($row['latePenalty'],$currCode); ?></td>
										<td class="text-center"><?php echo $petsAllowed; ?></td>
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