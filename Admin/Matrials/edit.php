<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';


# Fetch Categories ... 
$sql = "select * from lessons";
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
$sql = "select * from matrials where id=".$id;
$op  = mysqli_query($con,$sql);
$data = mysqli_fetch_assoc($op);
  
if(mysqli_num_rows($op) == 0){
    $_SESSION['Message'] = ["No data For this Id"];
    $_SESSION['del_falg'] = 1;
    header("Location: index.php");
}












if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name      = CleanInputs($_POST['name']);
    $lesson_id   = CleanInputs($_POST['lesson_id']);
    $oldvideo   = CleanInputs($_POST['oldvideo']);
  



   # FILE INFO ... 
    $VIDtmp_path = $_FILES['video']['tmp_name'];
    $VIDname     = $_FILES['video']['name'];
    $VIDsize     = $_FILES['video']['size'];
    $VIDtype     = $_FILES['video']['type'];



    $errors = [];

    # Validate ... 
    if(!validate($name,1)){
        $errors['Name'] = "Name : Requierd Field";
      }elseif(!validate($name,2)){
          $errors['Name'] = "Name : Invalid String";
        }
  
  
      if(!validate($lesson_id,1)){
          $errors['lesson'] = "lesson : Requierd Field";
      }elseif(!validate($lesson_id,6)){
          $errors['lesson'] = "lesson : Invalid Int";
      }
  
      if(isset($VIDname) && validate($VIDname,1) ){

        if(!validate($VIDtype,8)){
            $errors['Video'] = "VIDEO : Invalid Extension";
           }

    }

            



    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{



        if(isset($VIDname) && validate($VIDname,1) ){

            $extArray = explode('/',$VIDtype);
            $finalName =   rand().time().'.'.$extArray[1];
    
            $desPath = './uploads/'.$finalName;
            if(move_uploaded_file($VIDtmp_path,$desPath)){

                 unlink('./uploads/'.$oldvideo);
            
            }else{
                $errors =['Error In Uploading Try Again'];
          }

        }else{
            $finalName = $oldvideo;
        }


        if(count($errors) > 0){
            $_SESSION['Message'] = $errors;
        }else{
  
            // LOGIC ...
           // $user_id =$_SESSION['user']['id'];

            $sql ="update matrials set name='$name' , lesson_id = $lesson_id , videos='$finalName' where id =".$id;
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
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" name="name" value="<?php echo $data['name'];?>" class="form-control" id="exampleInputName" aria-describedby=""
                            placeholder="Enter name">
                    </div>

                    
                    
        

                   
                    <div class="form-group">
                        <label for="exampleInputPassword1">lesson</label>
                        <select name="lesson_id" class="form-control">

                            <?php while($result = mysqli_fetch_assoc($select_op)){?>
                            <option value="<?php echo $result['id'];?>"  <?php if($result['id'] == $data['lesson_id']){echo 'selected';}?>  ><?php echo $result['title'];?></option>
                            <?php }?>
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">video</label><br>
                        <input type="file" name="video"  >
                           
                    </div>

                    <input type='hidden' name="oldVideo" value="<?php echo $data['videos'];?>">


                    <video width="220" height="140" controls>
                    <label>Old Video</label><br>
                        <source src="./uploads/<?php echo $data['videos'];?>">
                    </video>


                    <button type="submit" class="btn btn-primary">Save</button>
                </form>


            </div>
        </main>




        <?php 
  
  require '../Layouts/footer.php';

?>