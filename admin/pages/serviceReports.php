<?php
	$managePage = 'true';
	$pageTitle = $servReportsPageTitle;
	$addCss = '<link rel="stylesheet" type="text/css" href="../css/datetimepicker.css" />';
	$datePicker = 'true';
	$jsFile = 'serviceReports';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('SERVRPT', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
			<h3><?php echo $pageTitle; ?></h3>
			
			<input type="hidden" id="weekStart" value="<?php echo $set['weekStart']; ?>" />
		
			<div class="row">
				<div class="col-md-6">
					<form action="index.php?action=servReqRpt" method="post">
						<fieldset class="warning">
							<legend class="warning"><?php echo $servReqNavLink; ?></legend>
								<div id="errNote1"></div>

								<label><?php echo $servReqLabel; ?></label>
								<div id="srvTypes" class="form-group">
									<input type="radio" name="srvType" id="allSrv" value="all" checked="" />
									<label for="allSrv" class="allSrvOpt"><i class="fa fa-dot-circle-o"></i> <?php echo $allCheckboxOpt; ?></label>

									<input type="radio" name="srvType" id="openSrv" value="open" />
									<label for="openSrv" class="openSrvOpt"> <i class="fa fa-circle-o"></i> <?php echo $activeOpenOpt; ?></label>
									
									<input type="radio" name="srvType" id="closedSrv" value="closed" />
									<label for="closedSrv" class="closedSrvOpt"> <i class="fa fa-circle-o"></i> <?php echo $closedComplOpt; ?></label>
								</div>

								<?php
									// Get Property List
									$propqry = "SELECT propertyId, propertyName, isLeased FROM properties";
									$propres = mysqli_query($mysqli, $propqry) or die('-1'.mysqli_error());
								?>
								<label for="propertyId"><?php echo $selectpropertiesField; ?></label>
								<select id="properties1" multiple class="form-control selectall" name="propertyId[]">
									<option value="all" selected><?php echo $allPropertiesOpt; ?></option>
									<?php
										while ($prop = mysqli_fetch_assoc($propres)) {
											if ($prop['isLeased'] == '0') { $noLease = ' *'; } else { $noLease = ''; }
											echo '<option value="'.$prop['propertyId'].'">'.$prop['propertyName'].$noLease.'</option>';
										}
									?>
								</select>
								<span class="help-block"><?php echo $selectpropertiesFieldHelp; ?></span>

								<div class="form-group">
									<label for="reqFromDate"><?php echo $showRecFromField; ?></label>
									<input type="text" class="form-control" name="fromDate" id="reqFromDate" required="required" value="" />
									<span class="help-block"><?php echo $showRecFromFieldHelp; ?></span>
								</div>
								<div class="form-group">
									<label for="reqToDate"><?php echo $showRecToField; ?></label>
									<input type="text" class="form-control" name="toDate" id="reqToDate" required="required" value="" />
									<span class="help-block"><?php echo $showRecToFieldHelp; ?></span>
								</div>

								<input type="hidden" name="rptType" value="srvRequests" />
								<button type="input" name="submit" value="runRpt" id="servReqRpt" class="btn btn-warning btn-sm btn-icon-alt"><?php echo $runRptBtn; ?> <i class="fa fa-long-arrow-right"></i></button>
						</fieldset>
					</form>
				</div>
				<div class="col-md-6">
					<form action="index.php?action=servReqRpt" method="post">
						<fieldset class="warning">
							<legend class="warning"><?php echo $servReqLegend; ?></legend>
								<div id="errNote2"></div>

								<?php
									// Get Property List
									$propqry1 = "SELECT propertyId, propertyName, isLeased FROM properties";
									$propres1 = mysqli_query($mysqli, $propqry1) or die('-1'.mysqli_error());
								?>
								<label for="propertyId"><?php echo $selectpropertiesField; ?></label>
								<select id="properties2" multiple class="form-control selectall" name="propertyId[]">
									<option value="all" selected><?php echo $allPropertiesOpt; ?></option>
									<?php
										while ($prop1 = mysqli_fetch_assoc($propres1)) {
											if ($prop1['isLeased'] == '0') { $noLease = ' *'; } else { $noLease = ''; }
											echo '<option value="'.$prop1['propertyId'].'">'.$prop1['propertyName'].$noLease.'</option>';
										}
									?>
								</select>
								<span class="help-block"><?php echo $selectpropertiesFieldHelp; ?></span>

								<div class="form-group">
									<label for="costFromDate"><?php echo $showRecFromField; ?></label>
									<input type="text" class="form-control" name="fromDate" id="costFromDate" required="required" value="" />
									<span class="help-block"><?php echo $showRecFromFieldHelp; ?></span>
								</div>
								<div class="form-group">
									<label for="costToDate"><?php echo $showRecToField; ?></label>
									<input type="text" class="form-control" name="toDate" id="costToDate" required="required" value="" />
									<span class="help-block"><?php echo $showRecToFieldHelp; ?></span>
								</div>

								<input type="hidden" name="rptType" value="totalCosts" />
								<button type="input" name="submit" value="runRpt" id="servCostRpt" class="btn btn-warning btn-sm btn-icon-alt"><?php echo $runRptBtn; ?> <i class="fa fa-long-arrow-right"></i></button>
						</fieldset>
					</form>
				</div>
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