<?php

// Add New Admin Account
if (isset($_POST['submit']) && $_POST['submit'] == 'newManager') {
  // Validation
  if($_POST['name'] == "") {
    $msgBox = alertBox($admNameReq, "<i class='fa fa-times-circle'></i>", "danger");
  } else if($_POST['email'] == "") {
    $msgBox = alertBox($admEmailReq, "<i class='fa fa-times-circle'></i>", "danger");
  } else if($_POST['tradingName'] != $_POST['tradingName']) {
    $msgBox = alertBox($admEmailNoMatch, "<i class='fa fa-warning'></i>", "warning");
  } else {
    // Set some variables
    $dupEmail = '';
    $isActive = htmlspecialchars($_POST['isActive']);
    $adminName = htmlspecialchars($_POST['name']);
    $tname = htmlspecialchars($_POST['tradingName']);
    $adminEmail = htmlspecialchars($_POST['email']);
    $primaryPhone = encryptIt($_POST['phone']);
    $postal_add = htmlspecialchars($_POST['postal_add']);
    $phy_add = htmlspecialchars($_POST['phy_add']);

    // Check for Duplicate email
    $check = $mysqli->query("SELECT 'X' FROM managers WHERE email = '".$adminEmail."'");
    if ($check->num_rows) {
      $dupEmail = 'true';
    }

    // If duplicates are found
    if ($dupEmail != '') {
      $msgBox = alertBox($dupAccountMsg, "<i class='fa fa-warning'></i>", "warning");
    } else {


      $stmt = $mysqli->prepare("
      INSERT INTO
      managers(
        isActive,
        name,
        tradingName,
        email,
        phone,
        phy_add,
        postal_add,
        created_on,
        created_by
        ) VALUES (
          ?,
          ?,
          ?,
          ?,
          ?,
          ?,
          ?,
          NOW(),
          ?
          )");
          $stmt->bind_param('ssssssss',
          $isActive,
          $adminName,
          $tname,
          $adminEmail,
          $primaryPhone,
          $phy_add,
          $postal_add,
          $rs_adminId
        );
        $stmt->execute();

        echo "error-".$stmt->error;
        $stmt->close();



        // Clear the form of Values
        $_POST['name'] = $_POST['tradingName'] = $_POST['email'] = $_POST['phone'] = $_POST['postal_add'] = $_POST['phy_add'] = '';

        // Add Recent Activity
        $activityType = '21';
        $rs_uid = '0';
        $activityTitle = $rs_adminName.' '.$newAdmAccAct.' "'.$adminName.'"';
        updateActivity($rs_adminId,$rs_uid,$activityType,$activityTitle);
        $newmngAccMsg = "New manager created successfully";
        $msgBox = alertBox($newmngAccMsg, "<i class='fa fa-check-square'></i>", "success");
      }
    }
  }

  $adminPage = 'true';
  $pageTitle = 'Create new Management';
  $addCss = '<link href="../css/chosen.css" rel="stylesheet">';
  $chosen = 'true';
  $jsFile = 'newAdmin';

  include 'includes/header.php';
  ?>
  <div class="container page_block noTopBorder">
    <hr class="mt-0 mb-0" />

    <?php
    if ((checkArray('MNGADMINS', $auths)) || $rs_isAdmin != '') {
      if ($msgBox) { echo $msgBox; }
      ?>
      <h3><?php echo $pageTitle; ?></h3>

      <form action="" method="post" class="mb-20">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="isActive"><?php echo $setAccActiveField; ?></label>
              <select class="form-control chosen-select" name="isActive">
                <option value="0"><?php echo $noBtn; ?></option>
                <option value="1" selected><?php echo $yesBtn; ?></option>
              </select>
              <span class="help-block"><?php echo $setAccActiveFieldHelp; ?></span>
            </div>
          </div>
          <div class="col-md-6">

          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Management Name</label>
              <input type="text" class="form-control" name="name" required="required" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="tradingName">Trading Name</label>
              <input type="text" class="form-control" name="tradingName" value="<?php echo isset($_POST['tradingName']) ? $_POST['tradingName'] : ''; ?>" />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" required="required" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="text" class="form-control" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="postal_add">Postal Address</label>
              <input type="text" class="form-control" name="postal_add" value="<?php echo isset($_POST['postal_add']) ? $_POST['postal_add'] : ''; ?>" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="phy_add">Physical Address</label>
              <input type="text" class="form-control" name="phy_add" value="<?php echo isset($_POST['phy_add']) ? $_POST['phy_add'] : ''; ?>" />
            </div>
          </div>
        </div>
        <button type="input" name="submit" value="newManager" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> Create New Management</button>
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
