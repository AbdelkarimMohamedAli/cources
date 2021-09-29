<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';


# Fetch Roles ... 
$sql = "select * from lessons";
$select_op  = mysqli_query($con,$sql);



if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name     = CleanInputs($_POST['name']);
    $lesson_id  = CleanInputs($_POST['lesson_id']);


    $VIDtmp_path = $_FILES['video']['tmp_name'];
    $VIDname     = $_FILES['video']['name'];
    $VIDsize     = $_FILES['video']['size'];
    $VIDtype     = $_FILES['video']['type'];



    $errors = [];

    # Validate ... 
    if(!validate($name,1)){
      $errors['Name'] = "Name : Requierd Field";
    }


    if(!validate($lesson_id,1)){
        $errors['lesson'] = "lesson : Requierd Field";
    }elseif(!validate($lesson_id,6)){
        $errors['lesson'] = "lesson : Invalid Int";
    }

    if(!validate($VIDname,1)){
    $errors['VID'] = "VIDEO : Field Required";
    
    }elseif(!validate($VIDtype,8)){
    $errors['VID'] = "VIDEO : Invalid Extension";
    }  




    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{

     
        $extArray = explode('/',$VIDtype);
        $finalName =   rand().time().'.'.$extArray[1];
        

        $desPath = './uploads/'.$finalName;
        
         
         if(move_uploaded_file($VIDtmp_path,$desPath)){
            
  
            // LOGIC ... 
            //$user_id =$_SESSION['user']['id'];
            $sql = "insert into matrials (name,videos,lesson_id) values ('$name','$finalName',$lesson_id)";

            $op  = mysqli_query($con,$sql);

          


          
             if($op){
                  $_SESSION['Message'] = ["Data Inserted"];
                 // header("Location: index.php");
                  //exit();

               }else{
                $_SESSION['Message'] = ["Error in sql OP Try Again"];
                }
            
         }else{
               $_SESSION['Message'] =['Error In Uploading Try Again'];
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



                <form method="post" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                    enctype="multipart/form-data">



                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name="name" class="form-control" id="exampleInputName" aria-describedby=""
                            placeholder="Enter Name">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">video</label><br>
                        <input type="file" name="video"  >
                           
                    </div>

                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">lessons</label>
                        <select name="lesson_id" class="form-control">

                            <?php while($result = mysqli_fetch_assoc($select_op)){?>
                            <option value="<?php echo $result['id'];?>"><?php echo $result['title'];?></option>
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