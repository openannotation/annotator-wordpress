<?php
class OkfnAnnotSettings {

  private $forminput_prefix = 'okfn-annot';
  private $submit_parameter_name = 'okfn-annotsettings-submit';
  private $options_defaults = array(
    'accountid'  => null,
    'auth_token' => null,
  );

  function __construct(){
  }

  /*
   * Registers the Annotator plugin settings page and its menu item
   * using wordpress special function 'add_options_page'
   *
   * returns nothing
   *
   */

  function register_menu() {
    add_options_page(
       'OKFN Annotator settings',          //page title
       'OKFN Annotator',                   //menu item text
       'manage_options',                   //wordpress permission level
       'okfn-annotator',                   //menu identifier
       array($this,'render_settings_form')  //callback
    );
  }


 /*
  * Sets the plugin options using the form input fields sent through the form
  *
  *
  * params - the request paramters
  *
  * returns nothing.
  *
  */

 function process_settings_form($params){
   $prefix = self::$forminput_prefix;
   $options=OkfnUtils::filter_by_regexp($prefix, $params, $remove_matches=true);

   foreach($options as $option => $value) {
     update_option($option, $value);
   }
 }

 /*
  *
  * Renders the HTML for the Annotator settings options page.
  *
  * returns a rendered form template
  *
  */

 function render_settings_form() {
   $options = array();
   foreach(self::$options_defaults as $optname => $value) {
     $options[$optname] = get_option($optname);
   }

   $mustache = new Mustache;
   $template = OkfnUtils::get_template('form.html');
   return $mustache->render($template, $options);
 }

 /*
  * Public:
  *
  * Logical switch determining whether to render or to process the setting form
  * on the basis of the presence of special parameter
  *
  *
  * params - the request parameters
  *
  *
  * returns nothing
  */

  function process_request($params) {
    $this->register_menu();

    (isset($params[ $this->submit_parameter_name  ])) ?
      $this->process_settings_form($params) :
      $this->render_settings_form() ;

  }

}
?>
