<?php
    require './Admin/helpers/dbConnection.php';
    require './Admin/helpers/helpers.php';
    require './Admin/helpers/checkLogin.php';



    # ID & Validate ...  
$_SESSION['del_falg'] = 0;

# GET data ... 

$id = sanitize($_GET['id'],1);

$Cource_id = sanitize($_GET['Cource_id'],1);

if (isset($_GET['Cource_id'])) {
    //$Cource_id = sanitize($_GET['Cource_id'],1);

    $sql = "insert into users_cources (user_id,cource_id,is_accepted) values ($id,$Cource_id,'no')";
      $op  = mysqli_query($con,$sql);

      if($op){
          $message = ["Data Inserted"];
      }else{
          $message = ["Error in sql OP Try Again"];
      }

        $_SESSION['Message'] = $message;
}

   
$error = [];
if(!validate($id,6)){
    $error['id'] = "Invalid Integar";
}
if(!validate($Cource_id,6)){
    $error['Cource_id'] = "Invalid Integar";
}
/*if(count($error) > 0){
    $_SESSION['Message'] = $error;
    $_SESSION['del_falg'] = 1;
    header("Location: index.php");
}*/
# Fetch User Data
$sql = "select *from users_cources where user_id=".$id.' and is_accepted="yes"';

$op  = mysqli_query($con,$sql);
//$data = mysqli_fetch_assoc($op);



if(mysqli_num_rows($op) == 0){
    $_SESSION['Message'] = ["No data For this Id"];
    $_SESSION['del_falg'] = 1;
    header("Location: cources.php");
}

$sql="select users_cources.*,users.name as username,cources.name as courcename,cources.image,cources.price,cources.description,cources.quiz_id as quiz_id from users_cources join users on users.id = users_cources.user_id join cources on cources.id = users_cources.cource_id where users_cources.user_id =".$id.' and is_accepted="yes"';
$op2  = mysqli_query($con,$sql);
/*$data = mysqli_fetch_assoc($op2);
print_r($data);
exit();*/

   // $sql = "select * from cources";
//$op = mysqli_query($con,$sql);

//$_SESSION['user'] = mysqli_fetch_assoc($op);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Mentor Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Mentor - v4.5.0
  * Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.html">Mentor</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="active" href="cources.php">Home</a></li>
          <li><a href="profile.php?id=<?php echo $_SESSION['user']['id']?>">Profile</a></li>
          <li><a href="logout.php">Logout</a></li>
          

         
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="courses.html" class="get-started-btn">Get Started</a>

    </div>
  </header><!-- End Header -->

 
  <main id="main">

    

    <!-- ======= Popular Courses Section ======= -->
    <section id="popular-courses" class="courses">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
            <p>Courses</p>
          <h2>Courses</h2>
        </div>

        <div class="row" data-aos="zoom-in" data-aos-delay="100">

        <?php
            $Cources_id=[]; 

            while ($data = mysqli_fetch_assoc($op2)){
                
                $Cources_id[]= $data['cource_id'];
                //print_r ($Cources_id);
                  //$Cources_id[]=$data['cource_id'];
                 // print_r($Cources_id);
                 //exit();
        ?>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="course-item">
              <img src="./Admin/Cources/uploads/<?php echo $data['image'];?>" class="img-fluid" alt="...">
              <div class="course-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h4><?php echo $data['courcename'];?></h4>
                  <p class="price"><?php echo $data['price'];?></p>
                </div>

                <h3><a href="course-details.html">Website Design</a></h3>
                <p><?php echo $data['description'];?></p>

                <h2 style="background-color: #5fcf80;width: 216px">
                  <a style="color:#262826" href="quiz.php?cource_id=<?php echo $data['cource_id'];?>">Quiz</a>
                </h2>

               
                
               
              </div>
            </div>
          </div> <!-- End Course Item-->

          <?php } ?>
                

         

        

        </div>
        <?php
          echo "---------------";
          //print_r ($Cources_id);
       //  foreach ($Cources_id as $key => $value) {
              
         // echo $value;
        // SELECT * FROM `Table` WHERE id IN ($Cources_id)
        // $sqls = "select *from lessons where cource_id=".$Cources_id;
          //  $sqls = "select *from lessons where cource_id IN (" .$value. ")";
          //$sqls = "select *from lessons where cource_id IN (1,2,3)";
         //$sql22= "select * from table where id in (1, 4, 6, 7)";
        // $sql22= "SELECT * FROM lessons WHERE id IN (" . $Cources_id . ")";
        // $sql2 = 'SELECT  FROM  WHERE cource_id IN (' . implode(",", $Cources_id) . ')';
        // $sqlr = 'SELECT * FROM lessons WHERE cource_id IN (' . implode(",", $Cources_id) . ')';
        // $sql2 = 'SELECT * FROM lessons WHERE cource_id IN (' . implode(",", $Cources_id) . ')';
       // $sqlrs = 'SELECT * FROM lessons WHERE cource_id IN (8)';

   
        $sql2 = 'SELECT * FROM lessons WHERE cource_id IN (' . implode(",", $Cources_id) . ')';
            $op3  = mysqli_query($con,$sql2);



            $Lessons_id=[];

            while($data_lesson = mysqli_fetch_assoc($op3)){

                $Lessons_id[]= $data_lesson['id'];
            //    print_r($data_lesson);
                echo '<br>';
                

                //print_r($Lessons_id);

            }

            $sql3 = 'SELECT * FROM matrials WHERE lesson_id IN (' . implode(",", $Lessons_id) . ')';
            $op4  = mysqli_query($con,$sql3);

            

            //$data_matrials = mysqli_fetch_assoc($op4);
            $Matrials_id=[];
            while($data_matrials = mysqli_fetch_assoc($op4)){

                //print_r($data_matrials);
                $Matrials_id[]= $data_matrials['id'];

                //print_r($Lessons_id);

            }
          /*  $sql5="select matrials.*,lessons.title from matrials 
            join lessons on matrials.lesson_id= lessons.id where matrials.id in (3,4,5,6)
            ";*/
            $sql5='select matrials.*,lessons.title from matrials 
            join lessons on matrials.lesson_id= lessons.id where matrials.id IN (' . implode(",", $Matrials_id) . ')';
            
            $op5  = mysqli_query($con,$sql5);

              
            
            ?>

            <div class="row" data-aos="zoom-in" data-aos-delay="100">
           <?php  while($Data_Matrial =mysqli_fetch_assoc($op5)){ 

             ?>

            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="course-item">
            <h4 style="background-color: #5fcf80;"><?php echo $Data_Matrial['name'];?></h4>
                <video width="220" height="140" controls>
                    <source src="./Admin/Matrials/uploads/<?php echo $Data_Matrial['videos'];?>">
                </video>
              <div class="course-content">
                <div class="">
                  <p class="price"><?php echo $Data_Matrial['title'];?></p>
                </div>

                
               
              </div>
            </div>
          </div>
          
           <?php } ?>

         
      </div>
    </section><!-- End Popular Courses Section -->

    

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>Mentor</h3>
            <p>
              A108 Adam Street <br>
              New York, NY 535022<br>
              United States <br><br>
              <strong>Phone:</strong> +1 5589 55488 55<br>
              <strong>Email:</strong> info@example.com<br>
            </p>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Join Our Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>Mentor</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/ -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/purecounter/purecounter.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>