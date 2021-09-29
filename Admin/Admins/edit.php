<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
//require '../helpers/checkLogin.php';
require '../helpers/checkAdmin.php';


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
$sql = "select * from users where id=".$id;
$op  = mysqli_query($con,$sql);
$data = mysqli_fetch_assoc($op);
  
if(mysqli_num_rows($op) == 0){
    $_SESSION['Message'] = ["No data For this Id"];
    $_SESSION['del_falg'] = 1;
    header("Location: index.php");
}








if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name     = CleanInputs($_POST['name']);
    $email    = CleanInputs($_POST['email']);
   // $password = CleanInputs($_POST['password']);
    $phone    = CleanInputs($_POST['phone']);
    $role_id  = CleanInputs($_POST['role_id']);

    $errors = [];

    # Validate ... 
    if(!validate($name,1)){
      $errors['Name'] = "Name : Requierd Field";
    }elseif(!validate($name,2)){
        $errors['Name'] = "Name : Invalid String";
      }

      if(!validate($email,1)){
        $errors['email'] = " Email : Requierd Field";
      }elseif(!validate($email,3)){
          $errors['email'] = "Email : Invalid Email";
        }


        // if(!validate($password,1)){
        //     $errors['Password'] = "Password : Requierd Field";
        //   }elseif(!validate($password,5)){
        //       $errors['Password'] = "Password : Invalid Length , Length must Be >= 6 CH";
        //     }   


        if(!validate($role_id,1)){
            $errors['Role'] = "Role : Requierd Field";
           }elseif(!validate($role_id,6)){
             $errors['Role'] = "Role : Invalid Int";
          }   



          if(!validate($phone,1)){
            $errors['phone'] = "Phone : Requierd Field";
           } elseif(!validate($phone,7)){
             $errors['Phone'] = "Invalid Phone Number";
          }    



    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{

     //$password = md5($password);
     
      $sql = "update users  set name = '$name' ,email = '$email',phone = '$phone',role_id = $role_id where id =".$id;
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
                      printMessages('Add Admin');
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


                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="email"  value="<?php echo $data['email'];?>"  class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                            placeholder="Password">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">Phone</label>
                        <input type="txt" name="phone" value="<?php echo $data['phone'];?>" class="form-control" id="exampleInputPassword1"
                            placeholder="Phone">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">Role</label>
                        <select name="role_id" class="form-control">
                           
                            <?php while($result = mysqli_fetch_assoc($select_op)){?>
                            <option value="<?php echo $result['id'];?>" <?php if($data['role_id'] == $result['id']){ echo 'selected';} ?>><?php echo $result['title'];?></option>
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