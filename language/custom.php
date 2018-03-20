<?php
/*
 * Please note - if you are translating this file, any quotes that have a backslash (\") need that
 * backslash to escape the extra quotes in the string.
 * Any variables in this file need to stay in the same format.
 *
 * OTHER Files to Translate:
 *  includes/paypal.php (Lines 8 through 10 ONLY)
 *  js/tableTools.php (Lines 9 through 18 ONLY)
 *  admin/includes/receipt_tmpl.php (see instructions at the top of the file)
 *  admin/js/adminAuths.js (see instructions at the top of the file)
 *
 * If you have any questions at all about this file, please contact me through my Support Center:
 * http://jennperrin.com/support/
 */

// All Pages - Globals
// --------------------------------------------------------------------------------------------------
$currCode					= "USD";
$accessErrorHeader			= "Access Error";
$permissionDenied			= "Permission Denied. You can not access this page.";
$registeredOnly				= "Only Registered Users can access this page.";
$loggedInOnly				= "You must be logged in to view this page";
$pageNotFoundHeader			= "Page Not Found &mdash; 404 Error";
$pageNotFoundQuip			= "The page requested could not be found or loaded.";
$pageError					= "Error Loading Page";
$htmlNotAllowed				= "HTML not allowed &amp; will be saved as plain text.";
$htmlAllowed1				= "HTML allowed: &lt;h1&gt;, &lt;h2&gt;, &lt;h3&gt;, &lt;h4&gt;, &lt;p&gt;, &lt;br&gt;, &lt;a&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;hr&gt;, &lt;i&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, &lt;blockquote&gt;, &amp; &lt;strike&gt;.";
$htmlAllowed2				= "HTML allowed: &lt;div&gt;, &lt;h3&gt;, &lt;h4&gt;, &lt;p&gt;, &lt;br&gt;, &lt;a&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;hr&gt;, &lt;i&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, &lt;blockquote&gt;, &amp; &lt;strike&gt;.";
$numbersOnlyHelp			= "Numbers Only, No currency symbols (Format: 500.00).";
$logoutConfirmationMsg		= ", are you sure you want to signout of your account?";
$signOutConfBtn				= "Sign Out";

$cancelBtn					= "Cancel";
$closeBtn					= "Close";
$clearBtn					= "Clear";
$okBtn						= "OK";
$yesBtn						= "Yes";
$noBtn						= "No";
$saveChangesBtn				= "Save Changes";
$saveBtn					= "Save";
$deleteBtn					= "Delete";
$updateBtn					= "Update";
$selectOption				= "Select...";
$noneOption					= "None";

$sunText					= "Sunday";
$monText					= "Monday";
$tueText					= "Tuesday";
$wedText					= "Wednesday";
$thuText					= "Thursday";
$friText					= "Friday";
$satText					= "Saturday";

$janText					= "January";
$febText					= "February";
$marText					= "March";
$aprText					= "April";
$mayText					= "May";
$junText					= "June";
$julText					= "July";
$augText					= "August";
$septText					= "September";
$octText					= "October";
$novText					= "November";
$decText					= "December";

$facebookText				= "Facebook";
$googleText					= "Google+";
$linkedinText				= "LinkedIn";
$pinterestText				= "Pinterest";
$twitterText				= "Twitter";
$youtubeText				= "YouTube";

$emailTankYouTxt			= "Thank you,";

// sign-in.php
// --------------------------------------------------------------------------------------------------
$signinPageTitle			= "Account Sign In / Up";
$accountSignInText			= "Account Sign In";
$accountSignUpText			= "New Account Sign Up";
$accountEmailText			= "Account Email";
$accountPasswordText		= "Account Password";
$resetPasswordText			= "Reset Password";
$signInText					= "Sign In";
$emailAddyText				= "Email Address";
$emailHelp					= "A Valid Email Address. Your Email Address is also used to log in.";
$passwordText				= "Password";
$newPasswordHelp			= "Choose a password for your new account.";
$repeatPasswordText			= "Repeat Password";
$repeatPasswordHelp			= "Type the password again.";
$fisrtNameText				= "Your First Name";
$fisrtNameHelp				= "Your First Name please.";
$lastNameText				= "Your Last Name";
$lastNameHelp				= "Your Last Name please.";
$captchaCodeText			= "Captcha Code";
$enterCodeText				= "Enter Captcha Code";
$createAccountText			= "Create My Account";
$resendActivationText		= "All ready signed up and did not receive the Account Activation Request?";
$resendActivationText2		= "You can have the Account Activation Email resent.";
$resendActivationBtn		= "Resend Account Activation";
$emailHelp2					= "The email address associated with your account.";
$emailHelp3					= "The email address you used to sign up with.";
$resetPasswordBtn			= "Reset Password";
$resendActivationTitle		= "Resend Account Activation Request";
$emailReq					= "Your Account Email Address is required.";
$passwordReq				= "Your Account Password is required.";
$disabledAccMsg1			= "The account for";
$disabledAccMsg2			= "has been disabled, and you can not sign in.";
$disabledAccMsg3			= "Your Admin Account has been disabled, and you can not sign in.";
$archivedAccMsg2			= "has been archived, and you can not sign in.";
$signInFailed				= "Sign In attempt failed. Please check your entries and try again.";
$inactiveAccMsg				= "Your Account is currently inactive, and you can not sign in.";
$noAccMsg					= "No Account found for the email address. Please check your entries and try again.";
$passwordResetMsg			= "Your Password has been reset. Please check your email for your new password, and instructions on how to update your account.";
$validEmailReq				= "A valid Email Address is required.";
$accPasswordReq				= "An account Password is required.";
$passwordsNoMatch			= "Passwords do not match, please check your entries.";
$fnameReq					= "Your First Name is required.";
$lnameReq					= "Your Last Name is required.";
$captchaReq					= "Please type the Captcha Code.";
$newAccError				= "Something went wrong, and your New Account could not be created.";
$duplicateAccFound			= "There is all ready an account registered with that email address.";
$newAccCreatedMsg			= "Thank you for creating a New Account. Please check your email for instructions on activating your Account.";
$captchaError				= "Incorrect Captcha Answer. Please try again.";
$emailReq2					= "The Email Address you signed up with is required.";
$emailResentMsg				= "The Account Activation Email has been resent. Please check your email for instructions on activating your Account.";
$emailResentError			= "Either the account does not exist, or the account is all ready active.";
$adminSignout				= "signed out of their Admin account";
$userSignout				= "signed out of their User account";
$disabledAcc				= "Attempted to Sign In with a disabled User account";
$archivedAcc				= "Attempted to Sign In with an archived User account";
$userAccSignIn				= "Signed In to their User Account";
$admAccSignin				= "Signed In to their Admin Account";
$userReset					= "reset their User account password";
$admReset					= "reset their Admin account password";
$newAccCreated				= "New User Account created by";
$emailResent				= "resent their User Account Activation email";
$newAccActivated			= "A New Account was activated by";
$newAccActivationError		= "The Account Activation page was directly accessed";
$passwordResetSubject		= "User Account Password Reset";
$passResetEmail1			= "Your temporary password is:";
$passResetEmail2			= "Please take the time to change your password to something you can easily remember. You can change your password on your My Profile page after logging into your account. There you can update your password, as well as your account details.";
$passResetEmail3			= "You can log into your account with your email address and new password at:";
$newUserSubject				= "New User Account";
$newUserEmail1				= "Your new Account details:";
$newUserEmail2				= "Username: Your email address<br>Password:";
$newUserEmail3				= "You must activate your account before you will be able to log in. Please click (or copy/paste) the following link to activate your account:<br>";
$newUserEmail4				= "Once you have activated your new account and logged in, please take the time to update your account profile details.";
$newUserEmail5				= "You can log in to your account at";
$signInPageTitle			= "Sign In / Up";

// activate.php
// --------------------------------------------------------------------------------------------------
$activatePageTitle			= "New Account Activation";
$accActivatedTitle			= "Account Activated";
$accActivated1				= "Thank you for verifying your email address and activating your account.";
$accActivated2				= "Your account has been activated, and you can now log in.";
$signInBtn					= "All Set! Go ahead and Sign In";
$signInBtn2					= "Go ahead and Sign In";
$accActiveTitle				= "Account Active";
$accActive					= "You have all ready verified your email address and activated your account.";
$getStarted					= "Get Started by Signing In";
$directAccessError			= "Direct Access Denied";
$directAccessError2			= "Please check your email for the Account Activation Link.";
$directAccessError3			= "You cannot directly access this page.<br />please use the link that has been sent to your email.";
$activatedUsrAccText		= "activated their New User Account";
$activatePageAccessErr		= "The Account Activation Page was directly accessed";

// includes/header.php, includes/user_header.php & admin/includes/header.php Includes
// --------------------------------------------------------------------------------------------------
$msgTextReqErr				= "Please enter your Message.";
$msgSendErr					= "Something went wrong, and your message could not be sent.";
$sendMsgSubject				= "A Contact Request was sent from";
$sendMsgEmail1				= "Contact Request from";
$sendMsgEmail2				= "From";
$sendMsgEmail3				= "Email:";
$sendMsgEmail4				= "Phone:";
$sendMsgEmail5				= "Message:";
$sendMsgEmailSent			= "Thank you for taking the time to contact us. We will get back to you within 2 business days.";
$sendMsgEmailErr			= "Incorrect Captcha Code. Please check your entry and try again.";
$needHelpText				= "Need Help?";
$toggleNavText				= "Toggle navigation";

/* -- Navigations -- */
$homeNavLink				= "Home";
$propNavLink				= "Properties";
$availPropNavLink			= "Available Properties";
$rentAppNavLink				= "Rental Application";
$aboutUsNavLink				= "About Us";
$contactUsNavLink			= "Contact Us";
$myAccNavLink				= "My Account";
$dashboardNavLink			= "Dashboard";
$myProfileNavLink			= "My Profile";
$manageNavLink				= "Manage";
$signOutNavLink				= "Sign Out";
$signInUpNavLink			= "Sign In / Up";
$signInNavLink				= "Sign In";
$signOutConf				= "are you sure you want to Sign Out of your account?";
$myPropNavText				= "My Property";
$servReqNavLink				= "Service Requests";
$payHistNavLink				= "Payment History";
$payInfoNavLink				= "Payment Information";
$myDocsNavLink				= "My Documents";
$tenantsNavLink				= "Tenants";
$leasedTenNavLink			= "Leased Tenants";
$unleasedTenNavLink			= "Unleased Tenants";
$archivedTenNavLink			= "Archived Tenants";
$newTenNavLink				= "Add a New Tenant";
$leasedPropNavLink			= "Leased Properties";
$unleasedPropNavLink		= "Unleased Properties";
$newPropNavLink				= "Add a New Property";
$propLeasesNavLink			= "Property Leases";
$openReqNavLink				= "Open/Active Requests";
$closedReqNavLink			= "Completed/Closed Requests";
$newReqNavLink				= "Create a New Request";
$adminsNavLink				= "Admins";
$adminAccNavLink			= "Admin Accounts";
$newAdminNavLink			= "Add a New Admin Account";
$adminAuthNavLink			= "Admin Authorizations";
$siteAlertsNavLink			= "Site Alerts";
$repNavLink					= "Reports";
$usrRepNavLink				= "User Reports";
$propRepNavLink				= "Property Reports";
$accRepNavLink				= "Accounting Reports";
$servRepNavLink				= "Service Reports";
$formsNavLink				= "Forms &amp; Templates";
$siteContNavLink			= "Site Content";
$settingsNavLink			= "Settings";
$siteSetNavLink				= "Site Settings";
$socNetNavLink				= "Social Networks";
$uplSetNavLink				= "Upload Settings";
$paySetNavLink				= "Payment Settings";
$reqSetNavLink				= "Service Request Settings";
$slideSetNavLink			= "Home Page Slider";
$impExptSetNavLink			= "Import/Export";
$siteLogsNavLink			= "Site Logs";

// includes/footer.php, includes/user_footer.php & admin/includes/footer.php Includes
// --------------------------------------------------------------------------------------------------
$getInTouchTitle			= "Get in Touch with Us";
$questionsCommentsTitle		= "Questions or Comments?";
$contUsFormFirstName		= "First Name";
$contUsFormLastName			= "Last Name";
$contUsFormPhone			= "Phone";
$contUsFormComments			= "Enter your massage. We will get back to you within 2 business days.";
$contUsFormBtn				= "Send Contact Request";
$copyrightText				= "Copyright";
$copyrightLink				= "<a class=\"copyright_logo\" href=\"http://codecanyon.net/item/reside-rental-property-management/5263078?ref=Luminary\">M-Reside Property Management</a>";
$getToKnowTitle				= "Get to Know Us";
$admAvatarAlt				= "Admin Avatar";
$allPropRentedText			= "All Properties Rented";
$recentActTitle				= "Recent Activty";
$noActMsg					= "No Recent Activity Recorded.";

// index.php
// --------------------------------------------------------------------------------------------------
$featuredPropText			= "Featured Properties";
$featuredText				= "Featured";

// about-us.php
// --------------------------------------------------------------------------------------------------
$viewPubProfileText			= "View Public Profile";
$memberSinceText			= "Member Since:";

// available-properties.php
// --------------------------------------------------------------------------------------------------
$yearText					= "Year";
$bedroomsText				= "Bedrooms";
$bathsText					= "Baths";
$petsText					= "Pets";
$rateText					= "Rate";
$noPropAvailMsg				= "There are currently no Properties Available.";

