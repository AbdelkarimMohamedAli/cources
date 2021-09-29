<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';

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

     
      $sql = "insert into quizes (name) values ('$name')";
      $op  = mysqli_query($con,$sql);

      if($op){
          $message = ["Data Inserted"];
      }else{
          $message = ["Error in sql OP Try Again"];
      }

        $_SESSION['Message'] = $message;


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
                      printMessages('Add quizes');
                     ?>

                    </li>
                </ol>



                <form method="post" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                    enctype="multipart/form-data">



                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name="name" class="form-control" id="exampleInputName" aria-describedby=""
                            placeholder="Enter Name">
                    </div>


                    <button type="submit" class="btn btn-primary">Save</button>
                </form>


            </div>
        </main>




        <?php 
  
  require '../Layouts/footer.php';

?>