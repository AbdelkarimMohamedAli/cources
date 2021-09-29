<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';


# Fetch Categories ... 
$sql = "select * from cources";
$select_op  = mysqli_query($con,$sql);

$sql = "select * from users";    
$opp = mysqli_query($con,$sql);


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

# Fetch User users_cources
$sql = "select * from users_cources where id=".$id;
$op  = mysqli_query($con,$sql);
$data = mysqli_fetch_assoc($op);
  
if(mysqli_num_rows($op) == 0){
    $_SESSION['Message'] = ["No data For this Id"];
    $_SESSION['del_falg'] = 1;
    header("Location: index.php");
}












if($_SERVER['REQUEST_METHOD'] == "POST"){

    $is_accepted = CleanInputs($_POST['is_accepted']);
    $user_id     = CleanInputs($_POST['user_id']);
    $cource_id   = CleanInputs($_POST['cource_id']);
  



    $errors = [];

    # Validate ... 
    if(!validate($is_accepted,1)){
        $errors['Accepted'] = "Accepted : Requierd Field";
      }elseif(!validate($is_accepted,2)){
          $errors['Accepted'] = "Accepted : Invalid String";
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
  
            // LOGIC ...
            //$user_id =$_SESSION['user']['id'];

            $sql ="update users_cources set user_id=$user_id , cource_id = $cource_id , is_accepted = '$is_accepted'  where id =".$id;
            $op  = mysqli_query($con,$sql);
              
             if($op){
                  $_SESSION['Message'] = ["Data Updated"];
                  header("Location: index.php");
                  exit();

               }else{
                $_SESSION['Message'] = ["Error in sql OP Try Again"];
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
                      printMessages('Edit cources');
                     ?>

                    </li>
                </ol>



                <form method="post" action="edit.php?id=<?php  echo $data['id'];?>"
                    enctype="multipart/form-data">



                    <div class="form-group">
                        <label for="exampleInputEmail1">Is_Accepted</label>
                        <input type="text" name="is_accepted" value="<?php echo $data['is_accepted'];?>" class="form-control" id="exampleInputName" aria-describedby="">
                    </div>

                   
                    <div class="form-group">
                        <label for="exampleInputPassword1">Users</label>
                        <select name="user_id" class="form-control">

                            <?php while($user = mysqli_fetch_assoc($opp)){?>
                            <option value="<?php echo $user['id'];?>"  <?php if($user['id'] == $data['user_id']){echo 'selected';}?>  ><?php echo $user['name'];?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Cources</label>
                        <select name="cource_id" class="form-control">

                            <?php while($cource = mysqli_fetch_assoc($select_op)){?>
                            <option value="<?php echo $cource['id'];?>"  <?php if($cource['id'] == $data['cource_id']){echo 'selected';}?>  ><?php echo $cource['name'];?></option>
                            <?php }?>
                        </select>
                    </div>

               


                    <button type="submit" class="btn btn-primary">Save</button>
                </form>


            </div>
        </main>




        <?php 
  
  require '../Layouts/footer.php';

?>