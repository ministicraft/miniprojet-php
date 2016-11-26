<?php
/**
 * Created by IntelliJ IDEA.
 * User: world
 * Date: 23/11/2016
 * Time: 22:06
 */

$app = array();

require_once __DIR__.'/../vendor/limonade.php';
require __DIR__ . '/../app/config/dev.php';
require __DIR__ . '/../app/app.php';
require __DIR__ . '/../app/routes.php';

ini_set('display_errors', 1);

run();