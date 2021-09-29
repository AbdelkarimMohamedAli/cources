<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';


# Fetch Roles ... 
$sql = "select * from cources";
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
$sql = "select * from lessons where id=".$id;
$op  = mysqli_query($con,$sql);
$data = mysqli_fetch_assoc($op);
  
if(mysqli_num_rows($op) == 0){
    $_SESSION['Message'] = ["No data For this Id"];
    $_SESSION['del_falg'] = 1;
    header("Location: index.php");
}








if($_SERVER['REQUEST_METHOD'] == "POST"){

    $title     = CleanInputs($_POST['title']);
    $cource_id  = CleanInputs($_POST['cource_id']);

    $errors = [];

    # Validate ... 
    if(!validate($title,1)){
      $errors['Title'] = "Title : Requierd Field";
    }elseif(!validate($title,2)){
        $errors['Title'] = "Title : Invalid String";
      }
   


        if(!validate($cource_id,1)){
            $errors['Cource'] = "Cource : Requierd Field";
           }elseif(!validate($cource_id,6)){
             $errors['Cource'] = "Cource : Invalid Int";
          }   


    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{

     //$password = md5($password);
     
      $sql = "update lessons  set title = '$title' ,cource_id = $cource_id where id =".$id;
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
                        <input type="text" name="title" value="<?php echo $data['title'];?>" class="form-control" id="exampleInputName" aria-describedby=""
                            placeholder="Enter title">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">cource</label>
                        <select name="cource_id" class="form-control">
                           
                            <?php while($result = mysqli_fetch_assoc($select_op)){?>
                            <option value="<?php echo $result['id'];?>" <?php if($data['cource_id'] == $result['id']){ echo 'selected';} ?>><?php echo $result['name'];?></option>
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