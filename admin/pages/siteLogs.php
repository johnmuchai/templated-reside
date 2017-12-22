<?php
	// Delete Logs
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteLogs') {
		$stmt = $mysqli->prepare("DELETE FROM activity");
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '10';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$delLogsAct;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($delLogsMsg, "<i class='fa fa-check-square'></i>", "success");
	}

	// Get the Site Logs
	$qry = "SELECT
				activity.*,
				admins.adminName AS admin,
				CONCAT(users.userFirstName,' ',users.userLastName) AS user
			FROM
				activity
				LEFT JOIN admins ON activity.adminId = admins.adminId
				LEFT JOIN users ON activity.userId = users.userId";
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());

	$managePage = 'true';
	$pageTitle = $siteLogsPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'siteLogs';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('SITELOGS', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>

		<h3><?php echo $pageTitle; ?></h3>
		<p class="text-right mt-10">
			<a data-toggle="modal" href="#deleteLogs" class="btn btn-warning btn-xs btn-icon mt-5 mb-10"><i class="fa fa-trash-o"></i> <?php echo $deleteLogsBtn; ?></a>
		</p>

		<div class="modal fade" id="deleteLogs" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="" method="post">
						<div class="modal-body">
							<p class="lead"><?php echo $deleteLogsConf; ?></p>
						</div>
						<div class="modal-footer">
							<button type="input" name="submit" value="deleteLogs" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> Yes, Delete ALL Logs</button>
							<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<table id="logs" class="display" cellspacing="0">
			<thead>
				<tr>
					<th class="text-center"><?php echo $idHead; ?></th>
					<th class="text-center"><?php echo $activityByHead; ?></th>
					<th class="text-center"><?php echo $activityHead; ?></th>
					<th><?php echo $descriptionHead; ?></th>
					<th class="text-center"><?php echo $activityDateHead; ?></th>
					<th class="text-center"><?php echo $ipAddHead; ?></th>
				</tr>
			</thead>

			<tbody>
			<?php
				while ($row = mysqli_fetch_assoc($res)) {
					$activityType = $otherActType;
					if ($row['activityType'] == '1') { $activityType = $tenantText; }
					if ($row['activityType'] == '2') { $activityType = $propertyHead; }
					if ($row['activityType'] == '3') { $activityType = $servReqTabTitle; }
					if ($row['activityType'] == '4') { $activityType = 'Not in Use'; }
					if ($row['activityType'] == '5') { $activityType = $adminManagerHead; }
					if ($row['activityType'] == '6') { $activityType = $siteAlertActType; }
					if ($row['activityType'] == '7') { $activityType = $uplActType; }
					if ($row['activityType'] == '8') { $activityType = $siteSetActType; }
					if ($row['activityType'] == '9') { $activityType = $accUpdateActType; }
					if ($row['activityType'] == '10') { $activityType = $siteLogsPageTitle; }
					if ($row['activityType'] == '11') { $activityType = $signinActType; }
					if ($row['activityType'] == '12') { $activityType = $signoutActType; }
					if ($row['activityType'] == '13') { $activityType = $adminAuthNavLink; }
					if ($row['activityType'] == '14') { $activityType = $propViewActType; }
					if ($row['activityType'] == '15') { $activityType = $contReqActType; }
					if ($row['activityType'] == '16') { $activityType = $userAccActType; }
					if ($row['activityType'] == '17') { $activityType = $admAccActType; }
					if ($row['activityType'] == '18') { $activityType = $siteContNavLink; }
					if ($row['activityType'] == '19') { $activityType = $fileUplActType; }
					if ($row['activityType'] == '20') { $activityType = $propLeasesNavLink; }
					if ($row['activityType'] == '21') { $activityType = $accErrActType; }
					if ($row['activityType'] == '22') { $activityType = $paypalActType; }
					if ($row['activityType'] == '23') { $activityType = $repNavLink; }
					if ($row['activityType'] == '24') { $activityType = $newAccActType; }

					if ($row['ipAddress'] == '::1') { $ipAddress = $localhostIpAdd; } else { $ipAddress = $row['ipAddress']; }
			?>
					<tr>
						<td class="text-center"><?php echo $row['activityId']; ?></td>
						<?php if ($row['adminId'] != '0') { ?>
							<td class="text-center"><?php echo clean($row['admin']); ?></td>
						<?php } else if ($row['userId'] != '0') { ?>
							<td class="text-center"><?php echo clean($row['user']); ?></td>
						<?php } else { ?>
							<td class="text-center"><?php echo $guestText; ?></td>
						<?php } ?>
						<td class="text-center"><?php echo $activityType; ?></td>
						<td><?php echo clean($row['activityTitle']); ?></td>
						<td class="text-center"><?php echo shortDateTimeFormat($row['activityDate']); ?></td>
						<td class="text-center"><?php echo $ipAddress; ?></td>
					</tr>
			<?php } ?>
			</tbody>
		</table>

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