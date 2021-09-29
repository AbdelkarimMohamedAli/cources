<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';


# Fetch Categories ... 
$sql = "select * from quizes";
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
$sql = "select * from cources where id=".$id;
$op  = mysqli_query($con,$sql);
$data = mysqli_fetch_assoc($op);
  
if(mysqli_num_rows($op) == 0){
    $_SESSION['Message'] = ["No data For this Id"];
    $_SESSION['del_falg'] = 1;
    header("Location: index.php");
}












if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name      = CleanInputs($_POST['name']);
    $price    = CleanInputs($_POST['price']);
    $desc     = CleanInputs($_POST['desc']);
    $quiz_id   = CleanInputs($_POST['quiz_id']);
    $oldImage   = CleanInputs($_POST['oldImage']);
  



   # FILE INFO ... 
   $IMGtmp_path = $_FILES['image']['tmp_name'];
   $IMGname     = $_FILES['image']['name'];
   $IMGsize     = $_FILES['image']['size'];
   $IMGtype     = $_FILES['image']['type'];



    $errors = [];

    # Validate ... 
    if(!validate($name,1)){
        $errors['Name'] = "Name : Requierd Field";
      }elseif(!validate($name,2)){
          $errors['Name'] = "Name : Invalid String";
        }
  
        if(!validate($price,1)){
          $errors['email'] = " price : Requierd Field";
        }elseif(!validate($price,6)){
            $errors['email'] = "price : invalid price";
        }
   
        if(!validate($desc,1)){
          $errors['description'] = " description : Requierd Field";
        }elseif(!validate($desc,5,20)){
            $errors['description'] = "description : Legth must be >= 20 CH";
        }
  
      if(!validate($quiz_id,1)){
          $errors['quiz'] = "quiz : Requierd Field";
      }elseif(!validate($quiz_id,6)){
          $errors['quiz'] = "quiz : Invalid Int";
      } 




        if(isset($IMGname) && validate($IMGname,1) ){

            if(!validate($IMGtype,4)){
                $errors['IMG'] = "IMAGE : Invalid Extension";
               }
    
        }

            



    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{



        if(isset($IMGname) && validate($IMGname,1) ){

            $extArray = explode('/',$IMGtype);
            $finalName =   rand().time().'.'.$extArray[1];
    
            $desPath = './uploads/'.$finalName;
            if(move_uploaded_file($IMGtmp_path,$desPath)){

                 unlink('./uploads/'.$oldImage);
            
            }else{
                $errors =['Error In Uploading Try Again'];
          }

        }else{
            $finalName = $oldImage;
        }


        if(count($errors) > 0){
            $_SESSION['Message'] = $errors;
        }else{
  
            // LOGIC ...
            $user_id =$_SESSION['user']['id'];

            $sql ="update cources set name='$name' , description = '$desc' , quiz_id = $quiz_id , price=$price , image='$finalName' where id =".$id;
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
                        <label for="exampleInputPassword1">New price</label>
                        <input type="text" name="price" class="form-control" value="<?php echo $data['price'];?>"
                            placeholder="Enter price">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">description</label>
                        <textarea name="desc" class="form-control">
                        <?php echo $data['description'];?>
                        </textarea>    
                    </div>
        

                   
                    <div class="form-group">
                        <label for="exampleInputPassword1">quiz</label>
                        <select name="quiz_id" class="form-control">

                            <?php while($result = mysqli_fetch_assoc($select_op)){?>
                            <option value="<?php echo $result['id'];?>"  <?php if($result['id'] == $data['quiz_id']){echo 'selected';}?>  ><?php echo $result['name'];?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Image</label><br>
                        <input type="file" name="image"  >
                    </div>
                    
                    <input type='hidden' name="oldImage" value="<?php echo $data['image'];?>">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Old Image</label><br>
                        <img src="./uploads/<?php echo $data['image'];?>"  width="150" height="200">
                    </div>


                    <button type="submit" class="btn btn-primary">Save</button>
                </form>


            </div>
        </main>




        <?php 
  
  require '../Layouts/footer.php';

?>