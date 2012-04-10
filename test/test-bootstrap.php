<?php

set_include_path(
  get_include_path() . PATH_SEPARATOR .
  dirname(dirname(__FILE__)) . '/lib' . PATH_SEPARATOR .
  dirname(dirname(__FILE__)) . '/vendor' . PATH_SEPARATOR .
  dirname(dirname(__FILE__)) . '/test/lib'
);

//require_once 'Mustache.php';

//global key value store
$okfn_fixtures = new stdClass;

//test helpers
require_once 'test-helpers.php';
require_once 'okfn-test-case.php';

//core library
require_once 'okfn-base.php';
require_once 'okfn-utils.php';
require_once 'okfn-annot-settings.php';
require_once 'okfn-annot-factory.php';
require_once 'okfn-annot-content-policy.php';
require_once 'okfn-annot-injector.php';
?>
