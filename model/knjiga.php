<?php

class Knjiga
{
    public $knjigaID;
    public $nazivKnjiga;
    public $pisac;
    public $godinaPisanja;
    public $zanr;

    public function __construct($knjigaID = null, $nazivKnjiga = null, $pisac = null, $godinaPisanja = null, $zanr = null)
    {
        $this->knjigaID = $knjigaID;
        $this->nazivKnjiga = $nazivKnjiga;
        $this->pisac = $pisac;
        $this->godinaPisanja = $godinaPisanja;
        $this->zanr = $zanr;
    }

    public static function getAll(mysqli $conn)
    {
        $q = "SELECT * FROM knjiga";
        return $conn->query($q);
    }
    public static function deleteById($knjigaID, mysqli $conn)
    {
        $q = "DELETE FROM knjiga WHERE knjigaID=$knjigaID";
        return $conn->query($q);
    }

    public static function add($nazivKnjiga, $pisac, $godinaPisanja, $zanr, mysqli $conn)
    {

        $q = "INSERT INTO knjiga(nazivKnjiga, pisac, godinaPisanja, zanr) values('$nazivKnjiga', '$pisac', '$godinaPisanja',  '$zanr')";
        return $conn->query($q);
    }


    public static function update($knjigaID, $nazivKnjiga, $pisac, $godinaPisanja, $zanr, mysqli $conn)
    {
        $q = "UPDATE knjiga set nazivKnjiga='$nazivKnjiga', pisac='$pisac', godinaPisanja='$godinaPisanja', zanr='$zanr' where knjigaID=$knjigaID";
        return $conn->query($q);
    }

    public static function getById($knjigaID, mysqli $conn)
    {
        $q = "SELECT * FROM knjiga WHERE knjigaID=$knjigaID";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public static function getZanrById($zanr, mysqli $conn)
    {
        $q = "SELECT * FROM zanrknjiga WHERE zanrID=$zanr";
        return $conn->query($q);
    }

    public static function getZanrAll($zanr, mysqli $conn)
    {
        $q = "SELECT * FROM zanrknjiga";
        return $conn->query($q);
    }


    public static function getLast(mysqli $conn)
    {
        $q = "SELECT * FROM knjiga ORDER BY knjigaID DESC LIMIT 1";
        return $conn->query($q);
    }
}
