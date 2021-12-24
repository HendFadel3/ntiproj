
 <?php 

require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../checkLogin.php';


// $sql = "select * from departments";
// $op  = mysqli_query($con,$sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = Clean($_POST['name']);
    $email = Clean($_POST['email']);
    $password = Clean($_POST['password']);
    $phone = Clean($_POST['phone']);

    # Validation ......
    $errors = [];

    # Validate Name
    if (!validate($name, 1)) {
        $errors['Name'] = 'Field Required';
    } elseif (!validate($name, 3)) {
        $errors['Name'] = 'Invalid String';
    }

    # Validate Email
    if (!validate($email, 1)) {
        $errors['Email'] = 'Field Required';
    } elseif (!validate($email, 2)) {
        $errors['Email'] = 'Invalid Email Format';
    }

    # Validate Password
    if (!validate($password, 1)) {
        $errors['password'] = 'Field Required';
    } elseif (!validate($password, 3)) {
        $errors['password'] = 'Length Must >= 6 chs';
    }

    

    # Validate phone
    if (!validate($phone, 1)) {
        $errors['phone'] = 'Field Required';
    } elseif (!validate($phone, 7)) {
        $errors['phone'] = 'Invalid Phone Number';
    }

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
            $errors['Image'] = 'Error In Extension';
        }
    }

    

    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {
        $desPath = './uploads/' . $FinalName;

        if (move_uploaded_file($tmpPath, $desPath)) {
            $password = md5($password);
        

            $sql = "insert into users (name,email,password,phone,image) values ('$name','$email','$password','$phone','$FinalName')";
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

                          <li class="breadcrumb-item active">Dashboard/Add USER</li>
                      
                      <?php } ?>
                       </ol>

               
                
                
                   
                         
                          <div class="card-body">
                        

                           <div class="container">
                              
                       
                       
                               <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                       
                       
                       
                                   
                       
                                   <div class="form-group">
    <label for="exampleInputName">Name</label>
    <input type="text" class="form-control" id="exampleInputName"  name="name" aria-describedby="" placeholder="Enter Name">
  </div>


  <div class="form-group">
    <label for="exampleInputEmail">Email address</label>
    <input type="email"   class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword">New Password</label>
    <input type="password"   class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
  </div>



  <div class="form-group">
    <label for="exampleInputName">phone</label>
    <input type="text" class="form-control" id="exampleInputName"  name="phone" aria-describedby="" placeholder="Enter Name">
  </div>


  <div class="form-group">
                            <label for="exampleInputPassword">Image</label><br>
                            <input type="file" name="image">
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