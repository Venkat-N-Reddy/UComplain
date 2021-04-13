<?php
//connect to database
$conn = new mysqli("localhost","root","narahari96","ucomplain");

$query1="SELECT * FROM complaints WHERE upvotes=500 OR upvotes=100 OR upvotes=500 OR upvotes=1000 or upvotes=5000";
$result1=$conn->query($query1);
if($result1->num_rows >0)
{ 
  while($row=$result1->fetch_assoc())
  {
  	$cmpno=$row['complaintno'];
  	$cmptype=$row['type'];
  	$cmpaddress=$row['address'];
  	$cmplocation=$row['location'];
  	$cmpupvotes=$row['upvotes'];
  	$cmptime=$row['ts'];
  	$cmpimage=$row['image'];
          
    $query2="SELECT * FROM `area` WHERE type='".$cmptype."' AND circle IN (SELECT circle FROM `locationtoarea` where location='".$cmplocation."')";
    $result2=$conn->query($query2);      
     if($result1->num_rows >0)
     { 
      while($row=$result1->fetch_assoc())
      {
       require('PHPMailer-master/PHPMailerAutoload.php');
       $subject = "You have a compliant getting lot of attention!";
       $mail = new PHPMailer();

       $mail->isSMTP();
       $mail->Host = "ssl://smtp.gmail.com";
       $mail->SMTPAuth = true;
       $mail->Username = "ucomplaincc@gmail.com";
       $mail->Password = "ucomplain6";
       $mail->SMTPSecure = 'ssl';
       $mail->Port = 465;
  //     $headers = "MIME-Version: 1.0\n";
  //     $headers .= "Content-Type: multipart/form-data";
  //     $headers .= "Content-Type: text/html";
  //     $mail->AddCustomHeader($headers);
       $today = date("F j, Y, g:i a");
       $mail->setFrom('ucomplaincc@gmail.com', 'UCOMPLAIN');
       $mail->addAddress($row['c_in_email'], $row['c_incharge']); 
       $mail->addAddress($row['z_in_email'], $row['z_incharge']); 
       $mail->Subject = $subject;
       $mail->AddEmbeddedImage($_FILES['cmpimage']['tmp_name'], "cimg","altimg","base64");
       $mail->Body    = '<html><body>
                         <h3>Complaint:</h3><br>
                         <p>Details: '.$cmpdetails.
                         '<br>Type: '.$cmptype.
                         '<br>Location: '.$cmpaddress.
                         '<br>Area: '.$cmplocation.
                         '<br>Time: '.$today.
                         '<br>Photo: <img alt="image" src="cid:cimg" width="50%" height="50%">'
                         .'</p>'
                         .'</body></html>';
        $mail->IsHTML(true);

       if(!$mail->send()) 
       {
          echo "Message could not be sent.</br>Mailer Error: ".$mail->ErrorInfo;
       }
       else 
       {
          echo "Compliant successfully posted!";
          header("location:ucomplain.php");
       }
      }
     }
    else{
    	echo "No appointed authorities yet!";
    } 
   }
}
else{
	echo "No rows reached the count";
}

?>