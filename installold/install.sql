CREATE TABLE IF NOT EXISTS `activity` (
  `activityId` int(5) NOT NULL AUTO_INCREMENT,
  `adminId` int(5) NOT NULL DEFAULT '0',
  `userId` int(5) NOT NULL DEFAULT '0',
  `activityType` int(2) NOT NULL,
  `activityTitle` text NOT NULL,
  `activityDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`activityId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `admins` (
  `adminId` int(5) NOT NULL AUTO_INCREMENT,
  `adminEmail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `adminName` varchar(255) NOT NULL,
  `primaryPhone` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `altPhone` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `adminAddress` text,
  `adminAvatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'adminDefault.png',
  `adminPhoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'defaultPhoto.png',
  `personalQuip` text,
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'Washington, DC',
  `facebook` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `google` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `linkedin` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `pinterest` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `twitter` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `youtube` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `notes` text,
  `lastVisited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hash` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `isAdmin` int(5) NOT NULL DEFAULT '0',
  `adminRole` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `isActive` int(1) NOT NULL DEFAULT '1',
  `isDisabled` int(1) NOT NULL DEFAULT '0',
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`adminId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `appauth` (
  `appauthId` int(5) NOT NULL AUTO_INCREMENT,
  `adminId` int(5) NOT NULL DEFAULT '0',
  `authFlag` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `authDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`appauthId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `assigned` (
  `assignId` int(5) NOT NULL AUTO_INCREMENT,
  `propertyId` int(5) NOT NULL DEFAULT '0',
  `adminId` int(5) NOT NULL DEFAULT '0',
  `assignDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`assignId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `authdesc` (
  `authFlag` varchar(10) COLLATE utf8_bin NOT NULL,
  `flagDesc` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`authFlag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `authdesc` (`authFlag`, `flagDesc`) VALUES
('MNGTEN', 'Manage Tenants'),
('MNGPROP', 'Manage Properties'),
('SRVREQ', 'Manage Service Requests'),
('MNGADMINS', 'Manage Administrators'),
('APPAUTH', 'Admin Access Authorizations'),
('SITEALRTS', 'Manage Site Alerts'),
('TENRPT', 'Tenant Report Access'),
('PROPRPT', 'Property Report Access'),
('SERVRPT', 'Sevice Request Report Access'),
('ACCTRPT', 'Accounting Report Access'),
('LEASERPT', 'Lease Report Access'),
('ADMINRPT', 'Adminsitrator Report Access'),
('FORMS', 'Manage Forms & Templates'),
('SITESET', 'Manage/Update Site Settings'),
('SITELOGS', 'View/Delete Site Logs'),
('SITECNT', 'Manage/Update Site Content');

CREATE TABLE IF NOT EXISTS `events` (
  `eventId` int(5) NOT NULL AUTO_INCREMENT,
  `adminId` int(5) NOT NULL DEFAULT '0',
  `internalEvent` int(1) NOT NULL DEFAULT '0',
  `publicEvent` int(1) NOT NULL DEFAULT '1',
  `eventDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `eventTitle` varchar(50) NOT NULL,
  `eventDesc` text,
  `eventColor` varchar(7) NOT NULL DEFAULT '#2481be',
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`eventId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `leases` (
  `leaseId` int(5) NOT NULL AUTO_INCREMENT,
  `propertyId` int(5) NOT NULL DEFAULT '0',
  `adminId` int(5) NOT NULL DEFAULT '0',
  `userId` int(5) NOT NULL DEFAULT '0',
  `leaseTerm` varchar(50) NOT NULL,
  `leaseStart` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `leaseEnd` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `notes` text,
  `closed` int(1) NOT NULL DEFAULT '0',
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`leaseId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `payments` (
  `payId` int(5) NOT NULL AUTO_INCREMENT,
  `leaseId` int(5) NOT NULL DEFAULT '0',
  `propertyId` int(5) NOT NULL DEFAULT '0',
  `adminId` int(5) NOT NULL DEFAULT '0',
  `userId` int(5) NOT NULL DEFAULT '0',
  `hasRefund` int(1) NOT NULL DEFAULT '0',
  `paymentDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `amountDue` varchar(50) NOT NULL,
  `amountPaid` varchar(50) NOT NULL,
  `penaltyFee` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `paymentFor` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `paymentType` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `isRent` int(1) NOT NULL DEFAULT '1',
  `rentMonth` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `rentYear` int(4) DEFAULT NULL,
  `notes` text,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`payId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `properties` (
  `propertyId` int(5) NOT NULL AUTO_INCREMENT,
  `adminId` int(5) NOT NULL DEFAULT '0',
  `propertyName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `propertyDesc` text,
  `propertyImage` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'genericRental.png',
  `propertyAddress` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `isLeased` int(1) NOT NULL DEFAULT '0',
  `propertyRate` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `latePenalty` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `propertyDeposit` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `petsAllowed` int(1) NOT NULL DEFAULT '0',
  `propertyNotes` text,
  `propertyFolder` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `propertyAmenities` longtext CHARACTER SET utf8 COLLATE utf8_bin,
  `propertyListing` text,
  `propertyType` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `propertyStyle` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `yearBuilt` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `propertySize` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `parking` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `heating` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `bedrooms` varchar(2) DEFAULT NULL,
  `bathrooms` varchar(3) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `featured` int(1) NOT NULL DEFAULT '0',
  `hoaName` varchar(255) DEFAULT NULL,
  `hoaAddress` text,
  `hoaPhone` varchar(50) DEFAULT NULL,
  `hoaFee` varchar(50) DEFAULT NULL,
  `feeSchedule` varchar(50) DEFAULT NULL,
  `googleMap` text,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`propertyId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `propfiles` (
  `fileId` int(5) NOT NULL AUTO_INCREMENT,
  `propertyId` int(5) NOT NULL DEFAULT '0',
  `adminId` int(5) NOT NULL DEFAULT '0',
  `fileName` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `fileDesc` text,
  `fileUrl` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`fileId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `proppictures` (
  `pictureId` int(5) NOT NULL AUTO_INCREMENT,
  `propertyId` int(5) NOT NULL DEFAULT '0',
  `adminId` int(5) NOT NULL DEFAULT '0',
  `picName` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `picDesc` text,
  `picUrl` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`pictureId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `refunds` (
  `refundId` int(5) NOT NULL AUTO_INCREMENT,
  `payId` int(5) NOT NULL DEFAULT '0',
  `leaseId` int(5) NOT NULL DEFAULT '0',
  `propertyId` int(5) NOT NULL DEFAULT '0',
  `adminId` int(5) NOT NULL DEFAULT '0',
  `userId` int(5) NOT NULL DEFAULT '0',
  `refundDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `refundAmount` varchar(50) NOT NULL,
  `refundFor` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `notes` text,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`refundId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `serviceexpense` (
  `expenseId` int(5) NOT NULL AUTO_INCREMENT,
  `requestId` int(5) NOT NULL DEFAULT '0',
  `leaseId` int(5) NOT NULL DEFAULT '0',
  `propertyId` int(5) NOT NULL DEFAULT '0',
  `adminId` int(5) NOT NULL DEFAULT '0',
  `vendorName` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `expenseName` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `expenseDesc` text,
  `expenseCost` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `dateOfExpense` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `notes` text,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`expenseId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `servicenotes` (
  `noteId` int(5) NOT NULL AUTO_INCREMENT,
  `requestId` int(5) NOT NULL DEFAULT '0',
  `leaseId` int(5) NOT NULL DEFAULT '0',
  `propertyId` int(5) NOT NULL DEFAULT '0',
  `adminId` int(5) NOT NULL DEFAULT '0',
  `userId` int(5) NOT NULL DEFAULT '0',
  `noteText` text,
  `noteDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`noteId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `servicepriority` (
  `priorityId` int(5) NOT NULL AUTO_INCREMENT,
  `priorityTitle` varchar(50) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`priorityId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `servicepriority` (`priorityId`, `priorityTitle`, `createDate`) VALUES
(1, 'Normal', '2015-01-01 00:00:00'),
(2, 'Important', '2015-01-01 00:00:00'),
(3, 'Urgent', '2015-01-01 00:00:00');

CREATE TABLE IF NOT EXISTS `servicerequests` (
  `requestId` int(5) NOT NULL AUTO_INCREMENT,
  `leaseId` int(5) NOT NULL DEFAULT '0',
  `propertyId` int(5) NOT NULL DEFAULT '0',
  `adminId` int(5) NOT NULL DEFAULT '0',
  `userId` int(5) NOT NULL DEFAULT '0',
  `adminCreated` int(1) NOT NULL DEFAULT '0',
  `assignedTo` int(5) DEFAULT '0',
  `requestTitle` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `requestText` longtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `requestDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `requestPriority` int(5) NOT NULL DEFAULT '1',
  `requestStatus` int(5) NOT NULL DEFAULT '1',
  `isClosed` int(1) NOT NULL DEFAULT '0',
  `resolutionText` text,
  `resolutionDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `needsFollowUp` int(1) NOT NULL DEFAULT '0',
  `followUpText` text,
  `notes` text,
  `dateCompleted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`requestId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `servicestatus` (
  `statusId` int(5) NOT NULL AUTO_INCREMENT,
  `statusTitle` varchar(50) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`statusId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

INSERT INTO `servicestatus` (`statusId`, `statusTitle`, `createDate`) VALUES
(1, 'New', '2015-01-01 00:00:00'),
(2, 'In Progress', '2015-01-01 00:00:00'),
(3, 'Waiting for Parts', '2015-01-01 00:00:00'),
(4, 'On Hold', '2015-01-01 00:00:00'),
(5, 'Waiting for Tenant', '2015-01-01 00:00:00'),
(6, 'Closed', '2015-01-01 00:00:00'),
(7, 'Work Completed', '2015-01-01 00:00:00'),
(8, 'Closed - No Work Needed', '2015-01-01 00:00:00'),
(9, 'Reopened', '2015-01-01 00:00:00'),
(10, 'Needs Follow-up', '2015-01-01 00:00:00');

CREATE TABLE IF NOT EXISTS `sitealerts` (
  `alertId` int(5) NOT NULL AUTO_INCREMENT,
  `adminId` int(5) NOT NULL,
  `isActive` int(5) NOT NULL DEFAULT '0',
  `alertType` int(1) NOT NULL DEFAULT '1',
  `alertTitle` varchar(255) NOT NULL,
  `alertText` longtext NOT NULL,
  `alertDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `alertStart` timestamp NULL DEFAULT NULL,
  `alertExpires` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`alertId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sitecontent` (
  `contentId` int(5) NOT NULL AUTO_INCREMENT,
  `pageId` int(2) NOT NULL DEFAULT '0' COMMENT '1 - Home, 2 - Available Properties, 3 - View Property, 4 - About Us, 5 - Contact Us, 6 - Rental Application',
  `contentName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pageContent` longtext CHARACTER SET utf8 NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`contentId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

INSERT INTO `sitecontent` (`contentId`, `pageId`, `contentName`, `pageContent`, `lastUpdated`) VALUES
(1, 1, 'Home Page Intro Text', '&lt;h1&gt;Your Home the Way You''ve Always Wanted It.&lt;/h1&gt;\r\n&lt;p class=&quot;lead&quot;&gt;When you live here, you get more than a home. You get an entire neighborhood where you can live, work, shop, dine and play.&lt;/p&gt;\r\n&lt;p&gt;Our homes include an abundance of neighborhood retail, restaurants, office space and more. With so much convenience right at your doorstep, there''s hardly a need to venture further, but the direct access to the Metro, I-495 and I-395 make downtown DC, Old Town Alexandria and more easily accessible.&lt;/p&gt;', '0000-00-00 00:00:00'),
(2, 2, 'Available Properties Page Content', '', '0000-00-00 00:00:00'),
(3, 3, 'View Property Page Content', '', '0000-00-00 00:00:00'),
(4, 4, 'About Us Intro Text', '&lt;h2&gt;We Are More then Just Management&lt;/h2&gt;\r\n&lt;p class=&quot;lead&quot;&gt;Although we manage properties, our business is people. We work hard to create great places for people to live, work, play and stay and take pride in the long-term relationships we have with our residents and team members.&lt;/p&gt;\r\n&lt;p&gt;Our residents, guests and tenants enjoy world-class customer service, and our team members understand the unique commitment we have to them, and their careers.&lt;/p&gt;', '0000-00-00 00:00:00'),
(5, 5, 'Contact Us Intro Text', '&lt;h2&gt;Our Guiding Mission is our residents, guests and tenants. &lt;/h2&gt;\r\n&lt;p class=&quot;lead&quot;&gt;Customer care is at the core of our guiding mission. Regardless of the size or location of your home, we treat all of our residents, guests and tenants with an uncompromising level of attention and service. We are proud to help you enjoy the highest levels of satisfaction and comfort. It''s just what we do.&lt;/p&gt;', '0000-00-00 00:00:00'),
(6, 6, 'Rental App Intro Text', '&lt;p class=&quot;lead&quot;&gt;Get started today by completing our Rental Application. It is quick, and we will respond within 2 business days.&lt;/p&gt;\r\n&lt;p&gt;Have questions are concerns? Please contact us and we will be happy to assist you in any way we can.&lt;/p&gt;', '0000-00-00 00:00:00');

CREATE TABLE IF NOT EXISTS `sitesettings` (
  `installUrl` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `siteName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `siteQuip` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `siteEmail` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `businessName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `businessAddress` text CHARACTER SET utf8,
  `businessPhone` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `contactPhone` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `localization` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT 'english',
  `avatarFolder` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'avatars/',
  `avatarTypesAllowed` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'jpg,png',
  `uploadPath` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'uploads/',
  `fileTypesAllowed` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'jpg,png,gif,txt,pdf,xls,xlsx,doc,docx,zip,rar',
  `templatesPath` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'templates/',
  `userDocsPath` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'docs/',
  `propPicsPath` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'pictures/',
  `propPicsAllowed` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'jpg,png',
  `contactUsMap` text COLLATE utf8_bin,
  `facebook` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `google` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `pinterest` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `weatherLoc` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'Washington, DC',
  `analyticsCode` text COLLATE utf8_bin,
  `allowRegistrations` int(1) NOT NULL DEFAULT '1',
  `enableHoa` int(1) NOT NULL DEFAULT '1',
  `enableSlider` int(1) NOT NULL DEFAULT '1',
  `enableWidgets` int(1) NOT NULL DEFAULT '1',
  `weekStart` int(1) NOT NULL DEFAULT '0',
  `enableCron` int(1) NOT NULL DEFAULT '1',
  `cronDay` int(2) NOT NULL DEFAULT '10',
  `enablePayments` int(1) NOT NULL DEFAULT '1',
  `enablePaypal` int(1) NOT NULL DEFAULT '1',
  `currencyCode` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'USD',
  `paymentCompleteMsg` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `paymentEmail` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `paymentItemName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `paymentFee` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`installUrl`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `sitetemplates` (
  `templateId` int(5) NOT NULL AUTO_INCREMENT,
  `adminId` int(5) NOT NULL DEFAULT '0',
  `templateName` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `templateDesc` text,
  `templateUrl` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`templateId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sliderpics` (
  `slideId` int(5) NOT NULL AUTO_INCREMENT,
  `adminId` int(5) NOT NULL DEFAULT '0',
  `slideUrl` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `slideTitle` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `slideText` tinytext CHARACTER SET utf8 COLLATE utf8_bin,
  `buttonUrl` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `btnText` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`slideId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `userdocs` (
  `docId` int(5) NOT NULL AUTO_INCREMENT,
  `adminId` int(5) NOT NULL DEFAULT '0',
  `userId` int(5) NOT NULL DEFAULT '0',
  `docTitle` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `docDesc` text,
  `docUrl` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ipAddress` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`docId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(5) NOT NULL AUTO_INCREMENT,
  `userEmail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userFirstName` varchar(255) NOT NULL,
  `userLastName` varchar(255) NOT NULL,
  `primaryPhone` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `altPhone` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `userAddress` text,
  `userAvatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'userDefault.png',
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'Washington, DC',
  `pets` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `notes` text,
  `userFolder` varchar(255) DEFAULT NULL,
  `lastVisited` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hash` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `isLeased` int(1) NOT NULL DEFAULT '0',
  `propertyId` int(5) NOT NULL DEFAULT '0',
  `leaseId` int(5) NOT NULL DEFAULT '0',
  `isActive` int(1) NOT NULL DEFAULT '1',
  `isDisabled` int(1) NOT NULL DEFAULT '0',
  `isResident` int(1) NOT NULL DEFAULT '0',
  `primaryTenantId` int(5) NOT NULL DEFAULT '0',
  `isArchived` int(1) NOT NULL DEFAULT '0',
  `archiveDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
