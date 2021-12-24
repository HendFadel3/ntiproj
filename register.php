<?php 

 require './Admin/helpers/dbConnection.php';
 require './Admin/helpers/functions.php';






if($_SERVER['REQUEST_METHOD'] == "POST"){

 // CODE ...... 
 $name     = Clean($_POST['name']);
 $email    = Clean($_POST['email']);
 $password = Clean($_POST['password']);
 $phone = Clean($_POST['phone']);



 # Validation ...... 
 $errors = [];

 # Validate Name 
 if(!validate($name,1)){
     $errors['Name'] = "Field Required";
 }


 # Validate Email 
 if(!validate($email,1)){
     $errors['Email'] = "Field Required";
 }elseif(!validate($email,2)){
    $errors['Email'] = "Invalid Email Format";
 }


  # Validate Password 
  if(!validate($password,1)){
     $errors['password'] = "Field Required";
 }elseif(!validate($password,3)){
    $errors['password'] = "Length Must >= 6 chs";
 }


 




  # Validate image 
  if(!validate($_FILES['image']['name'],1)){
     $errors['Image'] = "Field Required";
 }else{
     
$tmpPath    =  $_FILES['image']['tmp_name'];
$imageName  =  $_FILES['image']['name'];
$imageSize  =  $_FILES['image']['size'];
$imageType  =  $_FILES['image']['type'];

$exArray   = explode('.',$imageName);
$extension = end($exArray);

$FinalName = rand().time().'.'.$extension;

$allowedExtension = ["png",'jpg'];

    if(!validate($extension,5)){
      $errors['Image'] = "Error In Extension";
    }

 }

    if(count($errors) > 0){
        foreach ($errors as $key => $value) {
            # code...
            echo '* '.$key.' : '.$value.'<br>';
        }
    }else{

     // db .......... 

     $desPath = './uploads/'.$FinalName;

    if(move_uploaded_file($tmpPath,$desPath)){
    

     $password = md5($password);   // e10adc3949ba59abbe56e057f20f883e

     $sql = "insert into users (name,email,password,image,phone) values ('$name','$email','$password','$FinalName',$phone)";
     $op  = mysqli_query($con,$sql);

      if($op){
          echo 'Data Inserted';
      }else{
          echo 'Error Try Again'.mysqli_error($con);                      
      }
    }else{
    echo 'Error In Uploading file';
    }

    }






}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Register</h2>
 
 
  <form  action="<?php echo $_SERVER['PHP_SELF'];?>"   method="post"  enctype="multipart/form-data" >

  

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
    <label for="exampleInputPassword">Phone</label>
    <input type="text"   class="form-control" id="exampleInputPassword1" name="phone" placeholder="Password">
  </div>
  


  <div class="form-group">
    <label for="exampleInputPassword">Image</label>
    <input type="file"   name="image" >
  </div>

 
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

</body>
</html>