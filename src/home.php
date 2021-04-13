<?php
session_start();
//connect to database
$conn = new mysqli("localhost","root","narahari96","ucomplain");
if($_SESSION['is_logged_in'] === true)
{
 if(isset($_POST["cmp_btn"]))
 {
  $cmpdetails=$_POST["cmpdetails"];
  $cmpaddress=$_POST['cmpaddress'];
  $cmplocation=$_POST['areas'];
  $cmptype=$_POST['type'];
  $cmessage="";
  $cmpemail=$_SESSION['email'];
  $cmpimage=addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $cmpimagen="abc";
  //Get the content of the image and then add slashes to it 

  // Insert the image name and image content in image_table
  $query4="INSERT INTO complaints(complaintno,email,location,type,address,image,details,upvotes,ts,counter) VALUES (NULL,'$cmpemail','$cmplocation','$cmptype','$cmpaddress','$cmpimage','$cmpdetails',0,CURRENT_TIMESTAMP,0)";

  if($conn->query($query4)===TRUE)
  {  
      $cmpno=$conn->insert_id;
      $query4a="CREATE TABLE `$cmpno` (email VARCHAR(100) PRIMARY KEY)";
    if($conn->query($query4a)===TRUE)
    {
      $query6="SELECT * FROM `area` WHERE type='".$cmptype."' AND circle IN (SELECT circle FROM `locationtoarea` where location='".$cmplocation."')";
      $result=$conn->query($query6);
      if ($result->num_rows > 0) 
      {
       while($row = $result->fetch_assoc()) 
      {
       require('PHPMailer-master/PHPMailerAutoload.php');
       $subject = "You have a compliant!";
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
       $mail->AddEmbeddedImage($_FILES['image']['tmp_name'], "cimg","altimg","base64");
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
          $cmessage="Message could not be sent.</br>Mailer Error: ".$mail->ErrorInfo;
       }
       else 
       {
        $cmessage="Compliant successfully posted!";
        header("location:home.php");
       }
      }
      }
      else
      {
       $cmessage= "Could not post compliant to specified authorities due to unknown restriction!";
      }
    }
      
    else
    { 
      $cmessage=$conn->error;
    }
  } 
  else
  {
   $cmessage="Error in posting complaint.Please try again!";
  }
 }

}
else
{
  header("location:ucomplain.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>HOME | UCOMPLAIN</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">

body{
    text-align: center;
    padding-top:70px;
    background:#FAFBF5;
}

.navbar-header {
  float: none;
}
.navbar-toggle {
  display: block;
}
.navbar-collapse.collapse {
  display: none!important;
}
.navbar-nav {
  float: none!important;
}
.navbar-nav>li {
  float: right;
}
.navbar-collapse.collapse.in{
  display:block !important;
}
.navbar-inverse .navbar-brand {
    color: #FFFFFF;  
}
.navbar-inverse{
    border:0;
  }
.navbar-inverse:hover{
    border-color: #FFFFFF;
}
.navbar-inverse .navbar-nav > li > a {
    color: #FFFFFF;
}
.navbar-inverse .navbar-toggle .glyphicon-user {
   color:#FFFFFF;
   font-size: 20px;
}
.navbar-inverse .navbar-nav > li > a:hover,
.navbar-inverse .navbar-nav > li > a:focus,
.navbar-inverse .navbar-nav > li > a:active {
    color:#000000;
    background:#FFFFFF;
}
#un{
  color: #FFFFFF;
}
.card{
 text-align: center;
 border-radius:10px;
 background:#FFFFFF;
 margin: 0 auto;
 box-shadow:0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
 margin-bottom: 3px;
 padding:5px;
 max-width: 50%;
}




.btn.btn-primary{
  width:100%;
  height:100%;
  background: #6B5F87;
  color:#FFFFFF;
}
.btn.btn-primary:hover,
.btn.btn-primary:active{
  background: #FFFFFF;
  color:#6B5F87;
}


</style>
</head>


<body data-spy="scroll" data-target=".navbar" data-offset="50">
<div class="row">
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
   <div class="navbar-header">
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="glyphicon glyphicon-user"></span>                      
     </button>
     <a class="navbar-brand" href="#">UCOMPLAIN</a>
   </div>
    <div>
      <div class="navbar-collapse collapse" id="myNavbar">
        <ul class="nav navbar-nav nav-tabs navbar-right">
         <li id="un" role="presentation"><?php echo $_SESSION['username']; ?></li>
        </ul>
        <ul class="nav navbar-nav nav-tabs navbar-right">
         <li role="presentation"><a data-toggle="collapse" data-target=".navbar-collapse" href="logout.php">Logout</a></li>
         <li role="presentation"><a data-toggle="collapse" data-target=".navbar-collapse" href="userinfo.php" >Profile</a></li>
         <li role="presentation"><a data-toggle="collapse" data-target=".navbar-collapse" href="home.php" >Home</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>  
</div>

<div class="row">
  <div class="card" id="complaintform">
    <div class="card-block">

    <?php if(!empty($cmessage)){ ?> 
    <div class="alert alert-danger"><?php if(isset($cmessage)) echo $cmessage; ?></div>
    <?php } ?>
        
     <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#complaintModal"><span class="glyphicon glyphicon-edit"> Post a complaint</span></button>
     <div id="complaintModal" class="modal fade" role="dialog">
     <div class="modal-dialog">
     <div class="modal-content">
     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">Fill in the details:</h4>
     </div>
      <div class="modal-body">

      <form method="POST" action="home.php"  enctype="multipart/form-data" >
        <div class="form-group"><textarea class="form-control" rows="5" name="cmpdetails" placeholder="Write a complaint(400 characters only)"></textarea></div>
        </br>
        <div class="form-group"><textarea class="form-control" rows="3" name="cmpaddress" placeholder="Location address" required="required"></textarea></div>
        </br> 
        <div class="form-group">
          <input class="form-control" list="areas" name="areas" style=" width:70%; height:30%;font-size:10px;" maxlength="50" size="6" placeholder="Enter Area" required>
          <datalist id="areas">
            <?php
              $query1 = "SELECT location FROM locationtoarea";
              $result1 = $conn->query($query1); 
              while ($row = $result1->fetch_assoc()) 
              {
               echo "<option value='". $row['location']. "'>";
              }
            ?>
          </datalist>
        </div>
        <div class="form-group">
        <label class="btn btn-primary btn-md" style="width: 50%">
          <input type="file" name="image" accept="image/*" onchange="loadFile(event)" style="display: none;" >Upload an Image! <span class="glyphicon glyphicon-picture"></span>
        </label>
          <img id="output" for="img" src="" height="50%" width="50%" border="none" />
               <script>
                var loadFile = function(event){
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                };
               </script>
        </div>   
        </br>
        </br>
        <div class="form-group">
          <select class="form-control" name="type" style=" width:70%; height:5%;font-size:15px;" maxlength="50" placeholder="Enter Type" required>
            <?php
              $query2 = "SELECT * FROM types";
              $result2 = $conn->query($query2);
              while ($row = $result2->fetch_assoc()) 
              {
               echo "<option value='". $row['type']. "'>". $row['type']. "</option>";
              }
            ?> 
          </select>
        </div>
        <input type="submit" name="cmp_btn" class="btn btn-primary" value="Submit">             
      </form>

     </div> 
     <div class="modal-footer"></div>
     </div>
     </div>
     </div>


    </div>
  </div>  
</div>

<div class="row">
<div class="card" id="allcompliants">
<div class="card-block">
<?php 
  $conn = new mysqli("localhost","root","narahari96","ucomplain");
  $query3="SELECT * FROM complaints WHERE NOT email='".$_SESSION['email']."'";
  $result=$conn->query($query3);

  

  if ($result->num_rows > 0) 
  {
    while($row = $result->fetch_assoc()) 
    {
      $complaintno=$row['complaintno'];
      $image=$row['image'];
      $date=$row['ts'];
      $location=$row['location'];
      $address=$row['address'];
      $type=$row['type'];
      $upvotes=$row['upvotes'];
      $email=$row['email'];?>

      <div id="usercard2" class="card">
      <div class="card-block">
      <div class="container-fluid">

      <div class="row" style="text-align:center;">
      <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" width="90%" height="50%" />
      </div>
      <div class="row">
      <?php echo 'Complaint Id: '.$complaintno; ?>
      </div>
      <div class="row">
      <?php echo $location; ?>
      </div>
      <div class="row">
      <?php echo $address; ?>
      </div></br>
      <div class="row">
      <?php echo $date; ?>
      </div>
      <?php
      $query4="SELECT * FROM  `$complaintno` WHERE email='".$_SESSION['email']."'";
      $result1=$conn->query($query4);
      if ($result1->num_rows ==1) 
      {
        $status=1;
      }
      else
      {
        $status=0;
      }
        ?>
       <div class="row">
       <form method="POST" action="k2.php">
       <button class="btn btn-primary btn-sm" name="upvote" style="<?php if($status==1){ echo 'background:#A895D3'; } if($status==0){ echo 'background:#6B5F87'; }  ?>">
       <input type="hidden" name="cmpno" value="<?php echo $complaintno; ?>">
       <input type="submit" name="upvote" style="display:none;">
       <span class="glyphicon glyphicon-hand-right">
       </span>
       <?php echo ' '.$upvotes.' '; ?>
       Upvote
       </button>
       </form>
       </div>
  


      </div>
      </div>
      </div>

 <?php   }
  } 
  else 
  { ?>
    <div class="alert alert-danger">
    No new complaints posted yet.
    </div>
<?php  } ?>
</div>
</div>
</div>


</body>
</html>