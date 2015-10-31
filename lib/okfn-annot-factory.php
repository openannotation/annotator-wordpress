<?php

/**
 * Dynamically generates the JavaScript code snippet needed for instantiating
 * the Annotator.
 */

use \Firebase\JWT\JWT;

class OkfnAnnotFactory extends OkfnBase {
  private $uri; //current wordpress page
  private $template_vars;
  private $settings;

  /**
   * Public:
   * Class constructor
   * settings - an instance of OkfnAnnotSettings.
   */
  function __construct($settings) {
    $this->settings = $settings;
  }


  /**
   * Fetches the URI of the currently visited blog page
   * returns a uri string
   */

  private function get_current_uri(){
    return OkfnUtils::current_url();
  }

  /**
   * Wrapper method calling the Mustache template engine.
   * (Needed mostly for testing and mocking...)
   */

  function render_template($template_vars, $template='annotator-instance.js') {
    $template = OkfnUtils::get_template($template);
    $mustache = new Mustache;
    return $mustache->render($template,$template_vars);
  }


  private function prepare_variables(){
    $template_vars = $this->settings->get_options_values();

    $CONSUMER_TTL = 86400;

    $secret = $template_vars["annotateit_secret"];
    $objDateTime = new DateTime('NOW');
    $issuedAt = $objDateTime->format(DateTime::ISO8601)."Z";

    $user = wp_get_current_user()->user_login;

    $token = array(
      'consumerKey'=> $template_vars["annotateit_key"],
      'userId'=> $user,
      'issuedAt'=> $issuedAt,
      'ttl' => $CONSUMER_TTL
    );

    $template_vars["token"] = JWT::encode($token, $secret);
    $template_vars["user"] = $user;

        //todo: add load from search
    $template_vars['uri'] = $this->get_current_uri();

    $template_vars['annotateit_secret'] = ""; //should never be published

    return $template_vars;
  }

  /**
   * Generates a code snippet containing a customised Javascript instantiation
   * code for the Annotator.
   *
   * Returns a string or null if no instance is meant to be created.
   *
   */
  function create_snippet() {
    return $this->render_template($this->prepare_variables());
  }
}
?>