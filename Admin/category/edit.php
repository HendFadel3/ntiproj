<?php

require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../checkLogin.php';


# Get Data related to id ...... 
$id = $_GET['id'];

$sql = "select * from category where id = $id";
$op   = mysqli_query($con,$sql);

  if(mysqli_num_rows($op) == 1){

     $data = mysqli_fetch_assoc($op);
  }else{

     $_SESSION['Message'] = "Access Denied";
     header("Location: ".url('category/index.php'));
  }






if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // CODE ......
    $category = Clean($_POST['category']);

    # Validation ......
    $errors = [];

    # Validate Name
    if (!validate($category, 1)) {
        $errors['category'] = 'Field Required';
    }

    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {
        // db ..........

        $sql = "update  category  set cat_nm = '$category' where id = $id";
        $op = mysqli_query($con, $sql);

        if ($op) {
            $_SESSION['Message'] = ['message' => 'Raw Updated'];

            header("Location: ".url('category/index.php'));
            exit();

        } else {
            $_SESSION['Message'] = ['message' => 'Error Try Again'];

        }

       
    }
}

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
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

                <li class="breadcrumb-item active">Dashboard/Edit category</li>

                <?php } ?>
            </ol>



            <div class="card-body">


                <div class="container">



                    <form action="edit.php?id=<?php echo $data['id']; ?>" method="post" enctype="multipart/form-data">



                        <div class="form-group">
                            <label for="exampleInputName">Category</label>
                            <input type="text" class="form-control" id="exampleInputName" name="category"
                                aria-describedby=""  value="<?php echo $data['cat_nm'];?>"  placeholder="Enter new category">
                        </div>



                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>







                </div>
            </div>


        </div>
    </main>


    <?php
    
    require '../layouts/footer.php';
    ?>
