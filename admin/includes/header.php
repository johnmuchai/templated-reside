<?php
	// If you use an SSL Certificate - HTTPS://
	// Uncomment (remove the double slashes) from lines 5 - 9
	// ************************************************************************
	//if (!isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) != "on") {
	//	$url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	//	header("Location: $url");
	//	exit;
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
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title><?php echo $set['siteName'].' &middot; '.$pageTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="../star/vendors/iconfonts/mdi/css/materialdesignicons.min.css"/>
	<link rel="stylesheet" type="text/css" href="../star/vendors/css/vendor.bundle.base.css"/>
	<link rel="stylesheet" type="text/css" href="../star/vendors/css/vendor.bundle.addons.css"/>
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.css" />
	<link rel="stylesheet" type="text/css" href="../star/css/style.css" />
	<link rel="stylesheet" type="text/css" href="../css/styles.css" />
		<link rel="stylesheet" type="text/css" href="../css/custom.css" />


	<?php if (isset($addCss)) { echo $addCss; } ?>
	<script src="../star/vendors/js/vendor.bundle.base.js"></script>
	<script src="../star/js/vendor.bundle.addons.js"></script>
	<script src="../star/js/misc.js"></script>
</head>

<body>
	<div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="../index.php">
          <img src="../images/newlogo.png"  style="width:150px; height:80px;" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="../index.php">
          <img src="../images/logo-mini.svg" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
          <li class="nav-item">
            <a href="../index.php" class="nav-link">Home
              <span class="badge badge-primary ml-1">New</span>
            </a>
          </li>
          <li class="nav-item active">
            <a href="../available-properties.php" class="nav-link">
              <i class="mdi mdi-elevation-rise"></i>Properties</a>
          </li>
          <li class="nav-item">
            <a href="../about-us.php" class="nav-link">
              <i class="mdi mdi-bookmark-plus-outline"></i>About Us</a>
		  </li>
		  <li class="nav-item">
            <a href="../contact-us.php" class="nav-link">
              <i class="mdi mdi-bookmark-plus-outline"></i>Contact Us</a>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
         <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text">Hello, Simon </span>
              <img class="img-xs rounded-circle" src="../images/newlogo.png" alt="Profile image">
            </a>
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
              <a class="dropdown-item mt-2">
                Manage Accounts
              </a>
              <a class="dropdown-item">
                Change Password
              </a>
              <a class="dropdown-item">
                Check Inbox
              </a>
              <a class="dropdown-item">
                Sign Out
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
      
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">
                <div class="profile-image">
                  <img src="../images/newlogo.png" alt="profile image">
                </div>
                <div class="text-wrapper">
                  <p class="profile-name">Simon</p>
                  <div>
                    <small class="designation text-muted">Manager</small>
                    <span class="status-indicator online"></span>
                  </div>
                </div>
              </div>
              <button class="btn btn-success btn-block">New Project
                <i class="mdi mdi-plus"></i>
              </button>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Basic UI Elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="../../pages/ui-features/buttons.html">Buttons</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../../pages/ui-features/typography.html">Typography</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/forms/basic_elements.html">
              <i class="menu-icon mdi mdi-backup-restore"></i>
              <span class="menu-title">Form elements</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/charts/chartjs.html">
              <i class="menu-icon mdi mdi-chart-line"></i>
              <span class="menu-title">Charts</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/tables/basic-table.html">
              <i class="menu-icon mdi mdi-table"></i>
              <span class="menu-title">Tables</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/icons/font-awesome.html">
              <i class="menu-icon mdi mdi-sticker"></i>
              <span class="menu-title">Icons</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="menu-icon mdi mdi-restart"></i>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="../../pages/samples/blank-page.html"> Blank Page </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../../pages/samples/login.html"> Login </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../../pages/samples/register.html"> Register </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../../pages/samples/error-404.html"> 404 </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../../pages/samples/error-500.html"> 500 </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
              <a href="http://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with
              <i class="mdi mdi-heart text-danger"></i>
            </span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
	

