<?php
	// Check if install.php is present
	if(is_dir('install')) {
		header("Location: ../install/install.php");
	} else {
		if(!isset($_SESSION)) session_start();

		if (!isset($_SESSION['rs']['adminId'])) {
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
		} else if (isset($_GET['action']) && $_GET['action'] == 'leasedTenants') {		$page = 'leasedTenants';
		} else if (isset($_GET['action']) && $_GET['action'] == 'unleasedTenants') {	$page = 'unleasedTenants';
		} else if (isset($_GET['action']) && $_GET['action'] == 'archivedTenants') {	$page = 'archivedTenants';
		} else if (isset($_GET['action']) && $_GET['action'] == 'newTenant') {			$page = 'newTenant';
		} else if (isset($_GET['action']) && $_GET['action'] == 'viewTenant') {			$page = 'viewTenant';
		} else if (isset($_GET['action']) && $_GET['action'] == 'viewDocument') {		$page = 'viewDocument';
		} else if (isset($_GET['action']) && $_GET['action'] == 'leasedProperties') {	$page = 'leasedProperties';
		} else if (isset($_GET['action']) && $_GET['action'] == 'unleasedProperties') {	$page = 'unleasedProperties';
		} else if (isset($_GET['action']) && $_GET['action'] == 'newProperty') {		$page = 'newProperty';
		} else if (isset($_GET['action']) && $_GET['action'] == 'viewProperty') {		$page = 'viewProperty';
		} else if (isset($_GET['action']) && $_GET['action'] == 'viewPayments') {		$page = 'viewPayments';
		} else if (isset($_GET['action']) && $_GET['action'] == 'paymentDetail') {		$page = 'paymentDetail';
		} else if (isset($_GET['action']) && $_GET['action'] == 'receipt') {			$page = 'receipt';
		} else if (isset($_GET['action']) && $_GET['action'] == 'propertyLeases') {		$page = 'propertyLeases';
		} else if (isset($_GET['action']) && $_GET['action'] == 'viewLease') {			$page = 'viewLease';
		} else if (isset($_GET['action']) && $_GET['action'] == 'leaseProperty') {		$page = 'leaseProperty';
		} else if (isset($_GET['action']) && $_GET['action'] == 'viewUploads') {		$page = 'viewUploads';
		} else if (isset($_GET['action']) && $_GET['action'] == 'viewFile') {			$page = 'viewFile';
		} else if (isset($_GET['action']) && $_GET['action'] == 'activeRequests') {		$page = 'activeRequests';
		} else if (isset($_GET['action']) && $_GET['action'] == 'inactiveRequests') {	$page = 'inactiveRequests';
		} else if (isset($_GET['action']) && $_GET['action'] == 'viewRequest') {		$page = 'viewRequest';
		} else if (isset($_GET['action']) && $_GET['action'] == 'workOrder') {			$page = 'workOrder';
		} else if (isset($_GET['action']) && $_GET['action'] == 'newRequest') {			$page = 'newRequest';
		} else if (isset($_GET['action']) && $_GET['action'] == 'adminAuths') {			$page = 'adminAuths';
		} else if (isset($_GET['action']) && $_GET['action'] == 'adminAccounts') {		$page = 'adminAccounts';
		} else if (isset($_GET['action']) && $_GET['action'] == 'newAdmin') {			$page = 'newAdmin';
		} else if (isset($_GET['action']) && $_GET['action'] == 'viewAdmin') {			$page = 'viewAdmin';
		} else if (isset($_GET['action']) && $_GET['action'] == 'siteAlerts') {			$page = 'siteAlerts';
		} else if (isset($_GET['action']) && $_GET['action'] == 'userReports') {		$page = 'userReports';
		} else if (isset($_GET['action']) && $_GET['action'] == 'propertyReports') {	$page = 'propertyReports';
		} else if (isset($_GET['action']) && $_GET['action'] == 'accountingReports') {	$page = 'accountingReports';
		} else if (isset($_GET['action']) && $_GET['action'] == 'serviceReports') {		$page = 'serviceReports';
		} else if (isset($_GET['action']) && $_GET['action'] == 'tenantRpt') {			$page = 'tenantRpt';
		} else if (isset($_GET['action']) && $_GET['action'] == 'accountingRpt') {		$page = 'accountingRpt';
		} else if (isset($_GET['action']) && $_GET['action'] == 'propertyRpt') {		$page = 'propertyRpt';
		} else if (isset($_GET['action']) && $_GET['action'] == 'leaseRpt') {			$page = 'leaseRpt';
		} else if (isset($_GET['action']) && $_GET['action'] == 'servReqRpt') {			$page = 'servReqRpt';
		} else if (isset($_GET['action']) && $_GET['action'] == 'servCostRpt') {		$page = 'servCostRpt';
		} else if (isset($_GET['action']) && $_GET['action'] == 'adminRpt') {			$page = 'adminRpt';
		} else if (isset($_GET['action']) && $_GET['action'] == 'forms') { 				$page = 'forms';
		} else if (isset($_GET['action']) && $_GET['action'] == 'viewTemplate') { 		$page = 'viewTemplate';
		} else if (isset($_GET['action']) && $_GET['action'] == 'siteContent') { 		$page = 'siteContent';
		} else if (isset($_GET['action']) && $_GET['action'] == 'siteSettings') { 		$page = 'siteSettings';
		} else if (isset($_GET['action']) && $_GET['action'] == 'socialNetworks') {		$page = 'socialNetworks';
		} else if (isset($_GET['action']) && $_GET['action'] == 'uploadSettings') {		$page = 'uploadSettings';
		} else if (isset($_GET['action']) && $_GET['action'] == 'paymentSettings') { 	$page = 'paymentSettings';
		} else if (isset($_GET['action']) && $_GET['action'] == 'servReqSettings') { 	$page = 'servReqSettings';
		} else if (isset($_GET['action']) && $_GET['action'] == 'sliderSettings') { 	$page = 'sliderSettings';
		} else if (isset($_GET['action']) && $_GET['action'] == 'importExport') { 		$page = 'importExport';
		} else if (isset($_GET['action']) && $_GET['action'] == 'siteLogs') { 			$page = 'siteLogs';
		}else if (isset($_GET['action']) && $_GET['action'] == 'viewParent') { 			$page = 'viewParent';
		}else if (isset($_GET['action']) && $_GET['action'] == 'newManager') { 			$page = 'newManager';
		}else if (isset($_GET['action']) && $_GET['action'] == 'newManagerUser') { 			$page = 'newManagerUser';
		}else if (isset($_GET['action']) && $_GET['action'] == 'imports') { 			$page = 'imports';
		}else if (isset($_GET['action']) && $_GET['action'] == 'bulkApartments') { 			$page = 'bulkApartments';
		} else {$page = 'dashboard';}

		if (file_exists('pages/'.$page.'.php')) {
			// Load the Page
			?>
			<div class="row" style="padding-left: 0;">

				<div class="col-md-3">
			
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
              <span class="menu-title"><?php echo $dashboardNavLink; ?></span>
            </a>
          </li>


          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              
              <span class="menu-title"><?php echo $tenantsNavLink; ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="index.php?action=leasedTenants"><?php echo $leasedTenNavLink; ?></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?action=unleasedTenants"><?php echo $unleasedTenNavLink; ?></a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="index.php?action=archivedTenants"><?php echo $archivedTenNavLink; ?></a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="index.php?action=newTenant"><?php echo $newTenNavLink; ?></a>
                </li>
              </ul>
            </div>
          </li>

           <li class="nav-item">
           <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
           
              <span class="menu-title"><?php echo $propNavLink; ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                      <li class="nav-item"><a class="nav-link" href="index.php?action=leasedProperties"><?php echo $leasedPropNavLink; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="index.php?action=unleasedProperties"><?php echo $unleasedPropNavLink; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="index.php?action=newProperty"><?php echo $newPropNavLink; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="index.php?action=propertyLeases"><?php echo $propLeasesNavLink; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="index.php?action=imports">Import Properties and Tenants</a></li>
                      <li class="nav-item"><a class="nav-link" href="index.php?action=bulkApartments">Add bulk units</a></li>
              </ul>
            </div>
          </li>


           <li class="nav-item ">
           <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
           
              <span class="menu-title"><?php echo $servReqNavLink; ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                     <li class="nav-item"><a class="nav-link" href="index.php?action=activeRequests"><?php echo $openReqNavLink; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="index.php?action=inactiveRequests"><?php echo $closedReqNavLink; ?></a></li>
                      <li class="nav-item"><a class="nav-link" href="index.php?action=newRequest"><?php echo $newReqNavLink; ?></a></li>
              </ul>
            </div>
          </li>

           <li class="nav-item <?php echo $adminNav; ?>">
           <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
           
              <span class="menu-title"><?php echo $adminsNavLink; ?></span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="index.php?action=adminAccounts"><?php echo $adminAccNavLink; ?></a></li>
                  <li class="nav-item"><a class="nav-link" href="index.php?action=newAdmin"><?php echo $newAdminNavLink; ?></a></li>
                  <li class="nav-item"><a class="nav-link" href="index.php?action=newManager">Create <?php echo $propManagerHead; ?></a></li>
                  <li class="nav-item"><a class="nav-link" href="index.php?action=newManagerUser">Create <?php echo $propManagerHead; ?> User</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item <?php echo $manageNav; ?>">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic"> <span class="menu-title"><?php echo $manageNavLink; ?></span> <i class="menu-arrow"></i></a>
                <ul class="nav flex-column sub-menu">
                  <?php if ((checkArray('SITEALRTS', $auths)) || $rs_isAdmin != '') { ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=siteAlerts"><?php echo $siteAlertsNavLink; ?></a></li>
                  <?php } ?>
                  <li class="nav-item <?php echo $repNavLink; ?>">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic"><?php echo $repNavLink; ?></a>
                    <ul class="nav flex-column sub-menu">
                      <?php if ((checkArray('TENRPT', $auths)) || (checkArray('ADMINRPT', $auths)) || $rs_isAdmin != '') { ?>
                        <li class="nav-item" ><a class="nav-link"  href="index.php?action=userReports"><?php echo $usrRepNavLink; ?></a></li>
                      <?php } if ((checkArray('PROPRPT', $auths)) || (checkArray('LEASERPT', $auths)) || $rs_isAdmin != '') { ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=propertyReports"><?php echo $propRepNavLink; ?></a></li>
                      <?php }
                          if ($set['enablePayments'] == '1') {
                            if ((checkArray('ACCTRPT', $auths)) || $rs_isAdmin != '') {
                      ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?action=accountingReports"><?php echo $accRepNavLink; ?></a></li>
                      <?php
                          }
                        }
                        if ((checkArray('SERVRPT', $auths)) || $rs_isAdmin != '') {
                      ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?action=serviceReports"><?php echo $servRepNavLink; ?></a></li>
                      <?php } ?>
                    </ul>
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
      </div>
      </div>
      <div class="col-md-8"  style="padding-top:70px;">
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
					</div>u
				';
		}
		?>
</div>
</div>
<?php
		if (($page != 'receipt') && ($page != 'workOrder')) {
			include('includes/footer.php');
		}
	}
?>
				