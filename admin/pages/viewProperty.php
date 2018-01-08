<?php
	$propertyId = $mysqli->real_escape_string($_GET['propertyId']);
	$currentDay = date('d');
	$assignCheck = '';
	$enableHoa = $set['enableHoa'];
	if ($enableHoa == '1') { $showHoa = '6'; } else { $showHoa = '12'; }

	$amnSet = 'active';
	$listSet = $hoaSet = '';

	$tenantIsLate = '';

	// Get the Property Pictures Directory
	$propPicsPath = $set['propPicsPath'];

	// Get the picture file types allowed from Site Settings
	$picsAllowed = $set['propPicsAllowed'];
	// Replace the commas with a comma space
	$propPicsAllowed = preg_replace('/,/', ', ', $picsAllowed);

	// Get the Uploads Directory
	$uploadPath = $set['uploadPath'];

	// Get the file types allowed from Site Settings
	$filesAllowed = $set['fileTypesAllowed'];
	// Replace the commas with a comma space
	$fileTypesAllowed = preg_replace('/,/', ', ', $filesAllowed);

	// Get the Max Upload Size allowed
    $maxUpload = (int)(ini_get('upload_max_filesize'));

	$ipAddress = $_SERVER['REMOTE_ADDR'];

	// Update Property Info
	if (isset($_POST['submit']) && $_POST['submit'] == 'editProperty') {
		// User Validations
		if($_POST['propertyName'] == '') {
			$msgBox = alertBox($propNameReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['propertyAddress'] == '') {
			$msgBox = alertBox($propAddReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['propertyRate'] == '') {
			$msgBox = alertBox($propRateReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['propertyType'] == '') {
			$msgBox = alertBox($propTypeReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['propertyStyle'] == '') {
			$msgBox = alertBox($propStyleReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$propertyName = htmlspecialchars($_POST['propertyName']);
			$propertyAddress = htmlspecialchars($_POST['propertyAddress']);
			$propertyDesc = allowedHTML(htmlspecialchars($_POST['propertyDesc']));
			$propertyRate = htmlspecialchars($_POST['propertyRate']);
			$propertyDeposit = htmlspecialchars($_POST['propertyDeposit']);
			$latePenalty = htmlspecialchars($_POST['latePenalty']);
			$propertyType = htmlspecialchars($_POST['propertyType']);
			$propertyStyle = htmlspecialchars($_POST['propertyStyle']);
			$petsAllowed = htmlspecialchars($_POST['petsAllowed']);
			$yearBuilt = htmlspecialchars($_POST['yearBuilt']);
			$propertySize = htmlspecialchars($_POST['propertySize']);
			$bedrooms = htmlspecialchars($_POST['bedrooms']);
			$bathrooms = htmlspecialchars($_POST['bathrooms']);
			$parking = htmlspecialchars($_POST['parking']);
			$heating = htmlspecialchars($_POST['heating']);
			$googleMap = htmlspecialchars($_POST['googleMap']);

			$stmt = $mysqli->prepare("UPDATE
										properties
									SET
										propertyName = ?,
										propertyAddress = ?,
										propertyDesc = ?,
										propertyRate = ?,
										propertyDeposit = ?,
										latePenalty = ?,
										propertyType = ?,
										propertyStyle = ?,
										petsAllowed = ?,
										yearBuilt = ?,
										propertySize = ?,
										bedrooms = ?,
										bathrooms = ?,
										parking = ?,
										heating = ?,
										googleMap = ?,
										lastUpdated = NOW()
									WHERE
										propertyId = ?"
			);
			$stmt->bind_param('sssssssssssssssss',
									$propertyName,
									$propertyAddress,
									$propertyDesc,
									$propertyRate,
									$propertyDeposit,
									$latePenalty,
									$propertyType,
									$propertyStyle,
									$petsAllowed,
									$yearBuilt,
									$propertySize,
									$bedrooms,
									$bathrooms,
									$parking,
									$heating,
									$googleMap,
									$propertyId
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$updPropInfoAct.' "'.$propertyName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($updPropInfoMsg." \"".$propertyName."\" ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");
		}
	}

	// Set as a Featured Property
	if (isset($_POST['submit']) && $_POST['submit'] == 'setFeatured') {
		$propertyName = htmlspecialchars($_POST['propertyName']);

		$stmt = $mysqli->prepare("UPDATE properties SET featured = 1 WHERE propertyId = ?");
		$stmt->bind_param('s', $propertyId);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '2';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$featuredPropAct1.' "'.$propertyName.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($thePropText." ".$propertyName." ".$featuredPropMsg1, "<i class='fa fa-check-square'></i>", "success");
	}

	// Remove as a Featured Property
	if (isset($_POST['submit']) && $_POST['submit'] == 'remFeatured') {
		$propertyName = htmlspecialchars($_POST['propertyName']);

		$stmt = $mysqli->prepare("UPDATE properties SET featured = 0 WHERE propertyId = ?");
		$stmt->bind_param('s', $propertyId);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '2';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$featuredPropAct2.' "'.$propertyName.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($thePropText." ".$propertyName." ".$featuredPropMsg2, "<i class='fa fa-check-square'></i>", "success");
	}

	// Upload Featured Image
	if (isset($_POST['submit']) && $_POST['submit'] == 'uploadImage') {
		// Get the File Types allowed
		$fileExt = $set['propPicsAllowed'];
		$allowed = preg_replace('/,/', ', ', $fileExt); // Replace the commas with a comma space (, )
		$ftypes = array($fileExt);
		$ftypes_data = explode( ',', $fileExt );

		$propertyName = htmlspecialchars($_POST['propertyName']);

		// Check file type
		$ext = substr(strrchr(basename($_FILES['file']['name']), '.'), 1);
		if (!in_array($ext, $ftypes_data)) {
			$msgBox = alertBox($featuredImgError, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			// Rename the Featured Image to the Properties Name
			$picName = clean(strip($propertyName));

			// Replace any spaces with an underscore
			// And set to all lower-case
			$newName = str_replace(' ', '-', $picName);
			$fileName = strtolower($newName);

			// Generate a RANDOM Hash
			$randomHash = uniqid(rand());
			// Take the first 8 hash digits and use them as part of the Image Name
			$randHash = substr($randomHash, 0, 8);

			$fullName = $fileName.'-'.$randHash;

			// set the upload path
			$picUrl = basename($_FILES['file']['name']);

			// Get the files original Ext
			$extension = explode(".", $picUrl);
			$extension = end($extension);

			// Set the files name to the name set in the form
			// And add the original Ext
			$newPicName = $fullName.'.'.$extension;
			$movePath = '../'.$propPicsPath.$newPicName;

			$stmt = $mysqli->prepare("
								UPDATE
									properties
								SET
									propertyImage = ?
								WHERE
									propertyId = ?");
			$stmt->bind_param('ss',
							   $newPicName,
							   $propertyId);

			if (move_uploaded_file($_FILES['file']['tmp_name'], $movePath)) {
				$stmt->execute();
				$msgBox = alertBox($featuredImgMsg, "<i class='fa fa-check-square'></i>", "success");
				$stmt->close();

				// Add Recent Activity
				$activityType = '2';
				$rs_uid = '0';
				$activityTitle = $rs_adminName.' '.$featuredImgAct1.' '.$propertyName;
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
			} else {
				$msgBox = alertBox($featuredImgMsgErr, "<i class='fa fa-times-circle'></i>", "danger");

				// Add Recent Activity
				$activityType = '2';
				$rs_uid = '0';
				$activityTitle = $featuredImgAct2.' '.$propertyName.' '.$templUplActError1;
				updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
			}
		}
	}

	// Delete Featured Image
	if (isset($_POST['submit']) && $_POST['submit'] == 'deleteImage') {
		$propertyImage = htmlspecialchars($_POST['propertyImage']);
		$propertyName = htmlspecialchars($_POST['propertyName']);

		$filePath = '../'.$propPicsPath.$propertyImage;

		// Delete the Featured Image from the server
		if (file_exists($filePath)) {
			unlink($filePath);

			// Update the Property record
			$picImage = 'genericRental.png';
			$stmt = $mysqli->prepare("
								UPDATE
									properties
								SET
									propertyImage = ?
								WHERE
									propertyId = ?");
			$stmt->bind_param('ss',
							   $picImage,
							   $propertyId);
			$stmt->execute();
			$msgBox = alertBox($featuredImgErr1, "<i class='fa fa-check-square'></i>", "success");
			$stmt->close();

			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delFeaturedImgAct1.' '.$propertyName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		} else {
			$msgBox = alertBox($featuredImgErr2, "<i class='fa fa-warning'></i>", "warning");

			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $delFeaturedImgAct2.' '.$propertyName.' '.$deleteFileAct2;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}
	}

	// Upload Property Pictures
	if (isset($_POST['submit']) && $_POST['submit'] == 'uploadPics') {
		$uplSuccess = '';

		// Get the File Types allowed
		$fileExt = $set['propPicsAllowed'];
		$allowed = preg_replace('/,/', ', ', $fileExt); // Replace the commas with a comma space (, )
		$ftypes = array($fileExt);
		$ftypes_data = explode( ',', $fileExt );

		$propertyName = htmlspecialchars($_POST['propertyName']);

		// Get total Upload Count
		$picCount = count($_FILES['files']['name']);

		$i = 0;
		while($i < $picCount) {
			$ext = substr(strrchr(basename($_FILES['files']['name'][$i]), '.'), 1);

			if (in_array($ext, $ftypes_data)) {
				// Rename the Featured Image to the Properties Name
				$picName = clean(strip($propertyName));

				// Replace any spaces with an underscore
				// And set to all lower-case
				$newName = str_replace(' ', '-', $picName);
				$fileName = strtolower($newName);

				// Generate a RANDOM Hash
				$randomHash = uniqid(rand());
				// Take the first 8 hash digits and use them as part of the Image Name
				$randHash = substr($randomHash, 0, 8);

				$fullName = $fileName.'-'.$randHash;

				// set the upload path
				$picUrl = basename($_FILES['files']['name'][$i]);

				// Get the files original Ext
				$extension = explode(".", $picUrl);
				$extension = end($extension);

				// Set the files name to the name set in the form
				// And add the original Ext
				$newPicName = $fullName.'.'.$extension;
				$movePath = '../'.$propPicsPath.$newPicName;

				$stmt = $mysqli->prepare("
									INSERT INTO
										proppictures(
											propertyId,
											adminId,
											picUrl,
											uploadDate,
											ipAddress
										) VALUES (
											?,
											?,
											?,
											NOW(),
											?
										)");
				$stmt->bind_param('ssss',
					$propertyId,
					$rs_adminId,
					$newPicName,
					$ipAddress
				);

				if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $movePath)) {
					$stmt->execute();
					$stmt->close();

					$msgBox = alertBox($propPicsUploadedMsg, "<i class='fa fa-check-square'></i>", "success");
					$uplSuccess = 'true';
				} else {
					$msgBox = alertBox($propPicsUploadedMsg2, "<i class='fa fa-times-circle'></i>", "danger");
					$uplSuccess = 'false';
				}
			}
			$i++;
		}

		if ($uplSuccess == 'true') {
			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$propPicsUploadedAct1.' '.$propertyName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		} else if ($uplSuccess == 'false') {
			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $propPicsUploadedAct2.' '.$propertyName.' '.$templUplActError1;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}
	}

	// Delete Property Picture
	if (isset($_POST['submit']) && $_POST['submit'] == 'delPicture') {
		$pictureId = htmlspecialchars($_POST['pictureId']);
		$propertyName = htmlspecialchars($_POST['propertyName']);
		$picUrl = htmlspecialchars($_POST['picUrl']);

		$filePath = '../'.$propPicsPath.$picUrl;

		// Delete the Picture from the server
		if (file_exists($filePath)) {
			unlink($filePath);

			$stmt = $mysqli->prepare("DELETE FROM proppictures WHERE pictureId = ".$pictureId);
			$stmt->execute();
			$stmt->close();

			$msgBox = alertBox($delPropPicMsg, "<i class='fa fa-check-square'></i>", "success");

			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$delPropPicAct1.' '.$propertyName;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		} else {
			$msgBox = alertBox($delPropPicMsg1, "<i class='fa fa-warning'></i>", "warning");

			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $delPropPicAct2.' '.$propertyName.' '.$deleteFileAct2;
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}
	}

	// Update Property Amenities
	if (isset($_POST['submit']) && $_POST['submit'] == 'editDetails') {
		$propertyAmenities = htmlspecialchars($_POST['propertyAmenities']);
		$propertyName = htmlspecialchars($_POST['propertyName']);

		$stmt = $mysqli->prepare("UPDATE
									properties
								SET
									propertyAmenities = ?
								WHERE
									propertyId = ?"
		);
		$stmt->bind_param('ss',
								$propertyAmenities,
								$propertyId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '2';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$updAmnAct.' "'.$propertyName.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($updAmnMsg." ".$propertyName." ".$admAuthsUpdMsg2, "<i class='fa fa-check-square'></i>", "success");

		$amnSet = 'active';
		$listSet = $hoaSet = '';
	}

	// Update Property Listing
	if (isset($_POST['submit']) && $_POST['submit'] == 'editListing') {
		$propertyListing = htmlspecialchars($_POST['propertyListing']);
		$propertyName = htmlspecialchars($_POST['propertyName']);

		$stmt = $mysqli->prepare("UPDATE
									properties
								SET
									propertyListing = ?
								WHERE
									propertyId = ?"
		);
		$stmt->bind_param('ss',
								$propertyListing,
								$propertyId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '2';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$updListingAct.' "'.$propertyName.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($updListingMsg." ".$propertyName." ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");

		$listSet = 'active';
		$amnSet = $hoaSet = '';
	}

	// Update Property HOA
	if (isset($_POST['submit']) && $_POST['submit'] == 'editHoa') {
		$hoaName = htmlspecialchars($_POST['hoaName']);
		$hoaPhone = htmlspecialchars($_POST['hoaPhone']);
		$hoaFee = htmlspecialchars($_POST['hoaFee']);
		$feeSchedule = htmlspecialchars($_POST['feeSchedule']);
		$hoaAddress = htmlspecialchars($_POST['hoaAddress']);
		$propertyName = htmlspecialchars($_POST['propertyName']);

		$stmt = $mysqli->prepare("UPDATE
									properties
								SET
									hoaName = ?,
									hoaPhone = ?,
									hoaFee = ?,
									feeSchedule = ?,
									hoaAddress = ?
								WHERE
									propertyId = ?"
		);
		$stmt->bind_param('ssssss',
								$hoaName,
								$hoaPhone,
								$hoaFee,
								$feeSchedule,
								$hoaAddress,
								$propertyId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '2';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$updHoaAct.' "'.$propertyName.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($updHoaMsg." ".$propertyName." ".$servReqUpdatedMsg2, "<i class='fa fa-check-square'></i>", "success");

		$hoaSet = 'active';
		$amnSet = $listSet = '';
	}

	// Record a Payment Received
	if (isset($_POST['submit']) && $_POST['submit'] == 'recordPay') {
		// User Validations
		if($_POST['paymentDate'] == '') {
			$msgBox = alertBox($payDateReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['paymentFor'] == '') {
			$msgBox = alertBox($payForReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['amountPaid'] == '') {
			$msgBox = alertBox($payAmtReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['paymentType'] == '') {
			$msgBox = alertBox($payTypeReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$paymentDate = htmlspecialchars($_POST['paymentDate']);
			$paymentFor = htmlspecialchars($_POST['paymentFor']);
			$amountPaid = htmlspecialchars($_POST['amountPaid']);
			$paymentType = htmlspecialchars($_POST['paymentType']);
			$rentMonth = htmlspecialchars($_POST['rentMonth']);
			$rentYear = htmlspecialchars($_POST['rentYear']);
			$notes = htmlspecialchars($_POST['notes']);
			$propertyName = htmlspecialchars($_POST['propertyName']);
			$leaseId = htmlspecialchars($_POST['leaseId']);
			$userId = htmlspecialchars($_POST['userId']);

			if ($_POST['penaltyFee'] == '') { $penaltyFee = null; } else { $penaltyFee = htmlspecialchars($_POST['penaltyFee']); }
			if ($rentMonth == '...') {
				$isRent = '0';
				$rntMonth = null;
			} else {
				$isRent = '1';
				$rntMonth = $rentMonth;
			}
			if ($rentYear == '') {
				$rntYear = null;
			} else {
				$rntYear = $rentYear;
			}

			$stmt = $mysqli->prepare("
								INSERT INTO
									payments(
										leaseId,
										propertyId,
										adminId,
										userId,
										paymentDate,
										amountPaid,
										penaltyFee,
										paymentFor,
										paymentType,
										isRent,
										rentMonth,
										rentYear,
										notes,
										lastUpdated,
										ipAddress
									) VALUES (
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										NOW(),
										?
									)
			");
			$stmt->bind_param('ssssssssssssss',
				$leaseId,
				$propertyId,
				$rs_adminId,
				$userId,
				$paymentDate,
				$amountPaid,
				$penaltyFee,
				$paymentFor,
				$paymentType,
				$isRent,
				$rntMonth,
				$rntYear,
				$notes,
				$ipAddress
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$savePayAct.' "'.$propertyName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

			$msgBox = alertBox($savePayMsg." \"".$propertyName."\" ".$newDiscCmtMsg2."-".$stmt->error. "<i class='fa fa-check-square'></i>", "success");

			// Clear the Form of values
			$_POST['paymentDate'] = $_POST['paymentFor'] = $_POST['amountPaid'] = $_POST['penaltyFee'] = $_POST['paymentType'] = $_POST['notes'] = '';
		}
	}

	// Assign Property
	if (isset($_POST['submit']) && $_POST['submit'] == 'assignProp') {
		$assignAdmin = htmlspecialchars($_POST['assignAdmin']);
		$propertyName = htmlspecialchars($_POST['propertyName']);

		$stmt = $mysqli->prepare("
							INSERT INTO
								assigned(
									propertyId,
									adminId,
									assignDate,
									ipAddress
								) VALUES (
									?,
									?,
									NOW(),
									?
								)
		");
		$stmt->bind_param('sss',
			$propertyId,
			$assignAdmin,
			$ipAddress
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '2';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$assignPropAct.' "'.$propertyName.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($thePropText." ".$propertyName." ".$assignPropMsg, "<i class='fa fa-check-square'></i>", "success");
	}

	// Reassign Property
	if (isset($_POST['submit']) && $_POST['submit'] == 'reassignProp') {
		$reassignAdmin = htmlspecialchars($_POST['reassignAdmin']);
		$propertyName = htmlspecialchars($_POST['propertyName']);

		// Delete the current Assigned Record
		$stmt = $mysqli->prepare("DELETE FROM assigned WHERE propertyId = ?");
		$stmt->bind_param('s', $propertyId);
		$stmt->execute();
		$stmt->close();

		if ($reassignAdmin != '0') {
			// Add the new Assign Record
			$stmt = $mysqli->prepare("
								INSERT INTO
									assigned(
										propertyId,
										adminId,
										assignDate,
										ipAddress
									) VALUES (
										?,
										?,
										NOW(),
										?
									)
			");
			$stmt->bind_param('sss',
				$propertyId,
				$reassignAdmin,
				$ipAddress
			);
			$stmt->execute();
			$stmt->close();

			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$reassignPropAct.' "'.$propertyName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		} else {
			// Add Recent Activity
			$activityType = '2';
			$rs_uid = '0';
			$activityTitle = $rs_adminName.' '.$reassignPropAct1.' "'.$propertyName.'"';
			updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
		}

		$msgBox = alertBox($thePropText." ".$propertyName." ".$reassignPropMsg, "<i class='fa fa-check-square'></i>", "success");
	}

	// Add Resident
	if (isset($_POST['submit']) && $_POST['submit'] == 'addResident') {
		$theResident = htmlspecialchars($_POST['theResident']);
		$propertyName = htmlspecialchars($_POST['propertyName']);
		$leaseId = htmlspecialchars($_POST['leaseId']);
		$priTenantId = htmlspecialchars($_POST['priTenantId']);

		$stmt = $mysqli->prepare("UPDATE
									users
								SET
									isLeased = 1,
									propertyId = ?,
									leaseId = ?,
									primaryTenantId = ?
								WHERE
									userId = ?"
		);
		$stmt->bind_param('ssss',
								$propertyId,
								$leaseId,
								$theResident,
								$priTenantId
		);
		$stmt->execute();
		$stmt->close();

		// Add Recent Activity
		$activityType = '2';
		$rs_uid = '0';
		$activityTitle = $rs_adminName.' '.$addResAct.' "'.$propertyName.'"';
		updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);

		$msgBox = alertBox($addResMsg." ".$propertyName, "<i class='fa fa-check-square'></i>", "success");
	}

	// Upload File
	if (isset($_POST['submit']) && $_POST['submit'] == 'uploadFile') {
		// User Validations
		if($_POST['fileName'] == '') {
			$msgBox = alertBox($fileTitleReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['fileDesc'] == '') {
			$msgBox = alertBox($fileDescReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else {
			$fileName = htmlspecialchars($_POST['fileName']);
			$fileDesc = htmlspecialchars($_POST['fileDesc']);
			$propertyName = htmlspecialchars($_POST['propertyName']);

			// Get the File Types allowed
			$fileExt = $set['fileTypesAllowed'];
			$allowed = preg_replace('/,/', ', ', $fileExt); // Replace the commas with a comma space (, )
			$ftypes = array($fileExt);
			$ftypes_data = explode( ',', $fileExt );

			// Check file type
			$ext = substr(strrchr(basename($_FILES['file']['name']), '.'), 1);
			if (!in_array($ext, $ftypes_data)) {
				$msgBox = alertBox($fileTypeNotAllowed, "<i class='fa fa-times-circle'></i>", "danger");
			} else {
				// Rename the File to the Properties Name
				$fName = clean(strip($propertyName));

				// Replace any spaces with an underscore
				// And set to all lower-case
				$newName = str_replace(' ', '-', $fName);
				$newFName = strtolower($newName);

				// Generate a RANDOM Hash
				$randomHash = uniqid(rand());
				// Take the first 8 hash digits and use them as part of the Image Name
				$randHash = substr($randomHash, 0, 8);

				$fullName = $newFName.'-'.$randHash;

				// set the upload path
				$fileUrl = basename($_FILES['file']['name']);

				// Get the files original Ext
				$extension = explode(".", $fileUrl);
				$extension = end($extension);

				// Set the files name to the name set in the form
				// And add the original Ext
				$newFileName = $fullName.'.'.$extension;
				$movePath = '../'.$uploadPath.$newFileName;

				$stmt = $mysqli->prepare("
									INSERT INTO
										propfiles(
											propertyId,
											adminId,
											fileName,
											fileDesc,
											fileUrl,
											uploadDate,
											ipAddress
										) VALUES (
											?,
											?,
											?,
											?,
											?,
											NOW(),
											?
										)");
				$stmt->bind_param('ssssss',
					$propertyId,
					$rs_adminId,
					$fileName,
					$fileDesc,
					$newFileName,
					$ipAddress
				);

				if (move_uploaded_file($_FILES['file']['tmp_name'], $movePath)) {
					$stmt->execute();
					$msgBox = alertBox($theFileText." ".$fileName." ".$hasBeenUplAct, "<i class='fa fa-check-square'></i>", "success");
					$stmt->close();

					// Add Recent Activity
					$activityType = '19';
					$rs_uid = '0';
					$activityTitle = $rs_adminName.' '.$propFileUplAct.' '.$propertyName;
					updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
				} else {
					$msgBox = alertBox($propFileUplError, "<i class='fa fa-times-circle'></i>", "danger");

					// Add Recent Activity
					$activityType = '19';
					$rs_uid = '0';
					$activityTitle = $aFileForText.' '.$propertyName.' '.$templUplActError1;
					updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
				}
			}
		}
	}

	// Check if the Property has an active lease
	$lc = "SELECT
				isLeased
			FROM
				properties
			WHERE
				propertyId = ".$propertyId;
	$lcres = mysqli_query($mysqli, $lc) or die('-1' . mysqli_error());
	$lcrow = mysqli_fetch_assoc($lcres);
	$leaseCheck = $lcrow['isLeased'];

	// Get Data
	if ($leaseCheck == '1') {
		$leasedProp = 'Leased';

		$qry = "SELECT
					properties.*,
					leases.*,
					assigned.adminId AS assignedTo,
					users.userId,
					CONCAT(users.userFirstName,' ',users.userLastName) AS user,
					admins.adminId,
					admins.adminName
				FROM
					properties
					LEFT JOIN leases ON properties.propertyId = leases.propertyId
					LEFT JOIN assigned ON properties.propertyId = assigned.propertyId
					LEFT JOIN admins ON assigned.adminId = admins.adminId
					LEFT JOIN users ON properties.propertyId = users.propertyId
				WHERE
					leases.closed = 0 AND
					properties.propertyId = ".$propertyId." AND
					users.isResident = 0";
		$res = mysqli_query($mysqli, $qry) or die('-2' . mysqli_error());
		$row = mysqli_fetch_assoc($res);

		$priTenantId = $row['userId'];

		// Get Residents
		$resqry = "SELECT * FROM users WHERE isResident = 1 AND propertyId = ".$propertyId." AND leaseId = ".$row['leaseId'];
		$qryres = mysqli_query($mysqli, $resqry) or die('-5' . mysqli_error());

		if ($rs_isAdmin == '') {
			$assignCheck = $row['assignedTo'];
		} else {
			$assignCheck = '';
		}
	} else {
		$leasedProp = $unlsdText;
		$assignCheck = '';

		$qry = "SELECT * FROM properties WHERE propertyId = ".$propertyId;
		$res = mysqli_query($mysqli, $qry) or die('-3' . mysqli_error());
		$row = mysqli_fetch_assoc($res);
	}

	$lateRentAmt = $row['propertyRate'] + $row['latePenalty'];

	// Get Property Pictures
	$stmt = "SELECT * FROM proppictures WHERE propertyId = ".$propertyId;
	$results = mysqli_query($mysqli, $stmt) or die('-4' . mysqli_error());

	// Get Property Files
	$sqlstmt = "SELECT * FROM propfiles WHERE propertyId = ".$propertyId;
	$sqlres = mysqli_query($mysqli, $sqlstmt) or die('-6' . mysqli_error());

	// Get Active Service Requests
	$srv = "SELECT
				servicerequests.*,
				servicepriority.priorityTitle
			FROM
				servicerequests
				LEFT JOIN servicepriority ON servicerequests.requestPriority = servicepriority.priorityId
			WHERE servicerequests.isClosed = 0 AND servicerequests.propertyId = ".$propertyId;
	$srvres = mysqli_query($mysqli, $srv) or die('-7' . mysqli_error());

	if ($leaseCheck == '1') {
		// Check if the Tenant is late on current month's rent
		$todayDate = date("Y-m-d");
		$currentYear = date('Y');
		$currentMonth = date('F');

		$latecheck1 = "SELECT
						users.leaseId,
						leases.leaseStart
					FROM
						users
						LEFT JOIN leases ON users.leaseId = leases.leaseId
					WHERE
						users.leaseId = ".$row['leaseId']." AND
						'".$todayDate."' >= leases.leaseStart";
		$lateres1 = mysqli_query($mysqli, $latecheck1) or die('-8' . mysqli_error());

		if (mysqli_num_rows($lateres1) > 0) {
			$latecheck2 = "SELECT
							payments.*,
							users.leaseId,
							users.propertyId
						FROM
							payments
							LEFT JOIN users ON payments.userId = users.userId
						WHERE
							users.leaseId = ".$row['leaseId']." AND
							payments.rentMonth = '".$currentMonth."' AND
							payments.rentYear = '".$currentYear."'";
			$lateres = mysqli_query($mysqli, $latecheck2) or die('-9' . mysqli_error());
			if (mysqli_num_rows($lateres) > 0) { $tenantIsLate = 'false'; } else { $tenantIsLate = 'true'; }
		} else {
			$tenantIsLate = 'false';
		}
	}

	if ($row['petsAllowed'] == '1') {
		$pets = $yesBtn;
		$setSel = 'selected';
	} else {
		$pets = $noBtn;
		$setSel = '';
	}

	if (isset($_GET['delFile']) && $_GET['delFile'] == 'yes') {
		$msgBox = alertBox($propFileDltdMsg, "<i class='fa fa-check-square'></i>", "success");
	}

	$propPage = 'true';
	$pageTitle = $leasedProp.' '.$propertyHead;
	$addCss = '<link rel="stylesheet" type="text/css" href="../css/datetimepicker.css" /><link href="../css/chosen.css" rel="stylesheet">';
	$datePicker = 'true';
	$chosen = 'true';
	$jsFile = 'viewProperty';

	include 'includes/header.php';
?>
	<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />

		<?php
			if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
				// If the Property is assigned, is it assigned to the logged in manager?
				if ($assignCheck == '' || $assignCheck == $rs_adminId) {
					if ($msgBox) { echo $msgBox; }
		?>
				<h3><?php echo clean($row['propertyName']); ?></h3>
				<input type="hidden" id="weekStart" value="<?php echo $set['weekStart']; ?>" />

				<div class="row">
					<div class="col-md-8">
						<section class="viewProp mt-10 mb-20">
							<p class="lead mb-0 mt-0"><?php echo $leasedProp.' '.clean($row['propertyType']).' '.clean($row['propertyStyle']); ?></p>
							<div class="propFee clearfix">
								<div class="propPrice"><?php echo formatCurrency($row['propertyRate'],$currCode); ?> <small class="text-muted"><?php echo $slashMonthText; ?></small></div>
							</div>

							<hr />

							<div class="row mb-10">
								<div class="col-sm-8">
									<?php if ($row['featured'] == '1') { ?>
										<span class="ribbon top-left listed ribbon-primary">
											<small><?php echo $featuredText; ?></small>
										</span>
									<?php } ?>
									<img alt="" src="../<?php echo $propPicsPath.clean($row['propertyImage']); ?>" class="img-responsive" />
									<p class="lead mb-0 mt-10"><?php echo nl2br(clean($row['propertyAddress'])); ?></p>
								</div>
								<div class="col-sm-4">
									<ul class="propLists">
										<li><strong><?php echo $bedroomsText; ?></strong>: <?php echo clean($row['bedrooms']); ?></li>
										<li><strong><?php echo $bathroomsText; ?></strong>: <?php echo clean($row['bathrooms']); ?></li>
										<li><strong><?php echo $sixeText; ?></strong>: <?php echo clean($row['propertySize']); ?></li>
										<li><strong><?php echo $heatingText; ?></strong>: <?php echo clean($row['heating']); ?></li>
										<li><strong><?php echo $yearBuiltText; ?></strong>: <?php echo clean($row['yearBuilt']); ?></li>
										<li><strong><?php echo $petsText; ?></strong>: <?php echo $pets; ?></li>
										<li><strong><?php echo $parkingText; ?></strong>: <?php echo clean($row['parking']); ?></li>
										<li><strong><?php echo $depositText; ?></strong>: <?php echo formatCurrency($row['propertyDeposit'],$currCode); ?></li>
										<li><strong><?php echo $lateFeeText; ?></strong>: <?php echo formatCurrency($row['latePenalty'],$currCode); ?></li>
									</ul>
									<a data-toggle="modal" href="#editProperty" class="btn btn-xs btn-info btn-icon"><i class="fa fa-pencil"></i> <?php echo $updInfoBtn; ?></a>
									<a data-toggle="modal" href="#setFeatured" class="btn btn-xs btn-primary btn-icon"><i class="fa fa-bookmark"></i> <?php echo $setFeaturedBtn; ?></a>
								</div>
							</div>

							<div class="modal fade" id="editProperty" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
											<h4 class="modal-title"><?php echo $updPropInfoH4; ?></h4>
										</div>
										<form action="" method="post">
											<div class="modal-body">
												<div class="form-group">
													<label for="propertyName"><?php echo $propNameField; ?></label>
													<input type="text" class="form-control" name="propertyName" id="propertyName" required="required" value="<?php echo clean($row['propertyName']); ?>" />
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="propertyAddress"><?php echo $propAddressField; ?></label>
															<textarea class="form-control" name="propertyAddress" id="propertyAddress" required="required" rows="3"><?php echo clean($row['propertyAddress']); ?></textarea>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="propertyDesc"><?php echo $propDescField; ?></label>
															<textarea class="form-control" name="propertyDesc" id="propertyDesc" required="required" rows="3"><?php echo clean($row['propertyDesc']); ?></textarea>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="propertyRate"><?php echo $propRateField; ?></label>
															<input type="text" class="form-control" name="propertyRate" id="propertyRate" required="required" value="<?php echo clean($row['propertyRate']); ?>" />
															<span class="help-block"><?php echo $numbersOnlyHelp; ?></span>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="propertyDeposit"><?php echo $propDepAmtField; ?></label>
															<input type="text" class="form-control" name="propertyDeposit" id="propertyDeposit" required="required" value="<?php echo clean($row['propertyDeposit']); ?>" />
															<span class="help-block"><?php echo $numbersOnlyHelp; ?></span>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="latePenalty"><?php echo $propLateFeeField; ?></label>
															<input type="text" class="form-control" name="latePenalty" id="latePenalty" required="required" value="<?php echo clean($row['latePenalty']); ?>" />
															<span class="help-block"><?php echo $numbersOnlyHelp; ?></span>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="propertyType"><?php echo $propTypeField; ?></label>
															<input type="text" class="form-control" name="propertyType" id="propertyType" required="required" value="<?php echo clean($row['propertyType']); ?>" />
															<span class="help-block"><?php echo $propTypeFieldHelp; ?></span>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="propertyStyle"><?php echo $propStyleField; ?></label>
															<input type="text" class="form-control" name="propertyStyle" id="propertyStyle" required="required" value="<?php echo clean($row['propertyStyle']); ?>" />
															<span class="help-block"><?php echo $propStyleFieldHelp; ?></span>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="petsAllowed"><?php echo $petsAllowedHead; ?></label>
															<select class="form-control chosen-select" name="petsAllowed" id="petsAllowed">
																<option value="0"><?php echo $noBtn; ?></option>
																<option value="1" <?php echo $setSel; ?>><?php echo $yesBtn; ?></option>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-3">
														<div class="form-group">
															<label for="yearBuilt"><?php echo $yearBuiltText; ?></label>
															<input type="text" class="form-control" name="yearBuilt" id="yearBuilt" value="<?php echo clean($row['yearBuilt']); ?>" />
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="propertySize"><?php echo $propSizeField; ?></label>
															<input type="text" class="form-control" name="propertySize" id="propertySize" value="<?php echo clean($row['propertySize']); ?>" />
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="bedrooms"><?php echo $propBedsField; ?></label>
															<input type="text" class="form-control" name="bedrooms" id="bedrooms" value="<?php echo clean($row['bedrooms']); ?>" />
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="bathrooms"><?php echo $propBathsField; ?></label>
															<input type="text" class="form-control" name="bathrooms" id="bathrooms" value="<?php echo clean($row['bathrooms']); ?>" />
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="parking"><?php echo $propParkField; ?></label>
															<input type="text" class="form-control" name="parking" id="parking" value="<?php echo clean($row['parking']); ?>" />
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="heating"><?php echo $propHeatingField; ?></label>
															<input type="text" class="form-control" name="heating" id="heating" value="<?php echo clean($row['heating']); ?>" />
														</div>
													</div>
												</div>

												<div class="form-group">
													<label for="googleMap"><?php echo $propGoogleMapField; ?></label>
													<textarea class="form-control" name="googleMap" id="googleMap" rows="3"><?php echo clean($row['googleMap']); ?></textarea>
													<span class="help-block"><?php echo $propGoogleMapFieldHelp; ?></span>
												</div>
											</div>
											<div class="modal-footer">
												<button type="input" name="submit" value="editProperty" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $updPropInfoH4; ?></button>
												<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>

							<div class="modal fade" id="setFeatured" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<form action="" method="post">
											<div class="modal-body">
												<?php if ($row['featured'] == '0') { ?>
													<p class="lead"><?php echo $setFeaturedConf1; ?></p>
												<?php } else { ?>
													<p class="lead"><?php echo $setFeaturedConf2; ?></p>
												<?php } ?>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
												<?php if ($row['featured'] == '0') { ?>
													<button type="input" name="submit" value="setFeatured" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $setFeaturedPropBtn; ?></button>
												<?php } else { ?>
													<button type="input" name="submit" value="remFeatured" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $yesBtn; ?></button>
												<?php } ?>
												<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>

							<?php if (!is_null($row['googleMap'])) { ?>
								<iframe width="100%" height="240" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $row['googleMap']; ?>" class="mapBorder"></iframe>
							<?php } ?>

							<p class="lead"><?php echo nl2br(htmlspecialchars_decode($row['propertyDesc'])); ?></p>
						</section>

						<hr class="mt-0" />

						<h3><?php echo clean($row['propertyName']); ?> <?php echo $propPicsH3; ?></h3>
						<p><?php echo $propPicsQuip; ?></p>

						<?php if(mysqli_num_rows($results) > 0) { ?>
							<div class="gallery">
								<?php while ($pic = mysqli_fetch_assoc($results)) { ?>
									<a data-toggle="modal" href="#viewPicture<?php echo $pic['pictureId']; ?>">
										<img src="../<?php echo $propPicsPath.$pic['picUrl']; ?>" />
									</a>

									<div class="modal fade" id="viewPicture<?php echo $pic['pictureId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-body">
													<img src="../<?php echo $propPicsPath.$pic['picUrl']; ?>" class="img-responsive" />
													<small><?php echo $imageText; ?>: <?php echo $propPicsPath.$pic['picUrl']; ?></small>
												</div>
												<div class="modal-footer">
													<a data-toggle="modal" href="#delPicture<?php echo $pic['pictureId']; ?>" class="btn btn-danger btn-icon" data-dismiss="modal"><i class="fa fa-trash"></i> <?php echo $deletePicBtn; ?></a>
													<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
												</div>
											</div>
										</div>
									</div>

									<div class="modal fade" id="delPicture<?php echo $pic['pictureId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<form action="" method="post">
													<div class="modal-body">
														<p class="lead"><?php echo $deletePropPicConf; ?></p>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="pictureId" value="<?php echo clean($pic['pictureId']); ?>" />
														<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
														<input type="hidden" name="picUrl" value="<?php echo clean($pic['picUrl']); ?>" />
														<button type="input" name="submit" value="delPicture" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $deletePicBtn; ?></button>
														<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
													</div>
												</form>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						<?php } ?>

						<div class="clearfix"></div>

						<?php if ($row['propertyImage'] != 'genericRental.png') { ?>
							<a data-toggle="modal" href="#deleteImage" class="btn btn-xs btn-warning btn-icon mt-10"><i class="fa fa-times"></i> <?php echo $delFeaturedImgBtn; ?></a>

							<div class="modal fade" id="deleteImage" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<form action="" method="post">
											<div class="modal-body">
												<p class="lead"><?php echo $delFeaturedImgConf; ?></p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="propertyImage" value="<?php echo clean($row['propertyImage']); ?>" />
												<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
												<button type="input" name="submit" value="deleteImage" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $delFeaturedImgBtn; ?></button>
												<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>
						<?php } else { ?>
							<a data-toggle="modal" href="#uploadImage" class="btn btn-xs btn-success btn-icon mt-10"><i class="fa fa-upload"></i> <?php echo $uplFeaturedImgBtn; ?></a>

							<div class="modal fade" id="uploadImage" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
											<h4 class="modal-title"><?php echo $uplFeaturedImgH4; ?></h4>
										</div>
										<form enctype="multipart/form-data" action="" method="post">
											<div class="modal-body">
												<p>
													<?php echo $uplFeaturedImgQuip1; ?><br />
													<small>
														<?php echo $uplFeaturedImgQuip2; ?> <?php echo $propPicsAllowed; ?><br />
														<?php echo $maxUploadSizeText.' '.$maxUpload; ?> mb.
													</small>
												</p>
												<div class="form-group">
													<label for="file"><?php echo $uplFeaturedImgField; ?></label>
													<input type="file" id="file" name="file" required="required" />
												</div>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
												<button type="input" name="submit" value="uploadImage" class="btn btn-success btn-icon"><i class="fa fa-upload"></i> <?php echo $uploadBtn; ?></button>
												<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>
						<?php } ?>

						<a data-toggle="modal" href="#uploadPics" class="btn btn-xs btn-success btn-icon mt-10"><i class="fa fa-upload"></i> <?php echo $uplPropPicsBtn; ?></a>

						<div class="modal fade" id="uploadPics" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
										<h4 class="modal-title"><?php echo $uplPropPicsH4; ?></h4>
									</div>
									<form enctype="multipart/form-data" action="" method="post">
										<div class="modal-body">
											<p>
												<small>
													<?php echo $uplPropPicsQuip1; ?> <?php echo $propPicsAllowed; ?><br />
													<?php echo $uplPropPicsQuip2; ?><br />
													<?php echo $maxUploadSizeText.' '.$maxUpload; ?> mb.
												</small>
											</p>
											<div class="form-group">
												<label for="files"><?php echo $uplPropPicsField; ?></label>
												<input type="file" id="files" name="files[]" multiple="multiple" required="required" />
											</div>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
											<button type="input" name="submit" value="uploadPics" class="btn btn-success btn-icon"><i class="fa fa-upload"></i> <?php echo $uplPropPicturesBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<hr />

						<div class="tabs">
							<ul class="tabsBody">
								<li class="<?php echo $amnSet; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $propAmenitiesH4; ?></h4>
									<section class="tabContent" id="amenities">
										<h3><?php echo $propAmenitiesH4; ?></h3>
										<p><?php echo nl2br(htmlspecialchars_decode($row['propertyAmenities'])); ?></p>
										<a data-toggle="modal" href="#editDetails" class="btn btn-xs btn-info btn-icon"><i class="fa fa-pencil"></i> <?php echo $updPropAmenitiesBtn; ?></a>

										<div class="modal fade" id="editDetails" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
														<h4 class="modal-title"><?php echo $updPropAmenitiesBtn; ?></h4>
													</div>
													<form action="" method="post">
														<div class="modal-body">
															<div class="form-group">
																<textarea class="form-control" name="propertyAmenities" id="propertyAmenities" required="required" rows="12"><?php echo clean($row['propertyAmenities']); ?></textarea>
																<span class="help-block"><?php echo $htmlAllowed1; ?></span>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
															<button type="input" name="submit" value="editDetails" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $updPropAmenitiesBtn; ?></button>
															<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</section>
								</li>
								<li class="<?php echo $listSet; ?>">
									<h4 class="tabHeader" tabindex="0"><?php echo $propListingH4; ?></h4>
									<section class="tabContent" id="listing">
										<h3><?php echo $propListingH4; ?></h3>
										<p><?php echo nl2br(htmlspecialchars_decode($row['propertyListing'])); ?></p>
										<a data-toggle="modal" href="#editListing" class="btn btn-xs btn-info btn-icon"><i class="fa fa-pencil"></i> <?php echo $updPropListingField; ?></a>

										<div class="modal fade" id="editListing" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
														<h4 class="modal-title"><?php echo $updPropListingField; ?></h4>
													</div>
													<form action="" method="post">
														<div class="modal-body">
															<div class="form-group">
																<textarea class="form-control" name="propertyListing" id="propertyListing" required="required" rows="12"><?php echo clean($row['propertyListing']); ?></textarea>
																<span class="help-block"><?php echo $htmlAllowed1; ?></span>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
															<button type="input" name="submit" value="editListing" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $updPropListingField; ?></button>
															<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</section>
								</li>
								<?php if ($enableHoa == '1') { ?>
									<li class="<?php echo $hoaSet; ?>">
										<h4 class="tabHeader" tabindex="0"><?php echo $propHoaH4; ?></h4>
										<section class="tabContent" id="hoa">
											<h3><?php echo $hoaTitleH3; ?></h3>
											<ul class="propLists">
												<li><strong><?php echo $hoaNameText; ?></strong>: <?php echo clean($row['hoaName']); ?></li>
												<li><strong><?php echo $hoaPhoneText; ?></strong>: <?php echo clean($row['hoaPhone']); ?></li>
												<li><strong><?php echo $hoaAddressText; ?></strong>:<br /><?php echo nl2br(clean($row['hoaAddress'])); ?></li>
												<li><strong><?php echo $hoaFeeText; ?></strong>: <?php echo formatCurrency($row['hoaFee'],$currCode); ?></li>
												<li><strong>HOA Fee Schedule</strong>: <?php echo clean($row['feeSchedule']); ?></li>
											</ul>
											<a data-toggle="modal" href="#editHoa" class="btn btn-xs btn-info btn-icon"><i class="fa fa-pencil"></i> <?php echo $updateHoaInfoBtn; ?></a>

											<div class="modal fade" id="editHoa" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
															<h4 class="modal-title"><?php echo $updHoaInfoBtn; ?></h4>
														</div>
														<form action="" method="post">
															<div class="modal-body">
																<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="hoaName"><?php echo $hoaNameText; ?></label>
																			<input type="text" class="form-control" name="hoaName" id="hoaName" value="<?php echo clean($row['hoaName']); ?>" />
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="hoaPhone"><?php echo $hoaPhoneText; ?></label>
																			<input type="text" class="form-control" name="hoaPhone" id="hoaPhone" value="<?php echo clean($row['hoaPhone']); ?>" />
																		</div>
																	</div>
																</div>

																<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="hoaFee"><?php echo $hoaFeeText; ?></label>
																			<input type="text" class="form-control" name="hoaFee" id="hoaFee" value="<?php echo clean($row['hoaFee']); ?>" />
																			<span class="help-block"><?php echo $numbersOnlyHelp; ?></span>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="feeSchedule"><?php echo $hoaFeeSchedText; ?></label>
																			<input type="text" class="form-control" name="feeSchedule" id="feeSchedule" value="<?php echo clean($row['feeSchedule']); ?>" />
																			<span class="help-block"><?php echo $hoaFeeSchedHelp; ?></span>
																		</div>
																	</div>
																</div>

																<div class="form-group">
																	<label for="hoaAddress"><?php echo $hoaAddressText; ?></label>
																	<textarea class="form-control" name="hoaAddress" id="hoaAddress" rows="3"><?php echo clean($row['hoaAddress']); ?></textarea>
																</div>
															</div>
															<div class="modal-footer">
																<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
																<button type="input" name="submit" value="editHoa" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $updateHoaInfoBtn; ?></button>
																<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</section>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<div class="col-md-4">
						<?php if ($leaseCheck == '1') { ?>
							<ul class="list-group mb-10">
								<?php
									if ($set['enablePayments'] == '1') {
										if ($tenantIsLate == 'true') {
											if ($currentDay > '5') {
												echo '
														<li class="list-group-item late-rent">
															<span data-toggle="tooltip" data-placement="top" title="'.$rentRatePlusFeeText.'">
															<strong>Current Amount Past-Due:</strong> '.formatCurrency($lateRentAmt,$currCode).'
															</span>
														</li>
													';
											} else {
												echo '
														<li class="list-group-item amount-due">
															<span data-toggle="tooltip" data-placement="top" title="'.$rentalRateHead.'">
															<strong>Current Amount Due:</strong> '.formatCurrency($row['propertyRate'],$currCode).'
															</span>
														</li>
													';
											}
										} else if ($tenantIsLate == 'false') {
											echo '
													<li class="list-group-item month-paid">
														<span data-toggle="tooltip" data-placement="top" title="'.$rentPaidText.'">
														<strong>Current Amount Due:</strong> '.formatCurrency('0.00',$currCode).'
														</span>
													</li>
												';
										} else {
											echo '
													<li class="list-group-item amount-due">
														<span data-toggle="tooltip" data-placement="top" title="'.$rentalRateHead.'">
														<strong>Current Amount Due:</strong> '.formatCurrency($row['propertyRate'],$currCode).'
														</span>
													</li>
												';
										}
									}
								?>
							</ul>

							<ul class="list-group mb-10">
								<li class="list-group-item">
									<strong><?php echo $tenantHead; ?>:</strong>
									<a href="index.php?action=viewTenant&userId=<?php echo $row['userId']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $viewTenantText; ?>">
										<?php echo clean($row['user']); ?>
									</a>
								</li>
								<li class="list-group-item">
									<strong><?php echo $leaseTermText; ?></strong> <?php echo clean($row['leaseTerm']); ?><br />
									<small><?php echo dateFormat($row['leaseStart']); ?> &mdash; <?php echo dateFormat($row['leaseEnd']); ?></small>
								</li>
								<li class="list-group-item">
									<strong><?php echo $mngLandlordText; ?>:</strong>
									<?php
										if ($row['adminName'] != '') {
											echo
												clean($row['adminName']).'
												<a data-toggle="modal" href="#reassignProp" class="btn btn-xs btn-default btn-icon"><i class="fa fa-pencil"></i> '.$reassignPropText.'</a>
											';
									?>
											<div class="modal fade" id="reassignProp" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
															<h4 class="modal-title"><?php echo $reassignPropH4; ?></h4>
														</div>
														<form action="" method="post">
															<div class="modal-body">
																<?php
																	$reassign = "SELECT * FROM admins WHERE isActive = 1 AND adminId != ".$row['adminId'];
																	$reassignres = mysqli_query($mysqli, $reassign) or die('-1'.mysqli_error());
																?>
																<div class="form-group">
																	<select class="form-control chosen-select" id="reassignAdmin" name="reassignAdmin">
																		<option value="..."><?php echo $selectAdminOpt; ?></option>
																		<option value="0"><?php echo $remAssignedText; ?></option>
																		<?php
																			while ($ra = mysqli_fetch_assoc($reassignres)) {
																				echo '<option value="'.$ra['adminId'].'">'.$ra['adminName'].'</option>';
																			}
																		?>
																	</select>
																	<span class="help-block"><?php echo $remAssignedTextHelp; ?></span>
																</div>
															</div>
															<div class="modal-footer">
																<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
																<button type="input" name="submit" value="reassignProp" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
																<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
															</div>
														</form>
													</div>
												</div>
											</div>
									<?php
										} else {
											echo '
												Unassigned<br />
												<a data-toggle="modal" href="#assignProp" class="btn btn-xs btn-default btn-icon"><i class="fa fa-pencil"></i> Assign Property</a>
											';
									?>
											<div class="modal fade" id="assignProp" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
															<h4 class="modal-title"><?php echo $assignPropH4; ?></h4>
														</div>
														<form action="" method="post">
															<div class="modal-body">
																<?php
																	$assign = "SELECT * FROM admins WHERE isActive = 1";
																	$assignres = mysqli_query($mysqli, $assign) or die('-1'.mysqli_error());
																?>
																<div class="form-group">
																	<select class="form-control chosen-select" id="assignAdmin" name="assignAdmin">
																		<option value="..."><?php echo $selectAdminOpt; ?></option>
																		<?php
																			while ($a = mysqli_fetch_assoc($assignres)) {
																				echo '<option value="'.$a['adminId'].'">'.$a['adminName'].'</option>';
																			}
																		?>
																	</select>
																</div>
															</div>
															<div class="modal-footer">
																<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
																<button type="input" name="submit" value="assignProp" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
																<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
															</div>
														</form>
													</div>
												</div>
											</div>
									<?php
										}
									?>
								</li>
							</ul>
							<a href="index.php?action=viewLease&leaseId=<?php echo $row['leaseId']; ?>" class="btn btn-sm btn-success btn-block btn-icon"><i class="fa fa-file-text"></i> <?php echo $viewLeaseText; ?></a>
							<?php if ($set['enablePayments'] == '1') { ?>
								<a data-toggle="modal" href="#recordPay" class="btn btn-sm btn-success btn-block btn-icon"><i class="fa fa-credit-card"></i> <?php echo $newPropPayBtn; ?></a>
								<a href="index.php?action=viewPayments&leaseId=<?php echo $row['leaseId']; ?>" class="btn btn-sm btn-success btn-block btn-icon"><i class="fa fa-usd"></i> <?php echo $payHistNavLink; ?></a>

								<div class="modal fade" id="recordPay" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
												<h4 class="modal-title"><?php echo $recPayRecvdText; ?></h4>
											</div>
											<form action="" method="post">
												<div class="modal-body">
													<?php
														if ($tenantIsLate == 'true') {
															if ($currentDay > '5') {
																echo '<div class="well well-warning well-sm">'.$currAmyPastDueText.' '.formatCurrency($lateRentAmt,$currCode).'</div>';
															} else {
																echo '<div class="well well-success well-sm">'.$currAmtDueText.' '.formatCurrency($row['propertyRate'],$currCode).'</div>';
															}
														} else if ($tenantIsLate == 'false') {
															echo '<div class="well well-success well-sm">'.$currAmtDueText.' '.formatCurrency('0.00',$currCode).'</div>';
														} else {
															echo '<div class="well well-success well-sm">'.$currAmtDueText.' '.formatCurrency($row['propertyRate'],$currCode).'</div>';
														}
													?>

													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label for="paymentDate"><?php echo $datePayRcvdField; ?></label>
																<input type="text" class="form-control" name="paymentDate" id="paymentDate" required="required" value="<?php echo isset($_POST['paymentDate']) ? $_POST['paymentDate'] : ''; ?>" />
																<span class="help-block"><?php echo $datePayRcvdFieldHelp; ?></span>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="paymentFor"><?php echo $paymentForHead; ?></label>
																<input type="text" class="form-control" name="paymentFor" id="paymentFor" required="required" value="<?php echo isset($_POST['paymentFor']) ? $_POST['paymentFor'] : ''; ?>" />
																<span class="help-block"><?php echo $payForFieldHelp; ?></span>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label for="amountPaid"><?php echo $paymentAmtField; ?></label>
																<input type="text" class="form-control" name="amountPaid" id="amountPaid" required="required" value="<?php echo isset($_POST['amountPaid']) ? $_POST['amountPaid'] : ''; ?>" />
																<span class="help-block"><?php echo $payAmtHelp; ?></span>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="penaltyFee"><?php echo $latePayFeeField; ?></label>
																<input type="text" class="form-control" name="penaltyFee" id="penaltyFee" value="<?php echo isset($_POST['penaltyFee']) ? $_POST['penaltyFee'] : ''; ?>" />
																<span class="help-block"><?php echo $latePayFeeFieldHelp; ?></span>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label for="paymentType"><?php echo $payTypeField; ?></label>
																<input type="text" class="form-control" name="paymentType" id="paymentType" required="required" value="<?php echo isset($_POST['paymentType']) ? $_POST['paymentType'] : ''; ?>" />
																<span class="help-block"><?php echo $payTypeFieldHelp; ?></span>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label for="rentMonth"><?php echo $rentMonthField; ?></label>
																<select class="form-control chosen-select" name="rentMonth" id="rentMonth">
																	<option value="..."><?php echo $noneOption; ?></option>
																	<option value="January"><?php echo $janText; ?></option>
																	<option value="February"><?php echo $febText; ?></option>
																	<option value="March"><?php echo $marText; ?></option>
																	<option value="April"><?php echo $aprText; ?></option>
																	<option value="May"><?php echo $mayText; ?></option>
																	<option value="June"><?php echo $junText; ?></option>
																	<option value="July"><?php echo $julText; ?></option>
																	<option value="August"><?php echo $augText; ?></option>
																	<option value="September"><?php echo $septText; ?></option>
																	<option value="October"><?php echo $octText; ?></option>
																	<option value="November"><?php echo $novText; ?></option>
																	<option value="December"><?php echo $decText; ?></option>
																</select>
																<span class="help-block"><?php echo $rentMonthFieldHelp; ?></span>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label for="rentYear"><?php echo $rentYearFeild; ?></label>
																<input type="text" class="form-control" name="rentYear" id="rentYear" value="<?php echo isset($_POST['rentYear']) ? $_POST['rentYear'] : ''; ?>" />
																<span class="help-block"><?php echo $rentYearFeildHelp; ?></span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<label for="notes"><?php echo $paymentNotesText; ?></label>
														<textarea class="form-control" name="notes" id="notes" rows="3"><?php echo isset($_POST['notes']) ? $_POST['notes'] : ''; ?></textarea>
														<span class="help-block"><?php echo $payNotesQuip; ?></span>
													</div>
												</div>
												<div class="modal-footer">
													<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
													<input type="hidden" name="leaseId" value="<?php echo clean($row['leaseId']); ?>" />
													<input type="hidden" name="userId" value="<?php echo clean($row['userId']); ?>" />
													<button type="input" name="submit" value="recordPay" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $savePaymentBtn; ?></button>
													<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
												</div>
											</form>
										</div>
									</div>
								</div>
							<?php } ?>

							<h3><?php echo $residentsTexhH3; ?></h3>
							<?php
								if(mysqli_num_rows($qryres) > 0) {
									echo '<ul class="list-group">';
									while ($resrow = mysqli_fetch_assoc($qryres)) {
										if ($resrow['primaryPhone'] != '') { $residentPhone = decryptIt($resrow['primaryPhone']); } else { $residentPhone = ''; }
							?>
										<a href="index.php?action=viewTenant&userId=<?php echo $resrow['userId']; ?>" class="list-group-item group-item-sm">
											<strong><?php echo clean($resrow['userFirstName']).' '.clean($resrow['userLastName']); ?></strong>
										</a>
							<?php
									}
									echo '</ul>';
								} else {
							?>
								<div class="alertMsg default mb-20">
									<div class="msgIcon pull-left">
										<i class="fa fa-info-circle"></i>
									</div>
									<?php echo $noResidentsFoundMsg; ?>
								</div>
							<?php } ?>
							<a data-toggle="modal" href="#addResident" class="btn btn-sm btn-info btn-block btn-icon"><i class="fa fa-user"></i> <?php echo $addResBtn; ?></a>

							<div class="modal fade" id="addResident" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
											<h4 class="modal-title"><?php echo $addResH4; ?></h4>
										</div>
										<form action="" method="post">
											<div class="modal-body">
												<?php
													$rsdnt = "SELECT * FROM users WHERE isActive = 1 AND isResident = 1 AND isLeased = 0";
													$rsdntres = mysqli_query($mysqli, $rsdnt) or die('-10'.mysqli_error());
												?>
												<?php if(mysqli_num_rows($rsdntres) > 0) { ?>
												<div class="form-group">
													<select class="form-control chosen-select" id="theResident" name="theResident">
														<option value="..."><?php echo $selectResField; ?></option>
														<?php
															while ($b = mysqli_fetch_assoc($rsdntres)) {
																echo '<option value="'.$b['userId'].'">'.$b['userFirstName'].' '.$b['userLastName'].'</option>';
															}
														?>
													</select>
												</div>
												<?php } else { ?>
													<div class="alertMsg default">
														<div class="msgIcon pull-left">
															<i class="fa fa-warning"></i>
														</div>
														<?php echo $noActResidentsFoundMsg; ?>
													</div>
												<?php } ?>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
												<input type="hidden" name="leaseId" value="<?php echo clean($row['leaseId']); ?>" />
												<input type="hidden" name="priTenantId" value="<?php echo $priTenantId; ?>" />
												<button type="input" name="submit" value="addResident" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $saveBtn; ?></button>
												<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>

						<?php } else { ?>
							<div class="alertMsg default">
								<div class="msgIcon pull-left">
									<i class="fa fa-warning"></i>
								</div>
								<?php echo $propNotLeasedText; ?>
							</div>
							<a href="index.php?action=leaseProperty&propertyId=<?php echo $propertyId; ?>" class="btn btn-sm btn-success btn-block btn-icon"><i class="fa fa-file-text"></i> <?php echo $leasePropPageTitle; ?></a>
						<?php } ?>

						<h3><?php echo $propertyFilesH3; ?></h3>
						<?php
							if(mysqli_num_rows($sqlres) > 0) {
								echo '<ul class="list-group">';
								while ($filerow = mysqli_fetch_assoc($sqlres)) {
						?>
									<a href="index.php?action=viewFile&fileId=<?php echo $filerow['fileId']; ?>" class="list-group-item group-item-sm">
										<span class="badge badge-default"><?php echo dateFormat($filerow['uploadDate']); ?></span>
										<strong><?php echo clean($filerow['fileName']); ?></strong>
									</a>
						<?php
								}
								echo '</ul>';
							} else {
						?>
							<div class="alertMsg default mb-20">
								<div class="msgIcon pull-left">
									<i class="fa fa-info-circle"></i>
								</div>
								<?php echo $noUplFilesFoundMsg; ?>
							</div>
						<?php } ?>
						<a href="index.php?action=viewUploads&propertyId=<?php echo $propertyId; ?>" class="btn btn-sm btn-warning btn-block btn-icon"><i class="fa fa-file-o"></i> <?php echo $propUploadsBtn; ?></a>
						<a data-toggle="modal" href="#uploadFile" class="btn btn-sm btn-warning btn-block btn-icon"><i class="fa fa-upload"></i> <?php echo $uplPropFileBtn; ?></a>

						<div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
										<h4 class="modal-title"><?php echo $uplPropFileBtn; ?></h4>
									</div>
									<form enctype="multipart/form-data" action="" method="post">
										<div class="modal-body">
											<p>
												<small>
													<?php echo $propFileTypesAlld; ?>: <?php echo $fileTypesAllowed; ?><br />
													<?php echo $maxUploadSizeText.' '.$maxUpload; ?> mb.
												</small>
											</p>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="fileName"><?php echo $fileTitleField; ?></label>
														<input type="text" class="form-control" name="fileName" id="fileName" required="required" maxlength="50" value="<?php echo isset($_POST['fileName']) ? $_POST['fileName'] : ''; ?>" />
														<span class="help-block"><?php echo $fileTitleFieldHelp; ?></span>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="fileDesc"><?php echo $fileDescText; ?></label>
														<input type="text" class="form-control" name="fileDesc" id="fileDesc" required="required" value="<?php echo isset($_POST['fileDesc']) ? $_POST['fileDesc'] : ''; ?>" />
														<span class="help-block"><?php echo $fileDescFieldHelp; ?></span>
													</div>
												</div>
											</div>

											<div class="form-group">
												<label for="file"><?php echo $selFileField; ?></label>
												<input type="file" id="file" name="file" required="required" />
											</div>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="propertyName" value="<?php echo clean($row['propertyName']); ?>" />
											<button type="input" name="submit" value="uploadFile" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> <?php echo $uplPropertyFileBtn; ?></button>
											<button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> <?php echo $cancelBtn; ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<h3><?php echo $opnReqPageTitle; ?></h3>
						<?php
							if(mysqli_num_rows($srvres) > 0) {
								echo '<ul class="list-group">';
								while ($srvrow = mysqli_fetch_assoc($srvres)) {
						?>
									<a href="index.php?action=viewRequest&requestId=<?php echo $srvrow['requestId']; ?>" class="list-group-item group-item-sm">
										<span class="badge badge-default"><?php echo clean($srvrow['priorityTitle']); ?></span>
										<strong><?php echo clean($srvrow['requestTitle']); ?></strong>
									</a>
						<?php
								}
								echo '</ul>';
							} else {
						?>
							<div class="alertMsg default mb-20">
								<div class="msgIcon pull-left">
									<i class="fa fa-info-circle"></i>
								</div>
								<?php echo $noActServReqMsg; ?>
							</div>
						<?php } ?>
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
		<?php
				}
			} else {
		?>
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
