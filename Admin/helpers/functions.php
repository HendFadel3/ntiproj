<?php 


function Clean($input){

     return   strip_tags(trim($input));
}



function validate($input,$flag){

     $status = true;
    switch ($flag) {
        case 1:
            # code...
              if(empty($input)){
                  $status = false;
              }
            break;
        
        case 2: 
        # code ... 
        if(!filter_var($input,FILTER_VALIDATE_EMAIL)){
            $status = false;
        }
        break;


        case 3:
        # code ... 
        if(strlen($input) < 6){
            $status = false; 
        }
        break;
  

        case 4: 
        # code ... 
        if(!filter_var($input,FILTER_VALIDATE_INT)){
            $status = false;
        }
        break;

       case 5: 
       #code .... 
       $allowedExtension = ["png",'jpg'];
       if(!in_array($input,$allowedExtension)){
           $status = false;
       }
       break;
       case 6: 
        #code .... 
        $allowedExtension2 = ["pdf"];
        if(!in_array($input,$allowedExtension2)){
            $status = false;
        }
        break;
        case 7 : 
            # code ..... 
            if(!preg_match('/^01[0-2,5][0-9]{8}$/',$input)){
                $status = false;
            }
            break;
       
    }

    return $status ; 
}





function url($url){

 return   "http://".$_SERVER['HTTP_HOST']."/artp/Admin/".$url;

}

?>