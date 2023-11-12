<?php
    function evennumber($a){        
        if($a%2==0){
            echo "{$a}";
            echo "\n";    
        }
        if($a%2==1){
            echo "{$a}"+1;    
            echo "\n";
        }  
    }
   evennumber(1);
   evennumber(3);
   evennumber(4);
?>
