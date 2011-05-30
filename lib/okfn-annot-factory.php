<?php

/*
 * Dynamically generates the JavaScript code snippet needed for instantiating 
 * the Annotator.
 *
 *
 */

class OkfnAnnotFactory extends OkfnBase {
  private $user_id;
  private $accountid;
  private $store_uri;
  private $uri; //current wordpress page
  private $allow_anonymous;
  private $annotator_content;
  private $load_from_search;
  private $template_vars;
  private $settings;

  /*
   * Public:
   *
   * Class constructor
   *
   * $settings - an instance of OkfnAnnotSettings
   *
   */

  function __construct($settings) {
    $this->settings = $settings;

    foreach(array(
      'user_id',
      'accountid',
      'store_uri',
      'annotator_content',
      'allow_anonymous',

    ) as $attribute) {
      $this->$attribute = $settings->get_option($attribute);
    }

    //todo: add load from search
    $this->uri = $this->get_current_uri();
  }

  /*
   *
   * Fetches the URI of the currently visited blog page
   *
   * returns a uri string
   *
   */

  private function get_current_uri(){
    return 'http://' .
      preg_replace('/\/$/', '', $_SERVER['HTTP_HOST']) .
      $_SERVER['REQUEST_URI'];
  }

  /*
   * Wrapper method calling the Mustache template engine.
   *
   * (Needed mostly for testing and mocking...)
   *
   *
   *
   */

  function render_template($template_vars, $template='annotator-instance.js') {
    $template = OkfnUtils::get_template($template);
    $mustache = new Mustache;
    return $mustache->render($template,$template_vars);
  }


  private function prepare_variables(){
    $template_vars = array(
      'accountid'  => $this->accountid,
      'user_id' => $this->user_id,
      'annotator_content' => $this->annotator_content,
      'uri' => $this->uri,
      'load_limit' => -1,
      'store_uri' => !empty($this->store_uri) ? $this->store_uri : 'http://annotate.it'
    );

    return $template_vars;
  }

  /*
   * Generates a code snippet containing a customised Javascript instantiation
   * code for the Annotator.
   *
   * Returns a string or null if no instance is meant to be created.
   *
   *
   */

  function create_snippet() {
    //TODO: implement conditional here
    // return only if
    //  - user is logged in OR anonymous comments are allowed
    if (true) {
      return $this->render_template($this->prepare_variables());
    }
  }


}
?>
