<?php
/**
 * Created by PhpStorm.
 * User: ministicraft
 * Date: 31/12/2016
 * Time: 14:44
 */

/*
 * Fonction associé
 * aux
 * Documents
 *
 * */

/*Récupère tt les documents*/

function getDocuments()
{
    $dao = $GLOBALS['documentDAO'];
    $documents = $dao->getList();

    foreach ($documents as $document){
        $output[] = array(
            "id" => $document->getId(),
            "rang" => $document->getRang(),
            "promo" => $document->getPromo(),
            "fichier" => $document->getFichier(),
            "libelle" => utf8_decode($document->getLibelle())
        );
    }
    return json_encode($output);
}

/*Ajoute un document*/

function addDocument()
{
    $documentDAO = $GLOBALS['documentDAO'];
    $promoDAO = $GLOBALS['promoDAO'];

    $rang = $_POST['rang'];
    if($_POST['promo'] != 'null') {
        $tempPromo = $promoDAO->get($_POST['promo']);
        if (($tempPromo->getLocalisation() != 'N/A' && $tempPromo->getLocalisation() != '') && $tempPromo->getAlternance() != "") {
            if ($tempPromo->getAlternance() == 1) {
                $promo = $tempPromo->getCycle() . '_' . $tempPromo->getLocalisation() . '_' . $tempPromo->getAnnee() . '_ALT';
            } else {
                $promo = $tempPromo->getCycle() . '_' . $tempPromo->getLocalisation() . '_' . $tempPromo->getAnnee() . '_NONALT';
            }
        } else if ($tempPromo->getLocalisation() != 'N/A' && $tempPromo->getLocalisation() != '') {
            $promo = $tempPromo->getCycle() . '_' . $tempPromo->getLocalisation() . '_' . $tempPromo->getAnnee();
        } else {
            $promo = $tempPromo->getCycle() . '_' . $tempPromo->getAnnee();
        }
    } else{
        $tempPromo = null;
        $promo = "";
    }
    $libelle = $_POST['libelle'];
    if ($tempPromo == null) {
        $fichier = $_FILES['file']['name'];
    } else if ($tempPromo->getAnnee() == 'A1' || $tempPromo->getAnnee() == 'A2') {
        $fichier = 'A12/' . $_FILES['file']['name'];
    } else {
        $fichier = 'A345/' . $_FILES['file']['name'];
    }

    $data[] = [$rang,$promo,$libelle,$fichier];

    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        $documentDAO->addDocument($rang,$promo,$libelle,$fichier);
        if($tempPromo == null){
            move_uploaded_file($_FILES['file']['tmp_name'], $GLOBALS['fileLoc'] . $_FILES['file']['name']);
        }else if($tempPromo->getAnnee()=='A1' || $tempPromo->getAnnee()=='A2') {
            move_uploaded_file($_FILES['file']['tmp_name'], $GLOBALS['fileLoc'] . 'A12/' . $_FILES['file']['name']);
        }else {
            move_uploaded_file($_FILES['file']['tmp_name'], $GLOBALS['fileLoc'] .'A345/'. $_FILES['file']['name']);
        }
    }
}

/*Supprime un document*/

function delDocument()
{
    $dao = $GLOBALS['documentDAO'];
    $dao->delDocument($_POST['id']);
    return header("HTTP/1.1 200 OK");
}

/*Met à jour un document*/

function putDocument()
{
    $documentDAO = $GLOBALS['documentDAO'];
    $promoDAO = $GLOBALS['promoDAO'];

    $id = $_POST['id'];
    $rang = $_POST['rang'];
    if ($_POST['promo'] != null) {
        $tempPromo = $promoDAO->get($_POST['promo']);
        if ($tempPromo->getLocalisation() != 'N/A' && $tempPromo->getAlternance() != "") {
            if ($tempPromo->getAlternance() == 1) {
                $promo = $tempPromo->getCycle() . '_' . $tempPromo->getLocalisation() . '_' . $tempPromo->getAnnee() . '_ALT';
            } else {
                $promo = $tempPromo->getCycle() . '_' . $tempPromo->getLocalisation() . '_' . $tempPromo->getAnnee() . '_NONALT';
            }
        } else if ($tempPromo->getLocalisation() != 'N/A') {
            $promo = $tempPromo->getCycle() . '_' . $tempPromo->getLocalisation() . '_' . $tempPromo->getAnnee();
        } else {
            $promo = $tempPromo->getCycle() . '_' . $tempPromo->getAnnee();
        }
    } else {
        $tempPromo = null;
        $promo = "";
    }
    $libelle = $_POST['libelle'];

    $data[] = [$id, $rang, $promo, $libelle];

    $documentDAO->editDocument($id, $rang, $promo, $libelle);
}

/*
 * Fonction associé
 * aux
 * promos
 *
 * */
/*Récupère tt les promos*/

function getPromos()
{
    $dao = $GLOBALS['promoDAO'];
    $promos = $dao->getList();

    foreach ($promos as $promo){
        $output[] = array(
            "id" => $promo->getId(),
            "cycle" => $promo->getCycle(),
            "annee" => $promo->getAnnee(),
            "loc" => $promo->getLocalisation(),
            "alt" => $promo->getAlternance(),
            "libelle" => $promo->getLibelle(),
        );
    }
    return json_encode($output);
}

/*Récupère une les promos*/

function getPromo()
{
    $id = params('id');
    $dao = $GLOBALS['promoDAO'];
    $promo = $dao->get($id);

    $output[] = array(
        "id" => $promo->getId(),
        "cycle" => $promo->getCycle(),
        "annee" => $promo->getAnnee(),
        "loc" => $promo->getLocalisation(),
        "alt" => $promo->getAlternance(),
    );
    return json_encode($output);
}

/*Ajoute une promo*/

function postPromo()
{
    $dao = $GLOBALS['promoDAO'];
    if($_POST['alt']==''){
        $_POST['alt']= null;
    }
    $dao->addPromo($_POST['cycle'],$_POST['loc'],$_POST['annee'],$_POST['alt'],$_POST['libelle']);
}

/*Supprime une promo*/

function delPromo()
{
    $dao = $GLOBALS['promoDAO'];
    $dao->delPromo($_POST['id']);
}

/*Mes à jour une promo*/

function editPromo()
{
    $dao = $GLOBALS['promoDAO'];
    $dao->updatePromo($_POST['id'],$_POST['cycle'],$_POST['loc'],$_POST['annee'],$_POST['alt'],$_POST['libelle']);
}

/*
 * Fonction associé
 * aux
 * localisation
 *
 * */
/*Récupère tt les localisation*/

function getLocs()
{
    $dao = $GLOBALS['promoDAO'];
    $locs = $dao->getListLoc();

    return json_encode($locs);
}

/*Ajoute une localisation*/

function postLoc()
{
    $dao = $GLOBALS['promoDAO'];
    $dao->addLoc($_POST['loc']);
}

/*
 * Fonction associé
 * aux
 * cycles
 *
 * */

/*Récupère tt les cycles*/

function getCycles()
{
    $dao = $GLOBALS['promoDAO'];
    $cycles = $dao->getListCycle();

    return json_encode($cycles);
}

/*Ajoute un cycle*/

function postCycle()
{
    $dao = $GLOBALS['promoDAO'];
    $dao->addCycle($_POST['cycle']);
}

/*
 * Fonction associé
 * aux
 * année
 *
 * */

/*Récupère tt les années*/

function getAnnees()
{
    $dao = $GLOBALS['promoDAO'];
    $annees = $dao->getListAnnee();

    return json_encode($annees);
}