<?php
 session_start();
 //create connection
 $conn = new mysqli("localhost","root","narahari96","ucomplain");
 //check connection
 if($conn->connect_error)
 {
  die("Connection failed: " . $conn->connect_error);
 } 

 $_SESSION["is_logged_in"]= false;

if(isset($_POST["reg_btn"]))
{ 
 $username=$_POST['username'];
 $password=$_POST['password'];
 $password2=$_POST['password2'];
 $email=$_POST['email'];
 $rmessage="";

  
 /* Password Matching Validation */
 if($password != $password2)
 { 
  $message = "Passwords not same!"; 
 }
 if($password === $password2)
 { 
  $query1="SELECT * from users where email='$email'";
  $result = $conn->query($query1);
  if($result->num_rows > 0)
  {
   $rmessage = "User already exists with this email!";
  }
  else
  {
   $query2= "INSERT INTO users (username,email,password) VALUES ('$username','$email','$password')";
   if ($conn->query($query2) === TRUE) 
   {
    $rmessage = "You have registered successfully!"; 
   }
   else
   {
    $rmessage = "Error in registering!";
   } 
   unset($_POST);
  }
 }
}
if(isset($_POST['lgn_btn']))
{
    $email=$_POST['email'];
    $password=$_POST['password'];
    $lmessage="";
    $query1="SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($query1);
    $row = $result->fetch_assoc();
    if($result->num_rows > 0)
    {
      //$lmessage="You are logged in!";
      $_SESSION["is_logged_in"]= true;
      $_SESSION["username"]=$row["username"];
      $_SESSION["email"]=$row["email"];
      $_SESSION["password"]=$row["password"];
      header("location:home.php");
    }
   else
   {
      $lmessage="Incorrect Email/Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>UCOMPLAIN</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

  <style>
  body {
       background:#FAFBF5;
  }



.jumbotron.jmb1{
 background:url('img3a.jpeg') no-repeat center center ;
 background-size: 100% 100%;
 background-position:fixed;
 font-family: 'Lato', sans-serif;
 padding-left:4%;
 }


.jumbotron.jmb2{
  background:#FAFBF5;
 }

#login #crd1.card{
  padding-bottom: 63px;
}

#crd1.card{
 text-align:center;
 border-radius:10px;
 background:#FFFFFF;
 box-shadow:0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
 margin-bottom:10px;
}

.btn.btn-primary{
  background: #6B5F87;
  color:#FFFFFF;
}
.btn.btn-default:hover,
.btn.btn-default:active{
  background: #FFFFFF;
  color:#6B5F87;
}

.glyphicon-user{
 padding-top:23px;
 font-size:75px;
}

.jumbotron.jmb3{
  background:#FAFBF5;
  color:#6B5F87;
  text-align:center;
 }
#crd2.card{
 background:#6B5F87;
 text-align:center;
 margin:5px;
 padding:10px;
 height:250px;
 border-radius:10px;
 box-shadow:0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
 color:#FFFFFF;
}

.badge{
 margin-top:10px;
 height:50px;
 width:50px;
 color:#FFFFFF;
 background:transparent;
 border-radius:50%;
 border:7px solid #FFFFFF;
 box-shadow:0 0px 6px rgba(0,0,0,0.16), 0 0px 6px rgba(0,0,0,0.23);
 font-size:30px 
}

.carousel{
 height:220px;
 padding-right:10px;
 text-align:center;
}

.carousel-inner > .item > img,
.carousel-inner > .item > a > img {
      width:100%;
      margin: 0px;
}

.jumbotron.jmb4{
  background:#FAFBF5;
  color:#6B5F87;
  border:10px solid #6B5F87;
  border-radius: 5px;
  text-align:center;
  box-shadow:0 0px 6px rgba(0,0,0,0.16), 0 0px 6px rgba(0,0,0,0.23);
 }
 .jmb4 h4{
  font-weight: bold;
 }

 .card{
 text-align:center;
 border-radius:10px;
 background:#FFFFFF;
 box-shadow:0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
 margin-bottom:10px;
 padding-bottom: 5px;
}

#rwdimg{
    max-height:270px;
    width:90%;
   }



