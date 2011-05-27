<?php
class OkfnAnnotSettings {

  private $conf = array(
    //class configuration variables
    'forminput_prefix' => 'okfn-annot',
    'settings_page_title' => 'OKFN Annotator settings',
    'menu_item_title' => 'OKFN Annotator',
    'menu_item_identifier' => 'okfn-annotator',
    'submit_parameter_name' => 'okfn-annotsettings-submit',

    //options exposed to the user and stored in wordpress settings
    'default_options' => array(
      'accountid' => '',
      'auth_token' => '',
      'store_uri' => '',
    )
  );

  function __construct(){
    $this->conf = (object) $this->conf;
    add_action('admin_menu', array($this, 'register_menu'));
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

      $this->conf->settings_page_title,
      $this->conf->menu_item_title,
      'manage_options',                   //wordpress permission level
      $this->conf->menu_item_identifier,
      array($this,'process_request')      //callback popoulating the settings page content
    );
  }



  function form_is_submitted($params) {
    return isset($params[ $this->conf->submit_parameter_name  ]);
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
   $prefix = $this->conf->forminput_prefix;
   $options=OkfnUtils::filter_by_regexp("/^{$prefix}-/", $params, $remove_matches=true);

   foreach($options as $option => $value) {
     update_option($option, $value);
   }

   $this->render_settings_form($is_submit=true);
 }

 /*
  *
  * Renders the HTML for the Annotator settings options page.
  *
  * is_submit - boolean flag indicating whether data has been submitted
  *
  *
  * returns a rendered form template
  *
  *
  *
  */

 function render_settings_form($is_submit=false) {
   $prefix = $this->conf->forminput_prefix;

   $options = array(
     'prefix' => $prefix,
     'action' =>  $_SERVER['REQUEST_URI'],
     'submit_name' => $this->conf->submit_parameter_name,
     'submit_value' => __('Save settings'),
     'form_submitted' => $is_submit,
   );

   foreach($this->conf->default_options as $optname => $value) {
     $options[$optname] = get_option($optname);
   }


   $mustache = new Mustache;
   $template = OkfnUtils::get_template('settings.html');
   print $mustache->render($template, $options);
 }

 /*
  * Public:
  *
  * Logical switch determining whether to render or to process the setting form
  * on the basis of the presence of special parameter
  *
  *
  * params - the request parameters (defaults to $_POST if not provided).
  *
  *
  * returns nothing
  */

 function process_request($params=null) {

   if (empty($params)) {
      $params = $_POST;
    }

    $this->register_menu();

    ( $this->form_is_submitted($params) ) ?
      $this->process_settings_form($params) :
      $this->render_settings_form() ;
  }

}
?>
