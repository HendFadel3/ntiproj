<?php 
    
   
    if(!isset($_SESSION['user'])){
        header("Location: ".url('logout.php'));
    }


   

?>