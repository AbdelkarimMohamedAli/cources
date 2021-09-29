<?php 
require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';



 $id = sanitize($_GET['id'],1);

 $error = [];

 if(!validate($id,6)){
     $error['id'] = "Invalid Integar";
 }


 if(count($error) > 0){
     $message  = $error;
 }else{

    # video Name 
    $sql = "select videos from matrials where id =".$id;
    $op  = mysqli_query($con,$sql);
    $data =mysqli_fetch_assoc($op);
    $video = $data['videos'];


     $sql = "delete from matrials where id =".$id;

     $op  = mysqli_query($con,$sql);

     if($op){
        $path = './uploads/'.$video;
       
       if(file_exists($path)){
          unlink($path);
       } 
     

         $message = ["Record Deleted"];
     }else{
         $message = ["Error Try Again"];
     }

 }

 $_SESSION['Message'] = $message;
 
 header("Location: index.php");




?>