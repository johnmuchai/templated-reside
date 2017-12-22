<?php
	/*
	 * ONLY translate line 8 through 10.
	 *
	 * If you have any questions at all about this file, please contact me through my Support Center:
	 * http://jennperrin.com/support/
	 */
	$processPay			= "Processing Payment...";
	$plsWaitMsg			= "Please wait, your PayPal payment is being processed and you will be redirected to the PayPal website.";
	$redirectMsg		= "You will be automatically redirected to PayPal to complete your payment within a few seconds...";
	/* END */

	class paypalPaymnents {
		var $response;
		var $payment_data = array();
		var $fields = array();

		function paypalPaymnents() {
			$this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
			$this->response = '';
			$this->addField('rm','2');
			$this->addField('cmd','_xclick');
		}

		function addField($field, $value) {
			$this->fields["$field"] = $value;
		}

		function submit_post() {
			// Submit to PayPal
			echo "<body onLoad=\"document.forms['paypal_form'].submit();\">\n";
			echo "<h3>".$processPay."</h3>";
			echo "<div class=\"alertMsg info mb-20\"><div class=\"msgIcon pull-left\"><i class=\"fa fa-paypal\"></i></div>".$plsWaitMsg."</div>";
			echo "<form method=\"post\" name=\"paypal_form\" ";
			echo "action=\"".$this->paypal_url."\">\n";
			foreach ($this->fields as $name => $value) {
				echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
			}
			echo "<input type=\"hidden\" name=\"amount_1\" value=\"".$_POST['paymentAmount']."\"/>\n";
			echo "<input type=\"hidden\" name=\"payment_gross\" value=\"".$_POST['paymentAmount']."\"/>\n";
			echo "<input type=\"hidden\" name=\"paymentDesc\" value=\"".$_POST['paymentItemName']."\"/>\n";
			echo "<input type=\"hidden\" name=\"paymentAmount\" value=\"".$_POST['paymentAmount']."\"/>\n";
			echo "<input type=\"hidden\" name=\"item_number\" value=\"".$_POST['item_number']."\"/>\n";
			echo "<p class=\"mt-0\">".$redirectMsg."</p>";
			echo "</form>\n";
		}

		function validate_ipn() {
			// Parse PayPal URL
			$parseUrl = parse_url($this->paypal_url);

			$postString = '';
			foreach ($_POST as $field=>$value) {
				$this->payment_data["$field"] = $value;
				$postString .= $field.'='.urlencode(stripslashes($value)).'&';
			}
			$postString .= "cmd=_notify-validate";
			// Opens connection to PayPal
			$ppConn = fsockopen($parseUrl['host'],"80",$err_num,$err_str,30);
			if(!$ppConn) {
				return false;
			} else {
				// Post data back to PayPal
				fputs($ppConn, "POST $parseUrl[path] HTTP/1.1\r\n");
				fputs($ppConn, "Host: $parseUrl[host]\r\n");
				fputs($ppConn, "Content-type: application/x-www-form-urlencoded\r\n");
				fputs($ppConn, "Content-length: ".strlen($postString)."\r\n");
				fputs($ppConn, "Connection: close\r\n\r\n");
				fputs($ppConn, $postString."\r\n\r\n");
				// loop through the response
				while(!feof($ppConn)) {
					$this->response .= fgets($ppConn, 1024);
				}
				// Close connection
				fclose($ppConn);
			}
			if (preg_match("/VERIFIED/i",$this->response)) {
				return true;	// Valid IPN Transaction
			} else {
				return false;	// Invalid IPN Transaction
			}
		}
	}
?>
