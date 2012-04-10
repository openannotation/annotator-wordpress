<?php



/*
 * Stub method replacing OkfnAnnotSettings#get_option
 *
 * options - the name of a settings option (with no plugin prefix)
 *
 *
 * returns a value from the 'okfn_fixtures->setting' object.
 *
 */


function settings_get_option($option) {
    global $okfn_fixtures;
    return (string) @$okfn_fixtures->settings->$option;
}




class OkfnAnnotFactoryTest extends OkfnTestCase {

  function setUp() {
    //prepare test fixture
    global $okfn_fixtures;

    $okfn_fixtures->settings = (object) array(
      'annotator_content' => '.a-selector',
    );

    $okfn_fixtures->current_user = (object) array(
      'ID' => '0',
      'nickname' => '',
    );

    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    $_SERVER['HTTP_HOST'] = 'example.com';
    $_SERVER['REQUEST_URI'] = '/hello-test';


    //mock the settings object
    $this->settings_mock = $this->mockHelper('OkfnAnnotSettings',array('get_option'),array(), false);

    //stub the #get_options method so that it will return values from our fixtures
    $this->settings_mock->expects($this->any())
                        ->method('get_option')
                        ->will($this->returnCallback('settings_get_option'));

  }


  function testCreateSnippet() {
    $factory_mock = $this->getMock('OkfnAnnotFactory', array('render_template'), array($this->settings_mock));
    $factory_mock->expects($this->once())->method('render_template');

    $factory_mock->create_snippet();
  }
}
?>
