<?php
class OkfnAnnotSettingsTest extends OkfnTestCase {

    protected $methods_to_mock = array(
      'register_menu',
      'process_settings_form',
      'render_settings_form'
    );

    public function testShouldRegisterThePluginMenuItemAndOptionPage() {
      $mock = $this->mockHelper('OkfnAnnotSettings',$this->methods_to_mock);
      $mock->expects($this->once())
           ->method('register_menu');

      $mock->__construct();
      $mock->process_request();

    }

    public function testShouldRenderTheSettingsForm() {
      $request_params=array('okfn-annot-wrong-submit-button' => true);
      $mock = $this->mockHelper('OkfnAnnotSettings',$this->methods_to_mock);


      $mock->expects($this->once())
           ->method('render_settings_form');

      $mock->expects($this->never())
           ->method('process_settings_form');

      $mock->process_request();
    }


    public function testShouldProcessTheFormIfTheRightSubmitButtonIsSentOverWithTheRequest() {
      $request_params = array('okfn-annotsettings-submit' => true); //correct submit token

      $mock = $this->mockHelper('OkfnAnnotSettings',$this->methods_to_mock);

      $mock->expects($this->never())
           ->method('render_settings_form');

      $mock->expects($this->once())
           ->method('process_settings_form')
           ->with($request_params);

      $mock->process_request($request_params);
    }

    protected function tearDown() {
    }
}
?>
