<?php
	// Get Leased Tenant Data
	if ($rs_isAdmin != '') {
		// View Assigned
		$qry = "SELECT
					users.*,
					properties.propertyName,
					leases.leaseEnd,
					admins.adminId
				FROM
					users
					LEFT JOIN properties ON users.propertyId = properties.propertyId
					LEFT JOIN leases ON users.leaseId = leases.leaseId
					LEFT JOIN assigned ON users.propertyId = assigned.propertyId
					LEFT JOIN admins ON assigned.adminId = admins.adminId
				WHERE
					admins.adminId = ".$rs_adminId." AND
					users.isActive = 1 AND
					users.leaseId != 0";
		$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error($mysqli));
	} else {
		// View All
		$qry = "SELECT
					users.*,
					properties.*,
					leases.leaseEnd,
					admins.adminId,
					admins.adminName
				FROM
					users
					LEFT JOIN properties ON users.propertyId = properties.propertyId
					LEFT JOIN leases ON users.leaseId = leases.leaseId
					LEFT JOIN assigned ON users.propertyId = assigned.propertyId
					LEFT JOIN admins ON assigned.adminId = admins.adminId
				WHERE
					users.isActive = 1 AND
					users.leaseId != 0 AND
					properties.landlordId=".$rs_managerId;
		$res = mysqli_query($mysqli, $qry) or die('-2' . mysqli_error());
	}

	$tenPage = 'true';
	$pageTitle = $leasedTenantsPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'leasedTenants';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			//if ((checkArray('MNGTEN', $auths)) || $rs_isAdmin != '') {
				if(true){
				if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle; ?></h3>

				<?php if(mysqli_num_rows($res) < 1) { ?>
					<div class="alertMsg default mb-20">
						<div class="msgIcon pull-left">
							<i class="fa fa-info-circle"></i>
						</div>
						<?php echo $noLeasedTenFoundMsg; ?>
					</div>
				<?php } else { ?>
					<table id="leasedTenants" class="display" cellspacing="0">
						<thead>
							<tr>
								<th><?php echo $tenantHead; ?></th>
								<th class="text-center"><?php echo $typeHead; ?></th>
								<th class="text-center"><?php echo $propertyHead; ?></th>
								<th class="text-center"><?php echo $emailAddyText; ?></th>
								<th class="text-center"><?php echo $contUsFormPhone; ?></th>
								<th class="text-center"><?php echo $leaseEndHead; ?></th>
								<?php if ($rs_isAdmin != '') { ?>
									<th class="text-center"><?php echo $landlordHead; ?></th>
								<?php }	?>
							</tr>
						</thead>

						<tbody>
							<?php
								while ($row = mysqli_fetch_assoc($res)) {
									if ($row['isResident'] == '1') { $accType = $residentText; } else { $accType = $tenantText; }
									if (is_null($row['adminName'])) { $assignedTo = '<em class="text-warning">'.$unassignedText.'</em>'; } else { $assignedTo = clean($row['adminName']); }

									// Decrypt data for display
									if ($row['primaryPhone'] != '') { $tenantPhone = decryptIt($row['primaryPhone']); } else { $tenantPhone = ''; }
							?>
									<tr>
										<td>
											<a href="index.php?action=viewTenant&userId=<?php echo $row['userId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewTenantText; ?>">
												<?php echo clean($row['userFirstName']).' '.clean($row['userLastName']); ?>
											</a>
										</td>
										<td class="text-center"><?php echo $accType; ?></td>
										<td class="text-center">
											<a href="index.php?action=viewProperty&propertyId=<?php echo $row['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
												<?php echo clean($row['propertyName']); ?> - <?php echo clean($row['unitName']); ?>
											</a>
										</td>
										<td class="text-center"><?php echo clean($row['userEmail']); ?></td>
										<td class="text-center"><?php echo $tenantPhone; ?></td>
										<td class="text-center"><?php echo dateFormat($row['leaseEnd']); ?></td>
										<?php if ($rs_isAdmin != '') { ?>
											<td class="text-center"><a href="index.php?action=adminInfo&adminId=<?php echo $row['adminId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewLandlordText; ?>">
												<?php echo $assignedTo; ?></a>
											</td>
										<?php } ?>
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
