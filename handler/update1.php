<?php

require "../dbBroker1.php";
require "../model/knjiga.php";

if (isset($_POST['knjigaID']) && isset($_POST['nazivKnjiga']) && isset($_POST['pisac'])
    && isset($_POST['godinaPisanja']) && isset($_POST['zanr'])) {

    $status = Knjiga::update($_POST['knjigaID'], $_POST['nazivKnjiga'], $_POST['pisac'], $_POST['godinaPisanja'], $_POST['zanr'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}
?>