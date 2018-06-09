<?php
	// Delete Property
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteProperty') {
		$deleteId = htmlspecialchars($_POST['deleteId']);
		$propertyName = htmlspecialchars($_POST['propertyName']);

		$stmt = $mysqli->prepare("DELETE FROM assigned WHERE propertyId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM leases WHERE propertyId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM payments WHERE propertyId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM properties WHERE propertyId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM propfiles WHERE propertyId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM proppictures WHERE propertyId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM refunds WHERE propertyId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM serviceexpense WHERE propertyId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM servicenotes WHERE propertyId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM servicerequests WHERE propertyId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare("DELETE FROM serviceresolutions WHERE propertyId = ?");
		$stmt->bind_param('s', $deleteId);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '2';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$deletePropAct.' "'.$propertyName.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($thePropText." \"".$propertyName."\" ".$admAccDelConf2, "<i class='fa fa-check-square'></i>", "success");
	}
$propertyName = htmlspecialchars($_GET['propertyName']);
$propertyId = htmlspecialchars($_GET['propertyId']);

$qryP = "SELECT * from properties where propertyId=".$propertyId;

$propName = htmlspecialchars($rowP["propertyName"]);

$resP = mysqli_query($mysqli, $qryP) or die('-1' . mysqli_error($mysqli));
$rowP = mysqli_fetch_assoc($resP);
	$qry = "SELECT
				properties.*
			FROM
				properties
			WHERE
				 propertyName='".$propName."'";
         //echo $qry;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error($mysqli));


	$propPage = 'true';
	$pageTitle = "Units under property : ".$rowP["propertyName"];
	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
	$dataTables = 'true';
	$jsFile = 'unleasedProperties';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
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
						<th><?php echo $unitHead; ?></th>
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
										<?php echo clean($row['unitName']); ?>
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
