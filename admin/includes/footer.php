	<div class="container footer_block noBotBorder mt-20">
		<div class="row">
			<div class="col-md-3">

			</div>

			<div class="col-md-5">
				<h4 class="footer-hLine"><?php echo $recentActTitle; ?></h4>
				<?php
					// Get the Recent Activity
					$ra = "SELECT
								*,
								UNIX_TIMESTAMP(activityDate) AS orderDate
							FROM
								activity
							ORDER BY orderDate DESC LIMIT 5";
					$recent = mysqli_query($mysqli, $ra) or die('-100' . mysqli_error());

					if(mysqli_num_rows($recent) > 0) {
				?>
						
				<?php } else { ?>
					<div class="alertMsg default">
						<div class="msgIcon pull-left">
							<i class="fa fa-info-circle"></i>
						</div>
						<?php echo $noActMsg; ?>
					</div>
				<?php } ?>
			</div>

			<div class="col-md-4">
				<div class="dateTime">
					<div class="day"><?php echo date('j'); ?></div>
					<div class="monthYear">
						<?php echo $monthName.' '.date('Y'); ?><br />
						<span><?php echo $dayName; ?></span>
					</div>
				</div>
				<hr class="clearfix" />
				<?php if ($rs_adminLoc != '') { $widgetLoc = $rs_adminLoc; } else { $widgetLoc = $set['weatherLoc']; } ?>
				<input id="weatherLoc" type="hidden" value="<?php echo $widgetLoc; ?>" />
				<div id="weather"></div>
			</div>
		</div>

		<div class="copyright clearfix">
			<div class="pull-left">
				<span><i class="fa fa-copyright"></i> <?php echo $copyrightText; ?> <?php echo date("Y"); ?></span> <?php echo $copyrightLink; ?>
			</div>
			<div class="pull-right">
				<ul class="list-inline footer-nav">
					<li><a href="../index.php"><?php echo $homeNavLink; ?></a></li>
					<li><a href="../available-properties.php"><?php echo $propNavLink; ?></a></li>
					<li><a href="../about-us.php"><?php echo $aboutUsNavLink; ?></a></li>
					<li><a href="../contact-us.php"><?php echo $contactUsNavLink; ?></a></li>
					<li><a data-toggle="modal" href="#signOut"><?php echo $signOutNavLink; ?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<script src="../star/vendors/js/vendor.bundle.base.js"></script>
  <script src="../star/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../star/js/off-canvas.js"></script>
  <script src="../star/js/misc.js"></script>
  <!-- endinject -->
	<script>
	function isNumberKey(evt)
				{
					var charCode = (evt.which) ? evt.which : evt.keyCode;
					if (charCode != 46 && charCode > 31
					&& (charCode < 48 || charCode > 57))
					return false;
					return true;
				}
	</script>

	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<?php
		if (isset($chosen)) {
			echo '
					<script type="text/javascript" src="../js/chosen.jquery.min.js"></script>
					<script type="text/javascript" src="../js/chosen.js"></script>
				';
		}
	?>
	<script type="text/javascript" src="../js/simpleWeather.min.js"></script>
	<script type="text/javascript" src="../js/simpleWeather.js"></script>
	<script type="text/javascript" src="../js/custom.js"></script>
	<?php if (isset($datePicker)) { echo '<script type="text/javascript" src="../js/datetimepicker.js"></script>'; } ?>
	<?php
		if (isset($dataTables)) {
			echo '
				<script src="../js/dataTables.js"></script>
				<script src="../js/dataTables.tableTools.js"></script>
			';
			include('../js/tableTools.php');
		}
	?>
	<?php if (isset($jsFile)) { echo '<script type="text/javascript" src="js/'.$jsFile.'.js"></script>'; } ?>

</body>
</html>
