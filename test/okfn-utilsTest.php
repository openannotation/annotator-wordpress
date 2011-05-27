<?php
require_once '../lib/okfn-utils.php';

class OkfnAnnotSettingsTest extends PHPUnit_Framework_TestCase {

  function test_filter_by_regexp(){
    $filtered = OkfnUtils::filter_by_regexp('/^my-input-/', array(
      'foo' => 1,
      'bar' => 2,
      'my-input-foo' => 3,
      'my-input-bar' => 4
    ), true);

    $this->assertEquals($filtered, array(
      'foo' => 3,
      'bar' => 4
    ));
  }
}
?>
