<?php

$xml = simplexml_load_file('adresar.xml');
if (empty($_GET['id'])){
    //nebylo zadáno ID
    header("HTTP/1.0 404 Not Found");
    exit();
}


if (!empty($xml->osoba)){
    foreach ($xml->osoba as $osoba){//projdeme jednotlivé osoby (viz struktura daného souboru) - hledáme osobu se zadaným ID

        if ((string)$osoba['id']==$_GET['id']){
            //našli jsme příslušný obsah
            $result=[
                'id'=>(string)$osoba['id'],
                'jmeno'=>(string)$osoba->jmeno,
                'prijmeni'=>(string)$osoba->prijmeni
            ];
            if (!empty($osoba->adresa)){
                $result['adresa']=(string)$osoba->adresa;
            }
            if (!empty($osoba->spolecnost)){
                $result['spolecnost']=(string)$osoba->spolecnost;
            }
            break;
        }
    }
}

if (!empty($result)){
    echo json_encode($result);
}else{
    //nebyla nalezena daná osoba - vrátíme odpovídající HTTP chybu
    header("HTTP/1.0 404 Not Found");
    exit();
}
