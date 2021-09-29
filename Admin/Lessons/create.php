<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';


# Fetch Roles ... 
$sql = "select * from cources";
$select_op  = mysqli_query($con,$sql);



if($_SERVER['REQUEST_METHOD'] == "POST"){

    $title     = CleanInputs($_POST['title']);
    $cource_id  = CleanInputs($_POST['cource_id']);

    $errors = [];

    # Validate ... 
    if(!validate($title,1)){
      $errors['Title'] = "Title : Requierd Field";
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
            $sql = "insert into lessons (title,cource_id) values ('$title',$cource_id)";
            $op  = mysqli_query($con,$sql);

              
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
                      printMessages('Add lesson');
                     ?>

                    </li>
                </ol>



                <form method="post" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                    enctype="multipart/form-data">



                    <div class="form-group">
                        <label for="exampleInputEmail1">Lesson</label>
                        <input type="text" name="title" class="form-control" id="exampleInputName" aria-describedby=""
                            placeholder="Enter Lesson">
                    </div>



                    <div class="form-group">
                        <label for="exampleInputPassword1">cources</label>
                        <select name="cource_id" class="form-control">

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