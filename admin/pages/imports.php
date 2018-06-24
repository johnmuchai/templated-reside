<?php

function array_to_csv_download($array, $filename = "export.csv", $delimiter=",") {
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="'.$filename.'",');

  // open the "output" stream
  // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
  $f = fopen('php://output', 'w');

  foreach ($array as $line) {
    fputcsv($f, $line, $delimiter);
  }
  fclose($f);
}

function generateRandStr_md5 ($length,$prefix) {
  // Perfect for: PASSWORD GENERATION
  // Generate a random string based on an md5 hash
  $randStr = strtoupper(md5(rand(0, 1000000))); // Create md5 hash
  $rand_start = rand(5,strlen($randStr)); // Get random start point
  if($rand_start+$length > strlen($randStr)) {
    $rand_start -= $length; // make sure it will always be $length long
  } if($rand_start == strlen($randStr)) {
    $rand_start = 1; // otherwise start at beginning!
  }
  // Extract the 'random string' of the required length
  $randStr = strtoupper(substr(md5($randStr), $rand_start, $length));
  return $prefix.$randStr; // Return the string
}

// Get Leased Tenant Data

if (isset($_POST['submit']) && $_POST['submit'] == 'importP') {

  if($_POST['manager'] == '') {
    $msgBox = alertBox("Please select Properties Manager", "<i class='fa fa-times-circle'></i>", "danger");
  }else{

    $propManager=htmlspecialchars($_POST['manager']);
    $fname = $_FILES['importfile']['name'];
    $filename = $_FILES['importfile']['tmp_name'];
    $handle = fopen($filename, "r");
    $chk_ext = explode(".",$fname);

    $no = "0";
    $yes = "1";
    $sno = "No";
    //  echo "Here s ".$fname." ".$chk_ext[1];
    if(strtolower($chk_ext[1]) == "csv") {
      $count = 0;
      $resp = array();
      $success = true;
      $outputArray = array();
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        //echo "<br />"."Here ".$count;

        if($count>0){
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
              $data[0],
              $data[12],
              $data[11],
              $data[8],
              $data[10],
              $data[9],
              $no,
              $data[2],
              $data[3],
              $data[7],
              $data[4],
              $data[13],
              $sno,
              $data[5],
              $data[6],
              $data[14],
              $data[1],
              $data[15],
              $propManager
            );
            $res = $stmt->execute();
            //echo "<br />".$stmt->error;
            if($res ==true){

              $data =
              array(
                "createdBy" => "swiftcloudace",
                "invoiceNumber" => $data[1],
                "customerRef" => $data[1],
                "name" => $data[0],
                "recurring" => "Y",
                "remarks" => $data[0]."payments",
                "status" => "ACTIVE",
                "serviceCode" => "01",
                "type" => "1",
                "merchantId" => "1002",
                "amount" => $data[8]
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
              $resp[$count] = "success";
              $data[16]="success";
              $data[17]=$stmt->insert_id;

            }else{
              $resp[$count] = "Error: ".$stmt->error;
              $success = false;
              $data[16]="Errror: ".$stmt->error;
            }
            $stmt->close();
          }else{
            $data[16] = "Status";
            $data[17] = "propertyId";
          }
          $outputArray[] = $data;

          $count++;
        }


        array_to_csv_download($outputArray, $filename = "export.csv", $delimiter=",");

        exit();

        //print_r($resp);
      }
    }

  }

  if (isset($_POST['submit']) && $_POST['submit'] == 'importT') {

    if(false) {
      $msgBox = alertBox("Please select file ", "<i class='fa fa-times-circle'></i>", "danger");
    }else{

      $propManager=htmlspecialchars($_POST['manager']);
      $fname = $_FILES['importfile']['name'];
      $filename = $_FILES['importfile']['tmp_name'];
      $handle = fopen($filename, "r");
      $chk_ext = explode(".",$fname);

      $no = "0";
      $yes = "1";
      $sno = "No";
      //echo "Here s ".$fname." ".$chk_ext[1];
      if(strtolower($chk_ext[1]) == "csv") {
        $count = 0;
        $resp = array();

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          //echo "<br />"."Here ".$count;
          $success = true;
          if($count>0){
            $docFolderName = $data[0].'_'.$data[1];
            $tenantDocs = str_replace(' ', '_', $docFolderName);

            $tenantDocsFolder = strtolower($tenantDocs).'_'.$randHash;

            // Create the Tenant Document Directory
            if (mkdir('../'.$docUploadPath.$tenantDocsFolder, 0755, true)) {
              $newDir = '../'.$docUploadPath.$tenantDocsFolder;
            }



            $hash = md5(rand(0,1000));
            $password = encryptIt('default123');

            $stmt = $mysqli->prepare("
            INSERT INTO
            users(
              isResident,
              primaryTenantId,
              userEmail,
              password,
              userFirstName,
              userLastName,
              primaryPhone,
              altPhone,
              userFolder,
              createDate,
              hash,
              isActive
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
                NOW(),
                ?,
                ?
                )");
                $stmt->bind_param('sssssssssss',
                $no,
                $no,
                $data[3],
                $password,
                $data[0],
                $data[1],
                $data[4],
                $data[5],
                $tenantDocsFolder,
                $hash,
                $yes
              );
              $res = $stmt->execute();



              $userId = $stmt->insert_id;

              $stmt->close();

              //            echo "inserted ".$res." ".$userId;

              if($res==true){

                //echo "here 0";
                $sql = "SHOW TABLE STATUS LIKE 'leases'";
                $result = mysqli_query($mysqli, $sql) or die('-2' . mysqli_error($mysqli));
                $rows = mysqli_fetch_assoc($result);
                $nextLeaseId = $rows['Auto_increment'];

                $notes = "imported";
                $ipAddress="0.0.0.0";

                $leaseNo = generateRandStr_md5 (6,$propertyId);
                $date= date_create($data[8]);
                $leaseStart = date_format($date, 'Y-m-d');
                date_add($date, date_interval_create_from_date_string($data[7].' years'));
                $leaseEnd =  date_format($date, 'Y-m-d');

                //echo "here 1 ".$leaseStart. " ".$leaseEnd;


                $stmt = $mysqli->prepare("
                INSERT INTO
                leases(
                  leaseId,
                  propertyId,
                  adminId,
                  userId,
                  leaseTerm,
                  leaseStart,
                  leaseEnd,
                  notes,
                  closed,
                  ipAddress,
                  leaseNo
                  ) VALUES (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    0,
                    ?,
                    ?
                    )");
                    echo "here 2";
                    $stmt->bind_param('ssssssssss',
                    $nextLeaseId,
                    $data[6],
                    $rs_adminId,
                    $userId,
                    $data[7],
                    $leaseStart,
                    $leaseEnd,
                    $notes,
                    $ipAddress,
                    $leaseNo
                  );
                  //echo "here 3 ".$stmt->error;;
                  $resl = $stmt->execute();
                  //echo "here 4 ".$stmt->error;
                  $stmt->close();

                  //echo "lease ".$resl;

                  // Update the Property as Leased
                  $stmt = $mysqli->prepare("UPDATE
                    properties
                    SET
                    isLeased = 1
                    WHERE
                    propertyId = ?"
                  );
                  $stmt->bind_param('s',$data[6]);
                  $resu = $stmt->execute();
                  $stmt->close();

                  //echo "upd ".$resu;

                  // Update the User as Leased
                  $stmt = $mysqli->prepare("UPDATE
                    users
                    SET
                    isLeased = 1,
                    propertyId = ?,
                    leaseId = ?
                    WHERE
                    userId = ?"
                  );
                  $stmt->bind_param('sss',
                  $data[6],
                  $nextLeaseId,
                  $userId
                );
                $resul = $stmt->execute();
                $stmt->close();

                //echo "upd rl ".$resul;

                $msgBox = alertBox("Tenants and leases created successfully", "<i class='fa fa-check-square'></i>", "success");

              }else{
                //echo "res not true";
              }
            }

            $count++;
          }

          //print_r($resp);
        }
      }
    }

    include 'includes/header.php';
    ?>
    <div class="container page_block noTopBorder">
      <hr class="mt-0 mb-0" />

      <?php
      if ((checkArray('SITESET', $auths)) || $rs_isAdmin != '') {
        if ($msgBox) { echo $msgBox; }
        ?>

        <h3>Import Data</h3>

        <!-- <div class="alertMsg warning">
        <div class="msgIcon pull-left">
        <i class="fa fa-info-circle"></i>
      </div>
    </div> -->

    <hr />

    <div class="row">
      <div class="col-md-6">
        <form action="" method="post" enctype="multipart/form-data">
          <h3>Select Property Manager</h3>
          <div class="form-group">
            <label for="manager">Manager</label>
            <select class="form-control chosen-select" name="manager" id="manager">
              <?php

              $sql = "SELECT * FROM managers order by name asc";
              $res = mysqli_query($mysqli, $sql) or die('-1' . mysqli_error($mysqli));
              //$rows = mysqli_fetch_assoc($res);

              while ($row = mysqli_fetch_assoc($res)) { ?>
                <option value="<?php echo $row["id"];?>"><?php echo $row["name"]; ?></option>
                <?php
              }
              ?>
            </select>
          </div>
          <h3>Import Properties</h3>

          <div class="form-group">
            <label for="file">Select Properties file</label>
            <input type="file" name="importfile" required="" />
            <span class="help-block">Select the properties file. You should use the template that you downloaded. <a href="../../docs/properties.csv">Download Template</a></span>
          </div>

          <button type="input" name="submit" value="importP" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> Submit
          </form>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <form action="" method="post" enctype="multipart/form-data">
            <!-- <h3>Select Property Manager</h3>
            <div class="form-group">
              <label for="manager">Manager</label>
              <select class="form-control chosen-select" name="manager" id="manager">
                <?php

                $sql = "SELECT * FROM managers order by name asc";
                $res = mysqli_query($mysqli, $sql) or die('-1' . mysqli_error($mysqli));


                while ($row = mysqli_fetch_assoc($res)) { ?>
                  <option value="<?php echo $row["id"];?>"><?php echo $row["name"]; ?></option>
                  <?php
                }
                ?>
              </select>
            </div> -->
            <h3>Import Tenants</h3>

            <div class="form-group">
              <label for="file">Select Tenants file</label>
              <input type="file" name="importfile" required="" />
              <span class="help-block">Select the tenants file. You should use the template that you downloaded. <a href="../../docs/tenants.csv">Download Template</a></span>
            </div>

            <button type="input" name="submit" value="importT" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> Submit
            </form>
          </div>
        </div>
        <?php
      }else{
        ?>

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
      ?>
