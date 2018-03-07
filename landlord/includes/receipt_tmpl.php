<?php
	/*
	 * Please note - if you are translating this file, Translate ONLY the text before each --- EDITABLE ---
	 * php tags, and NOT any of the code, styling or variables (the text in the double brackets {{variable}}).
	 * All variables in this file need to stay in the same format for the email to display correctly.
	 *
	 * If you have any questions at all about this file, please contact me through my Support Center:
	 * http://jennperrin.com/support/
	 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{{siteName}} Receipt</title> <?php // --- EDITABLE --- ?>
</head>

<body leftmargin="0" rightmargin="0" bottommargin="0" topmargin="0" bgcolor="#ffffff" style="color:#505050;">
	<table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width:800px; margin:20px auto 0; border-bottom:1px solid #eeeeee;">
		<tr>
			<td valign="middle" align="left" style="width:50%">
				<img alt="Reside" src="{{installUrl}}images/logo.png" style="" />
			</td>
			<td valign="middle" align="right" style="width:50%">
				<h2 style="font-family:tahoma,arial,sans-serif; font-weight:300;">Receipt for Payment Received</h3> <?php // --- EDITABLE --- ?>
			</td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width:800px; margin:10px auto 20px;">
		<tr>
			<td valign="middle" align="right" style="width:100%">
				<p style="margin:0; padding:8px 0 8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300; font-size:16px;">
					Payment Id# {{payId}}<br /> <?php // --- EDITABLE --- ?>
					Date Received: {{paymentDate}} <?php // --- EDITABLE --- ?>
				</p>
			</td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width:800px;margin:0 auto;">
		<tr>
			<td valign="middle" align="left" style="width:48%; border:1px solid #eeeeee; background:#fafafa;">
				<h4 style="margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:600;">Paid To: {{siteName}}</h3> <?php // --- EDITABLE --- ?>
			</td>
			<td style="width:4%; border:1px solid transparent;"></td>
			<td valign="middle" align="left" style="width:48%; border:1px solid #eeeeee; background:#fafafa;">
				<h4 style="margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:600;">Received From: {{tenantsName}}</h3> <?php // --- EDITABLE --- ?>
			</td>
		</tr>
		<tr>
			<td valign="top" align="left" style="width:48%; border:1px solid #eeeeee; border-top:0;">
				<p style="margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300;">
					{{businessAddress}}
				</p>
			</td>
			<td style="width:4%; border:1px solid transparent;"></td>
			<td valign="top" align="left" style="width:48%; border:1px solid #eeeeee; border-top:0;">
				<p style="margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300;">
					{{tenantsAddress}}
				</p>
			</td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width:800px;margin:20px auto 0;">
		<tr>
			<td valign="middle" align="left" style="border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:600; font-size:14px;">
				Property <?php // --- EDITABLE --- ?>
			</td>
			<td valign="middle" align="left" style="border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:600; font-size:14px;">
				Description <?php // --- EDITABLE --- ?>
			</td>
			<td valign="middle" align="left" style="border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:600; font-size:14px;">
				Paid By <?php // --- EDITABLE --- ?>
			</td>
			<td valign="middle" align="left" style="border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:600; font-size:14px;">
				Amount <?php // --- EDITABLE --- ?>
			</td>
			<td valign="middle" align="left" style="border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:600; font-size:14px;">
				Late Fee <?php // --- EDITABLE --- ?>
			</td>
		</tr>
		<tr>
			<td valign="middle" align="left" style="border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300; font-size:14px;">
				{{propertyName}}
			</td>
			<td valign="middle" align="left" style="border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300; font-size:14px;">
				{{paymentFor}}
			</td>
			<td valign="middle" align="left" style="border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300; font-size:14px;">
				{{paymentType}}
			</td>
			<td valign="middle" align="left" style="border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300; font-size:14px;">
				{{amountPaid}}
			</td>
			<td valign="middle" align="left" style="border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300; font-size:14px;">
				{{penaltyFee}}
			</td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width:800px;margin:20px auto 0;">
		<tr>
			<td valign="middle" align="left" style="width:60%; border:1px solid transparent; margin:0; padding:8px 12px;"></td>
			<td valign="middle" align="left" style="width:25%; border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:600; font-size:14px;">
				Total Due: <?php // --- EDITABLE --- ?>
			</td>
			<td valign="middle" align="right" style="width:15%; border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300; font-size:14px;">
				{{totalDue}}
			</td>
		</tr>
		<tr>
			<td valign="middle" align="left" style="width:60%; border:1px solid transparent; margin:0; padding:8px 12px;"></td>
			<td valign="middle" align="left" style="width:25%; border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:600; font-size:14px;">
				Amount Refunded: <?php // --- EDITABLE --- ?>
			</td>
			<td valign="middle" align="right" style="width:15%; border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300; font-size:14px;">
				{{refundAmt}}
			</td>
		</tr>
		<tr>
			<td valign="middle" align="left" style="width:60%; border:1px solid transparent; margin:0; padding:8px 12px;"></td>
			<td valign="middle" align="left" style="width:25%; border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:600; font-size:14px;">
				Total Received: <?php // --- EDITABLE --- ?>
			</td>
			<td valign="middle" align="right" style="width:15%; border:1px solid #eeeeee; margin:0; padding:8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300; font-size:14px;">
				{{totalPaid}}
			</td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="width:800px; margin:20px auto 40px;">
		<tr>
			<td valign="middle" align="left" style="width:100%">
				<p style="margin:0; padding:8px 0 8px 12px; font-family:tahoma,arial,sans-serif; font-weight:300; font-size:16px;">
					{{paymentNotes}}
				</p>
			</td>
		</tr>
	</table>
</body>
</html>