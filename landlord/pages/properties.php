<?php
	// Delete Property
	$qry = "SELECT
				properties.*
			FROM
				properties
			WHERE
				properties.active = 1 AND properties.landlordId=".$rs_managerId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());

	$propPage = 'true';
	$pageTitle = "All properties"; //$unlPropPageTitle;
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'unleasedProperties';

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
				<?php echo $noUnlPropFound; ?>
			</div>
		<?php } else { ?>
			<table id="unleasedProperties" class="display" cellspacing="0">
				<thead>
					<tr>
						<th><?php echo $propertyHead; ?></th>
						<th><?php echo $propertyMother; ?></th>
						<th><?php echo $addressHead; ?></th>
						<th class="text-center"><?php echo $rateText; ?></th>
						<th class="text-center"><?php echo $depositText; ?></th>
						<th class="text-center"><?php echo $petsText; ?></th>
						<th class="text-center"><?php echo $bedsText; ?></th>
						<th class="text-center"><?php echo $bathsText; ?></th>
						<th class="text-center"><?php echo $sixeText; ?></th>
						<th class="text-right"></th>
					</tr>
				</thead>

				<tbody>
					<?php
						while ($row = mysqli_fetch_assoc($res)) {
							if ($row['petsAllowed'] == '0') { $petsAllowed = $noBtn; } else { $petsAllowed = $yesBtn; }
					?>
							<tr>
								<td>
									<a href="index.php?action=viewProperty&propertyId=<?php echo $row['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
										<?php echo clean($row['propertyName']); ?> - <?php echo clean($row['unitName']); ?>
									</a>
								</td>
								<td>
									<a href="index.php?action=viewParent&propertyId=<?php echo $row['propertyId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewPropertyText; ?>">
										<?php echo clean($row['propertyName']); ?>
									</a>
								</td>
								<td><?php echo clean($row['propertyAddress']); ?></td>
								<td class="text-center"><?php echo formatCurrency($row['propertyRate'],$currCode); ?></td>
								<td class="text-center"><?php echo formatCurrency($row['propertyDeposit'],$currCode); ?></td>
								<td class="text-center"><?php echo $petsAllowed; ?></td>
								<td class="text-center"><?php echo clean($row['bedrooms']); ?></td>
								<td class="text-center"><?php echo clean($row['bathrooms']); ?></td>
								<td class="text-center"><?php echo clean($row['propertySize']); ?></td>
								<td class="text-right">
									<a data-toggle="modal" href="#deleteProperty<?php echo $row['propertyId']; ?>" class="text-danger">
										<i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="Delete Property"></i>
									</a>

									<div class="modal fade" id="deleteProperty<?php echo $row['propertyId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog text-left">
											<div class="modal-content">
												<form action="" method="post">
													<div class="modal-body">
														<p class="lead">
															<?php echo $delPropConf1; ?> "<?php echo clean($row['propertyName']); ?>"?<br />
															<small><?php echo $delPropConf2; ?></small>
														</p>
													</div>
													<div class="modal-footer">
														<input name="deleteId" type="hidden" value="<?php echo $row['propertyId']; ?>" />
														<input name="propertyName" type="hidden" value="<?php echo clean($row['propertyName']); ?>" />
														<button type="input" name="submit" value="deleteProperty" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
														<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
													</div>
												</form>
											</div>
										</div>
									</div>
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
