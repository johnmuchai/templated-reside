

<?php // php populate html table from mysql database
 
//include variables;
$link = mysqli_connect("localhost", "root", "", "reside");
 
// Check connection
if($link === false){
    die("ERROR: Could not link. " . mysqli_connect_error());
}
// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
} 

$query = "SELECT * FROM `paymentspostage";

// result for method one
$result1 = mysqli_query($link, $query);
// result for method two 
$result2 = mysqli_query($link, $query);

$dataRow = "";

while($row2 = mysqli_fetch_array($result2))
{
    //$dataRow = $dataRow."<tr><td>$row2[4]</td><td>$row2[2]</td><td>$row2[5]</td><td>$row2[7]<tr><td>$row2[16]]</td></tr>";
	
	$dataRow = $dataRow."<tr>  <td>$row2[4]</td><td>$row2[2]</td><td>$row2[5]</td><td>$row2[7]</td> <td>$row2[7]</td> <td>$row2[16]</td> </tr>";
}


	$addCss = '<link href="../css/dataTables.css" rel="stylesheet">';
?>

<!DOCTYPE html>

<html>

    <head>

        <title>PHP DATA ROW TABLE FROM DATABASE</title>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style>

            table,th,tr,td
            {
                border: 1px solid black;
            }

        </style>

    </head>

    <body>

<!-- Table One -->
        <table style="background-color: red;">


            <?php while($row1 = mysqli_fetch_array($result1)):;?>
           
            <?php endwhile;?>

        </table>

        <br>
        <table width="835" border="0">
          <tr>
            <td><form name="form1" method="post" action="">
              <label>Property Name </label>
            </form></td>
            <td colspan="2"><select name="select">
            </select></td>
          </tr>
          <tr>
            <td>Month</td>
            <td colspan="2"><label1  > </label>&nbsp;</td>
          </tr>
          <tr>
            <td width="136">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><table style="background-color: grey; border-style:ridge">
              <tr>
                <th width="97">Unit Name</th>
                <th width="183">Tenant's Name</th>
                <th width="103">Rent Amount</th>
                <th width="72">Penalties</th>
                <th width="97">Commission</th>
                <th width="101">Rent Balance</th>
              </tr>
			  
			  <input type="hidden" id="weekStart" value="<?php echo $set['weekStart']; ?>" />

				<div class="row mb-20">
					<div class="col-md-3">
						
			  
			  
			  
              <?php echo $dataRow;?>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Total Expeceted Amount : </div></td>
            <td>&nbsp;
						
			<?php 
				$sql = "SELECT SUM(RentBalance ) AS value_sum FROM paymentspostage";
			$result = $link->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
									
					$expectectedamounts = $row["value_sum"];
					echo $expectectedamounts;
				}
			} else {
				echo "0 results";}
				
				?>		
			
			
			<label>
			
			<?php
//$itemName = 'pencil';
//$variable = 'itemName';
//echo "<span class=\"label-$variable\">${$variable}</span>";
//Prints: <span class="label-itemName
?>
			
			</label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Total Collected Amount : </div></td>
            <td>&nbsp;
			
			<?php 
					$sql = "SELECT SUM(Rent_Amount) AS value_sum FROM paymentspostage";
				$result = $link->query($sql);
				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
					
					$collectedamount = 0;
					echo $collectedamount;
					}
				} else {
					echo "0 results";}
					
					?>
			
			
			
			
			<label></label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Income on Commission : </div></td>
            <td>
				<?php  
	$sql = "SELECT SUM(RentBalance) AS value_sum FROM paymentspostage";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      //  echo  $row["value_sum"];
		$expectedamount = $row["value_sum"];
		$value = 7;
		$percentage = 100;
		
			$percentagevalue = $value / $percentage ;
			$percentagecommmission = $percentagevalue * $expectedamount ;
	     	echo $percentagecommmission ;
    }
} else {
    echo "0 results";}
	?>
			
			
			
			&nbsp;<label></label></td>
          </tr>
          <tr>
		  
		  
            <td>&nbsp;</td>
            <td><div align="right">Income on Penalties : </div></td>
            <td>
			
				<?php  
	$sql = "SELECT SUM(Penalties) AS value_sum FROM paymentspostage";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $penalties = $row["value_sum"];
		echo  $penalties ;
    }
} else {
    echo "0 results";}
	
	
	?>
			
			
			
			
			&nbsp;<label></label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="177"><div align="right">Aggregated Income : </div></td>
            <td width="500">
			
						<?php
			$totalcollectedamount = $collectedamount - $expectectedamounts ;
			$totalincome = $percentagecommmission + $penalties ;
			$Aggreagtedincome1 = $totalcollectedamount + $totalincome ;
				
			?>
			
			&nbsp;</td>
          </tr>
    </table>
        <br>

 <!-- Table Two -->
    </body>

</html>
<?php

$sql = "SELECT * FROM paymentspostage";// WHERE isLeased ='1' AND Posted=$Propertypostingvar";
if($result11 = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result11) > 0){
		do {
		$smonth = $row['S_month']; 	  
		echo $smonth ;
		}
						while ($row = mysqli_fetch_array($result11));
		
        mysqli_free_result($result11);
		///die ;
    } else{
        echo "No records matching your query were found.";
		
    }
} else{
    echo "ERROR: Could not able to execute $sql10. " . mysqli_error($link);
}

?>


	