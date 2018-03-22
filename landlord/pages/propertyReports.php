<?php

	$managePage = 'true';
	$pageTitle = $propertyReportsPageTitle;
	$jsFile = 'propertyReports';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('PROPRPT', $auths)) || (checkArray('LEASERPT', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
			<h3><?php echo $pageTitle; ?></h3>
		
			<div class="row">
				<?php if ((checkArray('PROPRPT', $auths)) || $rs_isAdmin != '') { ?>
					<div class="col-md-6">
						<form action="index.php?action=propertyRpt" method="post">
							<fieldset class="primary">
								<legend class="primary"><?php echo $propNavLink; ?></legend>
								<label><?php echo $propRptSelectPropField; ?></label>
								<div id="accTypes1" class="form-group">
									<input type="radio" name="propType" id="allProp" value="all" checked="" />
									<label for="allProp" class="allPropOpt"><i class="fa fa-dot-circle-o"></i> <?php echo $allCheckboxOpt; ?></label>

									<input type="radio" name="propType" id="leasedProp" value="leased" />
									<label for="leasedProp" class="leasedPropOpt"> <i class="fa fa-circle-o"></i> <?php echo $propLeasedOpt; ?></label>

									<input type="radio" name="propType" id="availProp" value="available" />
									<label for="availProp" class="availPropOpt"> <i class="fa fa-circle-o"></i> <?php echo $propAvailOpt; ?></label>
								</div>

								<button type="input" name="submit" value="runRpt" id="propertyRpt" class="btn btn-primary btn-sm btn-icon-alt"><?php echo $runRptBtn; ?> <i class="fa fa-long-arrow-right"></i></button>
							</fieldset>
						</form>
					</div>
				<?php
					}
					if ((checkArray('LEASERPT', $auths)) || $rs_isAdmin != '') {
				?>
					<div class="col-md-6">
						<form action="index.php?action=leaseRpt" method="post">
							<fieldset class="primary">
								<legend class="primary"><?php echo $propRptLeasesField; ?></legend>
								<label><?php echo $propRptLeasesFieldLabel; ?></label>
								<div id="accTypes1" class="form-group">
									<input type="radio" name="leaseType" id="allLeases" value="all" checked="" />
									<label for="allLeases" class="allLeasesOpt"><i class="fa fa-dot-circle-o"></i> <?php echo $allCheckboxOpt; ?></label>

									<input type="radio" name="leaseType" id="actLeases" value="active" />
									<label for="actLeases" class="actLeasesOpt"> <i class="fa fa-circle-o"></i> <?php echo $activeTabTitle; ?></label>

									<input type="radio" name="leaseType" id="inacLeases" value="inactive" />
									<label for="inacLeases" class="inacLeasesOpt"> <i class="fa fa-circle-o"></i> <?php echo $inactClosedText; ?></label>
								</div>

								<button type="input" name="submit" value="runRpt" id="leaseRpt" class="btn btn-primary btn-sm btn-icon-alt"><?php echo $runRptBtn; ?> <i class="fa fa-long-arrow-right"></i></button>
							</fieldset>
						</form>
					</div>
				<?php } ?>
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