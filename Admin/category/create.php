
 <?php 

 require '../helpers/dbConnection.php';
 require '../helpers/functions.php';
 require '../checkLogin.php';


 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // CODE ......
    $category = Clean($_POST['category']);
    # Validation ......
    $errors = [];
    # Validate Name
    if (!validate($category, 1)) {
        $errors['Title'] = 'Field Required';
    }
    if (count($errors) > 0) {
      
        $_SESSION['Message']  = $errors;

    } else {
        // db ..........

       $sql = "insert into category (cat_nm) values ('$category')";
       $op  = mysqli_query($con,$sql);

       if($op){
           $message = "Raw Inserted";
       }else{
           $message = "Error Try Again";
       }

        $_SESSION['Message'] =  ["message" => $message];

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

                           <li class="breadcrumb-item active">Dashboard/Add Category</li>
                       
                       <?php } ?>
                        </ol>
                           <div class="card-body">
                            <div class="container">
                                <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label for="exampleInputName">Category</label>
                                        <input type="text" class="form-control" id="exampleInputName" name="category" aria-describedby=""
                                            placeholder="Enter category">
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