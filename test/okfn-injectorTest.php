<?php
class OkfnAnnotInjectorTest extends PHPUnit_Framework_TestCase {

  public function testAllAssetPathsShouldCorrect(){
    $injector = new OkfnAnnotInjector;
    $conf = $injector->get_conf();

    foreach(array('javascripts', 'stylesheets') as $asset_type) {
      foreach($conf->$asset_type as $asset) {
        $this->assertFileExists(dirname(dirname(__FILE__)) ."/{$conf->assets_basepath}{$asset->file}");
      }
    }
  }


}
?>
