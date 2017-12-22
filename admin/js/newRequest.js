$(document).ready(function () {
	// Populate the Tenant Name & ID
	$("#propertyId").change(function() {
	
		var propId		= $("#propertyId").val();
		var propsName	= $("#propertyId option:selected").text();

		// Populate the hidden Property Name field
		$("#propName").val(propsName);
		
		if (propId !== '...') {
			// Make the ajax call
			post_data = {'propId':propId};
			$.post('includes/newRequest_f.php', post_data, function(datares) {
				if (datares.indexOf("userId") > 0) {
					// User found, load the data
					var obj = $.parseJSON(datares);

					// Populate the hidden User's ID & Name Field from the results
					$("#theId").val(obj[0].userId);
					$("#usersName").val(obj[0].user);				// Readonly field
					$("#leaseId").val(obj[0].leaseId);				// Readonly field
				} else {
					// Populate the hidden User's ID & Name Field to Unleased
					$("#theId").val("0");
					$("#usersName").val("Unleased Property");		// Readonly field
					$("#leaseId").val("0");
				}
			});
		}
	});

});