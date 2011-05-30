<?php

set_include_path(
  get_include_path() . PATH_SEPARATOR .
  dirname(dirname(__FILE__)) . '/lib' . PATH_SEPARATOR .
  dirname(dirname(__FILE__)) . '/test/lib'
);


//test helpers
require_once 'test-helpers.php';
require_once 'oknf-test-case.php';

//core library
require_once 'okfn-base.php';
require_once 'okfn-utils.php';
require_once 'okfn-annot-settings.php';
require_once 'okfn-annot-injector.php';
?>
