<?php
	$docId = $mysqli->real_escape_string($_GET['docId']);
	
	// Get the File Uploads Folder from the Site Settings
	$uploadsDir = $set['userDocsPath'];
	
	$qry = "SELECT
				userdocs.*,
				CONCAT(users.userFirstName,' ',users.userLastName) AS user,
				users.userFolder,
				users.isResident,
				admins.adminName
			FROM
				userdocs
				LEFT JOIN users ON userdocs.userId = users.userId
				LEFT JOIN admins ON userdocs.adminId = admins.adminId
			WHERE
				userdocs.docId = ".$docId;
	$res = mysqli_query($mysqli, $qry) or die('-1' . mysqli_error());
	$row = mysqli_fetch_assoc($res);
	
	if ($row['isResident'] == '1') { $accType = $residentText; } else { $accType = $tenantText;  }

	$tenPage = 'true';
	$pageTitle = $viewDocumentPageTitle;

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('SITEALRTS', $auths)) || $rs_isAdmin != '') {
				if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo $viewDocH3.' '.$accType.' '.$viewDocH31; ?></h3>
		
				<div class="row mb-10">
						<div class="col-md-4">
							<ul class="list-group">
								<li class="list-group-item"><strong><?php echo $titleText; ?></strong> <?php echo clean($row['docTitle']); ?></li>
								<li class="list-group-item"><strong><?php echo $tenantHead; ?>:</strong>
									<a href="index.php?action=viewTenant&userId=<?php echo $row['userId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewTenantText; ?>">
										<?php echo clean($row['user']); ?>
									</a>
								</li>
								<li class="list-group-item"><strong><?php echo $uploadedByText; ?></strong> <?php echo clean($row['adminName']); ?></li>
								<li class="list-group-item"><strong><?php echo $uploadedOnText; ?></strong> <?php echo dateFormat($row['uploadDate']); ?></li>
							</ul>
							<p><strong><?php echo $docDescText; ?></strong> <?php echo clean($row['docDesc']); ?></p>
						</div>
						<div class="col-md-8">
							<?php
								//Get File Extension
								$ext = substr(strrchr($row['docUrl'],'.'), 1);
								$imgExts = array('gif','GIF','jpg','JPG','jpeg','JPEG','png','PNG','tiff','TIFF','tif','TIF','bmp','BMP');

								if (in_array($ext, $imgExts)) {
									echo '
											<p>
												<a href="../'.$uploadsDir.$row['userFolder'].'/'.$row['docUrl'].'" target="_blank">
													<img alt="'.clean($row['docTitle']).'" src="../'.$uploadsDir.$row['userFolder'].'/'.$row['docUrl'].'" class="img-responsive" />
												</a>
											</p>
										';
								} else {
									echo '
											<div class="alertMsg default mb-20">
												<div class="msgIcon pull-left">
													<i class="fa fa-info-circle"></i>
												</div>
												'.$noPreviewAvailText.' '.clean($row['docTitle']).'
											</div>
											<p>
												<a href="../'.$uploadsDir.$row['userFolder'].'/'.$row['docUrl'].'" class="btn btn-success btn-icon" target="_blank">
												<i class="fa fa-download"></i> Download Document: '.$row['docTitle'].'</a>
											</p>
										';
								}
							?>
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