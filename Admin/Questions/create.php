<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';


# Fetch Roles ... 
$sql = "select * from quizes";
$select_op  = mysqli_query($con,$sql);

# Fetch Roles ... 
$sql = "select * from answers";
$select_op_ans  = mysqli_query($con,$sql);



if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name       = CleanInputs($_POST['name']);
    $answer_id  = CleanInputs($_POST['answer_id']);
    $quiz_id    = CleanInputs($_POST['quiz_id']);


    $errors = [];

    # Validate ... 
    if(!validate($name,1)){
      $errors['Name'] = "Name : Requierd Field";
    }
 
      

    if(!validate($quiz_id,1)){
        $errors['quiz'] = "quiz : Requierd Field";
    }elseif(!validate($quiz_id,6)){
        $errors['quiz'] = "quiz : Invalid Int";
    }

    if(!validate($answer_id,1)){
        $errors['answer'] = "answer : Requierd Field";
    }elseif(!validate($answer_id,6)){
        $errors['answer'] = "answer : Invalid Int";
    }




    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{

     
           
  
           
            $sql = "insert into questions (name,quiz_id,answer_id) values ('$name',$quiz_id,$answer_id)";
            $op  = mysqli_query($con,$sql);

            
           // echo mysqli_error($con);

           // exit();

      
              
             if($op){
                  $_SESSION['Message'] = ["Data Inserted"];
                 // header("Location: index.php");
                  //exit();

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
                      printMessages('Add Admin');
                     ?>

                    </li>
                </ol>



                <form method="post" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                    enctype="multipart/form-data">



                    <div class="form-group">
                        <label for="exampleInputEmail1">Question</label>
                        <input type="text" name="name" class="form-control" id="exampleInputName" aria-describedby=""
                            placeholder="Enter question">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">quiz</label>
                        <select name="quiz_id" class="form-control">

                            <?php while($result = mysqli_fetch_assoc($select_op)){?>
                            <option value="<?php echo $result['id'];?>"><?php echo $result['name'];?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">answer</label>
                        <select name="answer_id" class="form-control">

                            <?php while($ans = mysqli_fetch_assoc($select_op_ans)){?>
                            <option value="<?php echo $ans['id'];?>"><?php echo $ans['name'];?></option>
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