<?php

/*
 * mocks wordpress' hook registration function
 * and just runs the registred callback
 *
 *
 * $action   - string identifying the wordpress hook
 * $callback - a function name of an array containing the instance object as the first element and the method to be called as the second one.
 *
 *
 * returns nothing.
 */

function add_action($action, $callback) {
  call_user_func($callback);
}



/*
 * Dummy wrapper for calling mocked object. This is needed by PHPUnit as mocks need to
 * be called from within some other object in order to have their method calls tested.
 *
 *
 */

class SettingsRunner {

  /*
   * Public:
   *
   * Calls process_request on the mock object and passes an array of request parameters as argument
   *
   * settings          - a mock of OkfnAnnotSettings
   * request_parameter - collection of key value pairs representing the request parameters (no mater whether the method is POST or GET ).
   *
   *
   * returns nothing
   */
  function __construct($settings, $request_params=array()) {
    $settings->__construct();
    $settings->process_request($request_params);
  }
}


class OkfnAnnotSettingsTest extends PHPUnit_Framework_TestCase {

    protected $methods_to_mock = array(
      'register_menu',
      'process_settings_form',
      'render_settings_form'
    );
    /*
     * Mocks an object
     *
     */
    protected function mockHelper($class, $methods, $constructor_params=array(), $dont_call_constructor=true) {

      $mock_classname = OkfnUtils::unique_id($class . 'Mock');
      return $this->getMock($class,
        $methods,
        $constructor_params,
        $mock_classname,
        $dont_call_constructor
      );
    }

    public function testShouldRegisterThePluginMenuItemAndOptionPage() {
      $mock = $this->mockHelper('OkfnAnnotSettings',$this->methods_to_mock);
      $mock->expects($this->once())
           ->method('register_menu');

      new SettingsRunner($mock);
    }

    public function testShouldRenderTheSettingsForm() {
      $request_params=array('okfn-annot-wrong-submit-button' => true);
      $mock = $this->mockHelper('OkfnAnnotSettings',$this->methods_to_mock);


      $mock->expects($this->once())
           ->method('render_settings_form');

      $mock->expects($this->never())
           ->method('process_settings_form');

      new SettingsRunner($mock, $request_params);
    }

    public function testShouldProcessTheFormIfTheRightSubmitButtonIsSentOverWithTheRequest() {
      $request_params = array('okfn-annotsettings-submit' => true); //correct submit token

      $mock = $this->mockHelper('OkfnAnnotSettings',$this->methods_to_mock);

      $mock->expects($this->never())
           ->method('render_settings_form');

      $mock->expects($this->once())
           ->method('process_settings_form')
           ->with($request_params);

      new SettingsRunner($mock,$request_params);
    }

    protected function tearDown() {
    }
}
?>
