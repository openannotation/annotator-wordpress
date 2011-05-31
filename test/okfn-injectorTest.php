<?php
class OkfnAnnotInjectorTest extends OkfnTestCase {

  private $methods_to_mock = array(
    'wp_enqueue_asset',
    'load_javascript_dependencies',
    'print_snippet'
  );


  public function testAllAssetPathsShouldBeCorrect(){
    $injector = new OkfnAnnotInjector(new stdClass);
    $conf = $injector->get_conf();

    foreach(array('javascripts', 'stylesheets') as $asset_type) {
      foreach($conf->$asset_type as $asset) {
        $this->assertFileExists(dirname(dirname(__FILE__)) ."/{$conf->assets_basepath}{$asset->file}");
      }
    }
  }

  public function testShouldLoadJavascriptDependencies() {
    $injector_mock = $this->mockHelper('OkfnAnnotInjector',$this->methods_to_mock,array(new stdClass));

    $injector_mock->expects($this->once())
         ->method('load_javascript_dependencies');

    $injector_mock->inject();
  }

  public function testShouldLoadCorrectlyBothJavascriptAndStylesheetAssets() {
    $injector_mock = $this->mockHelper('OkfnAnnotInjector',$this->methods_to_mock, array(new stdClass));

    /*
     * NOTE: The value of the at() index does not refer the value of ->method(), but to stack of all the different 
     * method calls done by the mocked object (which sucks...).
     *
     */
    $injector_mock->expects($this->at(0))
                  ->method('wp_enqueue_asset')
                  ->with('annotator.css',
                    $this->anything(),
                    $this->anything(),
                    $this->anything(),
                    false,
                    'stylesheets'
                   );


    $injector_mock->expects($this->at(2))
                  ->method('wp_enqueue_asset')
                  ->with('jquery.js',
                    $this->anything(),
                    $this->anything(),
                    $this->anything(),
                    false,
                    'javascripts'
                  );

    $injector_mock->expects($this->at(3))
                  ->method('wp_enqueue_asset')
                  ->with('annotator-full.js',
                    $this->anything(),
                    $this->anything(),
                    $this->anything(),
                    false,
                    'javascripts'
                   );


    $injector_mock->inject();
  }



}
?>
