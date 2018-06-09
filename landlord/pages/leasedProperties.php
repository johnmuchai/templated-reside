<?php
	// Get Data
	if ($rs_isAdmin != '') {
		$qry = "SELECT
					properties.*,
					leases.*,
					users.userId,
					CONCAT(users.userFirstName,' ',users.userLastName) AS user,
					admins.adminName
				FROM
					properties
					LEFT JOIN leases ON properties.propertyId = leases.propertyId
					LEFT JOIN assigned ON properties.propertyId = assigned.propertyId
					LEFT JOIN admins ON assigned.adminId = admins.adminId
					LEFT JOIN users ON properties.propertyId = users.propertyId
				WHERE
					assigned.adminId = ".$rs_adminId." AND
					properties.isLeased = 1 AND
					properties.active = 1 AND
					leases.closed = 0 AND
					users.isResident = 0";
		$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	} else {
		$qry = "SELECT
					properties.*,
					leases.*,
					users.userId,
					CONCAT(users.userFirstName,' ',users.userLastName) AS user,
					admins.adminName
				FROM
					properties
					LEFT JOIN leases ON properties.propertyId = leases.propertyId
					LEFT JOIN assigned ON properties.propertyId = assigned.propertyId
					LEFT JOIN admins ON assigned.adminId = admins.adminId
					LEFT JOIN users ON properties.propertyId = users.propertyId
				WHERE
					properties.isLeased = 1 AND
					properties.active = 1 AND
					properties.landlordId= $rs_managerId AND
					leases.closed = 0 AND
					users.isResident = 0";
		$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	}

	$propPage = 'true';
	$pageTitle = $leasedPropPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'leasedProperties';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if($rs_managerId!=""){ //if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
			<h3><?php echo $pageTitle; ?></h3>

		<?php if(mysqli_num_rows($res) < 1) { ?>
			<div class="alertMsg default mb-20">
				<div class="msgIcon pull-left">
					<i class="fa fa-info-circle"></i>
				</div>
				<?php echo $noActivePropFoundMsg; ?>
			</div>
		<?php } else { ?>
			<table id="leasedProperties" class="display" cellspacing="0">
				<thead>
					<tr>
						<th><?php echo $unitHead; ?></th>
						<th><?php echo $propertyMother; ?></th>
						<th><?php echo $tenantHead; ?></th>
						<th><?php echo $assignedToHead; ?></th>
						<th class="text-center"><?php echo $rentAmtHead; ?></th>
						<th class="text-center"><?php echo $lateFeeHead; ?></th>
						<th class="text-center"><?php echo $petsText; ?></th>
						<th class="text-center"><?php echo $leaseTermHead; ?></th>
						<th class="text-center"><?php echo $leaseEndHead; ?></th>
						<th class="text-right"></th>
					</tr>
				</thead>

				<tbody>
					<?php
						while ($row = mysqli_fetch_assoc($res)) {
							if (is_null($row['adminName'])) { $assignedTo = '<em class="text-warning">'.$unassignedText.'</em>'; } else { $assignedTo = clean($row['adminName']); }
							if ($row['petsAllowed'] == '1') { $petsAllowed = $yesBtn; } else { $petsAllowed = $noBtn; }
					?>
							<tr>
								<td>
									<a href="index.php?action=viewProperty&propertyId=<?php echo $row['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
										 <?php echo clean($row['unitName']); ?>
									</a>
								</td>
								<td>
									<a href="index.php?action=viewParent&propertyId=<?php echo $row['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
										<?php echo clean($row['propertyName']); ?>
									</a>
								</td>
								<td>
									<a href="index.php?action=viewTenant&userId=<?php echo $row['userId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewTenantText; ?>">
										<?php echo clean($row['user']); ?>
									</a>
								</td>
								<td><?php echo $assignedTo; ?></td>
								<td class="text-center"><?php echo formatCurrency($row['propertyRate'],$currCode); ?></td>
								<td class="text-center"><?php echo formatCurrency($row['latePenalty'],$currCode); ?></td>
								<td class="text-center"><?php echo $petsAllowed; ?></td>
								<td class="text-center"><?php echo clean($row['leaseTerm']); ?></td>
								<td class="text-center"><?php echo dateFormat($row['leaseEnd']); ?></td>
								<td class="text-right">
									<a href="index.php?action=viewLease&leaseId=<?php echo $row['leaseId']; ?>" class="text-primary"><i class="fa fa-file-text" data-toggle="tooltip" data-placement="left" title="<?php echo $viewLeaseText; ?>"></i>
								</td>
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
		<?php } ?>
	</div>
