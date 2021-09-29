<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';


$sql = "select * from cources";
$select_op  = mysqli_query($con,$sql);

$sql = "select * from users";    
$op = mysqli_query($con,$sql);


if($_SERVER['REQUEST_METHOD'] == "POST"){

    $is_accepted = CleanInputs($_POST['is_accepted']);
    $cource_id  = CleanInputs($_POST['cource_id']);
    $user_id    = CleanInputs($_POST['user_id']);

    $errors = [];

    # Validate ... 
    if(!validate($is_accepted,1)){
      $errors['is_Accepted'] = "is_Accepted : Requierd Field";
    }elseif(!validate($is_accepted,2)){
        $errors['is_Accepted'] = "is_Accepted : Invalid String";
      }

    if(!validate($user_id,1)){
        $errors['user'] = "user : Requierd Field";
    }elseif(!validate($user_id,6)){
        $errors['user'] = "user : Invalid Int";
    }

    if(!validate($cource_id,1)){
        $errors['cource'] = "cource : Requierd Field";
    }elseif(!validate($cource_id,6)){
        $errors['cource'] = "cource : Invalid Int";
    }
  


    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{

     
      $sql = "insert into users_cources (user_id,cource_id,is_accepted) values ($user_id,$cource_id,'$is_accepted')";
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
                      printMessages('Add user and cource');
                     ?>

                    </li>
                </ol>



                <form method="post" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                    enctype="multipart/form-data">

                   

                    <div class="form-group">
                        <label for="exampleInputPassword1">User</label>
                        <select name="user_id" class="form-control">

                            <?php while($user = mysqli_fetch_assoc($op)){?>
                            <option value="<?php echo $user['id'];?>"><?php echo $user['name'];?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Cource</label>
                        <select name="cource_id" class="form-control">

                            <?php while($cource = mysqli_fetch_assoc($select_op)){?>
                            <option value="<?php echo $cource['id'];?>"><?php echo $cource['name'];?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Is_Accepted</label>
                        <input type="text" value="no" name="is_accepted" class="form-control" id="exampleInputName" aria-describedby="">
                    </div>


                    <button type="submit" class="btn btn-primary">Save</button>
                </form>


            </div>
        </main>




        <?php 
  
  require '../Layouts/footer.php';

?>