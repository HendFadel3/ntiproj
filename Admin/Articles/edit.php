<?php

require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../checkLogin.php';


# Get Data related to id ...... 
$id = $_GET['id'];

$sql = "select * from article where id = $id";
$op   = mysqli_query($con,$sql);

  if(mysqli_num_rows($op) == 1){

     $data = mysqli_fetch_assoc($op);
  }else{

    $_SESSION['Message'] = ['Message' => 'Access Denied'];
     header("Location: ".url('Articles/index.php'));
  }



  $sql = 'select * from category';
  $catData = mysqli_query($con, $sql);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    if (validate($_FILES['image']['name'], 1)) {
        $tmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageType = $_FILES['image']['type'];

        $exArray = explode('.', $imageName);
        $extension = end($exArray);

        $FinalName = rand() . time() . '.' . $extension;

        $allowedExtension = ['png', 'jpg'];

        if (!validate($extension, 5)) {
            $errors['Image'] = 'Error In Extension';
        }
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
        $_SESSION['Message'] = $errors;
    } else {
        // db ..........
        $OldImage = $data['image'];
        $Oldpdf = $data['pdf'];

        if (validate($_FILES['image']['name'], 1)  & validate($_FILES['pdf']['name'], 1)) {
            $desPath = './uploads/' . $FinalName;
            $desPath2 = './uploads/' . $FinalName2;


            if (move_uploaded_file($tmpPath, $desPath) & move_uploaded_file($tmpPath2, $desPath2)) {
                unlink('./uploads/' . $OldImage);
                unlink('./uploads/' . $Oldpdf);

            }
        } else {
            $FinalName = $OldImage;
            $FinalName2 = $Oldpdf;

        }
        $sql = "update article set name = '$name' , description='$description' , publisher='$publisher', edition =$edition ,  page =$page , price=$price ,catt_id = $cat_id , img ='$FinalName', pdf='$FinalName2' where id = $id";
        $op = mysqli_query($con, $sql);

        if ($op) {
            $_SESSION['Message'] = ['message' => 'Raw Updated'];

            header("Location: ".url('articles/index.php'));
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

                <li class="breadcrumb-item active">Dashboard/Edit Articles</li>

                <?php } ?>
            </ol>



            <div class="card-body">


                <div class="container">



                <form action="edit.php?id=<?php echo $data['id']; ?>"  method="post" enctype="multipart/form-data">



<div class="form-group">
    <label for="exampleInputName">ArticleName</label>
    <input type="text" class="form-control" id="exampleInputName" name="name" value="<?php echo $data['name'];?>"
        aria-describedby="" placeholder="Enter Name">
</div>


<div class="form-group">
    <label for="exampleInputEmail">ArticleDescription</label>
    <textarea type="text" class="form-control"  name="description" value="<?php echo $data['description'];?>" placeholder="Enter description"></textarea>
</div>
<div class="form-group">
    <label for="exampleInputName">ArticlePublisher</label>
    <input type="text" class="form-control" id="exampleInputName" name="publisher" value="<?php echo $data['publisher'];?>"
        aria-describedby="" placeholder="Enter name">
</div>
<div class="form-group">
    <label for="exampleInputName">EditionYear</label>
    <input type="text" class="form-control" id="exampleInputName" name="edition" value="<?php echo $data['edition'];?>"
        aria-describedby="" placeholder="Enter year">
</div>



<div class="form-group">
    <label for="exampleInputName">ArticleNoOfPages</label>
    <input type="text" class="form-control" id="exampleInputName" name="page" value="<?php echo $data['page'];?>"
        aria-describedby="" placeholder="Enter pag">
</div>
<div class="form-group">
    <label for="exampleInputName">ArticlePrice</label>
    <input type="text" class="form-control" id="exampleInputName" name="price" value="<?php echo $data['price'];?>"
        aria-describedby="" placeholder="Enter price">
</div>






<div class="form-group">
    <label for="exampleInputPassword">Category</label>

    <select class="form-control" name="catt_id">
        <?php
        while($catdetails = mysqli_fetch_assoc($catData)){
        ?>
        <option value="<?php echo $catdetails['id']; ?>"
        <?php if($data['catt_id']==$catdetails['id']){echo 'selected';} ?>>
        <?php echo $catdetails['cat_nm']; ?>
    </option>
        <?php } ?> 
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