// profile.php
// --------------------------------------------------------------------------------------------------
$sendText					= "Send";
$directMsgText				= "a Direct Message";
$enterMsgText				= "Please enter your massage.";
$sendDirectMsgBtn			= "Send Direct Message";
$directMsgFormSubject		= "Personal Contact Request from";
$directMsgForm1				= "Thank you for taking the time to contact me. I will get back to you as soon as I can.";

// rental-application.php
// --------------------------------------------------------------------------------------------------
$interestedText				= "Interested in Renting with Us?";
$dwnldAppTitle				= "Download Our Rental Application";
$dwnldAppText				= "Download and complete our Rental Application and drop it off at our office. We would love to speak with you about our properties and show you around. If you have any questions or concerns, please contact us and we will be happy to assist you in any way we can.";
$dwnldAppBtn				= "Download Rental Application";

// view-property.php
// --------------------------------------------------------------------------------------------------
$featuredPropText			= "Featured Property";
$slashMonthText				= "/ Month";
$bathroomsText				= "Bathrooms";
$sixeText					= "Size";
$heatingText				= "Heating";
$yearBuiltText				= "Year Built";
$parkingText				= "Parking";
$depositText				= "Deposit";
$readyRentAppBtn			= "Ready? Complete Our Rental Application";
$thePropText				= "The Property";
$wasViewedText				= "was viewed";

// pages/completed.php
// --------------------------------------------------------------------------------------------------
$cmpltPageTitle1			= "Payment Confirmation";
$cmpltPageTitle2			= "Payment Cancelled";
$compltPayActivity			= "completed a PayPal payment transaction";
$compltPayActivity1			= "A PayPal payment transaction was cancelled by";
$thankYouMsg				= "Thank you for your recent payment to";
$thankYouMsg1				= "Your payment will be added to your account by our staff, and you can then print a receipt for the payment.<br />
If you have any questions or concerns about Rental Payments, please <a href=\"contact-us.php\">Contact Us</a>.";
$cancelledMsg				= "If this was intentional, please disregard this notice. If you did not mean to cancel the Payment, please return to the Payments page
and attempt to make the payment again.<br />If you have any questions or concerns about Rental Payments, please <a href=\"contact-us.php\">Contact Us</a>.";
$thankYouConf				= "Thank you for your payment to";
$cancelledConf1				= "Your payment to";
$cancelledConf2				= "was Cancelled.";
$newPaymentEmailSubject		= "A new Lease Payment has been completed for:";
$newPaymentEmail1			= "Paid By:";
$newPaymentEmail2			= "Property:";
$newPaymentEmail3			= "Amount Paid:";
$newPaymentEmail4			= "Date of Payment:";
$directAccessError			= "You can not directly access this page.";
$directAccessError1			= "Please return to the Payments page and attempt to make a payment again.<br />If you have any questions or concerns about Rental Payments,
please <a href=\"contact-us.php\">Contact Us</a>.";
$directAccessActivity		= "attempted to directly access the Payment Confirmation Page";

// pages/dashboard.php
// --------------------------------------------------------------------------------------------------
$dashPageTitle				= "My Dashboard";
$welcomeText				= "Welcome";
$welcomeQuipText			= "web portal allows you to view information &amp; details relating to your current Leased Property.";
$dashRentLateText			= "This month's rent is Past Due. Total Due:";
$dashRentLateText1			= "(Rental Rate + Late Fee).";
$dashCurrentLeaseText		= "Your Current Lease";
$propertyHead				= "Property";
$monthlyRentHead			= "Monthly Rent";
$feeLateHead				= "Fee if Late";
$petsAllowedHead			= "Pets Allowed";
$leaseTermHead				= "Lease Term";
$managerHead				= "Manager";
$leaseEndHead				= "Lease Ends On";
$viewPropertyText			= "View Property";
$viewMngProfileText			= "View Manager Profile";
$usrNoLeasedPropMsg			= "You do not currently have a Leased Property";
$mostRecentPymntsText		= "Your Most Recent Payments";
$paymentForHead				= "Payment For";
$paidByHead					= "Paid By";
$amountPaidHead				= "Amount Paid";
$lateFeePaidHead			= "Late Fee Paid";
$paymentDateHead			= "Payment Date";
$renatlMonthHead			= "Rental Month";
$totalPaidHead				= "Total Paid";
$amtReflectsRefText			= "Amount Reflects Refund";
$noneText					= "None";
$naText						= "N/A";
$viewReceiptText			= "View Receipt";

// pages/myDocuments.php
// --------------------------------------------------------------------------------------------------
$usrNoDocsFoundMsg			= "No Uploaded Documents found.";
$docNameHead				= "Document Name";
$docDescHead				= "Document Description";
$uploadedByHead				= "Uploaded By";
$dateUploadedHead			= "Date Uploaded";
$viewDocText				= "View Document";

// pages/myProfile.php
// --------------------------------------------------------------------------------------------------
$persInfoText				= "Personal Information";
$persInfoQuip				= "We store your personal information in our database in an encrypted format. We do not sell or make your information available to any one
for any reason. We value your privacy and appreciate your trust in us.";
$accountTabTitle			= "Account";
$accountTabH3				= "Account Profile Info";
$primaryPhoneField			= "Primary Phone";
$altPhoneField				= "Alternate Phone";
$mailingAddrField			= "Mailing Address";
$locationField				= "Location";
$emailTabTitle				= "Email";
$currEmailAddrField			= "Current Email Address";
$newEmailAddrField			= "New Email Address";
$newEmailAddrFieldHelp		= "A Valid email. Used for logging in and notifications.";
$rptEmailAddrField			= "Repeat New Email";
$rptEmailAddrFieldHelp		= "Type the new email address again. Emails MUST Match.";
$passwordTabH3				= "Change Account Password";
$currPasswordField			= "Current Password";
$currPasswordFieldHelp		= "Your Current Account Password.";
$newPasswordField			= "New Password";
$newPasswordFieldHelp		= "Type a new Password for your Account.";
$rptPasswordField			= "Repeat Password";
$rptPasswordFieldHelp		= "Type the new password again. Passwords MUST Match.";
$avatarTabTitle				= "Avatar";
$avatarTabH3				= "Manage Profile Avatar";
$avatarTabQuip				= "Avatar image size is 80px wide by 80px high.<br />Allowed File Types:";
$avatarField				= "Select New Avatar";
$uplAvatarBtn				= "Upload Avatar";
$remAvatarQuip				= "You can remove your current Avatar, and use the default Avatar.<br />To upload a new Avatar image you will need to first remove your current Avatar.";
$remAvatarBtn				= "Remove Current Avatar Image";
$remAvatarConf				= "Are you sure you want to DELETE your current Profile Avatar image?";
$remAvatarConfBtn			= "Yes, Delete My Avatar Image";
$primPhoneReqMsg			= "Your Primary Phone Number is required.";
$mailingAddrReqMsg			= "Your Mailing Address is required.";
$profileUpdAct				= "updated their User Account Profile";
$profileUpdatedMsg			= "Your Account Profile has been updated.";
$newEmailAddrReq			= "Your New Email Address is required.";
$newEmailsNotMatchMsg		= "The Email Addresses Do Not Match, please check your entries.";
$emailAddrUpdatedAct		= "updated their User Account Email";
$emailAddrUpdatedMsg		= "Your Account Email has been updated.";
$accPasswordReqMsg			= "Your Current Account Password is required.";
$curAccPassWrongMsg			= "Your Current Account Password is incorrect.";
$newPassReqMsg				= "Your New Account Password is required.";
$retypeNewPassMsg			= "Please type your New Account Password again.";
$newPassNoMatchMsg			= "Your New Account Passwords Do Not Match, please check your entries.";
$usrPassChangeAct			= "changed their User Account Password";
$passChangedConf			= "Your Account Password has been changed.";
$avatarTypeErrMsg			= "The Avatar Image is not an allowed file type to be uploaded.";
$avatarUplMsg				= "Your New Avatar Image has been uploaded.";
$newAvatarUpldMsg			= "uploaded a New User Avatar Image";
$newAvatarUplErrMsg			= "An Error was encountered, and your New Avatar Image could not be uploaded.";
$newAvatarUplErrAct			= "New User Avatar Image failed to upload";
$delAvatarMsg				= "Your Avatar Image has been removed.";
$usrAvatarDelAct			= "deleted their User Profile Avatar Image";
$delAvatarErrMsg			= "An Error was encountered, and your Avatar Image could not be removed.";
$delAvatarErrAct			= "User Avatar Image failed to be removed";

// pages/myProperty.php
// --------------------------------------------------------------------------------------------------
$myPropPageTitle			= "My Leased Property";
$currAmtDueText				= "Current Amount Due:";
$lateFeeText				= "Late Fee";
$propAmenText				= "Property Amenities:";
$viewLeaseHistBtn			= "View Lease Payment History";
$newPaymentBtn				= "Make a New Payment";
$myLeaseH3					= "Lease";
$leaseTermText				= "Lease Term:";
$managerLiText				= "Manager:";
$myResidentsH3				= "Residents";
$noResidentsFoundMsg		= "No Residents found.";
$propertyFilesH3			= "Property Files";
$noUplFilesFoundMsg			= "No Uploaded Files found.";

// pages/newPayment.php
// --------------------------------------------------------------------------------------------------
$newPaymentPageTitle		= "Property Payments";
$paymentTypes1				= "accepts Cash, Personal / Cashier's Checks, Money Orders or PayPal for Rental Payments.";
$paymentTypes2				= "accepts Cash, Personal / Cashier's Checks or Money Orders for Rental Payments.";
$currAmyPastDueText			= "Current Amount Past-Due:";
$userMonRentAmtText			= "Your Monthly Rent Amount is:";
$addFeeText					= "Additional Fee if Rent Payment is Late:";
$payPayPalH3				= "Pay with PayPal";
$rentAmtEnteredText			= "Your Rent amount has been entered for you.";
$payPalQuip1				= "You can change the amount if what you are paying differs. The Payment Amount will be converted to include the additional";
$payPalQuip2				= "% of the base payment amount to cover PayPal's transaction fees. Make sure the payment details below are correct and click the
Pay With PayPal button.<br />You will then be redirected to PayPal's secure site to complete your payment.";
$paymentAmtField			= "Payment Amount";
$paymentAmtFieldHelp		= "Please enter the amount you would like to pay by PayPal. <strong>No currency symbols (Format: 500.00)</strong>.";
$totPaypalAmtField			= "Total PayPal Amount";
$totPaypalAmtFieldHelp1		= "This amount reflects the";
$totPaypalAmtFieldHelp2		= "% PayPal Fee and is the total for this rental payment.";
$payWithPaypalBtn			= "Pay with PayPal";
$otherPayH3					= "Pay by Cash, Personal / Cashier's Check or Money Order";
$payableToText				= "Payable To:";
$mailToText					= "Mail or drop off at:";
$mailToQuip					= "You can avoid paying the extra PayPal fees by paying with Cash, Check or a Money Order.";
$paymentQuestionsH3			= "Questions about Payments?";
$paymentQuestionsQuip		= "If you have any questions or concerns about Rental Payments, please <a href=\"contact-us.php\">Contact Us</a>.";

// pages/newRequest.php
// --------------------------------------------------------------------------------------------------
$newRequestPageTitle		= "New Service Request";
$requestTitleField			= "Request Title";
$requestTitleFieldHelp		= "Please give your Service Request a Title.";
$priorityField				= "Priority";
$priorityFieldHelp			= "Please choose a Priority Level for this Request.";
$requestDescField			= "Request Description";
$requestDescFieldHelp		= "Please be as detailed as possible.";
$reqTitleReq				= "The Request Title is required.";
$reqPriorityReq				= "The Priority is required.";
$reqDescReq					= "The Request Description is required.";
$newReqEmailSubject			= "New Service Request for";
$newReqEmail1				= "Requested By:";
$newReqEmail2				= "Request:";
$newReqEmail3				= "Description:";
$newUsrReqAct				= "created a New Service Request";
$newReqSavedMsg				= "The new New Service Request has been saved.";

// pages/paymentHistory.php
// --------------------------------------------------------------------------------------------------
$payHistPageTitle			= "Payment History";
$allPayRecH3				= "All Payments Received";
$leaseDatesHead				= "Lease Dates";
$totalReceivedText			= "Total Received:";
$allRefIssH3				= "All Refunds Issued";
$noRefIssMsg				= "No Refunds have been issued.";
$origPaymentHead			= "Original Payment";
$refundDateHead				= "Refund Date";
$refunfForHead				= "Refund For";
$refundAmtHead				= "Refund Amount";
$totRefundedText			= "Total Refunded:";
$noUserPaymentsMsg			= "You have not made any Payments.";

// pages/receipt.php
// --------------------------------------------------------------------------------------------------
$receiptPageTitle			= "Payment Receipt";
$receiptPageH3				= "Receipt for Payment Received";
$payIdText					= "Payment Id#";
$dateRecvdText				= "Date Received:";
$rentMonthText				= "Rent Month";
$paidToText					= "Paid To:";
$recFromText				= "Received From:";
$descriptionHead			= "Description";
$amountHead					= "Amount";
$lateFeeHead				= "Late Fee";
$totalDueText				= "Total Due:";
$amtRefundedText			= "Amount Refunded:";
$rcpPayRefText				= "This payment has been refunded.";
$rcpPayPartRefText			= "This Payment has been partially refunded, and the Total Received reflects the total amount received after the refund was issued.";

