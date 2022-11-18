<?php
require "../dbBroker1.php";
require  "../model/knjiga.php";

if(isset($_POST['knjigaID'])){
    
    $status = Knjiga::deleteById($_POST['knjigaID'], $conn);
    if($status){
        echo 'Success';
    }else{
        echo 'Failed';
    }
}
