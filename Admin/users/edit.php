<?php

require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../checkLogin.php';


# Get Data related to id ...... 
$id = $_GET['id'];

$sql = "select * from users where id = $id";
$op   = mysqli_query($con,$sql);

  if(mysqli_num_rows($op) == 1){

     $data = mysqli_fetch_assoc($op);
  }else{

     $_SESSION['Message'] = "Access Denied";
     header("Location: ".url('users/index.php'));
  }






if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // CODE ......
    $name     = Clean($_POST['name']);
    $email    = Clean($_POST['email']);
    $phone    = Clean($_POST['phone']);

    # Validation ...... 
$errors = [];

 # Validation ......
 $errors = [];
 # Validate Name
 if (!validate($name, 1)) {
     $errors['Name'] = 'Field Required';
 } elseif (!validate($name, 7)) {
     $errors['Name'] = 'Invalid String';
 }

 # Validate Email
 if (!validate($email, 1)) {
     $errors['Email'] = 'Field Required';
 } elseif (!validate($email, 2)) {
     $errors['Email'] = 'Invalid Email Format';
 }
# Validate phone
if (!validate($phone, 1)) {
    $errors['phone'] = 'Field Required';
} elseif (!validate($phone, 6)) {
    $errors['phone'] = 'Invalid Phone Number';
}


  


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
    

    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        // old Image
        $OldImage = $data['image'];

        if (validate($_FILES['image']['name'], 1)) {
            $desPath = './uploads/' . $FinalName;

            if (move_uploaded_file($tmpPath, $desPath)) {
                unlink('./uploads/' . $OldImage);
            }
        } else {
            $FinalName = $OldImage;
        }
        $password = md5($password);

        $sql = "update users set name = '$name' , email = '$email' , phone = '$phone',image = '$FinalName' where id = $id";
        $op = mysqli_query($con, $sql);

        if ($op) {
            $_SESSION['Message'] = ['message' => 'Raw Updated'];

            header('Location: ' . url('users/index.php'));
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

                <li class="breadcrumb-item active">Dashboard/Edit USERS</li>

                <?php } ?>
            </ol>



            <div class="card-body">


                <div class="container">



                    <form action="edit.php?id=<?php echo $data['id']; ?>" method="post" enctype="multipart/form-data">


 
                        
                        <div class="form-group">
   <label for="exampleInputName">Name</label>
   <input type="text" class="form-control" id="exampleInputName"  name="name"  value="<?php echo $data['name'];?>" aria-describedby="" placeholder="Enter Name">
 </div>

 

 <div class="form-group">
   <label for="exampleInputEmail">Email address</label>
   <input type="email"   class="form-control" id="exampleInputEmail1" name="email" value="<?php echo $data['email'];?>"  aria-describedby="emailHelp" placeholder="Enter email">
 </div>

 

 <div class="form-group">
   <label for="exampleInputEmail">phone</label>
   <input type="text"   class="form-control" id="exampleInputEmail1" name="phone" value="<?php echo $data['phone'];?>"  aria-describedby="emailHelp" placeholder="Enter email">
 </div>


 <div class="form-group">
                            <label for="exampleInputPassword">Image</label><br>
                            <input type="file" name="image">
                        </div>

                        <img src="./uploads/<?php echo $data['image']; ?>" height="80" width="80"><br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>







                </div>
            </div>


        </div>
    </main>


    <?php
    
    require '../layouts/footer.php';
    ?>
