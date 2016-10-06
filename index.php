<?php
require_once 'lib/limonade.php';
init_set('display-errors','on');
error_reporting(E_ALL);
dispatch('/', 'hello');
  function hello()
  {
      return 'Hello world!';
  }
run();
?>
