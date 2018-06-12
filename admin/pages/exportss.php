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
  
  
// Get Leased Tenant Data

  if (isset($_POST['submit'])) {   
	

			$filename = "PropertiesData.csv";
			$fp = fopen('php://output', 'w');

			$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='phppot_examples' AND TABLE_NAME='properties'";
			$result = mysqli_query($mysqli,$query);
			while ($row = mysqli_fetch_row($result)) {
				$header[] = $row[0];
			}	
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			fputcsv($fp, $header);

			$query = "SELECT * FROM properties WHERE adminId =$rs_adminId";
			$result = mysqli_query($mysqli, $query);
			while($row = mysqli_fetch_row($result)) {
				fputcsv($fp, $row);
			}
			exit;


       $msgBox = alertBox("Properties data exported successfully", "<i class='fa fa-check-square'></i>", "success");
      
    }
	


    include 'includes/header.php';
    ?>
    <div class="container page_block noTopBorder">
      <hr class="mt-0 mb-0" />

      <?php
      if ((checkArray('SITESET', $auths)) || $rs_isAdmin != '') {
        if ($msgBox) { echo $msgBox; }
        ?>

        <h3>Export Data</h3>

        <!-- <div class="alertMsg warning">
        <div class="msgIcon pull-left">
        <i class="fa fa-info-circle"></i>
      </div>
    </div> -->

    <hr />

    <div class="row">
      <div class="col-md-6">
        <form action="" method="post" enctype="multipart/form-data">
         
          <div class="form-group">
           
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
                  <option value="<?php echo $row["id"];

				  ?>"><?php echo $row["name"]; 
				  ?></option>
                  <?php
                }
                ?>
              </select>
            </div> -->
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
