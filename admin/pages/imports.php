<?php
// Get Leased Tenant Data
if ($rs_isAdmin != '') {


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

    <div class="alertMsg warning">
      <div class="msgIcon pull-left">
        <i class="fa fa-info-circle"></i>
      </div>

    </div>

    <hr />

    <div class="row">
      <div class="col-md-6">
        <form action="" method="post" enctype="multipart/form-data">
          <h3>1. Select Property Manager</h3>
          <div class="form-group">
            <label for="manager">Manager</label>
            
          </div>
          <h3>1. Import Properties</h3>

          <div class="form-group">
            <label for="file"><?php echo $selFileField; ?></label>
            <input type="file" name="importfile" required="" />
          </div>
        </form>
      </div>
    </div>



    <?php
  }
  ?>
