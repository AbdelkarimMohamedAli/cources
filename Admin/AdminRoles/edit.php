<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';



$_SESSION['del_falg'] = 0;

# GET data ... 

$id = sanitize($_GET['id'],1);

$error = [];
if(!validate($id,6)){
    $error['id'] = "Invalid Integar";
}

if(count($error) > 0){
     $_SESSION['Message'] = $error;

     header("Location: index.php");
}

# Fetch Data Based On Id ... 

$sql = "select * from roles where id =".$id;
$op  = mysqli_query($con,$sql);
$data = mysqli_fetch_assoc($op); 




if($_SERVER['REQUEST_METHOD'] == "POST"){

    $title = CleanInputs($_POST['title']);

    $errors = [];
    # Validate ... 
    if(!validate($title,1)){
      $errors['Title'] = "Requierd Field";
    }elseif(!validate($title,2)){
        $errors['Title'] = "Invalid String";
      }

    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{

      $sql = "update roles set title = '$title' where id=".$id;
      $op  = mysqli_query($con,$sql);

      if($op){
          $message = ["Data Updated"];

          $_SESSION['Message'] = $message;    
          $_SESSION['del_falg'] = 1;
          header("Location: index.php");     

      }else{
          $message = ["Error in sql OP Try Again"];
          $_SESSION['Message'] = $message;
       
      }

       


    }


}









 require '../Layouts/header.php';
 require '../Layouts/topNav.php';
?>

<div id="layoutSidenav">

    <?php 
    require '../Layouts/sidNav.php';
 ?>




    <div id="layoutSidenav_content">



        <main>
            <div class="container-fluid">

                <h1 class="mt-4">Dashboard </h1> 
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">
                      
                     <?php 
                   
                      printMessages('Edit Role',$_SESSION['del_falg']);
                   
                      //  unset($_SESSION['Message']);
                     ?>
                    
                    </li>
                </ol>



                <form method="post" action="edit.php?id=<?php  echo $data['id']; ?>"
                    enctype="multipart/form-data">



                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" name="title"  value="<?php echo $data['title'];?>" class="form-control" id="exampleInputName" aria-describedby=""
                            placeholder="Enter Title">
                    </div>


                    <button type="submit" class="btn btn-primary">Save</button>
                </form>


            </div>
        </main>




        <?php 
  
  require '../Layouts/footer.php';

?>