.navbar-inverse .navbar-brand {
    color: #000000;  
}
.navbar-inverse{
    border:0;
    background:transparent;
}
.navbar-inverse .navbar-nav > li > a {
    color: #000000;
}
.navbar-inverse .navbar-toggle .icon-bar {
   background:#000000;
}
.navbar-inverse .navbar-nav > li > a:hover,
.navbar-inverse .navbar-nav > li > a:focus,
.navbar-inverse .navbar-nav > li > a:active {
    color:#FFFFFF;
    background:#000000;
}

  footer {
      text-align: center;
      background-color: #2d2d30;
      color: #f5f5f5;
      padding: 32px;
      width: 100%;
      position: absolute;
      right: 0px;
      left: 0px;
  }
  footer a {
      color: #f5f5f5;
  }
  footer a:hover {
      color: #777;
      text-decoration: none;
  }  


  </style>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
   <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>   
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                       
    </button>
    <a class="navbar-brand" href="ucomplain.php"><b>UCOMPLAIN<b></a>
   </div>
    <div>
      <div class="navbar-collapse collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a data-toggle="collapse" data-target=".navbar-collapse" href="#login" >Login</a></li>
          <li><a data-toggle="collapse" data-target=".navbar-collapse" href="#register" >Register</a></li>
          <li><a data-toggle="collapse" data-target=".navbar-collapse" href="#howitworks" >How it works?</a></li>
          <li><a data-toggle="collapse" data-target=".navbar-collapse" href="#aboutus" >About us</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>  

<div id="ucomplain" class="jumbotron jmb1">
  </br></br></br></br></br></br></br></br></br></br>
  <h1><b>UCOMPLAIN<b></h1>
  <h4>Join the complaining community.</h4>
  <h4>A digital platform to spill out </h4>
  <h4>the complaints and find the support to uproar the complaint.</h4>
  </br></br></br></br></br></br></br></br></br></br></br>
</div>

<div class="container-fluid">
  <div class="jumbotron jmb2">
  <div class="row">
  <div id="login" class="col-sm-6" align="center">
    <div id="crd1" class="card" >
      <span class="glyphicon glyphicon-user"></span>
      <div class="card-block">
      <div class="container">
      <form method="Post" action="ucomplain.php" autocomplete="on">
<?php if(!empty($lmessage)) { ?> 
  <div class="alert alert-danger"><?php if(isset($lmessage)) echo $lmessage; ?></div>
<?php } ?>
       <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Email" required>
       </div>
       <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
       </div></br>
       <input type="submit" value="Login" class="btn btn-primary" name="lgn_btn"></br></br>
       </form>
      </div>
      </div>
    </div>
  </div>
  <div id="register" class="col-sm-6" align="center">
    <div id="crd1" class="card">
      <div class="card-block">
      <div class="container">
       <h3></br>Create your account here!</br></h3>
       <form method="Post" action="ucomplain.php" autocomplete="on">
<?php if(!empty($rmessage)) { ?> 
  <div class="alert alert-danger"><?php if(isset($rmessage)) echo $rmessage; ?></div>
<?php } ?>
       <div class="form-group">
        <input type="text" class="form-control" name="username" placeholder="Username" required>
       </div>
       <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Email" required>
       </div>
       <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
       </div>
       <div class="form-group">
        <input type="password" class="form-control" name="password2" placeholder="Re-enter Password" required>
       </div>
       <input type="submit" value="Submit" class="btn btn-primary" name="reg_btn"></br></br>
      </form>
      </div>
      </div>
    </div>
  </div>
</div>


<div class="container-fluid">
<div id="howitworks" class="jumbotron jmb3">
<h3><b><u>How it works?</u></b></h3>
<div class="row">
<div class="col-md-6">
 <div id="crd2" class="card">
  <div class="card-block">
    <h5><b>Front-end working:</b><h5>
    <div id="myCarousel1" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel1" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel1" data-slide-to="1"></li>
      <li data-target="#myCarousel1" data-slide-to="2"></li>
      <li data-target="#myCarousel1" data-slide-to="3"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <div><span class="badge">1</span></div>
        <h5></br><b>Create an account with your email-id.</b></h5>
      </div>

      <div class="item">
        <div><span class="badge">2</span></div>
        <h5></br><b>Login with registered Email-id.</b></h5>
      </div>
    
      <div class="item">
        <div><span class="badge">3</span></div>
        <h5></br><b>Post your complaint with the easy to use interface.</b></h5>
      </div>

      <div class="item">
        <div><span class="badge">4</span></div>
        <h5></br><b>Support other complaints and know the support of your posted complaints.</b></h5>
      </div>
    </div>
    </div>
  </div> 
 </div>
