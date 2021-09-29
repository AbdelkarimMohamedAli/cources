<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';


# Fetch Roles ... 
$sql = "select * from roles";
$select_op  = mysqli_query($con,$sql);


# ID & Validate ...  
$_SESSION['del_falg'] = 0;

# GET data ... 

$id = sanitize($_GET['id'],1);

$error = [];
if(!validate($id,6)){
    $error['id'] = "Invalid Integar";
}

if(count($error) > 0){
     $_SESSION['Message'] = $error;
     $_SESSION['del_falg'] = 1;
     header("Location: index.php");
}

# Fetch User Data
$sql = "select * from quizes where id=".$id;
$op  = mysqli_query($con,$sql);
$data = mysqli_fetch_assoc($op);
  
if(mysqli_num_rows($op) == 0){
    $_SESSION['Message'] = ["No data For this Id"];
    $_SESSION['del_falg'] = 1;
    header("Location: index.php");
}








if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name     = CleanInputs($_POST['name']);
    $errors = [];

    # Validate ... 
    if(!validate($name,1)){
      $errors['Name'] = "Name : Requierd Field";
    }elseif(!validate($name,2)){
        $errors['Name'] = "Name : Invalid String";
    }
 

    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{

     //$password = md5($password);
     
      $sql = "update quizes  set name = '$name' where id =".$id;
      $op  = mysqli_query($con,$sql);

      if($op){
          $message = ["Data Updated"];
          $_SESSION['Message'] = $message;
          $_SESSION['del_falg'] = 1;
          header("Location: index.php");
          exit();
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
                      printMessages('update quiz');
                     ?>

                    </li>
                </ol>



                <form method="post" action="edit.php?id=<?php echo $data['id'];?>"
                    enctype="multipart/form-data">



                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name="name" value="<?php echo $data['name'];?>" class="form-control" id="exampleInputName" aria-describedby=""
                            placeholder="Enter Name">
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>


            </div>
        </main>




        <?php 
  
  require '../Layouts/footer.php';

?>