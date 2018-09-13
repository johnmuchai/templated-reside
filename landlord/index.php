<?php
// Check if install.php is present
if(is_dir('install')) {
	header("Location: ../install/install.php");
} else {

	if(!isset($_SESSION)) session_start();

	if (!isset($_SESSION['rs']['userId'])) {
		header ('Location: ../index.php');
		exit;
	}

	// Access DB Info
	include('../config.php');

	// Get Settings Data
	include ('../includes/settings.php');
	$set = mysqli_fetch_assoc($setRes);

	// Include Functions
	include('../includes/functions.php');

	// Include Sessions & Localizations
	include('includes/sessions.php');

	// Set Week Day Name
	$theDay = date('l');
	switch ($theDay) {
		case 'Sunday':		$dayName = $sunText;	break;
		case 'Monday':		$dayName = $monText;	break;
		case 'Tuesday':		$dayName = $tueText;	break;
		case 'Wednesday':	$dayName = $wedText;	break;
		case 'Thursday':	$dayName = $thuText;	break;
		case 'Friday':		$dayName = $friText;	break;
		case 'Saturday':	$dayName = $satText;	break;
	}

	// Set Month Name
	$theMonth = date('F');
	switch ($theMonth) {
		case 'January':		$monthName = $janText;	break;
		case 'February':	$monthName = $febText;	break;
		case 'March':		$monthName = $marText;	break;
		case 'April':		$monthName = $aprText;	break;
		case 'May':			$monthName = $mayText;	break;
		case 'June':		$monthName = $junText;	break;
		case 'July':		$monthName = $julText;	break;
		case 'August':		$monthName = $augText;	break;
		case 'September':	$monthName = $septText;	break;
		case 'October':		$monthName = $octText;	break;
		case 'November':	$monthName = $novText;	break;
		case 'December':	$monthName = $decText;	break;
	}

	// Link to the Page
	if (isset($_GET['action']) && $_GET['action'] == 'myProfile') {					$page = 'myProfile';
	} else if (isset($_GET['action']) && $_GET['action'] == 'payments') {		$page = 'payments';
	} else if (isset($_GET['action']) && $_GET['action'] == 'properties') {	$page = 'properties';
	} else if (isset($_GET['action']) && $_GET['action'] == 'tenants') {	$page = 'tenants';
	} else if (isset($_GET['action']) && $_GET['action'] == 'viewProperty') {			$page = 'viewProperty';
	} else if (isset($_GET['action']) && $_GET['action'] == 'viewTenant') {			$page = 'viewTenant';
	} else if (isset($_GET['action']) && $_GET['action'] == 'leaseProperty') {			$page = 'leaseProperty';
	} else if (isset($_GET['action']) && $_GET['action'] == 'leasedProperties') {			$page = 'leasedProperties';
	} else if (isset($_GET['action']) && $_GET['action'] == 'leasedTenants') {			$page = 'leasedTenants';
	} else if (isset($_GET['action']) && $_GET['action'] == 'imports') {			$page = 'imports';
	} else if (isset($_GET['action']) && $_GET['action'] == 'newProperty') {			$page = 'newProperty';
	} else if (isset($_GET['action']) && $_GET['action'] == 'newTenant') {			$page = 'newTenant';
	} else if (isset($_GET['action']) && $_GET['action'] == 'bulkApartments') {			$page = 'bulkApartments';
	} else if (isset($_GET['action']) && $_GET['action'] == 'unit') {			$page = 'unit';
	} else if (isset($_GET['action']) && $_GET['action'] == 'unleasedTenants') {			$page = 'unleasedTenants';
	} else if (isset($_GET['action']) && $_GET['action'] == 'propertyLeases') {			$page = 'propertyLeases';
	} else if (isset($_GET['action']) && $_GET['action'] == 'unleasedProperties') {			$page = 'unleasedProperties';
} else if (isset($_GET['action']) && $_GET['action'] == 'newManagerUser') {			$page = 'newManagerUser';
} else if (isset($_GET['action']) && $_GET['action'] == 'viewLease') {			$page = 'viewLease';
	} else {$page = 'dashboard';}

	if (file_exists('pages/'.$page.'.php')) {
		// Load the Page
		?>
<div class="container-fluid page-body-wrapper">

      <!-- partial:../../partials/_sidebar.html -->
      
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              
              <button class="btn btn-success btn-block">New Project
                <i class="mdi mdi-plus"></i>
              </button>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" <a href="index.php">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title"><?php echo $homeNavLink; ?></span>
            </a>
          </li>


          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              
              <span class="menu-title">My <?php echo $propNavLink; ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="index.php?action=unleasedProperties"><?php echo $availPropNavLink; ?></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?action=leasedProperties"><?php echo "Leased Properties"; ?></a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="index.php?action=leasedTenants"><?php echo "Leased Tenants"; ?></a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="index.php?action=imports"><?php echo "Import Properties"; ?></a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="index.php?action=bulkApartments"><?php echo "Bulk Properties"; ?></a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="index.php?action=newProperty"><?php echo "New Property"; ?></a>
                </li>
				<li class="nav-item">
                  <a class="nav-link" href="index.php?action=propertyLeases"><?php echo "Property Leases"; ?></a>
                </li>
              </ul>
            </div>
          </li>

           <li class="nav-item">
           <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
           
              <span class="menu-title"><?php echo $tenantsNavLink; ?> </span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                      <li class="nav-item"><a class="nav-link" href="index.php?action=leasedTenants"><?php echo $leasedTenNavLink; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="index.php?action=unleasedTenants"><?php echo $unleasedTenNavLink; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="index.php?action=archivedTenants">"><?php echo $archivedTenNavLink; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="index.php?action=newTenant"><?php echo $newTenNavLink; ?></a></li>
              </ul>
            </div>
          </li>

		  <li class="nav-item">
           <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
           
              <span class="menu-title"><?php echo $adminsNavLink; ?> </span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                      <li class="nav-item"><a class="nav-link" href="index.php?action=newManagerUser">Create <?php echo $propManagerHead; ?> User</a></li>
              </ul>
            </div>
          </li>



         
                  <?php if ((checkArray('FORMS', $auths)) || $rs_isAdmin != '') { ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=forms"><?php echo $formsNavLink; ?></a></li>
                  <?php } if ((checkArray('SITECNT', $auths)) || $rs_isAdmin != '') { ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=siteContent"><?php echo $siteContNavLink; ?></a></li>
                  <?php } if ((checkArray('SITESET', $auths)) || $rs_isAdmin != '') { ?>
                    <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic"><?php echo $settingsNavLink; ?></a>
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="index.php?action=siteSettings"><?php echo $siteSetNavLink; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=socialNetworks"><?php echo $socNetNavLink; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=uploadSettings"><?php echo $uplSetNavLink; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=paymentSettings"><?php echo $paySetNavLink; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=servReqSettings"><?php echo $reqSetNavLink; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=sliderSettings"><?php echo $slideSetNavLink; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=importExport"><?php echo $impExptSetNavLink; ?></a></li>
                      </ul>
                    </li>
                  <?php } if ((checkArray('SITELOGS', $auths)) || $rs_isAdmin != '') { ?>
                    <li class="nav-link"><a class="nav-link" href="index.php?action=siteLogs"><?php echo $siteLogsNavLink; ?></a></li>
                  <?php } ?>
                </ul>
              </li>
        </ul>
			</nav>

	<div class="main-panel">
  <div class="content-wrapper">
	<div class="col">
	<?php
			include('pages/'.$page.'.php');	
	} else {
		$pageTitle = $pageNotFoundHeader;

		if (($page != 'receipt') && ($page != 'workOrder')) {
			include('includes/header.php');
		}

		// Else Display an Error
		echo '
		<div class="container page_block noTopBorder">
		<hr class="mt-0 mb-0" />
		<h3>'.$pageNotFoundHeader.'</h3>
		<div class="alertMsg warning mb-20">
		<div class="msgIcon pull-left">
		<i class="fa fa-warning"></i>
		</div>
		'.$pageNotFoundQuip.'
		</div>
		</div>
		';
	}
	?>
	
<?php
	if (($page != 'receipt') && ($page != 'workOrder')) {
		include('includes/footer.php');
	}
}
?>
</div>
</div>
</div>
</div>

