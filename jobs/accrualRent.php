<?php

// Access DB Info
include('../config.php');

// Get Settings Data
include ('../includes/settings.php');
$set = mysqli_fetch_assoc($setRes);

// Include Functions
include('../includes/functions.php');

$todayDate = date("Y-m-d");
$currentYear = date('Y');
$currentMonth = date('n');

$sqlstmt = "SELECT leases.*,properties.propertyRate FROM leases inner join properties on leases.propertyId=properties.propertyId WHERE leases.closed=0";
$sqlres = mysqli_query($mysqli, $sqlstmt) or die('-6' . mysqli_error($mysqli));

while($row=mysqli_fetch_assoc($sqlres)){



  $sqlinv = "SELECT * from invoices where tenantId=".$row["userId"]." and leaseId=".$row["leaseId"]." and invoiceType='Rent' and month(dateRaised)='".$currentMonth."'";
  //echo $sqlinv;
  $resinv = mysqli_query($mysqli, $sqlinv) or die('-6' . mysqli_error($mysqli));

  $rowinv = mysqli_fetch_assoc($resinv);

  if(!isset($rowinv)){
    //insert into invoices
    $invoiceType="Rent";
    $description = "Rent for ".$currentMonth."/".$currentYear;
    $dateDue =  date('Y-m-5',strtotime('today'));
    $status = "1";
    $stmt = $mysqli->prepare("
    INSERT INTO invoices (tenantId,leaseId,amount,dateRaised,dateDue,description,status,invoiceType) VALUES (?,?,?,NOW(),?,?,?,'Rent')");
    $stmt->bind_param('ssssss',
    $row["userId"],
    $row["leaseId"],
    $row["propertyRate"],
    $dateDue,
    $description,
    $status
  );
  $stmt->execute();

  echo $stmt->error;
  $stmt->close();


  //update accounts
  //but first check if it exists
  $sqla = "select * from accounts where tenantId=".$row["userId"]." and leaseId=".$row["leaseId"];
  $resa= mysqli_query($mysqli, $sqla) or die('-6' . mysqli_error($mysqli));

  $rowa = mysqli_fetch_assoc($resa);
  if(!isset($rowa)){
    $zero = "0";
    $accountName = "Rent Accrual account";
    $stmt = $mysqli->prepare("
    INSERT INTO accounts (tenantId,leaseId,accountName,balance,lastUpdated) VALUES (?,?,?,?,NOW())");
    $stmt->bind_param('ssss',
    $row["userId"],
    $row["leaseId"],
    $accountName,
    $zero
  );
  $stmt->execute();

  echo $stmt->error;
  $stmt->close();
}
//fetch for update

$sqll = "select * from accounts where tenantId=".$row["userId"]." and leaseId=".$row["leaseId"]." FOR UPDATE";
$resl= mysqli_query($mysqli, $sqll) or die('-6' . mysqli_error($mysqli));
$rowl = mysqli_fetch_assoc($resl);

$balance = $rowl["balance"]-(double)$row["propertyRate"];
$stmt = $mysqli->prepare("
UPDATE accounts set balance=? where tenantId=? and leaseId=?");
$stmt->bind_param('sss',
$balance,
$row["userId"],
$row["leaseId"]
);
$stmt->execute();

echo $stmt->error;
$stmt->close();

}else{

  //is the invoice already paid?
  if($rowinv["status"]=="1" && $rowinv["dateDue"]<''){  //if not paid for, is it overdue?
    //if overdue and not penalized already, please charge penaltyFee
    $invoiceType="Penalty";
    $description = "Penalty ".$currentMonth."/".$currentYear;
    $dateDue =  date('Y-m-5',strtotime('today'));
    $status = "1";
    $stmt = $mysqli->prepare("
    INSERT INTO invoices (tenantId,leaseId,amount,dateRaised,dateDue,description,status,invoiceType) VALUES (?,?,?,NOW(),?,?,?,'Penalty')");
    $stmt->bind_param('ssssss',
    $row["userId"],
    $row["leaseId"],
    $row["latePenalty"],
    $dateDue,
    $description,
    $status
  );
  $stmt->execute();

  echo $stmt->error;
  $stmt->close();

  $sqll = "select * from accounts where tenantId=".$row["userId"]." and leaseId=".$row["leaseId"]." FOR UPDATE";
  $resl= mysqli_query($mysqli, $sqll) or die('-6' . mysqli_error($mysqli));
  $rowl = mysqli_fetch_assoc($resl);

  $balance = $rowl["balance"]-(double)$row["latePenalty"];
  $stmt = $mysqli->prepare("
  UPDATE accounts set balance=? where tenantId=? and leaseId=?");
  $stmt->bind_param('sss',
  $balance,
  $row["userId"],
  $row["leaseId"]
);
$stmt->execute();

echo $stmt->error;
$stmt->close();

}



}

}


?>