</div>
<div class="col-md-6">
 <div id="crd2" class="card">
  <div class="card-block">
    <h5><b>Back-end working:</b><h5>
    <div id="myCarousel2" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel2" data-slide-to="1"></li>
      <li data-target="#myCarousel2" data-slide-to="2"></li>
      <li data-target="#myCarousel2" data-slide-to="3"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <div><span class="badge">1</span></div>
        <h5></br><b>The complaint is forwarded.</b></h5>
      </div>

      <div class="item">
        <div><span class="badge">2</span></div>
        <h5></br><b>The complaints posted are sorted based on location,type of complaint, etc.</b></h5>
      </div>
    
      <div class="item">
        <div><span class="badge">3</span></div>
        <h5></br><b>The respective authorities are notified about the issue.</b></h5>
      </div>

      <div class="item">
        <div><span class="badge">4</span></div>
        <h5></br><b>The number of responses for the complaint are notified to authorities more frequently.</b></h5>
      </div>
    </div>
    </div>
  </div> 
 </div>
</div>
</div>

</div>
</div>

<div id="aboutus" class="jumbotron jmb4">
 <h3><b><u>ABOUT US</u></b></h3>
  <div class="container-fluid">
  <div class="row">
  <div class="col-md-6">
   <div class="row"><h4><u>THE TEAM</u></h4></div>
   <div class="row"><h4>Team Members</h4></div>
    <div class="row">
     <div class="col-md-6">
        <div class="card">
         <div class="card-block">
           <span class="glyphicon glyphicon-user"></span>
           <h4>N. Venkat Ramana Reddy</h4>
           <h4>14241A1243</h4> 
         </div>
        </div>
       </div> 
     <div class="col-md-6">
        <div class="card">
         <div class="card-block">
           <span class="glyphicon glyphicon-user"></span>
           <h4>K. Venkata Raju</h4>
           <h4>14241A1228</h4> 
         </div>
        </div>
       </div> 
      </div>
      <div class="row">
     <div class="col-md-6">
        <div class="card">
         <div class="card-block">
           <span class="glyphicon glyphicon-user"></span>
           <h4>K. Sri Vardhan</h4>
           <h4>14241A1231</h4> 
         </div>
        </div>
       </div> 
     <div class="col-md-6">
        <div class="card">
         <div class="card-block">
           <span class="glyphicon glyphicon-user"></span>
           <h4>J. Subash</h4>
           <h4>14241A1225</h4> 
         </div>
        </div>
       </div> 
    </div>
    <div class="row"><h4>Team Guide</h4></div>
      <div class="row">
     <div class="col-md-12">
        <div class="card">
         <div class="card-block">
           <span class="glyphicon glyphicon-user"></span>
           <h4>L. Sukanya</h4>
           <h4>Assistant Professor</h4> 
         </div>
        </div>
       </div> 
      </div> 
     </div>   
    <div class="col-md-6">
           <h4><u>OUR DRIVE</u></h4>
           <h4></br>We aim to provide a smooth way for public to express their greviences to government and be the force to drive the authorities to work more effectively.</h4></br>
           <img id="rwdimg" src="rwdicon.png" alt="RWDicon">
    </div>
    </div>
    </div>

</div>

<div class="container">
<footer>
  <a class="up-arrow" href="#ucomplain" data-toggle="tooltip" title="TO TOP">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a><br><br>
  <p>|<a href="#">Contact us</a>|  <a href="#">Help</a>|  <a href="#">Privacy Policy</a>  |  <a href="#">Terms & Conditions</a>   |</p> 
</footer>
</div>
</body>
</html>
