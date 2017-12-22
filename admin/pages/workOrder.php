<?php
	$auths = getAdminAuth($rs_adminId);
	$requestId = $mysqli->real_escape_string($_GET['requestId']);


	// Get Service Request Data
	$qry = "SELECT
				servicerequests.*,
				properties.propertyName,
				properties.propertyAddress,
				properties.isLeased,
				servicepriority.priorityTitle,
				servicestatus.statusTitle
			FROM
				servicerequests
				LEFT JOIN properties ON servicerequests.propertyId = properties.propertyId
				LEFT JOIN servicepriority ON servicerequests.requestPriority = servicepriority.priorityId
				LEFT JOIN servicestatus ON servicerequests.requestStatus = servicestatus.statusId
			WHERE servicerequests.requestId = ".$requestId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);

	// Get User Data
	$sql = "SELECT
				CONCAT(users.userFirstName,' ',users.userLastName) AS user,
				users.userEmail,
				users.primaryPhone
			FROM
				users
				LEFT JOIN properties ON users.propertyId = properties.propertyId
			WHERE users.propertyId = ".$row['propertyId'];
	$result = mysqli_query($mysqli, $sql) or die('-2' . mysqli_error());
	$rows = mysqli_fetch_assoc($result);

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

	// Add Recent Activity
	$activityType = '3';
	$rs_uid = '0';
	$activityTitle = $rs_adminName.' viewed the Work Order for "'.clean($row['requestTitle']).'"';
	updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?php echo $set['siteName']; ?> &middot; <?php echo $workOrderPageTitle; ?></title>

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="../css/print.css" />
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.css" />
</head>

<body>
	<div class="container">
		<?php if ((checkArray('SRVREQ', $auths)) || $rs_isAdmin != '') { ?>
			<div class="row">
				<div class="col-xs-4">
					<img src="../images/logo.png" class="mt-20">
				</div>
				<div class="col-xs-8 text-right">
					<h2><?php echo $workOrderPageTitle; ?></h3>
				</div>
			</div>

			<hr />

			<div class="row">
				<div class="col-xs-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4><?php echo $propertyHead; ?>: <?php echo $row['propertyName']; ?></h3>
						</div>
						<div class="panel-body">
							<p class="sm-text"><?php echo nl2br(clean($row['propertyAddress'])); ?></p>
						</div>
					</div>
				</div>
				<?php if ($row['isLeased'] == '1') { ?>
					<div class="col-xs-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4><?php echo $tenantHead; ?>: <?php echo clean($rows['user']); ?></h3>
							</div>
							<div class="panel-body">
								<p class="sm-text">
									<?php echo clean($rows['userEmail']); ?><br />
									<?php echo decryptIt($rows['primaryPhone']); ?>
								</p>
							</div>
						</div>
					</div>
				<?php } else { ?>
					<div class="col-xs-4"></div>
				<?php } ?>
				<div class="col-xs-4">
					<p class="mb-20 text-right">
						<strong><?php echo $requestNumText; ?></strong> <?php echo $requestId; ?><br />
						<strong><?php echo $dateText; ?>:</strong> <?php echo dateFormat($row['requestDate']); ?><br />
						<strong><?php echo $reqAssignedToText; ?></strong> <?php echo $assignedAdmin; ?>
					</p>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="mt-0 mb-0"><?php echo $servReqTabTitle; ?>: <?php echo clean($row['requestTitle']); ?></h3>
				</div>
				<div class="panel-body">
					<p class="sm-text"><?php echo nl2br(htmlspecialchars_decode($row['requestText'])); ?></p>
				</div>
			</div>

			<?php if (!is_null($row['notes'])) { ?>
				<div class="well well-sm sm-text">
					<strong><?php echo $notesTabText; ?>:</strong> <?php echo nl2br(htmlspecialchars_decode($row['notes'])); ?>
				</div>
			<?php } ?>

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="qty-col text-center"><?php echo $qtyText; ?></th>
						<th class="desc-col"><?php echo $matDescText; ?></th>
						<th class="price-col text-center"><?php echo $unitPriceText; ?></th>
						<th class="line-tot-col text-center"><?php echo $lineTotText; ?></th>
					</tr>
				</thead>
				<tbody>
					<tr height="30">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr height="30">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr height="30">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr height="30">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>

			<div class="row">
				<div class="col-xs-8">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="lab-desc-col"><?php echo $laborDescText; ?></th>
								<th class="hours-col text-center"><?php echo $hoursText; ?></th>
							</tr>
						</thead>
						<tbody>
							<tr height="30">
								<td></td>
								<td></td>
							</tr>
							<tr height="30">
								<td></td>
								<td></td>
							</tr>
							<tr height="30">
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-xs-4">
					<table class="table table-bordered">
						<tbody>
							<tr height="44">
								<td class="sub-to-col text-right"><strong><?php echo $miscText; ?></strong></td>
								<td class="grand-tot-col"></td>
							</tr>
							<tr height="44">
								<td class="text-right"><strong><?php echo $subTotalText; ?></strong></td>
								<td></td>
							</tr>
							<tr height="44">
								<td class="text-right"><strong><?php echo $grandTotalText; ?></strong></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-8">
					<div class="well well-sm res-well">
						<strong><?php echo $resolutionTabText; ?>:</strong>
						<hr class="mt-0" />
					</div>
				</div>
				<div class="col-xs-4">
					<div class="well well-sm">
						<strong><?php echo $dateResvdText; ?>:</strong>
					</div>

					<div class="well well-sm">
						<strong><?php echo $needsFollowUpText; ?></strong><br />
						<i class="fa fa-square-o"></i> <?php echo $yesBtn; ?>
						&nbsp; &nbsp;
						<i class="fa fa-square-o"></i> <?php echo $noBtn; ?>
					</div>
				</div>
			</div>

		<?php } else { ?>
			<h3><?php echo $accessErrorHeader; ?></h3>
			<div class="alertMsg warning mb-20">
				<div class="msgIcon pull-left">
					<i class="fa fa-warning"></i>
				</div>
				<?php echo $permissionDenied; ?>
			</div>
		<?php } ?>
	</div>
</body>
</html>