// pages/serviceRequests.php
// --------------------------------------------------------------------------------------------------
$servReqPageTitle			= "Service Requests";
$servReqQuip1				= "Service Requests for your current Property Lease.";
$servReqQuip2				= "If you need Service or Maintenance, please <a href=\"page.php?page=newRequest\">request a New Service call</a>.";
$reqNewServBtn				= "Request New Service";
$assignedToHead				= "Assigned To";
$requestHead				= "Request";
$statusHead					= "Status";
$dateSubmittedHead			= "Date Submitted";
$lastUpdatedHead			= "Last Updated";
$openClosedHead				= "Open/Closed";
$unassignedText				= "Unassigned";
$openText					= "Open";
$closedText					= "Closed";
$viewRequestText			= "View Request";
$noOpenClosedReqFoundMsg	= "No Open/Active Service Requests found.";

// pages/viewDocument.php
// --------------------------------------------------------------------------------------------------
$viewDocPageTitle			= "View Document";
$titleText					= "Title:";
$uploadedByText				= "Uploaded By:";
$uploadedOnText				= "Uploaded On:";
$docDescText				= "Document Description:";
$noPreviewAvailText			= "No Preview Available:";
$downloadFileText			= "Download File:";

// pages/viewFile.php
// --------------------------------------------------------------------------------------------------
$viewFilePageTitle			= "View Property File";
$fileDescText				= "File Description:";
$fileDescFieldHelp			= "Short description of the File.";

// pages/viewPayments.php
// --------------------------------------------------------------------------------------------------
$viewPaymentsPageTitle		= "Lease Payment History";
$leasePayRecH3				= "Lease Payments Received";
$noLeasePayRecMsg			= "No Payments have been received.";
$totRecLeaseText			= "Total Received for Lease:";
$leaseRefIssH3				= "Lease Refunds Issued";
$noLeaseRefIssMsg			= "No Refunds have been issued for this Property/Lease.";
$totRefLeaseText			= "Total Refunded for Lease:";

// pages/viewRequest.php
// --------------------------------------------------------------------------------------------------
$viewReqPageTitle			= "View Service Request";
$reqPriorityText			= "Priority:";
$reqStatusText				= "Status:";
$reqAssignedToText			= "Assigned To:";
$servReqDateText			= "Request Date:";
$servReqByText				= "Requested By:";
$reqComplDateText			= "Complete Date:";
$reqClosedServReqMsg		= "Closed/Completed Service Request.";
$servReqTabTitle			= "Service Request";
$editReqBtn					= "Edit Request";
$editReqH4					= "Edit Service Request";
$servReqResTabTitle			= "Service Request Resolution";
$resDescText				= "Resolution Description:";
$dateClosedText				= "Date Closed:";
$followUpText				= "Follow Up:";
$servReqDiscH3				= "Service Request Discussions";
$postedByText				= "Posted By";
$atText						= "at";
$editCommentBtn				= "Edit Comment";
$editDiscCmtH3				= "Edit Discussion Comment";
$noDiscCmtFoundMsg			= "No Service Request Discussion Comments found.";
$addDiscCmtH3				= "Add a Discussion Comment";
$reqTitleReqMsg				= "The Service Request Title is required.";
$reqTextReqMsg				= "The Service Request Text is required.";
$reqUpdatedAct				= "updated the Service Request";
$servReqUpdatedMsg1			= "The Service Request";
$servReqUpdatedMsg2			= "has been updated.";
$discCmtReqMsg				= "The Discussion Comment is required.";
$discCmtUpdAct				= "updated Discussion Comment for";
$discCmtUpdMsg				= "The Discussion Comment for";
$newDiscCmtEmailSubject		= "New Service Request Comment for";
$newDiscCmtEmail1			= "Comment from:";
$newDiscCmtEmail2			= "Comment:";
$newDiscCmtAct				= "added a New Comment for the Request";
$newDiscCmtMsg1				= "The new New Service Request Comment for";
$newDiscCmtMsg2				= "has been saved.";

// admin/pages/accountingReports.php
// --------------------------------------------------------------------------------------------------
$accReportsPageTitle		= "Accounting Reports";
$payRcvdLegend				= "Payments Received";
$selectPayTypesField		= "Select the Payment Types";
$allCheckboxOpt				= "All";
$rentalPayOpt				= "Rental Payments";
$otherPayOpt				= "Other Payments";
$selectTenantsField			= "Select Tenant(s)";
$allTenantsOpt				= "All Tenants";
$selectTenantsFieldHelp		= "* Indicates a Tenant with an Inactive Lease.";
$showRecFromField			= "Show Records From";
$showRecFromFieldHelp		= "Please select or type a Beginning Date. Format: 0000-00-00";
$showRecToField				= "Show Records To";
$showRecToFieldHelp			= "Please select or type an End Date. Format: 0000-00-00";
$runRptBtn					= "Run Report";
$refIssLegend				= "Refunds Issued";

// admin/pages/accountingRpt.php
// --------------------------------------------------------------------------------------------------
$fromText					= "From";
$toText						= "to";
$nothingToRptMsg			= "Nothing to report, no results found.";
$tenantHead					= "Tenant";
$idHead						= "ID#";
$receivedByHead				= "Received By";
$origIdHead					= "Original ID#";
$issuedByHead				= "Issued By";
$reportErrorH3				= "Report Error";
$reportErrorQuip			= "An Error was encountered, and the report could not be generated.";
$rptTitle1					= "All Payments Received";
$rptTitle2					= "Rental Payments Received";
$rptTitle3					= "Other Payments Received";
$rptTitle4					= "Refunds Issued";

// admin/pages/activeRequests.php
// --------------------------------------------------------------------------------------------------
$actReqPageTitle			= "Open/Active Service Requests";
$viewTenantText				= "View Tenant";

// admin/pages/adminAccounts.php
// --------------------------------------------------------------------------------------------------
$adminAccPageTitle			= "Manage Administrators";
$activeTabTitle				= "Active";
$activeAdmAccH3				= "Active Admin Accounts";
$noActAdmAccFoundMsg		= "No Active Administrator Accounts found";
$adminNameFeild				= "Admin Name";
$titleHead					= "Title";
$superUserHead				= "Superuser";
$createDateHead				= "Create Date";
$lastSigninHead				= "Last Sign In";
$viewAdminText				= "View Admin";
$inactiveTabTitle			= "Inactive/Disabled";
$inactAdmTitle				= "Inactive/Disabled Admin Accounts";
$noInactAdmFoundMsg			= "No Inactive/Disabled Administrator Accounts found";
$inactEnbText				= "Inactive/Enabled";
$inactDisabText				= "Inactive/Disabled";
$delAdmAccText				= "Delete Admin Account";
$disabledText				= "Disabled";
$delAdmConf					= "Are you sure you want to permanently DELETE the Admin Account for";
$delAdmConf1				= "It is recommended to <strong>NOT</strong> delete Admin Accounts, as any Actions (Comments, Service Requests Etc.)
from the Admin will NOT be deleted.<br />Disabled Admins can not Sign in, and all data will remain intact.";
$delAdmAccAct1				= "attempted to deleted the Primary Admin Account";
$delAdmAccAct2				= "deleted the Admin Account for";
$delAdmAccErr				= "You can NOT delete the Primary Admin Account.";
$admAccDelConf1				= "The Admin Account for";
$admAccDelConf2				= "has been deleted.";

// admin/pages/adminAuths.php
// --------------------------------------------------------------------------------------------------
$adminAuthsPageTitle		= "Admin Access Authorizations";
$selectAdminH4				= "Select an Administrator to Update/Modify";
$selectAdminOpt				= "Select Admin";
$loadAdminBtn				= "Load Admin";
$superUserAccField			= "Superuser Access";
$superUserAccQuip			= "Superuser Accounts have access to everything, regardless of what their Access Authorizations are set to.";
$accessAuthH4				= "Access Authorizations";
$accessAuthQuip				= "Once an Administrator is loaded, select any/all of the Access Authorizations that they need access to.";
$accessAuthMsg				= "If you are not a Superuser and remove your permissions for Admin Access Authorizations, you will lose access to this page.";
$saveAuthsBtn				= "Save Authorizations";
$selectAdminErr				= "You need to first Select an Admin to update their Authorizations.";
$admAuthsAct1				= "updated the Authorizations for";
$admAuthsUpdMsg1			= "The Authorizations for";
$admAuthsUpdMsg2			= "have been updated.";
$updatedAdminAct1			= "updated the Admin";
$updatedAdminAct2			= "to Superuser Access";
$theAdminText				= "The Admin";
$adminSuperUserUpdMsg1		= "has been updated to Superuser Access.";
$adminSuperUserUpdMsg2		= "has been updated to Restricted Access.";

// admin/pages/adminRpt.php
// --------------------------------------------------------------------------------------------------
$adminRptPageTitle			= "Administrator Reports";
$adminManagerHead			= "Admin/Manager";
$roleHead					= "Role";
$assignedPropHead			= "Assigned Properties";
$assignedReqHead			= "Assigned Requests";
$inactClosedText			= "Inactive/Closed";
$startDateHead				= "Start Date";
$endDateHead				= "End Date";
$inactiveText				= "Inactive";
$adminRptTitle1				= "All Administrators &amp; Manager Accounts";
$adminRptTitle2				= "Active Administrator &amp; Manager Accounts";
$adminRptTitle3				= "Inactive Administrator &amp; Manager Accounts";
$adminRptTitle4				= "Disabled Administrator &amp; Manager Accounts";
$adminRptTitle5				= "Specific Administrator or Manager";
$adminRptAct1				= "viewed the";
$adminRptAct2				= "report";
$adminRptAct3				= "An error was encountered for the";

// admin/pages/archivedTenants.php
// --------------------------------------------------------------------------------------------------
$archivedTenantsPageTitle	= "Archived Tenants";
$noArcTenFoundMsg			= "No Archived Tenants found";
$typeHead					= "Type";
$joinedOnText				= "Joined On";
$dateArchHead				= "Date Archived";
$residentText				= "Resident";
$tenantText					= "Tenant";
$reactTenAccText			= "Reactivate Tenant Account";
$deleteTenAccText			= "Delete Tenant Account";
$reacTenAccConf				= "Reactivate the Tenant Account for";
$deleteTecAccConf			= "Are you sure you want to permanently DELETE the Tenant Account for";
$deleteTecAccConf1			= "You can only delete a Tenant Account that does not currently have an Active Lease.";
$reactTenAccAct				= "reactivated the Tenant Account for";
$reactTenAccAct1			= "could not reactivated the Tenant Account for";
$reactTenAccMsg				= "The Tenant Account for";
$reactTenAccMsg1			= "has been reactivated.";
$reactTenAccMsg2			= "The Tenant";
$reactTenAccMsg3			= "has an Active Lease and can not be reactivated.";
$deleteTenAccAct			= "deleted the Tenant Account for";
$deleteTenAccAct1			= "could not delete the Tenant Account for";
$deleTenAccConf				= "has an Active Lease and can not be deleted.";

// admin/pages/dashboard.php
// --------------------------------------------------------------------------------------------------
$dashboardPageTitle			= "Admin Dashboard";
$welcomeAdmText				= "Welcome,";
$theText					= "The";
$welcomeAdmQuip				= "web portal allows you to view/update information &amp; details relating to your Rental Properties and Tenants.";
$lateRentH3					= "Tenants With Late Rent for";
$addressHead				= "Address";
$rentAmtHead				= "Rent Amount";
$totalDueHead				= "Total Due";
$noLateRentMsg				= "No Late Rent to report.";
$rentRcvdForH3				= "Rent Received for";
$amtRefRefText				= "Amount Reflects Refund";
$receiptText				= "Receipt";
$totalRecvdForText			= "Total Received for";
$noPayMadeText				= "No Payments have been received for this month.";
$availPropH3				= "Available Properties";
$bedsText					= "Beds";
$bathsText					= "Baths";
$noPropFoundText			= "No Properties are currently Available.";
$leasedTenText				= "Leased Tenant";
$leasedTensText				= "Leased Tenants";
$availaPropText				= "Available Property";
$availPropsText				= "Available Properties";
$openServReqText			= "Open Service Request";
$openServReqsText			= "Open Service Requests";

// admin/pages/forms.php
// --------------------------------------------------------------------------------------------------
$formsPageTitle				= "Forms &amp; Templates";
$uplTemplH3					= "Uploaded Templates";
$uplTemplBtn				= "Upload a Template";
$uplTemplH4					= "Upload a New Template";
$fileTypesAllText			= "File types allowed:";
$maxUploadSizeText			= "Max Upload File Size:";
$templNameField				= "Template Name";
$templNameFieldHelp			= "Give the Template a short name.";
$templDescField				= "Template Description";
$templDescFieldHelp			= "A short description for the Template.";
$selFileField				= "Select File";
$uploadBtn					= "Upload";
$noUplTmplFoundMsg			= "No Uploaded Templates found.";
$viewTemplText				= "View Template";
$premadeFormsH3				= "Pre-Made Forms";
$premadeFormsQuip			= "comes with some pre-made Forms & Templates.";
$premadeFormsQuip1			= "These are great to use with your Tenants, just fill in the PDF fields with the Tenant's information.
These pre-made forms are designed to be filled out, printed and then given to the Tenant. If you have the full version of
<a href=\"http://www.adobe.com/products/acrobat.html\" target=\"_blank\">Adobe Acrobat,</a> you can also save the completed form,
and then upload it to the Tenant's account.";
$formNameHead				= "Form Name";
$formDescHead				= "Form Description";
$premadeForm1				= "Rental Application Form";
$premadeForm2				= "Basic Tenant Rental Application";
$premadeForm3				= "Rent Increase Notice";
$premadeForm4				= "Notice of Rental Rate Increase";
$premadeForm5				= "Move Out Reminder";
$premadeForm6				= "What's expected from a Tenant on Moving Out";
$premadeForm7				= "Pet Agreement";
$premadeForm8				= "Details of allowed pets";
$premadeForm9				= "Important Information for a New Tenant";
$premadeForm10				= "Helpful information relating to a newly Leased Property";
$premadeForm11				= "Returned Check Notice";
$premadeForm12				= "Notice of a Bank refused/Returned Check";
$premadeForm13				= "Notice to Vacate or Renew Lease";
$premadeForm14				= "Tenant's intentions beyond the current Lease";
$templNameReq				= "The Template Name is required.";
$templDescReq				= "The Template Description is required.";
$templWrongTypeMsg			= "The selected Template File is not an allowed file type to be uploaded.";
$templUplMsg				= "The New Template file has been uploaded.";
$templUplErrorMsg			= "An Error was encountered, and the New Template file could not be uploaded.";
$templUplAct				= "uploaded a New Template file";
$templUplActError			= "A New Template file";
$templUplActError1			= "failed to upload";
$templDeletedMsg			= "The Template file has been deleted.";

