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
  if(isset($_POST["upvote"]))
  {
    $complaintno=$_POST['cmpno'];
    $email=$_SESSION['email'];

      $query4="SELECT * FROM  `$complaintno` WHERE email='".$email."'";
      $result1=$conn->query($query4);
      if ($result1->num_rows >0) 
      {
        $status=1;
      }
      else
      {
        $status=0;
      } 

      echo $status;
   if($status==0)
   { 
    $query5="SELECT upvotes FROM complaints where complaintno=".$complaintno."";
    $result3=$conn->query($query5);
    if($result3->num_rows> 0)
    {
     while($row=$result3->fetch_assoc())
     {
      $u=$row['upvotes'];     
      $u=$u+1;
      $query6="INSERT INTO `$complaintno`(email) VALUES('".$email."')";
      $conn->query($query6);    
      $query7="UPDATE complaints SET upvotes=".$u." WHERE complaintno=".$complaintno."";
      echo $query7;
      $conn->query($query7);    
     }
    }
   }
   if($status==1)
   {  
    $query5="SELECT upvotes FROM complaints where complaintno=".$complaintno."";
    $result3=$conn->query($query5);  
    if($result3->num_rows > 0)
    {  
     while($row=$result3->fetch_assoc())
     {
      $u=$row['upvotes'];     
      $u=$u-1;    
      $query6="DELETE FROM `$complaintno` WHERE email='".$email."'";
      echo $query6;
      $conn->query($query6);    
      $query7="UPDATE complaints SET upvotes=".$u." WHERE complaintno=".$complaintno."";
      echo $query7;
      $conn->query($query7);    
     }
    } 
   }

   header("location:userinfo.php");
  }
}   
else
{
  header("location:ucomplain.php");
}

?>