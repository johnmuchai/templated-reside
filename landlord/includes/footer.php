	<div class="container footer_block noBotBorder mt-20">
		<div class="row">
			<div class="col-md-3">
				<h4 class="footer-hLine"><?php echo $availPropNavLink; ?></h4>
				<div class="footerTags">

				</div>
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
