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
  }

  require_once("lib.php");
  
?>
