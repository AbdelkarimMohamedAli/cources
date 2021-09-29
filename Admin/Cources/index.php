<?php 

require '../helpers/dbConnection.php';
require '../helpers/helpers.php';
require '../helpers/checkAdmin.php';
//require '../helpers/checkLogin.php';


# Fetch Roles ... 
$sql = "select cources.*,quizes.name as quizname from cources join quizes on quizes.id = cources.quiz_id";
$op  = mysqli_query($con,$sql);




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
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                                                     
                     <?php 
                            printMessages('Display Cources');
                     ?>
                    </ol>
                      
   

                        <div class="card mb-4">
                           
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Id</th>
                                                <th>name</th>
                                                <th>image</th>
                                                <th>price</th>
                                                <th>description</th>
                                                <th>quiz</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Id</th>
                                                <th>name</th>
                                                <th>image</th>
                                                <th>price</th>
                                                <th>description</th>
                                                <th>quiz</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     
                                 <?php 
                                    $i = 0;
                                    while($data = mysqli_fetch_assoc($op)){
                                 ?>       
                                        <tr>
                                            <td><?php echo ++$i;?></td>
                                            <td><?php echo $data['id'];?></td>
                                            <td><?php echo $data['name'];?></td>
                                            <td>
                                                <img src="./uploads/<?php echo $data['image'];?>" width="100" height="100">
                                            </td>
                                            <td><?php echo $data['price'];?></td>
                                            <td><?php echo $data['description'];?></td>
                                            <td><?php echo $data['quizname'];?></td>
                                            <td>
                                               <a href='delete.php?id=<?php echo $data['id'];?>' class='btn btn-danger m-r-1em'>Delete</a>
                                               <a href='edit.php?id=<?php echo $data['id'];?>' class='btn btn-primary m-r-1em'>Edit</a>
                                           </td> 
                                                                                      
                                        </tr>
                                <?php } ?>        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                



<?php 
  
  require '../Layouts/footer.php';

?>