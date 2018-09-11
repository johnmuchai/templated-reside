<?php
  // If you use an SSL Certificate - HTTPS://
  // Uncomment (remove the double slashes) from lines 5 - 9
  // ************************************************************************
  //if (!isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) != "on") {
  //  $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
  //  header("Location: $url");
  //  exit;
  //}

  // Set the Active State on the Navigation
  $dashNav = $tenNav = $propNav = $servNav = $adminNav = $manageNav = '';
  if (isset($dashPage)) { $dashNav = 'active'; } else { $dashNav = ''; }
  if (isset($tenPage)) { $tenNav = 'active'; } else { $tenNav = ''; }
  if (isset($propPage)) { $propNav = 'active'; } else { $propNav = ''; }
  if (isset($servPage)) { $servNav = 'active'; } else { $servNav = ''; }
  if (isset($adminPage)) { $adminNav = 'active'; } else { $adminNav = ''; }
  if (isset($managePage)) { $manageNav = 'active'; } else { $manageNav = ''; }

  // Get the Avatar Directory
  $avatarDir = $set['avatarFolder'];

  $auths = getAdminAuth($rs_adminId);
?>
<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $set['siteName'].' &middot; '.$pageTitle; ?></title>

  <link rel="stylesheet" href="../star/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../star/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../star/vendors/css/vendor.bundle.addons.css">
  
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.css" />
	<?php if (isset($addCss)) { echo $addCss; } ?>
	<link rel="stylesheet" type="text/css" href="../css/custom.css" />
	<link rel="stylesheet" type="text/css" href="../css/styles.css" />
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../star/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../star/images/favicon.png" />

</head>


<body>

<body>
   <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
   
    <nav class="navbar default-layout col-md-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="index.html">
          <img src="../images/newlogo.png" style="width:150px;height:80px; " />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
          <li class="nav-item">
                <a href="../index.php" class="nav-link"><?php echo $homeNavLink; ?></a>
              </li>

          <li class="nav-item active">
             <a class="nav-link" href="../available-properties.php"><?php echo $propNavLink; ?></a>
             </li>

             <li class="nav-item" ><a class="nav-link" href="../about-us.php"><?php echo $aboutUsNavLink; ?></a></li>

         <li class="nav-item"  ><a href="../contact-us.php" class="nav-link" ><?php echo $contactUsNavLink; ?></a></li>
          </ul>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="index.php?action=myProfile"data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text"><?php echo $myProfileNavLink; ?></span>
              
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <a class="dropdown-item p-0">
                <div class="d-flex border-bottom">
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                    <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                  </div>
                </div>
              </a>
              <a  class="dropdown-item" href="index.php?action=myProfile"><?php echo $myProfileNavLink; ?></a>
              <a data-toggle="modal" class="dropdown-item" href="#signOut"><?php echo $signOutNavLink; ?></a>
             
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->     
  </div>
  <div class="modal fade" id="signOut" tabindex="-1" role="dialog" aria-labelledby="signOutLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p class="lead"><?php echo $rs_adminName; ?>, <?php echo $signOutConf; ?></p>
      </div>
      <div class="modal-footer">
        <a href="../index.php?action=logout" class="btn btn-success btn-icon-alt"><?php echo $signOutNavLink; ?> <i class="fa fa-sign-out"></i></a>
        <button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle"></i> <?php echo $cancelBtn; ?></button>
      </div>
    </div>
  </div>
</div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
