<?php
// Access DB Info
include('config.php');

include('includes/functions.php');
/* turn autocommit on */
$mysqli->autocommit(TRUE);
//$con=mysqli_connect("localhost","root","notrust2015","reside");
// Check connection
if (mysqli_connect_errno())
{
  echo "Error Try again later: " . mysqli_connect_error();
}



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


$payment_source =htmlspecialchars($data['paymentSource']);
$paymentAmount =htmlspecialchars($data['paymentAmount']);
$paymentRef =htmlspecialchars($data['paymentRef']);
$paidInByName =htmlspecialchars($data['paidInByName']);
$payidInByMobile =htmlspecialchars($data['payidInByMobile']);
$status =htmlspecialchars($data['status']);
$merchantCode =htmlspecialchars($data['merchantCode']);
$phoneNumber = "";


$propqry = "SELECT propertyId, propertyName, isLeased FROM properties where unitName ='".$paymentRef."'";
echo $propqry;
$propres = mysqli_query($mysqli, $propqry) or die('-1'.mysqli_error());

if ($prop = mysqli_fetch_assoc($propres)) {
  $prodid =$prop['propertyId'];

  //echo $prodid;


  $leaseQuery ="SELECT *  FROM leases  where propertyId ='".$prodid."'";

  $leaseres = mysqli_query($mysqli, $leaseQuery) or die('-1'.mysqli_error());

  if ($ls= mysqli_fetch_assoc($leaseres)) {

    $leaseid =$ls['leaseId'];
    //echo $leaseid;

    $UserLeaseQuery ="SELECT *  FROM users  where propertyId ='".$prodid."' and leaseId='".$leaseid."'";

    $user_date = mysqli_query($mysqli, $UserLeaseQuery) or die('-1'.mysqli_error());

    if ($lusers= mysqli_fetch_assoc($user_date)) {

      $phoneNumber = $lusers["primaryPhone"];
      $userid =$lusers['userId'];
      //echo $userid;



      $stmt2 = "INSERT INTO
     payments (
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

        notes,
        lastUpdated
      ) VALUES (
        '".$leaseid."',
        '".$prodid."',
        '1',
        '".$userid."',
        '0',
        NOW(),
        '".  $paymentAmount."',
        'rent',
        '$payment_source',
        '1',

        '".$paidInByName."',
        NOW()

      )";

//<<<<<<< HEAD
 //     echo $stmt2;
//
  //    mysqli_query($mysqli, $stmt2);
 //    if( mysqli_query($mysqli, $stmt2)){
//      echo "New record created successfully";
//} else {
//      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//}
//=======
      //echo $stmt2;

      $insertres =mysqli_query($mysqli, $stmt2);

      if($insertres=== TRUE){


        //update accruals

//<<<<<<< HEAD
//      $accrual ="SELECT *  FROM accounts  where tenantId ='".$userid."' AND leaseId ='".$leaseid."'  FOR UPDATE";
//echo $accrual;
//      $accrualrs = mysqli_query($mysqli, $accrual) or die('-1'.mysqli_error());
//=======

        $accrual ="SELECT *  FROM accounts  where tenantId ='".$userid."' AND leaseId ='".$leaseid."'  FOR UPDATE";
//>>>>>>> 41794558fdd01a3a887a315f3f55eb677ff4a26e

        $accrualrs = mysqli_query($mysqli, $accrual) or die('-1'.mysqli_error());

        if ($ls= mysqli_fetch_assoc($accrualrs)) {

          $balance =$ls['balance'];

          $newbalance = intval($paymentAmount)+intval($balance);

          $updateQuery="UPDATE accounts SET  balance='".$newbalance."' where tenantId ='".$userid."' AND leaseId ='".$leaseid."' ";

          mysqli_query($mysqli, $updateQuery);

          //Send sms
          $message = "Dear tenant, your payment of KES ".$paymentAmount." was received and your tenant account updated successfully. Thanks for using m-reside.com";
          sendSMS($phoneNumber,$message);

          mysqli_close($mysqli);

          $jsonData = array(
            'responsecode' => 'OK',
            'response_message' => 'Succesful'
          );

          echo json_encode($jsonData);

        }else{
          $jsonData = array(
            'responsecode' => 'Error',
            'response_message' => 'Account not found'
          );

          echo json_encode($jsonData);
        }

//<<<<<<< HEAD
///echo "12"
 // }//
//echo "10"
//}
//=======
      }else{
        $jsonData = array(
          'responsecode' => 'Error',
          'response_message' => 'Error inserting: '.$mysqli->error.' '.$stmt2;
        );

        echo json_encode($jsonData);
      }


    }

  }
//>>>>>>> 41794558fdd01a3a887a315f3f55eb677ff4a26e






  ?>
