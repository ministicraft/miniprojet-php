<?php

  $titre = "Documents de rentrée";
  $annee = "2016";
  
  // mot de passe diffusé aux parents
  $cle1 = "isen1617";
  // pour garder si besoin le mot de passe de l'année dernière
  $cle2 = "isen2016";
    
  // informations concernant la base de données
  $DbHost = "localhost";
  $DbName = "doc_rentree";
  $DbUser = "cir32016";
  $DbPassword = "cir32016";
/*
$libellePromo = array (
    "1&#x02B3;&#x1D49; année, Cycle Biologie Sciences et Technologies" => "CBIO_A1",
    "1&#x02B3;&#x1D49; année, Cycle Sciences de l'Ingénieur" => "CSI_A1",
    "1&#x02B3;&#x1D49; année, Cycle Informatique et Réseaux (Brest)" => "CIR_BREST_A1",
    "1&#x02B3;&#x1D49; année, Cycle Informatique et Réseaux (Rennes)" => "CIR_RENNES_A1",
    "1&#x02B3;&#x1D49; année, BTS Prépa" => "BTSPREPA_A1",
    "2&#x1D49; année, Cycle Sciences de l'Ingénieur" => "CSI_A2",
    "2&#x1D49; année, Cycle Informatique et Réseaux (Brest)" => "CIR_BREST_A2",
    "2&#x1D49; année, Cycle Informatique et Réseaux (Rennes)" => "CIR_RENNES_A2",
    "2&#x1D49; année, BTS Prépa" => "BTSPREPA_A2",
    "3&#x1D49; année, Cycle Sciences de l'Ingénieur" => "CSI_A3",
    "3&#x1D49; année, Cycle Informatique et Réseaux (alternant)" => "CIR_A3_ALT",
    "3&#x1D49; année, Cycle Informatique et Réseaux (non alternant)" => "CIR_A3_NONALT",
    "3&#x1D49; année, Cycle Ingénieur Par l'Apprentissage" => "CIPA_A3",
    "4&#x1D49; année, Majeure - M1" => "M_A4",
    "4&#x1D49; année, Cycle Ingénieur Par l'Apprentissage" => "CIPA_A4",
    "5&#x1D49; année, Majeure - M2 (alternant)" => "M_A5_ALT",
    "5&#x1D49; année, Majeure - M2 (non alternant)" => "M_A5_NONALT",
    "5&#x1D49; année, Cycle Ingénieur Par l'Apprentissage" => "CIPA_A5"
);*/
  $DbLink = mysql_connect($DbHost, $DbUser, $DbPassword) or die('erreur de connexion au serveur');
  mysql_select_db($DbName) or die('erreur de connexion a la base de donnees');
  mysql_query("SET NAMES 'utf8'");
  $query = "SELECT * FROM promo";

  $result = mysql_query($query);
  $libellePromo = array();

  while($data = mysql_fetch_array($result)) {

    if (($data['localisation'] != 'N/A' && $data['localisation'] != '') && $data['alt'] != "") {
        if ($data['alt'] == 1) {
            $promo = $data['cycle'] . '_' . $data['localisation'] . '_' . $data['annee'] . '_ALT';
        } else {
            $promo = $data['cycle'] . '_' . $data['localisation'] . '_' . $data['annee'] . '_NONALT';
        }
    } else if ($data['localisation'] != 'N/A' && $data['localisation'] != '') {
        $promo = $data['cycle'] . '_' . $data['localisation'] . '_' . $data['annee'];
    } else {
        $promo = $data['cycle'] . '_' . $data['annee'];
    }
    $libellePromo[$data['libelle']] = $promo;
    print_r($libellePromo);
  }

  require_once("lib.php");
  
?>
