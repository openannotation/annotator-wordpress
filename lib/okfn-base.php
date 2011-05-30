<?php

/*
 * A base class providing attributes and methods shared by all the
 * defined components
 *
 */
class OkfnBase {
  function __construct() {
    $this->objectify_conf();
  }

  /*
   * Returns a read only copy of the internal config object.
   *
   * returns an object.
   *
   */
  public function get_conf() {
    return $this->conf;
  }



  /*
   * Turns the conf attribute from an array into an object.
   *
   * This is just a tiny bit of syntactical sugar which allows to
   * write $this->conf->bar rather than $this->conf['bar']
   *
   * (PHP does not allow to assign an object litteral to an
   * attribute defined in the class declaration).
   *
   *
   */
  private function objectify_conf(){
    if ($this->conf) {
      $this->conf = OkfnUtils::Objectify($this->conf);
    }
  }


}
?>