// admin/pages/importExport.php
// --------------------------------------------------------------------------------------------------
$importExportPageTitle		= "Import Reside Data";
$impExpH3					= "Import Data from Reside V.2";
$impExpQuip					= "You can import your previous Reside Version 2 data into Reside V3. If you choose to upload your old data, you will need to do this BEFORE you add any new data through
Reside. Once you have added any Tenants, Properties, Leases, Admin/Managers etc., you will no longer be able to import your old data. This is to prevent duplicate ID's in the
database.";
$impExpQuip1				= "You will need to upload any Tenant documents to the new system. The Export/Import feature will not include any Tenant or Property documents or any Templates and Forms.";
$impExpQuipMsg				= "Please Note: You can only import Reside Version 2 Data. This Export/Import feature will <strong>NOT</strong> work with versions older then V2.";
$impExpQuip2				= "To export your old data from Version 2 of Reside, please refer to the documentation that is included in the Reside download zip file you downloaded from Code Canyon.
If you have any questions about exporting/importing, please do not hesitate to contact me through my <a href=\"https://jennperrin.com/support/\" target=\"_blank\">Support System</a>.";
$impExpQuip3				= "If this is your first time using Reside, you do not need to do anything special. The Import Data page will not effect Reside in any way.";
$impAdmins					= "Import Admin/Manager Accounts";
$impAdmins1					= "The admins table in the database has more then 1 record.";
$impDataBtn					= "Import Data";
$impTenants					= "Import Tenant/Resident Accounts";
$impTenants1				= "The Tenants/Resident table in the database is not empty.";
$impProp					= "Import Properties";
$impProp1					= "The Properties table in the database is not empty.";
$impLeases					= "Import Leases";
$impLeases1					= "The Leases table in the database is not empty.";
$impPay						= "Import Payments";
$impPay1					= "The Payments table in the database is not empty.";
$impRefunds					= "Import Refunds";
$impRefunds1				= "The Refunds table in the database is not empty.";
$impServReq					= "Import Service Requests";
$impServReq1				= "The Service Requests table in the database is not empty.";
$impServReq2				= "Import Service Request Discussions";
$impServReq3				= "The Service Requests Discussions table in the database is not empty.";
$selFileWrongTypeMsg		= "The selected file is not the correct file type to import";
$adminImpAct				= "imported Admin/Manager data from V.2";
$adminRecsImpMsg			= "The Admin/Manager Accounts have been Imported successfully";
$tenantImpAct				= "imported Tenant/Resident data from V.2";
$tenantImpMsg				= "The Tenant/Resident Accounts have been Imported successfully";
$propImpAct					= "imported Property data from V.2";
$propImpMsg					= "The Property data has been Imported successfully";
$leaseImpAct				= "imported Lease data from V.2";
$leaseImpMsg				= "The Lease data has been Imported successfully";
$payImpAct					= "imported Payment data from V.2";
$payImpMsg					= "The Payment data has been Imported successfully";
$refImpAct					= "imported Refund data from V.2";
$refImpMsg					= "The Refund data has been Imported successfully";
$servReqImpAct				= "imported Service Request data from V.2";
$servReqImpMsg				= "The Service Request data has been Imported successfully";
$servReqDiscImpAct			= "imported Service Request Discussion data from V.2";
$servReqDiscImpMsg			= "The Service Request Discussion data has been Imported successfully";

// admin/pages/inactiveRequests.php
// --------------------------------------------------------------------------------------------------
$inactReqPageTitle			= "Completed/Closed Service Requests";
$noInactReqFoundMsg			= "No Completed/Closed Service Requests found.";

// admin/pages/leasedProperties.php
// --------------------------------------------------------------------------------------------------
$leasedPropPageTitle		= "Leased Properties";
$noActivePropFoundMsg		= "No Properties with an Active Lease found";
$viewLeaseText				= "View Lease";

// admin/pages/leasedTenants.php
// --------------------------------------------------------------------------------------------------
$leasedTenantsPageTitle		= "Leased Tenants";
$noLeasedTenFoundMsg		= "No Tenants with an Active Lease found";
$propertyHead				= "Property";
$leaseEndHead				= "Lease End";
$landlordHead				= "Landlord";
$viewLandlordText			= "View Landlord";

// admin/pages/leaseProperty.php
// --------------------------------------------------------------------------------------------------
$leasePropPageTitle			= "Lease Property";
$createLeaseQuip			= "Create a New Lease for this Property.";
$createLeaseMsg				= "Tenant accounts must first be created before you can create a new Lease for any Property.";
$monthlyRateText			= "Monthly Rate";
$selectTenOpt				= "Select Tenant";
$selectTenOptHelp			= "Select the Tenant this Lease is for.";
$termOfLeaseField			= "Term of Lease";
$termOfLeaseFieldHelp		= "The length of the Lease (ie. 6 Months, 12 Months etc).";
$leaseStartDateField		= "Lease Start Date";
$leaseStartDateFieldHelp	= "The Date the Lease will begin on.";
$leaseEndDateField			= "Lease End Date";
$leaseEndDateFieldHelp		= "The Date the Lease ends on.";
$leaseNotesField			= "Lease Notes";
$leaseNotesFieldHelp		= "Notes (if any) for this Lease.";
$createLeaseBtn				= "Create Lease";
$newLeaseCreatedMsg			= "The New Lease for";
$newLeaseCreatedMsg1		= "has been created.";
$allreadyLeasedMsg			= "This Property all ready has an Active Lease.";
$tenLeaseReq				= "The Tenant this Lease is for is required.";
$leaseTermReq				= "The Lease Term is required.";
$leaseStartDateReq			= "The Date the Lease Starts is required.";
$leaseEndDateReq			= "The Date the Lease Ends is required.";
$createLeaseAct				= "created a New Lease for";
$newLeaseMsg				= "The New Lease for";
$newLeaseMsg1				= "has been created.";

// admin/pages/leaseRpt.php
// --------------------------------------------------------------------------------------------------
$leaseRptPageTitle			= "Lease Reports";
$leaseRptTitle				= "All Leases";
$leaseRptTitle1				= "Active Leases";
$leaseRptTitle2				= "Inactive/Closed Leases";

// admin/pages/myProfile.php
// --------------------------------------------------------------------------------------------------
$myProfilePageTitle			= "My Profile";
$fullNameField				= "Full Name";
$socialLinksH4				= "Social Links";
$manSocialLinksH3			= "Manage Social Links";
$facebookProfField			= "Facebook Profile";
$googleProfField			= "Google+ Profile";
$limkedinProField			= "LinkedIn Profile";
$pinterestProfField			= "Pinterest Profile";
$twitterProfField			= "Twitter Profile";
$youtubeProfField			= "YouTube Profile";
$quoteH4					= "Quote";
$managePersQuoteH3			= "Manage Personal Quote";
$persQuoteField				= "Personal Quote";
$pictureH4					= "Picture";
$managePubPicH3				= "Manage Public Picture";
$managePubPicQuip			= "Public Picture image size is 180px wide by 180px high. Images uploaded will be resized if necessary.<br />
Allowed File Types: ";
$selectPicField				= "Select New Picture";
$uplPicBtn					= "Upload Picture";
$remPicQuip					= "You can remove your current Public Picture, and use the default Public Picture.<br />
To upload a new Picture image you will need to first remove your current Picture.";
$remPicBtn					= "Remove Current Avatar Picture";
$manageAvatarQuip			= "Avatar image size is 80px wide by 80px high. Images uploaded will be resized if necessary.<br />
Allowed File Types: ";
$uplAvatarBtn				= "Upload Avatar";
$remAvatarQuip				= "You can remove your current Avatar, and use the default Avatar.<br />To upload a new Avatar image you will need to first remove your current Avatar.";
$delAvatarBtn				= "Yes, Delete My Avatar Image";
$delPubPicConf				= "Are you sure you want to DELETE your current Public Picture?";
$delPubPicBtn				= "Yes, Delete My Public Picture";
$firstLastNamesReq			= "Your First and Last Names are required.";
$admProfileUpdAct			= "updated their Admin Account Profile";
$admEmailUpdAct				= "updated their Admin Account Email";
$admPassUpdAct				= "changed their Admin Account Password";
$admSocialLinksUpdAct		= "updated their Admin Social Links";
$admSocialLinksUpdMsg		= "Your Profile Social Links have been updated.";
$persQuoteUpdAct			= " updated their Admin Personal Quote";
$persQuoteUpdMsg			= "Your Personal Quote has been updated.";
$avatarUplAct				= "uploaded a New Admin Avatar Image";
$avatarUplAct1				= "'s New Admin Avatar Image failed to upload";
$delAvatarAct				= "deleted their Admin Profile Avatar Image";
$delAvatar1					= "'s Admin Avatar Image failed to be removed";
$pubPicFileError			= "The Public Picture is not an allowed file type to be uploaded.";
$pubPicUplMsg				= "Your New Public Picture has been uploaded.";
$pubPicUplAct				= "uploaded a New Admin Public Picture";
$pubPicUplError				= "An Error was encountered, and your New Public Picture could not be uploaded.";
$pubPicUplErrorAct			= "'s New Admin Public Picture failed to upload";
$delPubPicMsg				= "Your Public Picture has been removed.";
$delPubPicAct				= "deleted their Admin Public Picture";
$delPubPicErrorMsg			= "An Error was encountered, and your Public Picture could not be removed.";
$delPubPicErrorAct			= "'s Admin Public Picture failed to be removed";

// admin/pages/newAdmin.php
// --------------------------------------------------------------------------------------------------
$newAdminPageTitle			= "Add a New Administrator Account";
$setAccActiveField			= "Set the Account as Active?";
$setAccActiveFieldHelp		= "Inactive Administrators can NOT Sign In.";
$accountTypeField			= "Account Type";
$accountTypeFieldHelp		= "Selecting Superuser will give the New Admin ALL permissions.";
$limitedAccOpt				= "Limited Access";
$superAccOpt				= "Superuser Access";
$adminsNameField			= "Administrator's Name";
$adminsTitleField			= "Administrator's Title";
$adminsEmailAddField		= "Administrator's Email Address";
$repAdminEmailAddField		= "Repeat Administrator's Email Address";
$adminAccPassField			= "Account Password";
$genPasswordBtn				= "Generate Password";
$showPlainText				= "Show Plain Text";
$hidePlainText				= "Hide Plain Text";
$repeatPassField			= "Repeat Account Password";
$repeatPassFieldHelp		= "Repeat the New Password again. Passwords MUST Match.";
$adminPriPhoneField			= "Administrator's Primary Phone";
$adminAltPhoneField			= "Administrator's Alternate Phone";
$createAccBtn				= "Create New Account";
$admNameReq					= "The Administrator's Name is required.";
$admEmailReq				= "The Administrator's Email is required.";
$admEmailNoMatch			= "The Administrator's Email Address's do not match.";
$admPassReq					= "The Account Password is required.";
$accPassNoMatch				= "The Account Passwords do not match.";
$dupAccountMsg				= "There is all ready an account registered with that Email Address.";
$newAdmAccAct				= "created a New Admin Account for";
$newAdmAccMsg				= "The new Administrator account has been created.";

// admin/pages/newProperty.php
// --------------------------------------------------------------------------------------------------
$newPropertyPageTitle		= "Add a New Property";
$propNameField				= "Property Name";
$propAddressField			= "Property Address";
$propDescField				= "Property Description";
$propRateField				= "Property Rental Rate";
$propDepAmtField			= "Rental Deposit Amount";
$propLateFeeField			= "Late Fee Amount";
$propTypeField				= "Property Type";
$propTypeFieldHelp			= "ie. Single Family, Multi-Family etc.";
$propStyleField				= "Property Style";
$propStyleFieldHelp			= "ie. Detached Home, Apartment, Town House etc.";
$propSizeField				= "Property Size";
$propBedsField				= "Total Bedrooms";
$propBathsField				= "Total Bathrooms";
$propParkField				= "Parking Type";
$propHeatingField			= "Heating/Air Conditioning";
$propGoogleMapField			= "Google Map Embed URL";
$propGoogleMapFieldHelp		= "Google Map Embed URL only. Do NOT include the &lt;iframe&gt; or any of the attributes.";
$saveNewPropBtn				= "Save New Property";
$propNameReq				= "The Property Name is required.";
$propAddReq					= "The Property Address is required.";
$propRateReq				= "The Property Rental Rate is required.";
$propTypeReq				= "The Property Type is required.";
$propStyleReq				= "The Property Style is required.";
$newPropAct					= "added a New Property";
$newPropMsg					= "The new New Property has been saved.";

