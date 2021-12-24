<?php 
/// delete ...... 
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../checkLogin.php';


$id = $_GET['id'];


if(!validate($id,4)){
    $message =  'Invalid Number';
}else{

   $sql = "select * from article where id = $id";
   $op   = mysqli_query($con,$sql);

     if(mysqli_num_rows($op) == 1){
   
 $data = mysqli_fetch_assoc($op);

   $sql = "delete from article where id = $id ";
   $op  = mysqli_query($con,$sql);


   if($op){
    
    unlink('./uploads/'.$data['image']); 

    $message = 'raw deleted';
   }else{
    $message = 'error Try Again !!!!!! ';
   }
}else{
    $message = 'Error In User Id ';
}

}

   $_SESSION['Message'] = ["Message" =>  $message];

   header("Location: ".url('Articles/index.php'));


?>