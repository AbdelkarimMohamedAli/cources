<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';


# Fetch Categories ... 
$sql = "select * from quizes";
$select_op  = mysqli_query($con,$sql);

$sql = "select * from answers";
$select_op_answer  = mysqli_query($con,$sql);


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
$sql = "select * from questions where id=".$id;
$op  = mysqli_query($con,$sql);
$data = mysqli_fetch_assoc($op);
  
if(mysqli_num_rows($op) == 0){
    $_SESSION['Message'] = ["No data For this Id"];
    $_SESSION['del_falg'] = 1;
    header("Location: index.php");
}












if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name       = CleanInputs($_POST['name']);
    $quiz_id    = CleanInputs($_POST['quiz_id']);
    $answer_id  = CleanInputs($_POST['answer_id']);
  



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
  
            // LOGIC ...
           // $user_id =$_SESSION['user']['id'];

            $sql ="update questions set name='$name' , quiz_id = $quiz_id , answer_id=$answer_id where id =".$id;
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
                        <label for="exampleInputEmail1">Question</label>
                        <input type="text" name="name" value="<?php echo $data['name'];?>" class="form-control" id="exampleInputName" aria-describedby=""
                            placeholder="Enter name">
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
                        <label for="exampleInputPassword1">Answer</label>
                        <select name="answer_id" class="form-control">

                            <?php while($ans = mysqli_fetch_assoc($select_op_answer)){?>
                            <option value="<?php echo $ans['id'];?>"  <?php if($ans['id'] == $data['answer_id']){echo 'selected';}?>  ><?php echo $ans['name'];?></option>
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