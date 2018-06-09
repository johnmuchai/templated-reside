<?php
$activeSet = 'active';
$inactiveSet = '';

// Get Active Leases
if ($rs_isAdmin == '') {
	$qry = "SELECT
	leases.*,
	properties.propertyName,
	properties.propertyRate,
	properties.unitName,
	CONCAT(users.userFirstName,' ',users.userLastName) AS user,
	admins.adminName
	FROM
	leases
	LEFT JOIN properties ON leases.propertyId = properties.propertyId
	LEFT JOIN users ON leases.userId = users.userId
	LEFT JOIN assigned ON properties.propertyId = assigned.propertyId
	LEFT JOIN admins ON assigned.adminId = admins.adminId
	WHERE
	properties.landlordId=".$rs_managerId." AND
	leases.closed = 0 AND
	users.isResident = 0";
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error($mysqli));
} else {
	$qry = "SELECT
	leases.*,
	properties.propertyName,
	properties.propertyRate,
	properties.unitName,
	CONCAT(users.userFirstName,' ',users.userLastName) AS user,
	admins.adminName
	FROM
	leases
	LEFT JOIN properties ON leases.propertyId = properties.propertyId
	LEFT JOIN users ON leases.userId = users.userId
	LEFT JOIN assigned ON properties.propertyId = assigned.propertyId
	LEFT JOIN admins ON assigned.adminId = admins.adminId
	WHERE
	properties.landlordId=".$rs_managerId." AND
	leases.closed = 0 AND
	users.isResident = 0";
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
}

// Get Inactive Leases
$sql = "SELECT
leases.*,
properties.propertyName,
properties.propertyRate,
properties.unitName,
CONCAT(users.userFirstName,' ',users.userLastName) AS user
FROM
leases
LEFT JOIN properties ON leases.propertyId = properties.propertyId
LEFT JOIN users ON leases.userId = users.userId
WHERE
properties.landlordId=".$rs_managerId." AND
leases.closed = 1 AND
users.isResident = 0";
$result = mysqli_query($mysqli, $sql) or die('-2' . mysqli_error());

$propPage = 'true';
$pageTitle = $propertyLeasesPageTitle;
$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
$dataTables = 'true';
$jsFile = 'propertyLeases';

include 'includes/header.php';
?>
<div class="container page_block noTopBorder">
	<hr class="mt-0 mb-0" />

	<?php
	if($rs_managerId!=""){ //if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
		if ($msgBox) { echo $msgBox; }
		?>
		<div class="tabs">
			<ul class="tabsBody">
				<li class="<?php echo $activeSet; ?>">
					<h4 class="tabHeader" tabindex="0"><?php echo $activeTabTitle; ?></h4>
					<section class="tabContent" id="active">
						<h3><?php echo $activePropLeasesH3; ?></h3>

						<?php if(mysqli_num_rows($res) < 1) { ?>
							<div class="alertMsg default mb-20">
								<div class="msgIcon pull-left">
									<i class="fa fa-info-circle"></i>
								</div>
								<?php echo $noActPropLeasesFoundMsg; ?>
							</div>
						<?php } else { ?>
							<table id="actLeases" class="display" cellspacing="0">
								<thead>
									<tr>
										<th><?php echo $unitHead; ?></th>
										<th><?php echo $tenantHead; ?></th>
										<th><?php echo $assignedToHead; ?></th>
										<th class="text-center"><?php echo $rentAmtHead; ?></th>
										<th class="text-center"><?php echo $leaseTermHead; ?></th>
										<th class="text-center"><?php echo $leaseStartHead; ?></th>
										<th class="text-center"><?php echo $leaseEndHead; ?></th>
										<th class="text-right"></th>
									</tr>
								</thead>

								<tbody>
									<?php
									while ($row = mysqli_fetch_assoc($res)) {
										if (is_null($row['adminName'])) { $assignedTo = '<em class="text-warning">Unassigned</em>'; } else { $assignedTo = clean($row['adminName']); }
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
											<td class="text-center"><?php echo clean($row['leaseTerm']); ?></td>
											<td class="text-center"><?php echo dateFormat($row['leaseStart']); ?></td>
											<td class="text-center"><?php echo dateFormat($row['leaseEnd']); ?></td>
											<td class="text-right">
												<a href="index.php?action=viewLease&leaseId=<?php echo $row['leaseId']; ?>" class="text-primary"><i class="fa fa-file-text" data-toggle="tooltip" data-placement="left" title="<?php echo $viewUpdateLeaseText; ?>"></i>
												</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							<?php } ?>
						</section>
					</li>
					<li class="<?php echo $inactiveSet; ?>">
						<h4 class="tabHeader" tabindex="0"><?php echo $inactiveText; ?></h4>
						<section class="tabContent" id="inactive">
							<h3><?php echo $inactPropLeaseH3; ?></h3>

							<?php if(mysqli_num_rows($result) < 1) { ?>
								<div class="alertMsg default mb-20">
									<div class="msgIcon pull-left">
										<i class="fa fa-info-circle"></i>
									</div>
									<?php echo $noInactPropLeasesFoundMsg; ?>
								</div>
							<?php } else { ?>
								<table id="inactLeases" class="display" cellspacing="0">
									<thead>
										<tr>
											<th><?php echo $unitHead; ?></th>
											<th><?php echo $propertyMother; ?></th>
											<th><?php echo $tenantHead; ?></th>
											<th class="text-center"><?php echo $rentAmtHead; ?></th>
											<th class="text-center"><?php echo $leaseTermHead; ?></th>
											<th class="text-center"><?php echo $leaseStartHead; ?></th>
											<th class="text-center"><?php echo $leaseEndHead; ?></th>
											<th class="text-right"></th>
										</tr>
									</thead>

									<tbody>
										<?php while ($rows = mysqli_fetch_assoc($result)) { ?>
											<tr>
												<td>
													<a href="index.php?action=viewProperty&propertyId=<?php echo $rows['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
														<?php echo clean($rows['unitName']); ?>
													</a>
												</td>
												<td>
													<a href="index.php?action=viewParent&propertyId=<?php echo $row['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
														<?php echo clean($row['propertyName']); ?>
													</a>
												</td>
												<td>
													<a href="index.php?action=viewTenant&userId=<?php echo $rows['userId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewTenantText; ?>">
														<?php echo clean($rows['user']); ?>
													</a>
												</td>
												<td class="text-center"><?php echo formatCurrency($rows['propertyRate'],$currCode); ?></td>
												<td class="text-center"><?php echo clean($rows['leaseTerm']); ?></td>
												<td class="text-center"><?php echo dateFormat($rows['leaseStart']); ?></td>
												<td class="text-center"><?php echo dateFormat($rows['leaseEnd']); ?></td>
												<td class="text-right">
													<a href="index.php?action=viewLease&leaseId=<?php echo $rows['leaseId']; ?>" class="text-primary"><i class="fa fa-file-text" data-toggle="tooltip" data-placement="left" title="<?php echo $viewLeaseText; ?>"></i>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								<?php } ?>
							</section>
						</li>
					</ul>
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
			<?php } ?>
		</div>
