<?php

set_include_path(
  get_include_path() . PATH_SEPARATOR . dirname(dirname(__FILE__)) . '/lib' 
);

require_once 'okfn-base.php';
require_once 'okfn-utils.php';
require_once 'okfn-annot-settings.php';
?>
