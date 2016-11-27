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
    $dao = new DocumentDAO($GLOBALS['db']);
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
    $dao = new PromoDAO($GLOBALS['db']);
    $promos = $dao->getList();

    foreach ($promos as $promo){
        $output[] = array(
            "id" => $promo->getId(),
            "type" => $promo->getCycle(),
            "annee" => $promo->getAnnee(),
            "localisation" => $promo->getLocalisation(),
        );
    }
    return json_encode($output);
}
dispatch('/api/promos/:id', 'getPromo');
function getPromo()
{
    $id = params('id');
    $dao = new PromoDAO($GLOBALS['db']);
    $promo = $dao->get($id);

    $output[] = array(
        "id" => $promo->getId(),
        "type" => $promo->getCycle(),
        "annee" => $promo->getAnnee(),
        "localisation" => $promo->getLocalisation(),
    );
    return json_encode($output);
}
dispatch('/api/locs', 'getLocs');
function getLocs()
{
    $dao = new PromoDAO($GLOBALS['db']);
    $locs = $dao->getListLoc();

    return json_encode($locs);
}
dispatch('/api/annees', 'getAnnees');
function getAnnees()
{
    $dao = new PromoDAO($GLOBALS['db']);
    $annees = $dao->getListAnnee();

    return json_encode($annees);
}
dispatch('/api/cycles', 'getCycles');
function getCycles()
{
    $dao = new PromoDAO($GLOBALS['db']);
    $cycles = $dao->getListCycle();

    return json_encode($cycles);
}