// admin/pages/newRequest.php
// --------------------------------------------------------------------------------------------------
$newRequestPageTitle		= "New Service Request";
$selectPropField			= "Select Property";
$selectPropFieldHelp		= "Select the Property this Support Request is for.";
$tenResField				= "Tenant/Resident";
$tenResFieldHelp			= "Read Only, Populated based on the Property selected.";
$reqPropReq					= "The Property this Request is for is required.";
$newServReqAct				= "added a New Service Request for";
$newServReqMsg				= "The new New Service Request for";

// admin/pages/newTenant.php
// --------------------------------------------------------------------------------------------------
$newTenantPageTitle			= "Add a New Tenant Account";
$setTenActHelp				= "Selecting No will require the Tenant to activate the Account via a link sent to the account email address.";
$priTenantopt				= "Primary Tenant";
$tntAccountTypeHelp			= "Is this account for the Primary Tenant or a Resident living with the Primary Tenant (ie. spouse, relative, room-mate etc.)?";
$tntFirstNameField			= "Tenant/Resident First Name";
$tntLastNameField			= "Tenant/Resident Last Name";
$tntEmalAddField			= "Tenant/Resident Email Address";
$tntRepeatEmailField		= "Repeat Tenant/Resident Email Address";
$tntaccPassField			= "Account Password";
$tntPriPhoneField			= "Tenant/Resident Primary Phone";
$tntAltPhoneField			= "Tenant/Resident Alternate Phone";
$tntFirstNameReq			= "The Tenant/Resident First Name is required.";
$tntLastNameReq				= "The Tenant/Resident Last Name is required.";
$tntEmailReq				= "The Tenant/Resident Email is required.";
$tntEmailNoMatch			= "The Tenant/Resident Email Address do not match.";
$newTntEmailSubject			= "Your";
$newTntEmailSubject1		= "Account has been created";
$newTntEmail				= "Your new Account details:";
$newTntEmail1				= "Username: Your email address<br>Password:";
$newTntEmail2				= "You must activate your account before you will be able to log in. Please click (or copy/paste) the following link to activate your account:";
$newTntEmail3				= "Once you have activated your new account and logged in, please take the time to update your account profile details.";
$newTntCreatedMsg			= "The new Tenant/Resident account has been created, and an email to activate the account has been sent.";
$newTntCreatedAct			= "created a New Tenant Account for";
$newTntCreatedAct1			= "created a New Tenant Account for";
$newTntCreatedMsg1			= "The new Tenant/Resident account has been created, and set as active.";

// admin/pages/paymentDetail.php
// --------------------------------------------------------------------------------------------------
$paymentDetailPageTitle		= "Property Payment Detail";
$tenantNameText				= "Tenant Name";
$leaseStatusText			= "Lease Status";
$paymentNotesText			= "Payment Notes";
$editPaymentBtn				= "Edit Payment";
$datePayRcvdField			= "Date Payment Received";
$datePayRcvdFieldHelp		= "The Date the Payment was received from the Tenant. Format: YYYY-MM-DD";
$payForFieldHelp			= "What this Payment is for. (ie. Deposit, Rent etc.)";
$payAmtHelp					= "The base amount of the Payment. Do not include any Late Fees paid here.";
$latePayFeeField			= "Late Penalty Fee";
$latePayFeeFieldHelp		= "If the Payment was late and incurred the Late Fee Penalty.";
$payTypeField				= "Payment Type";
$payTypeFieldHelp			= "What form the Payment was made in. (ie. Cash, Check etc.)";
$rentMonthField				= "Rent Month";
$rentMonthFieldHelp			= "If this is a Monthly Rental Payment, otherwise leave at None.";
$rentYearFeild				= "Rent Year";
$rentYearFeildHelp			= "If this is a Monthly Rental Payment, otherwise leave blank.";
$payNotesFieldHelp			= "Payment Notes are internal only, and the Tenant will not see them.";
$issueRefBtn				= "Issue a Refund";
$issueRefH4					= "Issue a Full or Partial Refund";
$refDateField				= "Refund Date";
$refDateFieldHelp			= "The Date the Refund was issued to the Tenant.";
$refAmtField				= "Refund Amount";
$refForField				= "Refund For";
$refForFieldHelp			= "What this Refund is for. (ie. Refund Security Deposit, Over Payment etc.)";
$refundNotesField			= "Refund Notes";
$issueRefundBtn				= "Issue Refund";
$deletePayBtn				= "Delete Payment";
$deletePayConf				= "Are you sure you want to permanently DELETE the the Payment for";
$deletePayConf1				= "This will delete the Payment, and any Refunds issued (if any) for that payment.";
$viewReceiptBtn				= "View Receipt";
$emailReceiptBtn			= "Email Receipt";
$emailReceiptConf			= "Email a receipt of this payment to the Tenant";
$refundIssuedH3				= "Refunds Issued";
$editRefundBtn				= "Edit Refund";
$editRefundForH4			= "Edit Refund for";
$deleteRefundBtn			= "Delete Refund";
$deleteRefundConf			= "Are you sure you want to permanently DELETE the Refund for";
$payDateReq					= "The Payment Date is required.";
$payForReq					= "The Payment For is required.";
$payAmtReq					= "The Payment Amount is required.";
$payTypeReq					= "The Payment Type is required.";
$updPaymentAct				= "updated the Payment for";
$updPaymentMsg				= "The Payment for";
$updPaymentMsg1				= "has been updated.";
$refDateReq					= "The Refund Date is required.";
$refAmtReq					= "The Refund Amount is required.";
$refForReq					= "The Refund For is required.";
$refExceedsMsg				= "The Refund Amount exceeds the original amount paid.";
$issRefundAct				= "issued a Refund for";
$issRefundMsg				= "The Refund for";
$delPayRecAct				= "deleted a Payment for";
$editRefAct					= "updated the Refund";
$editRefMsg					= "The Refund";
$delRefundAct				= "deleted a the Refund for";
$delRefundMsg				= "The Refund for";
$paymentRefundedMsg			= "This payment has been refunded.";
$paymentRefundedMsg1		= "This Payment has been partially refunded, and the Total Received reflects the total amount received after the refund was issued.";
$payReceiptEmailSubject		= "Receipt of Payment to";
$receiptEmailedAct			= "emailed a Receipt of Payment to";
$receiptEmailedMsg			= "The Receipt of Payment has been emailed to";

// admin/pages/paymentSettings.php
// --------------------------------------------------------------------------------------------------
$paymentSettingsPageTitle	= "Payment Settings";
$enablePaySystemField		= "Enable Payment System?";
$enablePaySystemQuip		= "Enabling the <strong>Payment System</strong> allows Tenants to have access to all payments records and receipts, and enables all of the Payment System features for
all authorized Admins and Managers. Set to no to completely disable the Payment System for all Tenants, Managers and Admins.";
$enablePaySystemBtn			= "Save Payment System Settings";
$enablePaypalField			= "Enable Payments Through PayPal?";
$enablePaypalQuip			= "Enabling the <strong>Payments through PayPal</strong> allows Tenants to make rent payments via PayPal through their account.
If you disable PayPal Payments, Tenants will still have access to all payment records and receipts as long as the Payment System is enabled.";
$paypalCurrCodeField		= "PayPal Currency Code";
$paypalCurrCodeFieldHelp	= "Select the supported PayPal Currency Code to use in PayPal payments.";
$paypalEmailField			= "PayPal Account Email";
$paypalEmailFieldHelp		= "Your PayPal Account's email &mdash; where PayPal payments will be sent to.";
$paypalItemNameField		= "Payment Item Name";
$paypalItemNameFieldHelp	= "The item name that appears on the PayPal payment.";
$paypalUseFeeField			= "PayPal Use Fee";
$paypalUseFeeFieldHelp		= "Fee charged by PayPal. Do not include \"%\" symbol (ie. 0.5).";
$paymntComplMsgField		= "Payment Completed Message";
$paymntComplMsgFieldHelp	= "What the Tenant will see once they have completed a PayPal payment.";
$savePaypalSetBtn			= "Save PayPal Payment Settings";
$paysettingsAct				= "enabled the Payment System Settings";
$paysettingsMsg				= "The Payment System has been enabled.";
$paysettingsAct1			= "disabled the Payment System";
$paysettingsMsg1			= "The Payment System has been disabled.";
$paypalEmailReq				= "The PayPal Account Email is required.";
$paypalItemNameReq			= "The Payment Item Name is required.";
$paypalUseFeeReq			= "The PayPal Use Fee is required.";
$paymentComplMsgReq			= "The Payment Completed Message is required.";
$paymentUpdAct				= "enabled and updated the PayPal Payment Settings";
$paymentUpdMsg				= "The PayPal Payment Settings have been enabled and updated.";
$paymentUpdAct1				= "disabled the PayPal Payment System";
$paynentUpdMsg1				= "The PayPal Payment System has been disabled.";

// admin/pages/propertyLeases.php
// --------------------------------------------------------------------------------------------------
$propertyLeasesPageTitle	= "Property Leases";
$activePropLeasesH3			= "Active Property Leases";
$noActPropLeasesFoundMsg	= "No Active Property Leases found";
$leaseStartHead				= "Lease Start";
$viewUpdateLeaseText		= "View/Update Lease";
$inactPropLeaseH3			= "Inactive/Archived Property Leases";
$noInactPropLeasesFoundMsg	= "No Inactive/Archived Property Leases found";

// admin/pages/propertyReports.php
// --------------------------------------------------------------------------------------------------
$propertyReportsPageTitle	= "Property Reports";
$propRptSelectPropField		= "Select the Property types to include on the report";
$propLeasedOpt				= "Leased";
$propAvailOpt				= "Available";
$propRptLeasesField			= "Leases";
$propRptLeasesFieldLabel	= "Select the Lease types to include on the report";

// admin/pages/propertyRpt.php
// --------------------------------------------------------------------------------------------------
$typeStyleHead				= "Type/Style";
$rentalRateHead				= "Rental Rate";
$propertyRptTitle			= "All Properties";
$propertyRptTitle1			= "Leased Properties";
$propertyRptTitle2			= "Available Properties";

// admin/pages/serviceReports.php
// --------------------------------------------------------------------------------------------------
$servReportsPageTitle		= "Service Reports";
$servReqLabel				= "Select the Request status types to include on the report";
$activeOpenOpt				= "Active/Open";
$closedComplOpt				= "Closed/Completed";
$selectpropertiesField		= "Select Properties";
$selectpropertiesFieldHelp	= "* Indicates a Property without an Active Lease.";
$allPropertiesOpt			= "All Properties";
$servReqLegend				= "Service Request Expenses";

// admin/pages/serviceReqRpt.php
// --------------------------------------------------------------------------------------------------
$serviceReqRptPageTitle		= "Service Request Reports";
$createdByHead				= "Created By";
$expenseDateHead			= "Expense Date";
$vendorHead					= "Vendor";
$forHead					= "For";
$expenceAmtHead				= "Expense Amount";
$enteredByHead				= "Entered By";
$serviceReqRptTitle1		= "All Service Requests";
$serviceReqRptTitle2		= "Active/Open Service Requests";
$serviceReqRptTitle3		= "Closed/Completed Service Requests";
$servReqRptType1			= "Service Request Expenses";

// admin/pages/serviceRequestSettings.php
// --------------------------------------------------------------------------------------------------
$serReqSettingsPageTitle	= "Service Request Settings";
$servPriSelOptions			= "Service Priority Select Options";
$servPriQuip				= "Visible to all Users, Admins &amp; Managers.";
$newPriOptBtn				= "New Priority Option";
$newPriOptionH4				= "Create a New Priority Select Option";
$priTitleField				= "Priority Title";
$dateCreatedHead			= "Date Created";
$editPriTitleText			= "Edit Priority Title";
$delPriTitleText			= "Delete Priority Option";
$delPriOptionConf			= "Are you sure you want to permanently DELETE the Priority Select Option";
$noPriOptFoundMsg			= "No Service Priority Select Options found";
$servStaOptionH4			= "Service Status Select Options";
$servStaOptionsQuip			= "Visible to Admins/Managers only.";
$newStaOptionBtn			= "New Status Option";
$newStaOptH4				= "Create a New Status Select Option";
$staTitleField				= "Status Title";
$editStaTitleText			= "Edit Status Title";
$delStatusOptConf			= "Are you sure you want to permanently DELETE the Status Select Option";
$noStatusOptionsFound		= "No Service Status Select Options found";
$priTitleReq				= "The Priority Title is required.";
$newPriOptionAct			= "created a New Priority Option";
$newPriOptionMsg			= "The New Service Priority Select Option";
$editPriOptionAct			= "updated the Priority Option";
$editPriOptionMsg			= "The Service Priority Select Option";
$deletPriOptionAct			= "deleted the Priority Option";
$deletPriOptionMsg			= "The Service Priority Select Option";
$staTitleReq				= "The Status Title is required.";
$newStaOptionAct			= "created a New Status Option";
$newStaOptionMsg			= "The New Service Status Select Option";
$editStaOptionAct			= "updated the Status Option";
$editStaOptionMsg			= "The Service Status Select Option";
$delStaOptionAct			= "deleted the Status Option";
$delStaOptionMsg			= "The Service Status Select Option";

