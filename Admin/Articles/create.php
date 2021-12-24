<?php

require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../checkLogin.php';


# Fetch Roles .....
$sql = 'select * from category';
$categories = mysqli_query($con, $sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // CODE ......
    $name   = Clean($_POST['name']);
    $description = Clean($_POST['description']);
    $publisher    = Clean($_POST['publisher']);
    $edition = Clean($_POST['edition']);
    $page    = Clean($_POST['page']);
    $price = Clean($_POST['price']);
    $cat_id  = $_POST['catt_id'];

    # Validation ......
    $errors = [];

    # Validate Name
    if (!validate($name, 1)) {
        $errors['Title'] = 'Field Required';
    } 

    # Validate Email
      if (!validate($description, 1)) {
        $errors['Content'] = 'Field Required'; }  
      if (!validate($publisher, 1)) {
      $errors['Content'] = 'Field Required';}  
       if (!validate($edition, 1)) {
       $errors['Title'] = 'Field Required';} 
       if (!validate($page, 1)) {
       $errors['Title'] = 'Field Required'; } 
       if (!validate($price, 1)) {
          $errors['Title'] = 'Field Required';} 

   

    
    # Validate image
    if (!validate($_FILES['image']['name'], 1)) {
        $errors['Image'] = 'Field Required';
    } else {
        $tmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageType = $_FILES['image']['type'];
        $exArray = explode('.', $imageName);
        $extension = end($exArray);
        $FinalName = rand() . time() . '.' . $extension;
        $allowedExtension = ['png', 'jpg'];
        if (!validate($extension, 5)) {
            $errors['Image'] = 'Error In Extension';}
    }
    # Validate pdf
    if (!validate($_FILES['pdf']['name'], 1)) {
        $errors['pdf'] = 'Field Required';
    } else {
        $tmpPath2 = $_FILES['pdf']['tmp_name'];
        $pdfName = $_FILES['pdf']['name'];
        $pdfSize = $_FILES['pdf']['size'];
        $pdfType = $_FILES['pdf']['type'];
        $exArray2 = explode('.', $pdfName);
        $extension2 = end($exArray2);
        $FinalName2 = rand() . time() . '.' . $extension2;
        $allowedExtension2 = ['pdf'];
        if (!validate($extension2, 6)) {
            $errors['pdf'] = 'Error In Extension';}
    }

    if (count($errors) > 0) {
         $_SESSION['Message'] = $errors;}
        //  else {
        $desPath = './uploads/' . $FinalName;
        $desPath2 = './uploads/' . $FinalName2;

        if (move_uploaded_file($tmpPath, $desPath) & move_uploaded_file($tmpPath2, $desPath2)) {

          
            $sql  = "insert into article (name,description,publisher,edition,page,price,catt_id,img,pdf) values ('$name','$description','$publisher',$edition,$page,$price,$cat_id,'$FinalName','$FinalName2')";
            $op = mysqli_query($con, $sql);

            if ($op) {
                $message = 'Raw Inserted';
            } else {
                $message = 'Error Try Again';
            }
        } else {
            $message = 'Error In Uploading file';
        }

        $_SESSION['Message'] = ['message' => $message];
    
}
// print_r($_POST);
// exit();

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
                                echo '* '.$key.' : '.$val.'<br>';
                                }
                                unset($_SESSION['Message']); 
                            }else{
                            
                            ?>

                <li class="breadcrumb-item active">Dashboard/Add User</li>

                <?php } ?>
            </ol>






            <div class="card-body">


                <div class="container">



                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">



                        <div class="form-group">
                            <label for="exampleInputName">ArticleName</label>
                            <input type="text" class="form-control" id="exampleInputName" name="name"
                                aria-describedby="" placeholder="Enter Name">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail">ArticleDescription</label>
                            <textarea type="text" class="form-control"  name="description" placeholder="Enter description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName">ArticlePublisher</label>
                            <input type="text" class="form-control" id="exampleInputName" name="publisher"
                                aria-describedby="" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName">EditionYear</label>
                            <input type="text" class="form-control" id="exampleInputName" name="edition"
                                aria-describedby="" placeholder="Enter year">
                        </div>



                        <div class="form-group">
                            <label for="exampleInputName">ArticleNoOfPages</label>
                            <input type="text" class="form-control" id="exampleInputName" name="page"
                                aria-describedby="" placeholder="Enter pag">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName">ArticlePrice</label>
                            <input type="text" class="form-control" id="exampleInputName" name="price"
                                aria-describedby="" placeholder="Enter price">
                        </div>






                        <div class="form-group">
                            <label for="exampleInputPassword">Category</label>

                            <select class="form-control" name="catt_id">
                                <?php
                                while($data = mysqli_fetch_assoc($categories)){
                                ?>
                                <option value="<?php echo $data['id']; ?>"><?php echo $data['cat_nm']; ?></option>
                                <?php } ?> ?>
                            </select>
                        </div>



                        <div class="form-group">
                            <label for="exampleInputPassword">Image</label><br>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword">pdf</label><br>
                            <input type="file" name="pdf">
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