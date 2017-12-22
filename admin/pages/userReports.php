<?php

	$managePage = 'true';
	$pageTitle = $userReportsPageTitle;
	$addCss = '<link href="../css/chosen.css" rel="stylesheet">';
	$chosen = 'true';
	$jsFile = 'userReports';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('TENRPT', $auths)) || (checkArray('ADMINRPT', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $pageTitle; ?></h3>

				<div class="row">
					<?php if ((checkArray('TENRPT', $auths)) || $rs_isAdmin != '') { ?>
						<div class="col-md-6">
							<form action="index.php?action=tenantRpt" method="post">
								<fieldset class="info">
									<legend class="info"><?php echo $userRptLegend1; ?></legend>
									<label><?php echo $userRptLegendLabel1; ?></label>
									<div id="accTypes1" class="form-group">
										<input type="radio" name="accType1" id="allUsrAcc1" value="all" checked="" />
										<label for="allUsrAcc1" class="allUsrAccOpt1"><i class="fa fa-dot-circle-o"></i> <?php echo $allCheckboxOpt; ?></label>

										<input type="radio" name="accType1" id="actUsrAcc1" value="active" />
										<label for="actUsrAcc1" class="actUsrAccOpt1"> <i class="fa fa-circle-o"></i> <?php echo $activeTabTitle; ?></label>

										<input type="radio" name="accType1" id="inactUsrAcc1" value="inactive" />
										<label for="inactUsrAcc1" class="inactUsrAccOpt1"> <i class="fa fa-circle-o"></i> <?php echo $inactiveText; ?></label>
									</div>
									
									<input type="hidden" name="rptType" value="tenantRpt1" />
									<button type="input" name="submit" value="runRpt" id="tenantRpt1" class="btn btn-info btn-sm btn-icon-alt"><?php echo $runRptBtn; ?> <i class="fa fa-long-arrow-right"></i></button>
								</fieldset>
							</form>
							
							<hr class="mt-0" />
							
							<form action="index.php?action=tenantRpt" method="post">
								<fieldset class="info">
									<legend class="info"><?php echo $userRptLegend2; ?></legend>
									<label><?php echo $userRptLegendLabel2; ?></label>
									<div id="accTypes2" class="form-group">
										<input type="radio" name="accType2" id="allUsrAcc2" value="all" checked="" />
										<label for="allUsrAcc2" class="allUsrAccOpt2"><i class="fa fa-dot-circle-o"></i> <?php echo $allCheckboxOpt; ?></label>

										<input type="radio" name="accType2" id="arcUsrAcc2" value="archived" />
										<label for="arcUsrAcc2" class="arcUsrAccOpt2"> <i class="fa fa-circle-o"></i> <?php echo $archivedOption; ?></label>
										
										<input type="radio" name="accType2" id="dsbUserAcc2" value="disabled" />
										<label for="dsbUserAcc2" class="dsbUserAccOpt2"> <i class="fa fa-circle-o"></i> <?php echo $disabledText; ?></label>
									</div>
									
									<input type="hidden" name="rptType" value="tenantRpt2" />
									<button type="input" name="submit" value="runRpt" id="tenantRpt2" class="btn btn-info btn-sm btn-icon-alt"><?php echo $runRptBtn; ?> <i class="fa fa-long-arrow-right"></i></button>
								</fieldset>
							</form>
						</div>
					<?php
						}
						if ((checkArray('ADMINRPT', $auths)) || $rs_isAdmin != '') {
					?>
						<div class="col-md-6">
							<form action="index.php?action=adminRpt" method="post">
								<fieldset class="info">
									<legend class="info"><?php echo $admReportLegend1; ?></legend>
									<label><?php echo $admReportLegendLabel; ?></label>
									<div id="adminOptions" class="form-group">
										<input type="radio" name="admAccType" id="allAdm" value="all" checked="" />
										<label for="allAdm" class="allAdmOpt"><i class="fa fa-dot-circle-o"></i> <?php echo $allCheckboxOpt; ?></label>
										
										<input type="radio" name="admAccType" id="actAdm" value="active" />
										<label for="actAdm" class="actAdmOpt"> <i class="fa fa-circle-o"></i> <?php echo $activeTabTitle; ?></label>

										<input type="radio" name="admAccType" id="inactAdm" value="inactive" />
										<label for="inactAdm" class="inactAdmOpt"> <i class="fa fa-circle-o"></i> <?php echo $inactiveText; ?></label>
										
										<input type="radio" name="admAccType" id="dsbAdm" value="disabled" />
										<label for="dsbAdm" class="dsbAdmOpt"> <i class="fa fa-circle-o"></i> <?php echo $disabledText; ?></label>
									</div>

									<input type="hidden" name="rptType" value="adminRpt1" />
									<button type="input" name="submit" value="runRpt" id="adminRpt1" class="btn btn-info btn-sm btn-icon-alt"><?php echo $runRptBtn; ?> <i class="fa fa-long-arrow-right"></i></button>
								</fieldset>
							</form>

							<hr class="mt-0" />

							<form action="index.php?action=adminRpt" method="post">
								<fieldset class="info">
									<legend class="info"><?php echo $admReportLegend2; ?></legend>
									<div id="errNote"></div>
									<div class="form-group">
										<?php
											// Get Admin List
											$admqry = "SELECT adminId, adminName, isActive, isDisabled FROM admins";
											$admres = mysqli_query($mysqli, $admqry) or die('-1'.mysqli_error());
										?>
										<label for="adminsId"><?php echo $selectAdmField; ?></label>
										<select class="form-control chosen-select" name="adminsId" id="adminsId">
											<option value="..."><?php echo $selectOption; ?></option>
											<?php
												while ($adm = mysqli_fetch_assoc($admres)) {
													if ($adm['isActive'] == '0' || $adm['isDisabled'] == '1') { $markIt = ' *'; } else { $markIt = ''; }
													echo '<option value="'.$adm['adminId'].'">'.$adm['adminName'].$markIt.'</option>';
												}
											?>
										</select>
										<span class="help-block"><?php echo $selectAdmFieldHelp; ?></span>
									</div>

									<input type="hidden" name="rptType" value="adminRpt2" />
									<button type="input" name="submit" value="runRpt" id="adminRpt2" class="btn btn-info btn-sm btn-icon-alt"><?php echo $runRptBtn; ?> <i class="fa fa-long-arrow-right"></i></button>
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