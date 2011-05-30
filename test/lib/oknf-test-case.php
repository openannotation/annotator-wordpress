<?php
class OkfnTestCase extends PHPUnit_Framework_TestCase {

    /*
     * Convenient wrapper for calling PHPUnit's method
     * getmock without automatically running the class constructor
     *
     * class                 - The name of the class to be mocked.
     * methods               - The array of instance method to be mocked.
     * constructor_params    - An array of parameters to be passed to the constructor.
     * dont_call_constructor - whether or not to disable the constructor call; defaults to true (optional).
     *
     *
     * returns a PHPUnit class instance mock.
     */

    protected function mockHelper($class, $methods=array(), $constructor_params=array(), $dont_call_constructor=true) {

      $mock_classname = OkfnUtils::unique_id($class . 'Mock');
      return $this->getMock($class,
        $methods,
        $constructor_params,
        $mock_classname,
        $dont_call_constructor
      );
    }

}
?>
