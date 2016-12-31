<?php
/**
 * Created by IntelliJ IDEA.
 * User: world
 * Date: 23/11/2016
 * Time: 22:07
 */

use App\DAO\DocumentDAO;
use App\DAO\PromoDAO;
include_once('api.php');
$GLOBALS['documentDAO'] = new DocumentDAO($GLOBALS['db']);
$GLOBALS['promoDAO'] = new PromoDAO($GLOBALS['db']);
$GLOBALS['fileLoc'] = 'uploads/';

/*Route Client*/

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

/* Route serveur/api */

/*Route associé aux documents*/

dispatch('/api/documents', 'getDocuments');

dispatch_post('/api/documents', 'addDocument');

dispatch_delete('/api/documents', 'delDocument');

dispatch_put('/api/documents', 'putDocument');

/*Route associé aux promos*/

dispatch('/api/promos', 'getPromos');

dispatch('/api/promos/:id', 'getPromo');

dispatch_post('/api/promos', 'postPromo');

dispatch_delete('/api/promos', 'delPromo');

dispatch_put('/api/promos', 'editPromo');

/*Route associé aux localisation*/

dispatch('/api/locs', 'getLocs');

dispatch_post('/api/locs', 'postLoc');

/*Route associé aux cycles*/

dispatch('/api/cycles', 'getCycles');

dispatch_post('/api/cycles', 'postCycle');

/*Route associé aux années*/

dispatch('/api/annees', 'getAnnees');