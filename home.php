<?php

require "dbBroker1.php";
require "model/knjiga.php";
session_start();
if (empty($_SESSION['loggeduser']) || $_SESSION['loggeduser'] == '') {
    header("Location: index.php");
    die();
}


$result = Knjiga::getAll($conn);
if (!$result) {
    echo "Greska kod upita<br>";
    die();
}
if ($result->num_rows == 0) {
    echo "Nema knjiga";
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="icon" href="image/boy.png" />
    <link rel="stylesheet" href="css/home.css">
    <title>Laguna</title>
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <div class="jumbotron text-center" style=" background-color: rgba(255, 182, 193, 0);">
        <div class="container">
            <h1 style="color:darkred">Prodavnica knjiga</h1>
        </div>
    </div>

    <div class="col-md-8" style="text-align:center; width:66.6%;float:left">
        <div id="pregled">
            <table id="tabela" class="table sortable table-bordered table-hover ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Naziv knjige</th>
                        <th scope="col">Pisac</th>
                        <th scope="col">Godina pisanja</th>
                        <th scope="col">Zanr</th>
                        <th scope="col">Izaberi knjigu</th>
                        <th scope="col"><?php ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($red = $result->fetch_array()) {
                        $test = Knjiga::getZanrById($red["zanr"],$conn);
                        $row = mysqli_fetch_array($test);
                        
                    ?>
                    
                        <tr id="tr-<?php echo $red["knjigaID"] ?>">
                            <td><?php echo $red["knjigaID"] ?></td>
                            <td><?php echo $red["nazivKnjiga"] ?></td>
                            <td><?php echo $red["pisac"] ?></td>
                            <td><?php echo $red["godinaPisanja"] ?></td>
                            <td><?php echo $row[1] ?></td>
                            <td>
                                <label class="radio-btn">
                                    <input type="radio" name="checked-donut" value=<?php echo $red["knjigaID"] ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div>




            </div>
        </div>
    </div>
    
<!--  DUGMICI -->
    <div class="col-md-4" style="display: block; background-color: rgba(255, 255, 255, 0.4);">
        <div class="menilr" style="text-align:center;">
            <h3>Pretraga knjiga</h3>
            <input type="text" id="myInput" class="btn" placeholder="Pretrazi knjige" onkeyup="pretrazi()">
        </div>
        <div class="menilr" style="text-align:center; ">
            <h3>Dodaj novu knjigu</h3>
            <button id="btn-dodaj" class="btn" data-toggle="modal" data-target="#myModal"><img src="image/add.png" style="width: 25px;height: 25px;"></button>
        </div>
        <div class="menilr" style="text-align:center;">
            <h3>Izmeni knjigu</h3>
            <button id="btn-izmeni" class="btn" data-toggle="modal" data-target="#izmeniModal"><img src="image/edit.png" style="width: 25px;height: 25px;"></button>
        </div>
        <div class="menilr" style="text-align:center;">
            <h3>Izbrisi knjigu</h3>
            <button id="btn-izbrisi" class="btn"><img src="image/delete.png" style="width: 25px;height: 25px;"></button>
        </div>
        <div class="menilr" style="text-align:center;">
            <h3>Sortiraj po imenu</h3>
            <button id="btnIzmeni" class="btn" onclick="sortTable()"><img src="image/sort.png" style="width: 25px;height: 25px;"></button>
        </div>
        <br>



    </div>


<!-- MODALI -->
    <br>
    <a href="logout.php" class="label label-primary" style="font-size:16px; position: fixed; bottom:0; right:0; float:right">Logout</a>
    <!-- DODAJ KNJIGU -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!--Sadrzaj modala-->
            <div class="modal-content" style="border: 4px solid green;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container knjiga-form">
                        <form action="#" method="post" id="dodajForm">
                            <h3 id="naslov" style="color: black" text-align="center">Dodavanje knjige</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" style="border: 1px solid black" name="nazivKnjiga" class="form-control" placeholder="Naziv knjige *" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" style="border: 1px solid black" name="pisac" class="form-control" placeholder="Pisac  *" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input type="date" style="border: 1px solid black" name="godinaPisanja" class="form-control" placeholder="Godina pisanja *" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" style="border: 1px solid black" name="zanr" class="form-control" placeholder="zanr *" value="" />  
                                    </div>
                                    <div class="form-group">
                                        <button id="btnDodaj" type="submit" class="btn btn-success btn-block" style="background-color: orange; border: 1px solid black;"><i class="glyphicon glyphicon-plus"></i> Dodaj knjigu
                                        </button>
                                    </div>

                                </div>


                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="color: white; background-color: orange; border: 1px solid white" data-dismiss="modal">Zatvori</button>
                </div>
            </div>

        </div>
    </div>

<!-- IZMENI KNJIGU -->
    <div class="modal fade" id="izmeniModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal sadrzaj-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container knjiga-form">
                        <form action="#" method="post" id="izmeniForm">
                            <h3 style="color: red">Izmeni knjigu</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="idd" type="text" name="knjigaID" class="form-control" placeholder="Id knjige *" value="" readonly />
                                    </div>
                                    <div class="form-group">
                                        <input id="nazivv" type="text" name="nazivKnjiga" class="form-control" placeholder="Naziv knjige *" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input id="pisacc" type="text" name="pisac" class="form-control" placeholder="Pisac *" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input id="godinaa" type="date" name="godinaPisanja" class="form-control" placeholder="Godina pisanja *" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input id="zanrr" type="text" name="zanr" class="form-control" placeholder="Zanr*" value="" />
                                    </div>
                                    <div class="form-group">
                                        <button id="btn-izmeni" type="submit" class="btn btn-success btn-block" data-toggle="modal" style="color: white; background-color: orange; border: 1px solid white"><i class="glyphicon glyphicon-pencil"></i> Izmeni knjigu
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
                </div>
            </div>

        </div>
    </div>
<!-- Legenda -->
<?php
$pdo = new PDO('mysql:host=localhost;dbname=knjizara', 'root', '');
$sql = "SELECT zanrID, zanrName FROM zanrknjiga";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll();
?>
<table class="table sortable table-bordered table-hover legenda"> 
<tr class="header">
                <td>Zanr</td>
                <td>Id</td>
</tr>
<?php foreach($books as $book): ?>
        <tr>
        <td><?= $book['zanrName']; ?></td>
        <td><?= $book['zanrID']; ?></td>
        </tr>
        <?php endforeach; ?>
</table>
<!-- Legenda end -->
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    <script src="js/main.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        function pretrazi() {

            var input, filter, table, tr, i, td1, td2, td3, td4, txtValue1, txtValue2, txtValue3, txtValue4;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("tabela");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td1 = tr[i].getElementsByTagName("td")[1];
                td2 = tr[i].getElementsByTagName("td")[2];
                td3 = tr[i].getElementsByTagName("td")[3];
                td4 = tr[i].getElementsByTagName("td")[4];

                if (td1 || td2 || td3 || td4) {
                    txtValue1 = td1.textContent || td1.innerText;
                    txtValue2 = td2.textContent || td2.innerText;
                    txtValue3 = td3.textContent || td3.innerText;
                    txtValue4 = td4.textContent || td4.innerText;

                    if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1 ||
                        txtValue3.toUpperCase().indexOf(filter) > -1 || txtValue4.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function sortTable() {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("tabela");
            switching = true;
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[1];
                    y = rows[i + 1].getElementsByTagName("TD")[1];
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }
    </script>
</body>

</html>