<?php
    include "Database.php";
    $mydb = new Database('rest');
    if(isset($_POST["posalji"]) && $_POST["posalji"]="Posalji zahtev"){
        if($_POST["naslov_novosti"]!=null && $_POST["tekst_novosti"]!=null && $_POST["kategorija_odabir"]!=null){
            $niz = ["naslov"=> "'".$_POST["naslov_novosti"]."'", "tekst"=>"'".$_POST["tekst_novosti"]."'", "datumvreme"=>"NOW()", "kategorija_id"=>$_POST["kategorija_odabir"]];
            if($mydb->insert("novosti", "naslov, tekst, datumvreme, kategorija_id", $niz)){
                echo "vrednosti ubacene";
            }else{
                echo "vrednosti nisu ubacene";
            }
            $_POST = array();
            exit();
        }elseif($_POST["brisanje"]!=null && $_POST["odabir_tabele"]!=null){
            $tabela = $_POST["odabir_tabele"];
            $id = "id";
            $id_val = $_POST["brisanje"];
            if($mydb->delete($tabela,$id,$id_val)){
                echo "red obrisan";
            }else{
                echo "greska prilikom brisanja";
            }
            $_POST = array();
            exit();
        }
        if($_POST["kategorija_naziv"]!=null) {
            $niz = ["kategorija" => "'" . $_POST["kategorija_naziv"] . "'"];

            if($mydb->insert("kategorije", "kategorija", $niz)) {
                echo "vrednosti ubacene";
            } else {
                echo "vrednosti nisu ubacene";
            }
            $_POST = array();
            exit();
        }
        if($_POST["http_zahtev"] != null && $_POST["http_zahtev"] == "get" && $_POST["odabir_tabele"] == "kategorije") {
            $table = $_POST["odabir_tabele"];
            $mydb->select($table);
            $result = $mydb->getResult();

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "id: " . $row["id"]. " - Naziv kategorije:" .$row["kategorija"]. "<br>";
                }
            } else {
                echo "0 results";
            }
            $_POST = array();
            exit();

        }
        if($_POST["http_zahtev"]!=null && $_POST["http_zahtev"] == "get" && $_POST["odabir_tabele"] == "novosti") {
            $table = $_POST["odabir_tabele"];
            $mydb->select($table);
            $result = $mydb->getResult();

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "id: " .$row["id"]. 
                        " - Naslov: " .$row["naslov"]. 
                        " - Tekst: " .$row["tekst"]. 
                        " - Datum: " .$row["datumvreme"].
                        " - Kategorija: " .$row["kategorija_id"].
                        "<br>";
                }
            }
            $_POST = array();
            exit();
        }

        if($_POST["http_zahtev"] != null && $_POST["http_zahtev"] == "put" && $_POST["odabir_tabele"] == "kategorije") {
            $table = $_POST["odabir_tabele"];
            $id = $_POST["kategorija_id"];
            $novi_naziv = "'" . $_POST["kategorija_naziv_put"] . "'";

            if($mydb->update($table, $id, ["kategorija"], [$novi_naziv])) {
                echo "vrednost promenjena";
            }
            else {
                echo "vrednost nije promenjena";
        
            }
            $_POST = array();
            exit();
        }

        if($_POST["http_zahtev"] != null && $_POST["http_zahtev"] == "put" && $_POST["odabir_tabele"] == "novosti") {
            $table = $_POST['odabir_tabele'];
            $id = $_POST['novosti_id'];
            $keys = ['naslov', 'tekst', 'datumvreme', 'kategorija_id'];
            $values = [];
            $values[] = "'" . $_POST['naslov_novosti_put'] . "'";
            $values[] = "'" . $_POST['tekst_novosti_put'] . "'";
            $values[] = "'" . date("Y-m-d H:i:s") . "'";
            $values[] =$_POST['kategorija_odabir_put'];

            if($mydb->update($table, $id, $keys, $values)) {
                echo "vrednost promenjena";
            } else {
                echo "vrednost nije promenjena";
            }
            $_POST = array();
            exit();
        }
    }
?>