<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
//require '../helpers/checkLogin.php';
require '../helpers/checkAdmin.php';


# Fetch Roles ... 
$sql = "select * from quizes";
$select_op  = mysqli_query($con,$sql);



if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name     = CleanInputs($_POST['name']);
    $price     = CleanInputs($_POST['price']);
    $desc    = CleanInputs($_POST['desc']);
    $quiz_id  = CleanInputs($_POST['quiz_id']);


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

    if(!validate($IMGname,1)){
    $errors['IMG'] = "IMAGE : Field Required";
    
    }elseif(!validate($IMGtype,4)){
    $errors['IMG'] = "IMAGE : Invalid Extension";
    }  




    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{

     
        $extArray = explode('/',$IMGtype);
        $finalName =   rand().time().'.'.$extArray[1];
        

        $desPath = './uploads/'.$finalName;
        
         
         if(move_uploaded_file($IMGtmp_path,$desPath)){
            
  
            // LOGIC ... 
            //$user_id =$_SESSION['user']['id'];
            $sql = "insert into cources (name,price,quiz_id,description,image) values ('$name',$price,$quiz_id,'$desc','$finalName')";
            $op  = mysqli_query($con,$sql);

          //echo mysqli_error($op);
            //exit();
              
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
                        <label for="exampleInputEmail1">Cource</label>
                        <input type="text" name="name" class="form-control" id="exampleInputName" aria-describedby=""
                            placeholder="Enter Cource">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">Image</label><br>
                        <input type="file" name="image"  >
                           
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">New price</label>
                        <input type="text" name="price" class="form-control" id="exampleInputPassword1"
                            placeholder="Enter price">
                    </div>



                    <div class="form-group">
                        <label for="exampleInputPassword1">description</label>
                        <textarea name="desc" class="form-control"></textarea>    
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">quizes</label>
                        <select name="quiz_id" class="form-control">

                            <?php while($result = mysqli_fetch_assoc($select_op)){?>
                            <option value="<?php echo $result['id'];?>"><?php echo $result['name'];?></option>
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