// admin/pages/siteAlerts.php
// --------------------------------------------------------------------------------------------------
$siteAlertsPageTitle		= "Site Alerts";
$newSiteAlertBtn			= "Create a New Site Alert";
$siteAlertQuip				= "To use a Start Date and/or an End Date, set the new Alert as inactive. Site Alerts set to Active will display regardless of what dates are set.";
$alertStatField				= "Alert Status";
$alertStatFieldHelp			= "Setting the Alert Status to Active will display the Alert to all Logged In Users.";
$alertTypeField				= "Alert Type";
$alertTypeFieldHelp			= "Public Alerts display for all registered Users and Guests. Private Alerts display for registered Users ONLY.";
$publicOption				= "Public";
$privateOption				= "Private";
$alertStartHelp				= "Leave blank if the Alert does not have a start date. Format: 0000-00-00";
$alertEndHelp				= "Leave blank if the Alert never expires. Format: 0000-00-00";
$alertTitleField			= "Alert Title";
$alertTextField				= "Alert Text";
$saveNewAlertBtn			= "Save New Alert";
$editAlertBtn				= "Edit Site Alert";
$delAlertBtn				= "Delete Site Alert";
$delAlertConf				= "Are you sure you want to permanently DELETE the Site Alert";
$alertTitleReq				= "The Alert Title is required.";
$alertTextReq				= "The Alert Text is required.";
$newAlertAct				= "created the Site Alert";
$newAlertMsg				= "The New Site Alert";
$editAlertAct				= "updated the Site Alert";
$editAlertMsg				= "The Site Alert";
$delAlertAct				= "deleted the Site Alert";
$delAlertMsg				= "The Site Alert";

// admin/pages/siteContent.php
// --------------------------------------------------------------------------------------------------
$siteContentPageTitle		= "Manage Site Content";
$homePageTabTitle			= "Home Page";
$homePageTabQuip			= "Manage Home Page Content";
$availPropTabTitle			= "Available Properties Page";
$availPropTabQuip			= "Manage Available Properties Page Content";
$viewPropPageTabTitle		= "View Property Page";
$viewPropPageTabQuip		= "Manage View Property Page Content";
$aboutUsPageTabQuip			= "Manage About Us Page Content";
$contUsPageTabQuip			= "Manage Contact Us Page Content";
$rentAppPageTabQuip			= "Manage Rental Application Page Content";
$siteContentAct1			= "updated the Site Content for the Home Page";
$siteContentAct2			= "updated the Site Content for the Available Properties Page";
$siteContentAct3			= "updated the Site Content for the View Property Page";
$siteContentAct4			= "updated the Site Content for the About Us Page";
$siteContentAct5			= "updated the Site Content for the Contact Us Page";
$siteContentAct6			= "updated the Site Content for the Rental Application Page";
$siteContentMsg1			= "The Home Page Content has been updated.";
$siteContentMsg2			= "The Available Properties Page Content has been updated.";
$siteContentMsg3			= "The View Property Page Content has been updated.";
$siteContentMsg4			= "The About Us Content has been updated.";
$siteContentMsg5			= "The Contact Us Content has been updated.";
$siteContentMsg6			= "The Rental Application Content has been updated.";

// admin/pages/siteLogs.php
// --------------------------------------------------------------------------------------------------
$siteLogsPageTitle			= "Site Logs";
$deleteLogsBtn				= "Delete All Logs";
$deleteLogsConf				= "Are you sure you want to permanently DELETE the Site Logs?";
$activityByHead				= "Activity By";
$activityHead				= "Activity";
$activityDateHead			= "Activity Date";
$ipAddHead					= "IP Address";
$siteAlertActType			= "Site Alert";
$uplActType					= "Upload";
$siteSetActType				= "Site Setting";
$accUpdateActType			= "Account Update";
$signinActType				= "Account Sign In";
$signoutActType				= "Account Sign Out";
$propViewActType			= "Property View";
$contReqActType				= "Contact Request";
$userAccActType				= "User Account";
$admAccActType				= "Admin Account";
$fileUplActType				= "File Uploads";
$accErrActType				= "Access Error";
$paypalActType				= "PayPal";
$newAccActType				= "New Accounts";
$otherActType				= "Other";
$localhostIpAdd				= "localhost";
$guestText					= "Guest";
$delLogsAct					= "deleted the Site Logs";
$delLogsMsg					= "The Site Logs have been deleted.";

// admin/pages/siteSettings.php
// --------------------------------------------------------------------------------------------------
$siteSettingsPageTitle		= "Global Site Settings";
$installUrlField			= "Installation URL";
$installUrlFieldHelp		= "Used in all uploads &amp; email notifications. Must include the trailing slash.";
$siteNameField				= "Site Name";
$siteNameFieldHelp			= "Appears in the Header and throughout other areas.";
$siteEmailField				= "Site Email";
$siteEmailFieldHelp			= "Used in all email notifications.";
$busiNameField				= "Business Name";
$busiNameFieldHelp			= "Appears in the Header and throughout other areas.";
$localField					= "Localization";
$localFieldHelp				= "Choose English or the Custom File to load. The custom file will need to be translated.";
$enbRegField				= "Enable Registrations?";
$enbRegFieldHelp			= "Set to No to disable the ability for Users Creating New Accounts.";
$enbHoaField				= "Enable HOA Data?";
$enbHoaFieldHelp			= "Set to No to disable the HOA Data.";
$weekStartField				= "Week Start Day";
$weekStartFieldHelp			= "Set the Day the week starts on.";
$busPhoneField				= "Business Phone";
$busPhoneFieldHelp			= "Public Phone Number for General Information, Questions etc.";
$contPhoneField				= "Contact Phone";
$contPhoneFieldHelp			= "Phone Number Tenants can call for General Information, Questions etc.";
$siteTitleField				= "Site Title/Quip";
$weatherWidgLocField		= "Weather Widget Location";
$weatherWidgLocFieldHelp	= "Default Location for the Admin Side Weather Widget.";
$busiAddField				= "Business Address";
$busiAddFieldHelp			= "Full Mailing Address. (Appears in Tenant's Receipt).";
$googMapUrlField			= "Google Map URL";
$googMapUrlFieldHelp		= "Used in the public Footer and in the Contact Us page. Google Map Embed URL only. Do NOT include the &lt;iframe&gt; or any of the attributes.";
$googAnalyticsField			= "Google Analytics Code";
$googAnalyticsFieldHelp		= "Adds your Google tracking code to all front facing pages. Don't include the &lt;script&gt; tags";
$saveGlobSetBtn				= "Save Global Site Settings";
$installUrlReq				= "Installation URL is required (include the trailing slash).";
$siteNameReq				= "The Site Name is required.";
$busAddReq					= "The Business Address is required.";
$siteEmailReq				= "The Site Email Address is required.";
$busPhoneReq				= "The Business Phone Number is required.";
$googMapUrlReq				= "The Google Map URL is required.";
$globSitSetAct				= "updated the Global Site Settings";
$globSitSetMsg				= "The Global Site Settings have been updated.";

// admin/pages/sliderSettings.php
// --------------------------------------------------------------------------------------------------
$sliderSettingsPageTitle	= "Home Page Slider Settings";
$enableSliderField			= "Enable the Home Page Image Slider Carousel?";
$enableSliderFieldHelp		= "Set to Yes to show the Image Slider Carousel on the Home page.";
$enableSliderBtn			= "Save Slider Carousel Settings";
$uplSliderImageText			= "Upload a New Slider Image";
$imgTitleField				= "Image Title";
$imgTitleFieldHelp			= "Not Required. Displays as the Heading over the Slider Image.";
$btnUrlField				= "Button URL";
$btnUrlFieldHelp			= "Not Required. Creates a Link Button over the Slider Image. (Full URL including http://)";
$btnTextField				= "Button Text";
$btnTextFieldHelp			= "Displays as the Button Text.";
$imgTextField				= "Image Text";
$imgTextFieldHelp			= "Not Required. Displays as a short paragraph over the Slider Image.";
$selectImgField				= "Select Image";
$selectImgFieldHelp1		= "Allowed File Types:";
$selectImgFieldHelp2		= "Max Upload File Size:";
$selectImgFieldHelp3		= "Height: 300px &amp; Width: 1170px Recommended.<br />Slider images should all be uniform in height and width.";
$uplImageBtn				= "Upload Image";
$currSliderImagesH3			= "Current Uploaded Slider Carousel Images";
$noSliderImagesFound		= "No Slider Carousel Images have been uploaded.";
$editSliderBtn				= "Edit";
$deleteSliderBtn			= "Delete";
$editSliderdataH4			= "Edit Uploaded Slider Carousel Image Data";
$delSliderImgConf			= "Are you sure you want to DELETE the Slider Image";
$sliderSetUpdAct			= "updated the Home Page Slider Settings";
$sliderSetUpdMsg			= "The Home Page Slider Settings have been updated.";
$editSliderImgAct			= "updated a Slider Carousel Image";
$editSliderImgMsg			= "The Slider Carousel Image Data has been updated.";
$deleteSliderImgAct			= "deleted a Slider Carousel Image";
$deleteSliderImgErrAct		= "An error was encountered and the Slider Image could not be deleted";
$deleteSliderImgMsg			= "The Slider Image has been deleted.";
$deleteSliderImgMsgErr		= "An error was encountered and the Slider Image could not be deleted.";
$sliderImgReq				= "A Slider Image must be selected.";
$sliderImgFileTypeErr		= "The selected Slider Image is not the correct type.";
$uplSliderImgAct			= "uploaded a new Slider Carousel Image";
$uplSliderImgMsg			= "The new Slider Image has been uploaded.";

// admin/pages/socialNetworks.php
// --------------------------------------------------------------------------------------------------
$socialNetworksPageTitle	= "Social Network Settings";
$socNetPageQuip				= "The Social Network Settings are used to link the Social Icons in the header on the front end. Use the URL links to your profile
pages for any of the Social Networks listed below your company uses.";
$facebookUrl				= "Facebook Profile URL";
$googleUrl					= "Google+ Profile URL";
$linkedinUrl				= "LinkedIn Profile URL";
$pinterestUrl				= "Pinterest URL";
$twitterUrl					= "Twitter Profile URL";
$youtubeUrl					= "YouTube URL";
$saveSocNetSetBtn			= "Save Social Network Settings";
$socNetSettingsAct			= "updated the Social Network Settings";
$socNetSettingsMsg			= "The Social Network Settings have been updated.";

// admin/pages/tenantRpt.php
// --------------------------------------------------------------------------------------------------
$tenantRptPageTitle			= "User Reports";
$tenantRptType1				= "All Tenant &amp; Resident Accounts";
$tenantRptType2				= "Active Tenant &amp; Resident Accounts";
$tenantRptType3				= "Inactive Tenant &amp; Resident Accounts";
$tenantRptType4				= "All Archived/Disabled Tenant &amp; Resident Accounts";
$tenantRptType5				= "Archived Tenant &amp; Resident Accounts";
$tenantRptType6				= "Disabled Tenant &amp; Resident Accounts";

// admin/pages/unleasedProperties.php
// --------------------------------------------------------------------------------------------------
$unlPropPageTitle			= "Unleased Properties";
$noUnlPropFound				= "No Properties with an Inactive Lease found";
$delPropConf1				= "Are you sure you want to permanently DELETE the Property";
$delPropConf2				= "This action will DELETE the Property and ALL records for that Property.";
$deletePropAct				= "deleted the Property";

// admin/pages/unleasedTenants.php
// --------------------------------------------------------------------------------------------------
$unlTntsPageTitle			= "Unleased Tenants";
$noUnlTntsFound				= "No Tenants with an Inactive Lease found";
$archTntAccBtn				= "Archive Tenant Account";
$delTntAccBtn				= "Delete Tenant Account";
$archTntAccConf1			= "Archive the Tenant Account for";
$archTntAccConf2			= "You can only archive a Tenant Account that does not currently have an Active Lease.";
$delTntAccConf1				= "Are you sure you want to permanently DELETE the Tenant Account for";
$delTntAccConf2				= "You can only delete a Tenant Account that does not currently have an Active Lease.";
$archTntAccAct				= "archived the Tenant Account for";
$archTntAccAct1				= "has been archived.";
$archTntAccErrAct			= "could not archived the Tenant Account for";
$archTntAccErrAct1			= "has an Active Lease and can not be archived.";
$delTntAccAct				= "deleted the Tenant Account for";
$delTntAccAct1				= "could not delete the Tenant Account for";
$delTntAccMsg				= "has an Active Lease and can not be deleted.";

// admin/pages/uploadSettings.php
// --------------------------------------------------------------------------------------------------
$uploadSettingsPageTitle	= "Global File Upload Settings";
$propUplDirField			= "Property Upload Directory";
$propUplDirFieldHelp		= "Where all Property documents upload to. Must include the trailing slash.";
$tntDocDirField				= "Tenant Documents Directory";
$tntDocDirFieldHelp			= "Where all Tenant documents upload to. Must include the trailing slash.";
$avatarDirField				= "Avatar Upload Directory";
$avatarDirFieldHelp			= "Where all Avatars upload to. Must include the trailing slash.";
$propPicDirField			= "Property Pictures Directory";
$propPicDirFieldHelp		= "Where all Property pictures upload to. Must include the trailing slash.";
$tmplDirField				= "Template Upload Directory";
$tmplDirFieldHelp			= "Where all template files upload to. Must include the trailing slash.";
$fileTpsAllwdField			= "Upload File Types Allowed";
$fileTpsAllwdFieldHelp		= "Tenant &amp; Template file types you allow to be uploaded. NO spaces &amp; each separated by a comma (Format: jpg,jpeg,png).";
$avatarTpsAllwdField		= "Avatar File Types Allowed";
$avatarTpsAllwdFieldHelp	= "Avatar file types you allow to be uploaded. NO spaces &amp; each separated by a comma (Format: jpg,jpeg,png).";
$propPicTpsAllwdField		= "Property Picture File Types Allowed";
$propPicTpsAllwdFieldHelp	= "Property picture file types you allow to be uploaded. NO spaces &amp; each separated by a comma (Format: jpg,jpeg,png).";
$saveUplSetBtn				= "Save Global Upload Settings";
$propUplDirReq				= "The Property Upload Directory is required (include the trailing slash).";
$tntDocDirReq				= "The Tenant Documents Directory is required.";
$avatarDirReq				= "The Avatar Upload Directory is required.";
$propPicDirReq				= "The Property Pictures Directory is required.";
$templDirReq				= "The Template Upload Directory is required.";
$uplFileTypesReq			= "The Upload File Types Allowed is required.";
$avatarFileTypesReq			= "The Avatar File Types Allowed is required.";
$propPicFileTypesReq		= "The Property Picture File Types Allowed is required.";
$uplSetAct					= "updated the File/Image Upload Settings";
$uplSetMsg					= "The File/Image Upload Settings have been updated.";

