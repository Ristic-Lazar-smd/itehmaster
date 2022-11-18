<?php
require "../dbBroker1.php";
require "../model/knjiga.php";


$status = Knjiga::getZanrAll($conn);
while ($rowData= $status->fetch_array()) {
    echo $rowData[0];}
