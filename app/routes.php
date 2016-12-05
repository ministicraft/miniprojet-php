<?php
/**
 * Created by IntelliJ IDEA.
 * User: world
 * Date: 23/11/2016
 * Time: 22:07
 */

use App\DAO\DocumentDAO;
use App\DAO\PromoDAO;

$GLOBALS['db'] = new PDO('mysql:host=localhost;dbname=doc_rentree', 'rentree', 'rentree');
$GLOBALS['documentDAO'] = new DocumentDAO($GLOBALS['db']);
$GLOBALS['promoDAO'] = new PromoDAO($GLOBALS['db']);

dispatch('/', 'hello');
function hello()
{
    require '../views/home.php';
}
dispatch('/promos', 'promos');
function promos()
{
    require '../views/promos.php';
}
dispatch('/documents', 'documents');
function documents()
{
    require '../views/documents.php';
}
dispatch('/api/documents', 'getDocuments');
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
dispatch('/api/promos', 'getPromos');
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
        );
    }
    return json_encode($output);
}
dispatch('/api/promos/:id', 'getPromo');
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
    );
    return json_encode($output);
}
dispatch('/api/locs', 'getLocs');
function getLocs()
{
    $dao = $GLOBALS['promoDAO'];
    $locs = $dao->getListLoc();

    return json_encode($locs);
}
dispatch('/api/annees', 'getAnnees');
function getAnnees()
{
    $dao = $GLOBALS['promoDAO'];
    $annees = $dao->getListAnnee();

    return json_encode($annees);
}
dispatch('/api/cycles', 'getCycles');
function getCycles()
{
    $dao = $GLOBALS['promoDAO'];
    $cycles = $dao->getListCycle();

    return json_encode($cycles);
}
dispatch_post('/api/cycles', 'postCycle');
function postCycle()
{
    $dao = $GLOBALS['promoDAO'];
    $dao->addCycle($_POST['cycle']);
}
dispatch_post('/api/locs', 'postLoc');
function postLoc()
{
    $dao = $GLOBALS['promoDAO'];
    $dao->addLoc($_POST['loc']);
}
dispatch_post('/api/promos', 'postPromo');
function postPromo()
{
    $dao = $GLOBALS['promoDAO'];
    $dao->addPromo($_POST['cycle'],$_POST['loc'],$_POST['annee']);
}
dispatch_delete('/api/promos', 'delPromo');
function delPromo()
{
    $dao = $GLOBALS['promoDAO'];
    $dao->delPromo($_POST['id']);
}
dispatch_put('/api/promos', 'editPromo');
function editPromo()
{
    $dao = $GLOBALS['promoDAO'];
    $dao->updatePromo($_POST['id'],$_POST['cycle'],$_POST['loc'],$_POST['annee']);
}
dispatch_post('/api/documents', 'addDocument');
function addDocument()
{
    $dao = $GLOBALS['documentDAO'];
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
    }
}