<?php
session_start();
//connect to database
$conn = new mysqli("localhost","root","narahari96","ucomplain");
if($conn->connect_error)
 {
  die("Connection failed: " . $conn->connect_error);
 } 
if($_SESSION['is_logged_in'] === true)
{

//Username reset php 

 if(isset($_POST["un_btn"]))
 {
  $username=$_POST['username'];
  $email=$_SESSION['email'];
  $umessage="";
  $query1 = "UPDATE users SET username='$username' WHERE email='$email'";
  if ($conn->query($query1) === TRUE) 
   {
    $umessage="Username changed successfully changed!";
    $_SESSION['username']=$username;
    header("location:userinfo.php");
   } 
  else 
   {
    $umessage="Error in changing username. Please try again!";
   }
 }

//Password reset php

 if(isset($_POST["pwd_btn"]))
 {
  $email=$_SESSION['email'];
  $password=$_POST['password'];
  $password1=$_POST['password1'];
  $password2=$_POST['password2'];
  $umessage="";
  if($password === $_SESSION['password'])
  {
   if($password1 === $password2)
   {
    $query2 = "UPDATE users SET password='$password2' WHERE email='$email'";
    if ($conn->query($query2) === TRUE) 
    {
     $umessage="Password successfully changed!";
     $_SESSION['password']=$password1;
     header("location:userinfo.php");
    } 
    else 
    {
     $umessage="Error in changing password.Please try again!";
    }
   }
   else
   {
    $umessage="New passwords do not match!";
   }
  }
  else
  {
   $umessage="Old password is incorrect";
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
  <title>PROFILE | UCOMPLAIN</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
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

.card{
 padding:10px;
 text-align: left;
 border-radius:10px;
 background:#FFFFFF;
 box-shadow:0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
 margin: 0 auto;
 margin-bottom: 5px;
 max-width: 500px;
}

.btn.btn-default{
  width:100%;
  height:100%;
  background: #6B5F87;
  color:#FFFFFF;
}
.btn.btn-default:hover,
.btn.btn-default:active{
  background: #FFFFFF;
  color:#6B5F87;
}




</style>
</head>


<body data-spy="scroll" data-target=".navbar" data-offset="50">
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
   <div class="navbar-header">
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="glyphicon glyphicon-user"> <?php echo $_SESSION['username']; ?> </span>                     
     </button>
     <a class="navbar-brand" href="#">UCOMPLAIN</a>
   </div>
    <div>
      <div class="navbar-collapse collapse" id="myNavbar">
        <ul class="nav navbar-nav nav-tabs navbar-right">
          <li role="presentation"><a data-toggle="collapse" data-target=".navbar-collapse" href="logout.php">Logout</a></li>
         <li role="presentation"><a data-toggle="collapse" data-target=".navbar-collapse" href="userinfo.php" >Profile</a></li>
         <li role="presentation"><a data-toggle="collapse" data-target=".navbar-collapse" href="home.php" >Home</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>  
<div id="usercard1" class="card">
<div class="card-block">
<div class="container-fluid">
    <?php if(!empty($umessage)) { ?> 
      <div class="alert alert-danger"><?php if(isset($umessage)){ echo $umessage; } ?></div>
    <?php } ?>
    <div class="row"><p1>Name:     <?php echo $_SESSION['username']; ?> </p1>
        <!-- Trigger the modal with a button -->
       <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal1"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
        <!-- Modal -->
        <div id="myModal1" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
        <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Change Username?</h4>
         </div>
         <div class="modal-body">
         <div>
          <form method="Post" action="userinfo.php">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="New Username">
            </div>
            <input type="submit" value="Save changes" name="un_btn" class="btn btn-default">
          </form>
         </div>
         </div>
         <div class="modal-footer"></div>
        </div>
        </div>
        </div>
    </div></br>
    <div class="row"><p1>Email-id: <?php echo $_SESSION['email']; ?>    </p1></div></br>
    <div class="row">
       <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal2"><span class="glyphicon glyphicon-pencil"></span> Change Password</button>
        <!-- Modal -->
        <div id="myModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
        <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Change Username?</h4>
         </div>
         <div class="modal-body">
         <div>
          <form method="Post" action="userinfo.php">
          <div class="form-group">
           <input type="password" class="form-control" name="password" placeholder="Old Password">
          </div>
          <div class="form-group">
           <input type="password" class="form-control" name="password1" placeholder="New Password">
          </div> 
          <div class="form-group">
           <input type="password" class="form-control" name="password2" placeholder="Re-enter New Password">
          </div>                
          <input type="submit" value="Save changes" name="pwd_btn" class="btn btn-default">
          </form>
         </div>
         </div>
         <div class="modal-footer"></div>
        </div>
        </div>
        </div>

    </div></br>

</div>
</div>
</div>
<h3>Your Complaints:</h3>
</br>
<?php 
  $conn = new mysqli("localhost","root","narahari96","ucomplain");
  $query3="SELECT * FROM complaints WHERE email='".$_SESSION['email']."'";
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
       <form method="POST" action="k1.php">
       <button class="btn btn-default btn-sm" name="upvote" style="<?php if($status==1){ echo 'background:#A895D3'; } if($status==0){ echo 'background:#6B5F87'; } ?>">
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
    No complaints posted yet
    </div>
<?php  } ?>


</body>
</html>