// admin/pages/userReports.php
// --------------------------------------------------------------------------------------------------
$userReportsPageTitle		= "User Reports";
$userRptLegend1				= "Active &amp; Inactive Tenants/Residents";
$userRptLegend2				= "Archived Tenants/Residents";
$userRptLegendLabel1		= "Select the type of Accounts to include on the report";
$userRptLegendLabel2		= "Select the type of Accounts to include on the report";
$archivedOption				= "Archived";
$admReportLegend1			= "Administrator/Manager Accounts";
$admReportLegend2			= "Specific Administrator/Manager";
$admReportLegendLabel		= "Select the type of Admin Accounts to include on the report";
$selectAdmField				= "Select Adminstrator";
$selectAdmFieldHelp			= "* Indicates an Inactive or Disabled account.";

// admin/pages/viewAdmin.php
// --------------------------------------------------------------------------------------------------
$viewAdminPageTitle			= "View Administrator Account";
$manageAdminAccH3			= "Manage the Administrator's Account Info";
$admNameField				= "Admin's Name";
$titleField					= "Title";
$changeAdmEmailH3			= "Change the Administrator's Account Email";
$admCurrEmailField			= "Admin's Current Email";
$admNewEmailField			= "Admin's New Email";
$admRepeatEmailField		= "Repeat Admin's Email";
$changeAdmPassH3			= "Change the Administrator's Account Password";
$admNewPassFieldHelp		= "Type a new Password for the Administrator's Account.";
$mngAdmAccPicH3				= "Manage Administrator's Picture";
$mngAdmAccRicQuip			= "The Administrator does not have a Picture uploaded at this time.";
$mngAdmAccRicQuip1			= "You can remove the Administrator's current Picture, and use the default Picture. This is handy in the case of a Administrator uploading a questionable image.";
$remAdmPicBtn				= "Remove Current Picture";
$delAdmPicBtn				= "Yes, Delete the Administrator's Picture";
$remAdmPicConf				= "Are you sure you want to DELETE the Administrator's current Picture?";
$mngAdmAvatarH3				= "Manage Administrator's Profile Avatar";
$mngAdmAvatarQuip			= "The Administrator does not have a custom Avatar uploaded at this time.";
$mngAdmAvatarQuip1			= "You can remove the Administrator's current Avatar, and use the default Avatar. This is handy in the case of a Administrator uploading a questionable image.";
$mngAdmAvatarConf			= "Are you sure you want to DELETE the Administrator's current Profile Avatar image?";
$delAdmAvatarBtn			= "Yes, Delete the Administrator's Avatar Image";
$accountStatusTabH4			= "Account Status";
$accStatusNoModifyMsg		= "You cannot modify the Account Status for the Primary Administrator.";
$dsbAccField				= "Disable Account?";
$dsbAdmAccFieldHelp			= "Select \"Yes\" to set the Administrator's account to Disabled. Disabled Admin's CANNOT access their accounts.";
$socialTabH4				= "Social";
$socialTabH3				= "Manage the Administrator's Social Links";
$admNameReq					= "The Admin's Name is required.";
$admPriPhoneReq				= "The Admin's Primary Phone Number is required.";
$admMailAddReq				= "The Admin's Mailing Address is required.";
$admTitleReq				= "The Admin's Title is required.";
$admAccUpdAct				= "updated the Admin Account Info for";
$admAccUpdMsg				= "The Admin Account Info for";
$admNewEmailAddReq			= "The Admin's New Email Address is required.";
$admAccEmailUpdAct			= "updated the Admin Account Email for";
$admAccEmailUpdMsg			= "The Admin's Account Email has been updated.";
$adminPassReq				= "The Admin's New Account Password is required.";
$adminPassRepeatReq			= "Please type the Admin's New Account Password again.";
$adminPassUpdAct			= "changed the Admin Account Password for";
$adminPassUpdMsg			= "The Admin's Account Password has been changed.";
$delAdmPicAct				= "deleted the Admin Picture for";
$delAdmPicAct1				= "could not remove the Admin Picture for";
$delAdmPicMsg				= "The Admin's Picture has been removed.";
$delAdmPicMsg1				= "An Error was encountered, and the Admin's Picture could not be removed.";
$delAdmAvatarAct			= "deleted the Admin Profile Avatar for";
$delAdmAvatarAct1			= "could not remove the Admin Profile Avatar for";
$delAdmAvatarMsg			= "The Admin's Avatar Image has been removed.";
$delAdmAvatarMsg1			= "An Error was encountered, and the Admin's Avatar Image could not be removed.";
$dsbAdmAccAct				= "updated the Admin Account Status for";
$dsbAdmAccMsg				= "The Admin Account Status has been updated.";
$updAdmSocLinksAct			= "updated the Social Links for";
$updAdmSocLinksMsg			= "The Social Links for";
$disabledAccText			= "Disabled Account";
$enabledAccText				= "Enabled Account";

// admin/pages/viewDocument.php
// --------------------------------------------------------------------------------------------------
$viewDocumentPageTitle		= "View Document";
$viewDocH3					= "View Uploaded";
$viewDocH31					= "Document";

// admin/pages/viewFile.php
// --------------------------------------------------------------------------------------------------
$viewFilePageTitle			= "View Property File";
$deleteFileBtn				= "Delete File";
$deleteFileConf				= "Are you sure you want to permanently DELETE the the Property file";
$deleteFileAct				= "deleted the Property File file";
$deleteFileAct1				= "The Property File";
$deleteFileMsg				= "An Error was encountered, and the Property File could not be deleted.";
$deleteFileAct2				= "failed to delete";

// admin/pages/viewLease.php
// --------------------------------------------------------------------------------------------------
$viewLeasePageTitle			= "View Property Lease";
$closeLeaseBtn				= "Close Lease";
$closeLeaseConf				= "Has the Lease ended? Select Yes to Close this Lease and Update the Tenant &amp; the Property.";
$closeLeaseConfBtn			= "Yes, Close Lease";
$leaseClosedMsg				= "Lease is Inactive/Closed";
$updLeaseAct				= "updated the Property Lease for";
$updLeaseMsg				= "The Property Lease for";
$closeLeaseAct				= "closed the Property Lease for";
$closeLeaseMsg				= "The Property Lease for";
$closeLeaseMsg1				= "has been closed.";
$actLeaseText				= "Active Lease";
$inactLeaseText				= "Inactive/Closed Lease";

// admin/pages/viewPayments.php
// --------------------------------------------------------------------------------------------------
$viewPaymentsPageTitle		= "View Property Payments";
$recPayRecvdBtn				= "Record a Payment Received";
$recPayRecvdText			= "Record a Payment Received for this Lease";
$payNotesQuip				= "Payment Notes WILL print on the Tenant's Receipt.";
$savePaymentBtn				= "Save Payment";
$propPayRecvdH3				= "Property Payments Received";
$payDetailsOptText			= "Payment Detail &amp; Options";
$totRecvdforLease			= "Total Received for Current Lease";
$propRefIssH3				= "Property Refunds Issued";
$noRefIssLeaseMsg			= "No Refunds have been issued for this Property/Lease.";
$editRefBtn					= "Edit Refund";
$editRefH4					= "Edit Refund for";
$deleteRefBtn				= "Delete Refund";
$deleteRefConf				= "Are you sure you want to permanently DELETE the Refund";
$savePayAct					= "recorded a Payment Received for";
$savePayMsg					= "The Payment received for";

// admin/pages/viewProperty.php
// --------------------------------------------------------------------------------------------------
$updInfoBtn					= "Update Info";
$setFeaturedBtn				= "Set Featured";
$updPropInfoH4				= "Update Property Information";
$setFeaturedConf1			= "Setting a Property to Featured will have the Property shown on the Home Page, and will add the ribbon tag \"Featured\".<br />
<small>Only un-leased Properties will be displayed.</small>";
$setFeaturedConf2			= "Remove the Featured tag from this Property and remove it from the Home Page?";
$setFeaturedPropBtn			= "Set as a Featured Property";
$propPicsH3					= "Pictures";
$propPicsQuip				= "Any pictures uploaded for this property are viewable by guests and Tenants/Residents.";
$imageText					= "Image";
$deletePicBtn				= "Delete Picture";
$deletePropPicConf			= "Are you sure you want to permanently DELETE this Property Picture?";
$delFeaturedImgBtn			= "Delete Featured Image";
$delFeaturedImgConf			= "Are you sure you want to permanently DELETE the Featured Image for this Property?";
$uplFeaturedImgBtn			= "Upload Featured Image";
$uplFeaturedImgH4			= "Upload a Featured Image for this Property";
$uplFeaturedImgQuip1		= "The Featured Image for a Property displays as the primary image in the Available Property Listings, and on the home page.";
$uplFeaturedImgQuip2		= "Image/Picture types allowed:";
$uplFeaturedImgField		= "Select Featured Image";
$uplPropPicsBtn				= "Upload Property Pictures";
$uplPropPicsH4				= "Upload Pictures for this Property";
$uplPropPicsQuip1			= "Image/Picture types allowed:";
$uplPropPicsQuip2			= "Max Pictures per upload: 20";
$uplPropPicsField			= "Select Pictures";
$uplPropPicturesBtn			= "Upload Pictures";
$propAmenitiesH4			= "Property Amenities";
$updPropAmenitiesBtn		= "Update Property Amenities";
$propListingH4				= "Property Listing";
$updPropListingField		= "Update Property Listing";
$propHoaH4					= "Property HOA";
$hoaTitleH3					= "Home Owners Association";
$hoaNameText				= "HOA Name";
$hoaPhoneText				= "HOA Contact Phone";
$hoaAddressText				= "HOA Address";
$hoaFeeText					= "HOA Fee";
$hoaFeeSchedText			= "HOA Fee Schedule";
$hoaFeeSchedHelp			= "ie. Monthly, Yearly etc.";
$updHoaInfoBtn				= "Update Property HOA Information";
$updateHoaInfoBtn			= "Update HOA Info";
$rentRatePlusFeeText		= "Rental Rate + Late Fee";
$rentPaidText				= "Paid";
$mngLandlordText			= "Manager/Landlord";
$reassignPropText			= "Reassign Property";
$reassignPropH4				= "Reassign Property to a Manager/Landlord";
$remAssignedText			= "Remove Assigned";
$remAssignedTextHelp		= "Select \"Remove Assigned\" to leave the Property Unassigned";
$assignPropH4				= "Assign Property to a Manager/Landlord";
$newPropPayBtn				= "New Payment";
$residentsTexhH3			= "Residents";
$noResidentsFoundMsg		= "No Residents found.";
$addResBtn					= "Add a Resident";
$addResH4					= "Add a Resident to this Property";
$selectResField				= "Select Resident";
$noActResidentsFoundMsg		= "No active Residents found.";
$propNotLeasedText			= "This Property is currently not leased.";
$propUploadsBtn				= "Property Uploads";
$uplPropFileBtn				= "Upload Property File";
$propFileTypesAlld			= "Upload File types allowed";
$fileTitleField				= "File Title";
$fileTitleFieldHelp			= "Short Title for the File.";
$uplPropertyFileBtn			= "Upload File";
$noActServReqMsg			= "No Active Service Requests found.";
$opnReqPageTitle			= "Open Service Requests";
$updPropInfoAct				= "updated the Property Info for";
$updPropInfoMsg				= "The Property Info";
$featuredPropAct1			= "set the Property as Featured for";
$featuredPropAct2			= "removed the Property as Featured for";
$featuredPropMsg1			= "has been set as Featured.";
$featuredPropMsg2			= "has been removed as Featured.";
$featuredImgError			= "The Featured Image is not an allowed file type to be uploaded.";
$featuredImgMsg				= "The New Featured Image has been uploaded.";
$featuredImgMsgErr			= "An Error was encountered, and the New Featured Image could not be uploaded.";
$featuredImgAct1			= "uploaded a New Featured Image for";
$featuredImgAct2			= "A New Featured Image for";
$featuredImgErr1			= "The Featured Image has been removed.";
$featuredImgErr2			= "An Error was encountered, and the Featured Image could not be removed.";
$delFeaturedImgAct1			= "deleted the Featured Image for";
$delFeaturedImgAct2			= "The Featured Image for";
$propPicsUploadedMsg		= "The Property Pictures have been uploaded.";
$propPicsUploadedMsg2		= "An Error was encountered, and the Property Pictures could not be uploaded.";
$propPicsUploadedAct1		= "uploaded Property Pictures for";
$propPicsUploadedAct2		= "Property Pictures for";
$delPropPicMsg				= "The Property Picture has been deleted.";
$delPropPicMsg1				= "An Error was encountered, and the Property Picture could not be deleted.";
$delPropPicAct1				= "deleted a Property Picture for";
$delPropPicAct2				= "A Property Picture for";
$updAmnAct					= "updated the Property Amenities for";
$updAmnMsg					= "The Property Amenities for";
$updListingAct				= "updated the Property Listing for";
$updListingMsg				= "The Property Listing for";
$updHoaAct					= "updated the Property HOA for";
$updHoaMsg					= "The Property HOA for";
$assignPropAct				= "assigned the Property";
$assignPropMsg				= "has been assigned.";
$reassignPropAct			= "reassigned the Property";
$reassignPropAct1			= "removed the Manager for Property";
$reassignPropMsg			= "has been reassigned.";
$addResAct					= "added a Resident to";
$addResMsg					= "The Resident has been added for";
$fileTitleReq				= "The File Title is required.";
$fileDescReq				= "The File Description is required.";
$fileTypeNotAllowed			= "The File is not an allowed file type to be uploaded.";
$theFileText				= "The File";
$hasBeenUplAct				= "has been uploaded.";
$propFileUplAct				= "uploaded a New File for";
$propFileUplError			= "An Error was encountered, and the File could not be uploaded.";
$aFileForText				= "A File for";
$unlsdText					= "Unleased";
$propFileDltdMsg			= "The Property file has been deleted.";

