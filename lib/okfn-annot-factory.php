<?php

/*
 * Dynamically generates the JavaScript code snippet needed for instantiating 
 * the Annotator.
 *
 *
 */

class OkfnAnnotFactory extends OkfnBase {
  private $accountid;
  private $auth_token;
  private $store_uri;
  private $uri; //current wordpress page
  private $allow_anonymous;
  private $annotator_content;
  private $load_from_search;
  private $template_vars;
  private $settings;
  private $userinfo;
  private $user_id;
  private $user_name;

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
      'accountid',
      'store_uri',
      'auth_token',
      'annotator_content',
      'allow_anonymous',

    ) as $attribute) {
      $this->$attribute = $settings->get_option($attribute);
    }

    //todo: add load from search
    $this->uri = $this->get_current_uri();
    $this->user_id = $this->get_user_id();
    $this->user_name = $this->get_user_name();

  }


  /*
   *
   * Fetches the URI of the currently visited blog page
   *
   * returns a uri string
   *
   */

  private function get_current_uri(){
    return 'http://' . preg_replace('/\/$/', '', $_SERVER['HTTP_HOST']) .
      $_SERVER['REQUEST_URI'];
  }

  /*
   * Gets the logged in user id or the anonymous visitor IP address.
   *
   * returns a string
   *
   */

  private function get_user_id() {
    if (!$this->userinfo) $this->userinfo = wp_get_current_user();

    return $this->userinfo && isset($this->userinfo->ID) && $this->userinfo->ID > 0 ?
      $this->userinfo->ID :
      $_SERVER["REMOTE_ADDR"];
  }

  /*
   * Gets the user display name.
   *
   * returns a string or null if the user is not logged in
   *
   */
  private function get_user_name() {
    if (!$this->userinfo) $this->userinfo = wp_get_current_user();
    $username = $this->userinfo && isset($this->userinfo->data->user_login) ?
      $this->userinfo->data->user_login :
      null;

    //prefer nickname over loggin name
    if ($this->userinfo && isset($this->userinfo->data) && strlen($this->userinfo->data->nickname)) {
      $username = $this->userinfo->data->nickname;
    }

    return $username;

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
      'account_id'  => $this->accountid,
      'auth_token'  => $this->auth_token,
      'user_id' => $this->user_id,
      'user_name' => $this->user_name,
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
    if ($this->allow_anonymous === 'y' or $this->userinfo->ID > 0 ) {
      return $this->render_template($this->prepare_variables());
    }
  }
}
?>
