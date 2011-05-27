<?php

require_once '../lib/okfn-annot-settings.php';


/*
 * fake wordpress hook registration function.
 */

function add_action($action_hook, array $action) {
  call_user_func($action,array());
}




// Dummy wrapper, needed as PHPUnit does not allow to call mock object directly
// but expects them to be passed into as 'collaborators' other wrapper objects 
// and called internally within them.

class SettingsRunner {

  /*
   * Calls process_request on the mock object and passes an array of request parameters as argument
   *
   * settings          - a mock of OkfnAnnotSettings
   * request_parameter - collection of key value pairs representing the request parameters (no mater whether the method is POST or GET ).
   *
   */
  function __construct($settings, $request_params=array()) {
    $settings->process_request($request_params);
  }
}

class OkfnAnnotSettingsTest extends PHPUnit_Framework_TestCase {

    protected function getSettingsMock() {
      return $this->getMock('OkfnAnnotSettings', array(
        'register_menu',
        'process_settings_form',
        'render_settings_form'
      ));
    }

    public function testShouldRegisterThePluginMenuItemAndOptionPage() {
      $mock = $this->getSettingsMock($this);
      $mock->expects($this->once())
           ->method('register_menu');

      new SettingsRunner($mock);
    }

    public function testShouldRenderTheSettingsForm() {
      $request_params=array('okfn-annot-wrong-submit-button' => true);

      $mock = $this->getSettingsMock();

      $mock->expects($this->once())
           ->method('render_settings_form');

      $mock->expects($this->never())
           ->method('process_settings_form');

      new SettingsRunner($mock, $request_params);
    }

    public function testShouldProcessTheFormIfTheRightSubmitButtonIsSentOverWithTheRequest() {
      $request_params = array('okfn-annotsettings-submit' => true); //correct submit token

      $mock = $this->getSettingsMock();

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