<!-- End of NEw Interfaca -->


	<div class="container page_block noTopBorder noBotBorder">
		<div class="header-cont">
			<div class="row">
				<div class="col-md-8">
					<ul class="list-inline mt-0 mb-0">
						<li><small><a href="../index.php"><?php echo $homeNavLink; ?></a></small></li>
						<li><small><a href="../available-properties.php"><?php echo $propNavLink; ?></a></small></li>
						<li><small><a href="../about-us.php"><?php echo $aboutUsNavLink; ?></a></small></li>
						<li><small><a href="../contact-us.php"><?php echo $contactUsNavLink; ?></a></small></li>
					</ul>
				</div>
				<div class="col-md-4">
					<ul class="list-inline mt-0 mb-0 pull-right">
						<li><small><a href="index.php?action=myProfile"><?php echo $myProfileNavLink; ?></a></small></li>
						<li><small><a data-toggle="modal" href="#signOut"><?php echo $signOutNavLink; ?></a></small></li>
					</ul>
				</div>
			</div>

			<hr class="mt-10 mb-10" />

			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only"><?php echo $toggleNavText; ?></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="index.php" style="height:80px;"><img src="../images/newlogo.png" /></a>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							<li class="<?php echo $dashNav; ?>"><a href="index.php"><?php echo $dashboardNavLink; ?></a></li>
							<?php
								if ((checkArray('MNGTEN', $auths)) || $rs_isAdmin != '') {
							?>
									<li class="dropdown <?php echo $tenNav; ?>">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $tenantsNavLink; ?> <i class="fa fa-angle-down"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="index.php?action=leasedTenants"><?php echo $leasedTenNavLink; ?></a></li>
											<li><a href="index.php?action=unleasedTenants"><?php echo $unleasedTenNavLink; ?></a></li>
											<li><a href="index.php?action=archivedTenants"><?php echo $archivedTenNavLink; ?></a></li>
											<li><a href="index.php?action=newTenant"><?php echo $newTenNavLink; ?></a></li>
										</ul>
									</li>
							<?php
								}
								if ((checkArray('MNGPROP', $auths)) || $rs_isAdmin != '') {
							?>
									<li class="dropdown <?php echo $propNav; ?>">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $propNavLink; ?> <i class="fa fa-angle-down"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="index.php?action=leasedProperties"><?php echo $leasedPropNavLink; ?></a></li>
											<li><a href="index.php?action=unleasedProperties"><?php echo $unleasedPropNavLink; ?></a></li>
											<li><a href="index.php?action=newProperty"><?php echo $newPropNavLink; ?></a></li>
											<li><a href="index.php?action=propertyLeases"><?php echo $propLeasesNavLink; ?></a></li>
											<li><a href="index.php?action=imports">Import Properties and Tenants</a></li>
											<li><a href="index.php?action=bulkApartments">Add bulk units</a></li>
										</ul>
									</li>
							<?php
								}
								if ((checkArray('SRVREQ', $auths)) || $rs_isAdmin != '') {
							?>
									<li class="dropdown <?php echo $servNav; ?>">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $servReqNavLink; ?> <i class="fa fa-angle-down"></i></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="index.php?action=activeRequests"><?php echo $openReqNavLink; ?></a></li>
											<li><a href="index.php?action=inactiveRequests"><?php echo $closedReqNavLink; ?></a></li>
											<li><a href="index.php?action=newRequest"><?php echo $newReqNavLink; ?></a></li>
										</ul>
									</li>
							<?php
								}
								if ((checkArray('MNGADMINS', $auths)) || $rs_isAdmin != '') {
							?>
							<li class="dropdown <?php echo $adminNav; ?>">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $adminsNavLink; ?> <i class="fa fa-angle-down"></i></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="index.php?action=adminAccounts"><?php echo $adminAccNavLink; ?></a></li>
									<li><a href="index.php?action=newAdmin"><?php echo $newAdminNavLink; ?></a></li>
									<li><a href="index.php?action=newManager">Create <?php echo $propManagerHead; ?></a></li>
									<li><a href="index.php?action=newManagerUser">Create <?php echo $propManagerHead; ?> User</a></li>
									<?php if ((checkArray('APPAUTH', $auths)) || $rs_isAdmin != '') { ?>
										<li><a href="index.php?action=adminAuths"><?php echo $adminAuthNavLink; ?></a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
							<li class="dropdown <?php echo $manageNav; ?>">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $manageNavLink; ?> <i class="fa fa-angle-down"></i></a>
								<ul class="dropdown-menu" role="menu">
									<?php if ((checkArray('SITEALRTS', $auths)) || $rs_isAdmin != '') { ?>
										<li><a href="index.php?action=siteAlerts"><?php echo $siteAlertsNavLink; ?></a></li>
									<?php } ?>
									<li class="dropdown-submenu">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $repNavLink; ?></a>
										<ul class="dropdown-menu">
											<?php if ((checkArray('TENRPT', $auths)) || (checkArray('ADMINRPT', $auths)) || $rs_isAdmin != '') { ?>
												<li><a href="index.php?action=userReports"><?php echo $usrRepNavLink; ?></a></li>
											<?php } if ((checkArray('PROPRPT', $auths)) || (checkArray('LEASERPT', $auths)) || $rs_isAdmin != '') { ?>
												<li><a href="index.php?action=propertyReports"><?php echo $propRepNavLink; ?></a></li>
											<?php }
													if ($set['enablePayments'] == '1') {
														if ((checkArray('ACCTRPT', $auths)) || $rs_isAdmin != '') {
											?>
														<li><a href="index.php?action=accountingReports"><?php echo $accRepNavLink; ?></a></li>
											<?php
													}
												}
												if ((checkArray('SERVRPT', $auths)) || $rs_isAdmin != '') {
											?>
												<li><a href="index.php?action=serviceReports"><?php echo $servRepNavLink; ?></a></li>
											<?php } ?>
										</ul>
									</li>
									<?php if ((checkArray('FORMS', $auths)) || $rs_isAdmin != '') { ?>
										<li><a href="index.php?action=forms"><?php echo $formsNavLink; ?></a></li>
									<?php } if ((checkArray('SITECNT', $auths)) || $rs_isAdmin != '') { ?>
										<li><a href="index.php?action=siteContent"><?php echo $siteContNavLink; ?></a></li>
									<?php } if ((checkArray('SITESET', $auths)) || $rs_isAdmin != '') { ?>
										<li class="dropdown-submenu">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $settingsNavLink; ?></a>
											<ul class="dropdown-menu">
												<li><a href="index.php?action=siteSettings"><?php echo $siteSetNavLink; ?></a></li>
												<li><a href="index.php?action=socialNetworks"><?php echo $socNetNavLink; ?></a></li>
												<li><a href="index.php?action=uploadSettings"><?php echo $uplSetNavLink; ?></a></li>
												<li><a href="index.php?action=paymentSettings"><?php echo $paySetNavLink; ?></a></li>
												<li><a href="index.php?action=servReqSettings"><?php echo $reqSetNavLink; ?></a></li>
												<li><a href="index.php?action=sliderSettings"><?php echo $slideSetNavLink; ?></a></li>
												<li><a href="index.php?action=importExport"><?php echo $impExptSetNavLink; ?></a></li>
											</ul>
										</li>
									<?php } if ((checkArray('SITELOGS', $auths)) || $rs_isAdmin != '') { ?>
										<li><a href="index.php?action=siteLogs"><?php echo $siteLogsNavLink; ?></a></li>
									<?php } ?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
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