// admin/pages/viewRequest.php
// --------------------------------------------------------------------------------------------------
$viewRequestPageTitle		= "View Service Request";
$printWorkOrderBtn			= "Print Work Order";
$assignReqBtn				= "Assign Request";
$assignServReqBtn			= "Assign Service Request";
$selectAdmMngField			= "Select Admin/Manager";
$closeCmpServReqH4			= "Close/Complete Service Request";
$resDescField				= "Resolution Description";
$resDateCmplField			= "Date Completed";
$resDateCmplFieldHelp		= "Date the Request was completed. Format: 0000-00-00";
$needsFollowupField			= "Needs Followup?";
$needsFollowupFieldHelp		= "Does this Request require further work?";
$followupDescField			= "Follow Up Explanation";
$followupDescFieldHelp		= "Please describe what Follow Up (if any) is required.";
$reoprenReqBtn				= "Reopen Request";
$reoprenReqConf				= "Reopen the Service Request";
$forText					= "for";
$notesTabText				= "Notes";
$servReqNotesH3				= "Service Request Notes";
$servReqNotesQuip			= "These notes are NOT visible to the Tenant, but WILL print on the Work Order.";
$updNotesBtn				= "Update Notes";
$addNotesBtn				= "Add Notes";
$resolutionTabText			= "Resolution";
$servReqResH3				= "Service Request Resolution";
$followupExpText			= "Follow Up Explanation:";
$editResBtn					= "Edit Resolution";
$editResH4					= "Edit Service Request Resolution";
$expensesTabText			= "Expenses";
$addExpenseBtn				= "Add an Expense";
$addExpenseH4				= "Add a Service Request Expense";
$vendorNameField			= "Vendor Name";
$vendorNameFieldHelp		= "The Company the Expense is from.";
$expenseNameField			= "Expense Name";
$expenseNameFieldHelp		= "Give the Expense a short name (ie. New Faucet, Drywall etc.).";
$expenseAmtField			= "Expense Amount";
$expenseAmtFieldHelp		= "Total amount of the expense. Numbers Only (Format: 00.00).";
$dateofExpenseField			= "Date of the Expense";
$dateofExpenseFieldHelp		= "Date the Expense was paid. Format: 0000-00-00";
$expenseDescField			= "Expense Description";
$expenseNotesField			= "Expense Notes";
$nameHead					= "Name";
$editExpenseBtn				= "Edit Expense";
$editExpenseH4				= "Edit Service Expense";
$delExpenseBtn				= "Delete Expense";
$delExpenseConf				= "Are you sure you want to permanently DELETE the Service Expense";
$totalExpensesPaidText		= "Total Expenses Paid:";
$noExpensesFoundMsg			= "No Expenses for this Service Request found.";
$delCommentBtn				= "Delete Comment";
$delCommentConf				= "Are you sure you want to permanently DELETE the Discussion Comment?";
$noCommentsFoundMsg			= "No Service Request Discussion Comments found.";
$updReqAct					= "updated the Service Request";
$assignReqAdminReq			= "The Admin/Manager is required.";
$assignReqAct				= "assigned the Service Request";
$assignReqMsg				= "has been assigned to";
$editCommentAct				= "updated a Discussion Comment for";
$editCommentMsg				= "The Discussion Comment for";
$delCommentAct				= "deleted a Discussion Comment for";
$delCommentMsg				= "The Discussion Comment for";
$resTextReq					= "The Service Request Resolution description is required.";
$reqDateCompReq				= "The Service Request Date Completed is required.";
$closeReqAct				= "closed the Service Request";
$closeReqMsg				= "has been closed.";
$reopnReqAct				= "reopened the Service Request";
$reopnReqMsg				= "has been reopened.";
$newReqNotesAct				= "Updated the Service Notes for";
$newReqNotesMsg				= "The Service Notes for";
$updReqResAct				= "updated the Service Request Resolution for";
$updReqResMsg				= "The Service Request Resolution for";
$vendorNameReq				= "The Vendor Name is required.";
$expenseNameReq				= "The Expense Name is required.";
$expenseCostReq				= "The Expense Cost is required.";
$expenseDateReq				= "The Date of the Expense is required.";
$expenseDescReq				= "The Expense Description is required.";
$newExpenseAct				= "added a New Service Expense for the Request";
$newExpenseMsg				= "The new New Service Expense for";
$updExpenseAct				= "updated the Service Expense";
$updExpenseMsg				= "The Service Expense for";
$delExpenseAct				= "deleted a Service Expense for";
$delExpenseMsg				= "The Service Expense for";
$newCommentEmailSubject		= "New Service Request comment for";
$newCommentEmail1			= "Comment from:";
$newCommentAct				= "added a New Comment for the Request";
$newCommentMsg				= "The new New Service Request Comment for";

// admin/pages/viewTemplate.php
// --------------------------------------------------------------------------------------------------
$viewTemplatePageName		= "View Uploaded Template";
$tempNameField				= "Template Name";
$tempNameHelp				= "A short Name for the Template.";
$templDeacField				= "Template Description";
$templDeacFieldHelp			= "A short description for the Template.";
$editTemplBtn				= "Edit Template";
$delTemplBtn				= "Delete Template";
$delTemplConf				= "Are you sure you want to permanently DELETE the the uploaded Template file";
$viewTemplQuip				= "Pictures/Images will be displayed. Any other Template/Form type will need to be downloaded to view/use.";
$noPreviewAvailMsg			= "No preview available";
$dwnldTemplBtn				= "Download Template:";
$updTemplAct				= "updated the Template";
$updTemplMsg				= "The Template";
$delTemplAct				= "deleted the Template file";
$delTemplError				= "An Error was encountered, and the Template could not be deleted.";
$delTemplErrAct				= "The Template file";

// admin/pages/viewTenant.php
// --------------------------------------------------------------------------------------------------
$viewTenantPageTitle		= "View Tenant Account";
$leasedPropText				= "Leased Property";
$noTntActLeaseFoundMsg		= "No Active Lease found for this";
$mngTntAccH3				= "Manage the";
$mngTntAccH31				= "'s Account Info";
$changeTheH3				= "Change the";
$changeTheH31				= "'s Account Email";
$currEmailText				= "'s Current Email";
$newEmailText				= "'s New Email";
$repeatText					= "Repeat";
$repeatText1				= "'s Email";
$accPassText				= "'s Account Password";
$accPassText1				= "Type a new Password for the";
$accPassText2				= "'s Account.";
$profAvatarText				= "'s Profile Avatar";
$profAvatarText1			= "does not have a custom Avatar uploaded at this time.";
$profAvatarText2			= "You can remove the";
$profAvatarText3			= "'s current Avatar, and use the default Avatar. This is handy in the case of a";
$profAvatarText4			= "uploading a questionable image.";
$profAvatarText5			= "Are you sure you want to DELETE the";
$profAvatarText6			= "'s current Profile Avatar image?";
$profAvatarText7			= "Yes, Delete the";
$profAvatarText8			= "'s Avatar Image";
$theText					= "The";
$accStatText				= "'s Account Status";
$accStatText1				= "Resident Accounts can be changed at any time, regardless of their Lease status.";
$selectYesText				= "Select \"Yes\" to set the";
$selectYesText1				= "'s account to Disabled. Disabled Tenants CANNOT access their accounts.";
$arcAccText					= "Archive Account?";
$arcAccHelp					= "Active &amp; Archived";
$arcAccHelp1				= "'s can still access their accounts.";
$tntAccStaQuip				= "The Tenant's Account Status can only be changed when they do NOT have an Active Property Lease. Resident Accounts can be changed at any time,
regardless of their Lease status.";
$tntIntNotesText			= "'s Internal Notes";
$intNotesField				= "Internal Notes";
$intNotesFieldHelp1			= "Internal Notes. The";
$intNotesFieldHelp2			= "can not see these notes.";
$docsTabH4					= "Documents";
$mngTntDocs					= "Manage Documents for this";
$uplDocBtn					= "Upload a Document";
$uplDoctntH4				= "Upload a Document for this";
$docTitleField				= "Document Title";
$docTitleFieldHelp			= "Short Title for the Document.";
$docDescField				= "Document Description";
$docDescFieldHelp			= "Short description of the Document.";
$selectDocField				= "Select Document";
$uploadDocBtn				= "Upload Document";
$noDocsFoundMsg				= "No Uploaded Documents found for this";
$delDocBtn					= "Delete Document";
$delDocConf					= "Are you sure you want to permanently DELETE the uploaded Document";
$tntPriPhoneReq				= "The Tenant/Resident Primary Phone Number is required.";
$tntMailAddReq				= "The Tenant/Resident Mailing Address is required.";
$updTenatAccAct				= "updated the Tenant Account Info for";
$updTenatAccMsg				= "The Tenant Account Info for";
$tntEmailAddyReq			= "The Tenant's New Email Address is required.";
$updTenantEmailAct			= "updated the Tenant Account Email for";
$updTenantEmailMsg			= "The Tenant's Account Email has been updated.";
$tntNewPassReq				= "The Tenant's New Account Password is required.";
$retypeTntNewPassReq		= "Please type the Tenant's New Account Password again.";
$tntPassNoMatch				= "The Tenant's New Account Passwords Do Not Match, please check your entries.";
$updTntPassAct				= "changed the Tenant Account Password for";
$updTntPassMsg				= "The Tenant's Account Password has been changed.";
$delTntAvatarAct			= "deleted the Tenant Profile Avatar for";
$delTntAvatarMsg			= "The Tenant's Avatar Image has been removed.";
$delTntAvatarError			= "An Error was encountered, and the Tenant's Avatar Image could not be removed.";
$delTntAvatarAct2			= "could not remove the Tenant Profile Avatar for";
$tntAccStaAct				= "updated the Tenant Account Status for";
$tntAccStaMsg				= "The Tenant Account Status has been updated.";
$opdTntNotesAct				= "updated the Tenant Account Notes for";
$opdTntNotesMsg				= "The Tenant Account Notes have been updated.";
$tntDocTitleReq				= "The Document Title is required.";
$tntDocDescReq				= "The Document Description is required.";
$tntDocFileTypeErr			= "The Document is not an allowed file type to be uploaded.";
$tntDocUplMsg				= "The Document";
$tntDocUplEmailSubject		= "New Document Uploaded";
$tntDocUplEmail1			= "Document Title:";
$tntDocUplAct				= "uploaded a New Document for";
$tntDocUplErr				= "An Error was encountered, and the Document could not be uploaded.";
$TntDocUplErr1				= "A Document for";
$delTntDocErr				= "An Error was encountered, and the Document could not be deleted.";
$delTntDocAct				= "deleted the Document";
$tntEnabledText				= "Enabled";
$tntArchivedText			= "/Archived";

// admin/pages/viewUploads.php
// --------------------------------------------------------------------------------------------------
$uplFileBtn					= "Upload a File";
$uplFileH4					= "Upload a Property File";
$uploadFileBtn				= "Upload File";
$fileTitleHead				= "File Title";
$viewFileText				= "View File";
$delFileConf				= "Are you sure you want to permanently DELETE the uploaded file";
$noPropFilesFoundMsg		= "No Files have been uploaded for this Property.";
$delFileAct					= "deleted the File";
$delFileError				= "An Error was encountered, and the File could not be deleted.";

// admin/pages/workOrder.php
// --------------------------------------------------------------------------------------------------
$workOrderPageTitle			= "Service Work Order";
$requestNumText				= "Request#";
$dateText					= "Date";
$qtyText					= "Quantity";
$matDescText				= "Materials Description";
$unitPriceText				= "Unit Price";
$lineTotText				= "Line Total";
$laborDescText				= "Labor Description";
$hoursText					= "Hours";
$miscText					= "Misc";
$subTotalText				= "Sub-Total";
$grandTotalText				= "Grand Total";
$dateResvdText				= "Date Resolved";
$needsFollowUpText			= "Needs Follow-Up?";

/* --------------------------------------------------------------------------------------------------
 * Updates added September 26, 2015
 *
 * *** IMPORTANT! PLEASE READ ***
 * If you have all ready translated this file, just copy/paste the new localizations below to
 * you translated file. DO NOT over-write your file, or all translations will be lost.
 * --------------------------------------------------------------------------------------------------
 * ------------- ALWAYS MAKE A BACKUP OF YOUR DATABASE AND ALL FILES BEFORE UPGRADING!! -------------
 * -------------------------------------------------------------------------------------------------- */
$propNameFieldHelp			= "Property Names must be unique.";
$dupPropertyNameMsg			= "Duplicate Property Name. Property Names must be unique.";
