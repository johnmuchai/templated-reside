<?php
	$homeSet = 'active';
	$availSet = $viewSet = $abtSet = $cntSet = $rntSet = '';

	// Update Home Page Content
	if (isset($_POST['submit']) && $_POST['submit'] == 'homePage') {
		$homepageContent = allowedHTML(htmlspecialchars($_POST['homepageContent']));

		$stmt = $mysqli->prepare("UPDATE
									sitecontent
								SET
									pageContent = ?,
									lastUpdated = NOW()
								WHERE
									pageId = 1"
		);
		$stmt->bind_param('s', $homepageContent);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '18';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$siteContentAct1;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($siteContentMsg1, "<i class='fa fa-check-square'></i>", "success");

		$homeSet = 'active';
		$availSet = $viewSet = $abtSet = $cntSet = $rntSet = '';
	}

	// Update Available Properties Page Content
	if (isset($_POST['submit']) && $_POST['submit'] == 'availPage') {
		$availpageContent = allowedHTML(htmlspecialchars($_POST['availpageContent']));

		$stmt = $mysqli->prepare("UPDATE
									sitecontent
								SET
									pageContent = ?,
									lastUpdated = NOW()
								WHERE
									pageId = 2"
		);
		$stmt->bind_param('s', $availpageContent);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '18';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$siteContentAct2;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($siteContentMsg2, "<i class='fa fa-check-square'></i>", "success");

		$availSet = 'active';
		$homeSet = $viewSet = $abtSet = $cntSet = $rntSet = '';
	}

	// Update View Property Page Content
	if (isset($_POST['submit']) && $_POST['submit'] == 'viewPage') {
		$viewpageContent = allowedHTML(htmlspecialchars($_POST['viewpageContent']));

		$stmt = $mysqli->prepare("UPDATE
									sitecontent
								SET
									pageContent = ?,
									lastUpdated = NOW()
								WHERE
									pageId = 3"
		);
		$stmt->bind_param('s', $viewpageContent);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '18';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$siteContentAct3;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($siteContentMsg3, "<i class='fa fa-check-square'></i>", "success");

		$viewSet = 'active';
		$homeSet = $availSet = $abtSet = $cntSet = $rntSet = '';
	}

	// Update About Us Page Content
	if (isset($_POST['submit']) && $_POST['submit'] == 'aboutPage') {
		$aboutpageContent = allowedHTML(htmlspecialchars($_POST['aboutpageContent']));

		$stmt = $mysqli->prepare("UPDATE
									sitecontent
								SET
									pageContent = ?,
									lastUpdated = NOW()
								WHERE
									pageId = 4"
		);
		$stmt->bind_param('s', $aboutpageContent);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '18';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$siteContentAct4;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($siteContentMsg4, "<i class='fa fa-check-square'></i>", "success");

		$abtSet = 'active';
		$homeSet = $availSet = $viewSet = $cntSet = $rntSet = '';
	}

	// Update Contact Us Page Content
	if (isset($_POST['submit']) && $_POST['submit'] == 'contactPage') {
		$contactpageContent = allowedHTML(htmlspecialchars($_POST['contactpageContent']));

		$stmt = $mysqli->prepare("UPDATE
									sitecontent
								SET
									pageContent = ?,
									lastUpdated = NOW()
								WHERE
									pageId = 5"
		);
		$stmt->bind_param('s', $contactpageContent);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '18';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$siteContentAct5;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($siteContentMsg5, "<i class='fa fa-check-square'></i>", "success");

		$cntSet = 'active';
		$homeSet = $availSet = $viewSet = $abtSet = $rntSet = '';
	}

	// Update Rental Application Page Content
	if (isset($_POST['submit']) && $_POST['submit'] == 'rentPage') {
		$rentpageContent = allowedHTML(htmlspecialchars($_POST['rentpageContent']));

		$stmt = $mysqli->prepare("UPDATE
									sitecontent
								SET
									pageContent = ?,
									lastUpdated = NOW()
								WHERE
									pageId = 6"
		);
		$stmt->bind_param('s', $rentpageContent);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '18';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$siteContentAct6;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($siteContentMsg6, "<i class='fa fa-check-square'></i>", "success");

		$rntSet = 'active';
		$homeSet = $availSet = $viewSet = $abtSet = $cntSet = '';
	}

	// Get Home Content Data
	$homeCnt = "SELECT * FROM sitecontent WHERE pageId = 1";
	$homeres = mysqli_query($mysqli, $homeCnt) or die('-1' . mysqli_error());
	$homerow = mysqli_fetch_assoc($homeres);

	// Get About Us Content Data
	$aboutCnt = "SELECT * FROM sitecontent WHERE pageId = 4";
	$aboutres = mysqli_query($mysqli, $aboutCnt) or die('-2' . mysqli_error());
	$aboutrow = mysqli_fetch_assoc($aboutres);

	// Get Contact Us Content Data
	$contactCnt = "SELECT * FROM sitecontent WHERE pageId = 5";
	$contactres = mysqli_query($mysqli, $contactCnt) or die('-3' . mysqli_error());
	$contactrow = mysqli_fetch_assoc($contactres);

	// Get Rental App Content Data
	$rentCnt = "SELECT * FROM sitecontent WHERE pageId = 6";
	$rentres = mysqli_query($mysqli, $rentCnt) or die('-4' . mysqli_error());
	$rentrow = mysqli_fetch_assoc($rentres);

	// Get Available Properties Content Data
	$availCnt = "SELECT * FROM sitecontent WHERE pageId = 2";
	$availres = mysqli_query($mysqli, $availCnt) or die('-5' . mysqli_error());
	$availrow = mysqli_fetch_assoc($availres);

	// Get View Property Content Data
	$viewCnt = "SELECT * FROM sitecontent WHERE pageId = 3";
	$viewres = mysqli_query($mysqli, $viewCnt) or die('-6' . mysqli_error());
	$viewrow = mysqli_fetch_assoc($viewres);

	$managePage = 'true';
	$pageTitle = $siteContentPageTitle;
	$jsFile = 'siteContent';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('SITECNT', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>

			<div class="tabs">
				<ul class="tabsBody">
					<li class="<?php echo $homeSet; ?>">
						<h4 class="tabHeader" tabindex="0"><?php echo $homePageTabTitle; ?></h4>
						<section class="tabContent" id="home">
							<h3><?php echo $homePageTabQuip; ?></h3>
							<p class="text-muted"><?php echo $htmlAllowed1; ?></p>
							<form action="" method="post">
								<div class="form-group">
									<textarea class="form-control" name="homepageContent" id="homepageContent" rows="14"><?php echo htmlspecialchars_decode($homerow['pageContent']); ?></textarea>
								</div>
								<button type="input" name="submit" value="homePage" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
							</form>
						</section>
					</li>
					<li class="<?php echo $availSet; ?>">
						<h4 class="tabHeader" tabindex="0"><?php echo $availPropTabTitle; ?></h4>
						<section class="tabContent" id="avail">
							<h3><?php echo $availPropTabQuip; ?></h3>
							<p class="text-muted"><?php echo $htmlAllowed1; ?></p>
							<form action="" method="post">
								<div class="form-group">
									<textarea class="form-control" name="availpageContent" id="availpageContent" rows="14"><?php echo htmlspecialchars_decode($availrow['pageContent']); ?></textarea>
								</div>
								<button type="input" name="submit" value="availPage" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
							</form>
						</section>
					</li>
					<li class="<?php echo $viewSet; ?>">
						<h4 class="tabHeader" tabindex="0"><?php echo $viewPropPageTabTitle; ?></h4>
						<section class="tabContent" id="view">
							<h3><?php echo $viewPropPageTabQuip; ?></h3>
							<p class="text-muted"><?php echo $htmlAllowed1; ?></p>
							<form action="" method="post">
								<div class="form-group">
									<textarea class="form-control" name="viewpageContent" id="viewpageContent" rows="14"><?php echo htmlspecialchars_decode($viewrow['pageContent']); ?></textarea>
								</div>
								<button type="input" name="submit" value="viewPage" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
							</form>
						</section>
					</li>
					<li class="<?php echo $abtSet; ?>">
						<h4 class="tabHeader" tabindex="0"><?php echo $aboutUsNavLink; ?></h4>
						<section class="tabContent" id="about">
							<h3><?php echo $aboutUsPageTabQuip; ?></h3>
							<p class="text-muted"><?php echo $htmlAllowed1; ?></p>
							<form action="" method="post">
								<div class="form-group">
									<textarea class="form-control" name="aboutpageContent" id="aboutpageContent" rows="14"><?php echo htmlspecialchars_decode($aboutrow['pageContent']); ?></textarea>
								</div>
								<button type="input" name="submit" value="aboutPage" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
							</form>
						</section>
					</li>
					<li class="<?php echo $cntSet; ?>">
						<h4 class="tabHeader" tabindex="0"><?php echo $contactUsNavLink; ?></h4>
						<section class="tabContent" id="contact">
							<h3><?php echo $contUsPageTabQuip; ?></h3>
							<p class="text-muted"><?php echo $htmlAllowed1; ?></p>
							<form action="" method="post">
								<div class="form-group">
									<textarea class="form-control" name="contactpageContent" id="contactpageContent" rows="14"><?php echo htmlspecialchars_decode($contactrow['pageContent']); ?></textarea>
								</div>
								<button type="input" name="submit" value="contactPage" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
							</form>
						</section>
					</li>
					<li class="<?php echo $rntSet; ?>">
						<h4 class="tabHeader" tabindex="0"><?php echo $rentAppNavLink; ?></h4>
						<section class="tabContent" id="rental">
							<h3><?php echo $rentAppPageTabQuip; ?></h3>
							<p class="text-muted"><?php echo $htmlAllowed1; ?></p>
							<form action="" method="post">
								<div class="form-group">
									<textarea class="form-control" name="rentpageContent" id="rentpageContent" rows="14"><?php echo htmlspecialchars_decode($rentrow['pageContent']); ?></textarea>
								</div>
								<button type="input" name="submit" value="rentPage" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
							</form>
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