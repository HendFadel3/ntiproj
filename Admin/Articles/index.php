<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../checkLogin.php';




# DB OP
$sql = 'select article.* , category.cat_nm as CatTitle  from article inner join category  on article.catt_id = category.id ';
$op = mysqli_query($con, $sql);



require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Admin</h1>
            <ol class="breadcrumb mb-4">
                <?php   
                if(isset($_SESSION['Message'])){
                              foreach($_SESSION['Message'] as $key => $val){
                              echo '* '.$key.' : '.$val;
                              }
                              unset($_SESSION['Message']); 
                          }else{
                          ?>
                <li class="breadcrumb-item active">Dashboard/Edit Articles</li>
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
                                    <th>Art Name</th>
                                    <th>Art Publisher</th>
                                    <th>Art Description</th>
                                    <th>Edition Year</th>
                                    <th>No.Pages</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Control</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Art Name</th>
                                    <th>Art Publisher</th>
                                    <th>Art Description</th>
                                    <th>Edition Year</th>
                                    <th>No.Pages</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Control</th>

                                </tr>
                            </tfoot>
                            <tbody>
                                <?php 
                                              while($data = mysqli_fetch_assoc($op)){
                                            
                                            ?><tr>
                                <td><?php echo $data['id']; ?></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['publisher']; ?></td>
                                    <td><?php echo $data['description']; ?></td>
                                    <td><?php echo $data['edition']; ?></td>
                                    <td><?php echo $data['page']; ?></td>
                                    <td><?php echo $data['price']; ?></td>
                                    <td><?php echo $data['CatTitle']; ?></td>
                                    <td><img src="./uploads/<?php echo $data['img']; ?>" width="45" height="45"> </td>
                                    <td>
                                        <a href='delete.php?id=<?php echo $data['id']; ?>'
                                            class='btn btn-danger m-r-1em'>Delete</a>
                                        <a href='edit.php?id=<?php echo $data['id']; ?>'
                                            class='btn btn-primary m-r-1em'>Edit</a><br></br>
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
