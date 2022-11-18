<?php

require "../dbBroker1.php";
require "../model/knjiga.php";

if(isset($_POST['knjigaID'])) {
    $myArray = Knjiga::getById($_POST['knjigaID'], $conn);
    echo json_encode($myArray);
}
?>