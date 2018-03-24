<?php

if (isset($_POST['submit']) && $_POST['submit'] == 'addUnits') {
  // User Validations
  if($_POST['propertyId'] == '') {
    $msgBox = alertBox("Property should be selected ", "<i class='fa fa-times-circle'></i>", "danger");
  } else if($_POST['unitCount'] == '') {
    $msgBox = alertBox("Count should greater than 1", "<i class='fa fa-times-circle'></i>", "danger");
  } else if($_POST['unitPrefix'] == '') {
    $msgBox = alertBox("Enter a prefix", "<i class='fa fa-times-circle'></i>", "danger");
  } else if($_POST['courtName'] == '') {
    $msgBox = alertBox("Enter court name", "<i class='fa fa-times-circle'></i>", "danger");
  }  else {
    // Set some variables
    $propertyId = htmlspecialchars($_POST['propertyId']);
    $unitCount = htmlspecialchars($_POST['unitCount']);
    $unitPrefix = htmlspecialchars($_POST['unitPrefix']);
    $courtName = htmlspecialchars($_POST['courtName']);

    $sql = "select * from properties where propertyId=".stripChar($propertyId);
    $res = mysqli_query($mysqli, $sql) or die('-1' . mysqli_error($mysqli));

    $row = mysqli_fetch_assoc($res);
    if(isset($row)){
      $propertyName=$row['propertyName'];
      $propertyDesc=$row['propertyDesc'];
      $propertyAddress=$row['propertyAddress'];
      $propertyRate=$row['propertyRate'];
      $latePenalty=$row['latePenalty'];
      $propertyDeposit=$row['propertyDeposit'];
      $petsAllowed=$row['petsAllowed'];
      $propertyType=$row['propertyType'];
      $propertyStyle=$row['propertyStyle'];
      $yearBuilt=$row['yearBuilt'];
      $propertySize=$row['propertySize'];
      $parking=$row['parking'];
      $heating=$row['heating'];
      $bedrooms=$row['bedrooms'];
      $bathrooms=$row['bathrooms'];
      $googleMap=$row['googleMap'];

      $propManager=$row['landlordId'];

      for($x=1;$x<=(int)$unitCount;$x++){

        $unitName = $unitPrefix.$x;

        $stmt = $mysqli->prepare("
        INSERT INTO
        properties(
          adminId,
          propertyName,
          propertyDesc,
          propertyAddress,
          propertyRate,
          latePenalty,
          propertyDeposit,
          petsAllowed,
          propertyType,
          propertyStyle,
          yearBuilt,
          propertySize,
          parking,
          heating,
          bedrooms,
          bathrooms,
          googleMap,
          lastUpdated,
          unitName,
          courtName,
          landlordId
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
            ?,
            ?,
            ?,
            ?,
            NOW(),
            ?,
            ?,
            ?
            )");
            $stmt->bind_param('ssssssssssssssssssss',
            $rs_adminId,
            $propertyName,
            $propertyDesc,
            $propertyAddress,
            $propertyRate,
            $latePenalty,
            $propertyDeposit,
            $petsAllowed,
            $propertyType,
            $propertyStyle,
            $yearBuilt,
            $propertySize,
            $parking,
            $heating,
            $bedrooms,
            $bathrooms,
            $googleMap,
            $unitName,
            $courtName,
            $propManager
          );
          $stmt->execute();

          echo $stmt->error;
          $stmt->close();


          $data =
          array(
            "createdBy" => "swiftcloudace",
            "invoiceNumber" => $unitName,
            "customerRef" => $unitName,
            "name" => $propertyName,
            "recurring" => "Y",
            "remarks" => $propertyName."payments",
            "status" => "ACTIVE",
            "serviceCode" => "01",
            "type" => "1",
            "merchantId" => "1002",
            "amount" => $propertyRate
          );
          $data_string = json_encode($data);

          $ch = curl_init('http://localhost:8094/invoice/create/v1');
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
          );

          $result = curl_exec($ch);
        }

        header("Location: index.php?action=viewParent&propertyId=".$propertyId);
        $msgBox = alertBox($newPropMsg, "<i class='fa fa-check-square'></i>", "success");
      }
    }
  }
  $propPage = 'true';
  $pageTitle = $newPropertyPageTitle;
  $addCss = '<link href="../css/chosen.css" rel="stylesheet">';
  $chosen = 'true';

  include 'includes/header.php';
  ?>
  <div class="container page_block noTopBorder">
    <hr class="mt-0 mb-0" />

    <?php
    if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
      if ($msgBox) { echo $msgBox; }
      ?>
      <h3><?php echo $pageTitle; ?></h3>

      <form action="" method="post" class="mb-20">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="propertyName"><?php echo $propNameField; ?></label>
              <select class="form-control chosen-select" name="propertyId" id="propertyId">
                <?php

                $sql = "SELECT DISTINCT(properties.propertyName),managers.name,properties.propertyId FROM `properties` inner join managers on properties.landlordId=managers.id where properties.propertyStyle='Apartment' order by properties.lastUpdated desc";
                $res = mysqli_query($mysqli, $sql) or die('-1' . mysqli_error($mysqli));

                while ($row = mysqli_fetch_assoc($res)) { ?>
                  <option value="<?php echo $row["propertyId"];?>"><?php echo $row["propertyName"]; ?> (<?php echo $row["name"]; ?>)</option>
                  <?php
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <label for="unit">Number of Units</label>
            <input type="text" class="form-control" name="unitCount" id="unitCount" required="required" value="<?php echo isset($_POST['unitCount']) ? $_POST['unitCount'] : ''; ?>" />
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="unitPrefix">Unit Prefix</label>
              <input type="text" class="form-control" name="unitPrefix" id="unitPrefix" required="required" value="<?php echo isset($_POST['unitPrefix']) ? $_POST['unitPrefix'] : ''; ?>" />
            </div>
          </div>

        </div>
        <div class="row">

          <div class="col-md-6">
            <div class="form-group">
              <label for="courtName">Court Name</label>
              <input type="text" class="form-control" name="courtName" id="courtName" required="required" value="<?php echo isset($_POST['courtName']) ? $_POST['courtName'] : ''; ?>" />
            </div>
          </div>
        </div>

        <button type="input" name="submit" value="addUnits" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> Create</button>
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
