<?php
	// Update Social Network Settings
	if (isset($_POST['submit']) && $_POST['submit'] == 'socialSettings') {
		$facebook = htmlspecialchars($_POST['facebook']);
		$google = htmlspecialchars($_POST['google']);
		$linkedin = htmlspecialchars($_POST['linkedin']);
		$pinterest = htmlspecialchars($_POST['pinterest']);
		$twitter = htmlspecialchars($_POST['twitter']);
		$youtube = htmlspecialchars($_POST['youtube']);

		$stmt = $mysqli->prepare("UPDATE
									sitesettings
								SET
									facebook = ?,
									google = ?,
									linkedin = ?,
									pinterest = ?,
									twitter = ?,
									youtube = ?
		");
		$stmt->bind_param('ssssss',
							$facebook,
							$google,
							$linkedin,
							$pinterest,
							$twitter,
							$youtube
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '8';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$socNetSettingsAct;
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($socNetSettingsMsg, "<i class='fa fa-check-square'></i>", "success");
	}

	// Get Data
    $qry = "SELECT * FROM sitesettings";
    $res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);

	$managePage = 'true';
	$pageTitle = $socialNetworksPageTitle;

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('SITEALRTS', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
			<h3><?php echo $pageTitle; ?></h3>
			<p><?php echo $socNetPageQuip; ?></p>
			<form action="" method="post">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="facebook"><?php echo $facebookUrl; ?></label>
							<input type="text" class="form-control" name="facebook" id="facebook" value="<?php echo $row['facebook']; ?>" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="google"><?php echo $googleUrl; ?></label>
							<input type="text" class="form-control" name="google" id="google" value="<?php echo $row['google']; ?>" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="linkedin"><?php echo $linkedinUrl; ?></label>
							<input type="text" class="form-control" name="linkedin" id="linkedin" value="<?php echo $row['linkedin']; ?>" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="pinterest"><?php echo $pinterestUrl; ?></label>
							<input type="text" class="form-control" name="pinterest" id="pinterest" value="<?php echo $row['pinterest']; ?>" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="twitter"><?php echo $twitterUrl; ?></label>
							<input type="text" class="form-control" name="twitter" id="twitter" value="<?php echo $row['twitter']; ?>" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="youtube"><?php echo $youtubeUrl; ?></label>
							<input type="text" class="form-control" name="youtube" id="youtube" value="<?php echo $row['youtube']; ?>" />
						</div>
					</div>
				</div>
				<button type="input" name="submit" value="socialSettings" class="btn btn-success btn-icon mt-20 mb-20"><i class="fa fa-check-square-o"></i> <?php echo $saveSocNetSetBtn; ?></button>
			</form>

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