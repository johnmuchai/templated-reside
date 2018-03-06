<?php
// Access DB Info
include('config.php');


if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('Request method must be POST!');
}

//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
    throw new Exception('Content type must be: application/json');
}


$data = json_decode(trim(file_get_contents('php://input')), true);

//If json_decode failed, the JSON is invalid.
if(!is_array($data)){
    throw new Exception('Received content contained invalid JSON!');
}
//$data= file_get_contents('php://input');

var_dump($data);
echo $data."---------------------";
$payment_source =htmlspecialchars($data['paymentSource']);
$paymentAmount =htmlspecialchars($data['paymentAmount']);
$paymentRef =htmlspecialchars($data['paymentRef']);
$paidInByName =htmlspecialchars($data['paidInByName']);
$payidInByMobile =htmlspecialchars($data['payidInByMobile']);
$status =htmlspecialchars($data['status']);
$merchantCode =htmlspecialchars($data['merchantCode']);

echo  $payment_source."*******************";

$propqry = "SELECT propertyId, propertyName, isLeased FROM properties where unitName ='".$paymentRef."'";
echo  $propqry;

$propres = mysqli_query($mysqli, $propqry) or die('-1'.mysqli_error());

while ($prop = mysqli_fetch_assoc($propres)) {
  $prodid =$prop['propertyId'];

 echo  $prodid;

  $leaseQuery ="SELECT *  FROM leases  where propertyId ='".$prodid."'";

  $leaseres = mysqli_query($mysqli, $leaseQuery) or die('-1'.mysqli_error());

  while ($ls= mysqli_fetch_assoc($leaseres)) {

     $leaseid =$ls['leaseId'];

echo  $leaseid;

$stmt = $mysqli->prepare("
          INSERT INTO
            payments(
              leaseId,
              propertyId,
              adminId,
              userId,
              hasRefund,
              paymentDate,
              amountPaid,
              paymentFor,
              paymentType,
              isRent,
              rentYear,
              notes,
              lastUpdated
            ) VALUES (
              ?,
              ?,
              '1',
              '1',
              '0',
              NOW(),
              ?,
              'rent',
              ?,
              '1',
                NOW(),
                  ?,
              NOW(),

            )");
$stmt->bind_param('sssssssssssssssssss',
  $leaseid,
  $prodid,
  $paymentAmount,
  $payment_source,
  $paidInByName."/".$payidInByMobile
);
$stmt->execute();
$stmt->close();

$jsonData = array(
    'responsecode' => 'OK',
    'response_message' => 'Succesful'
);

echo json_encode($jsonData);

  }

}

$jsonData = array(
    'responsecode' => 'FAILED',
    'response_message' => 'Failed'
);

echo json_encode($jsonData);





?>
