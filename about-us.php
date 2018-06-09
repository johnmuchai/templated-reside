<?php
	// Check if install.php is present
	if(is_dir('install')) {
		header("Location: install/install.php");
	} else {
		if(!isset($_SESSION)) session_start();

		// Access DB Info
		include('config.php');

		// Get Settings Data
		include ('includes/settings.php');
		$set = mysqli_fetch_assoc($setRes);

		// Include Functions
		include('includes/functions.php');

		// Include Sessions & Localizations
		include('includes/sessions.php');

		// Get Manager/Admin Data
		$qry = "SELECT * FROM admins WHERE isDisabled = 0";
		$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());

		// Get Home Page Content
		$pageCont = "SELECT * FROM sitecontent WHERE pageId = 4";
		$pcres = mysqli_query($mysqli, $pageCont) or die('-2' . mysqli_error());
		$pc = mysqli_fetch_assoc($pcres);

		$aboutPage = 'true';
		$pageTitle = $aboutUsNavLink;

		include('includes/header.php');
?>
		<div class="container page_block noTopBorder">
			<?php if ($msgBox) { echo $msgBox; } ?>

			<hr class="mt-0 mb-0" />

			<?php if ($pc['pageContent'] != '') { ?>
				<div class="intro-text">
					<?php echo htmlspecialchars_decode($pc['pageContent']); ?>
				</div>
			<?php } ?>
		</div>

		
<?php
		include('includes/footer.php');
	}
?>
