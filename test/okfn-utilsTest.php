<?php
class OkfnAnnotUtilsTest extends PHPUnit_Framework_TestCase {

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

  function test_objectify() {
    $object = OkfnUtils::objectify(array(
       'a' => array(
          'a1' => array(
             'a1a' => 'hi!'
           )
        ),
        'b'
    ));
    $this->assertEquals($object->a->a1->a1a,'hi!');
  }

  function test_unque_id() {
    for ($index = 0; $index < 3; $index++) {
      $ids[]=(int) OkfnUtils::unique_id($prefix='');
    }

    $this->assertGreaterThan($ids[1],$ids[2]);
    $this->assertGreaterThan($ids[0],$ids[1]);
  }
}
?>
