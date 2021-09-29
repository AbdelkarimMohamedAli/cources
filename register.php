<?php 

require './Admin/helpers/dbConnection.php';
require './Admin/helpers/helpers.php';
//require '../helpers/checkLogin.php';
//require './Admin/helpers/checkAdmin.php';





if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name     = CleanInputs($_POST['name']);
    $email    = CleanInputs($_POST['email']);
    $password = CleanInputs($_POST['password']);
    $phone    = CleanInputs($_POST['phone']);

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

        
        $sql = "select id from users where email='$email'";    
        $op = mysqli_query($con,$sql);

        if(mysqli_num_rows(mysqli_query($con,$sql))>0){
            $errors['email'] = "Email :  Email already used";
        }



        if(!validate($password,1)){
            $errors['Password'] = "Password : Requierd Field";
          }elseif(!validate($password,5)){
              $errors['Password'] = "Password : Invalid Length , Length must Be >= 6 CH";
            }   


          if(!validate($phone,1)){
            $errors['phone'] = "Phone : Requierd Field";
           } elseif(!validate($phone,7)){
             $errors['Phone'] = "Invalid Phone Number";
          }    



    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{

      $password = md5($password);
     
      $sql = "insert into users (name,email,password,phone) values ('$name','$email','$password','$phone')";
      $op  = mysqli_query($con,$sql);

      if($op){
          $message = ["Data Inserted"];
      }else{
          $message = ["Error in sql OP Try Again"];
      }

        $_SESSION['Message'] = $message;


    }  



}
require './Admin/Layouts/header.php';
?>


<body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>

                     <?php 
                            printMessages();
                     ?>


                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" id="inputEmailAddress" name="email" type="email" placeholder="Enter email address" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" id="inputPassword"   name="password" type="password" placeholder="Enter password" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">phone</label>
                                                <input class="form-control py-4" name="phone" type="text" placeholder="Enter phone" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">name</label>
                                                <input class="form-control py-4"    name="name" type="text" placeholder="Enter name" />
                                            </div>
                                           
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <!-- <a class="small" href="password.html">Forgot Password?</a> -->
                                                <input type="submit" class="btn btn-primary"value="Login">
                                            </div>
                                        </form>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
          


<div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
