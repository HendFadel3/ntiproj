<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../checkLogin.php';






require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';



$sql = "select * from users ";

$op  = mysqli_query($con,$sql);
?>



<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">




            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">

                <?php 
                            
                            if(isset($_SESSION['Message'])){
                              foreach($_SESSION['Message'] as $key => $val){
                              echo '* '.$key.' : '.$val;
                              }
                              unset($_SESSION['Message']); 
                          }else{
                          
                          ?>

                <li class="breadcrumb-item active">Dashboard/Edit Users</li>

                <?php } ?>
            </ol>


            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    DataTable Example
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>phone</th>
                                    <th>Image</th>


                                    <th>Control</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>phone</th>

                                    <th>Image</th>

                                    <th>Control</th>
                                </tr>
                            </tfoot>
                            <tbody>

                                <?php 
                                            
                                              while($data = mysqli_fetch_assoc($op)){
                                            
                                            ?>
                                <tr>
                                    <td><?php echo $data['id']; ?></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['email']; ?></td>
                                    <td><?php echo $data['phone']; ?></td>
                                    <td><img src="./uploads/<?php echo $data['image']; ?>" width="45" height="45"> </td>

                                    <td>
                                        <a href='delete.php?id=<?php echo $data['id']; ?>'
                                            class='btn btn-danger m-r-1em'>Delete</a>
                                        <a href='edit.php?id=<?php echo $data['id']; ?>'
                                            class='btn btn-primary m-r-1em'>Edit</a>
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
    
    require '../layouts/footer.php';
    ?>
