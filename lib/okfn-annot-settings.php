<?php
class OkfnAnnotSettings extends OkfnBase {

  /*
   * Class configuration variables
   *
   */
  protected $conf = array(
    'forminput_prefix' => 'okfn-annot',
    'settings_page_title' => 'Annotator settings',
    'menu_item_title' => 'Annotator',
    'menu_item_identifier' => 'okfn-annotator',
    'submit_parameter_name' => 'okfn-annotsettings-submit',

    //options exposed to the user and stored in wordpress settings
    'default_options' => array(
      'annotator_content' => '.entry-content',
      'url_pattern' => '.*',
    )
  );

  function __construct(){
    parent::__construct();
    add_action('admin_menu', array($this,'register_menu'));
  }

  /*
   * Wrapper for calling wordpress internal 'get_option'. Its sole function is to
   * automatically add the plugin prefix defined in '$conf->forminput_prefix'.
   *
   * option        - the name of the option to be retrieved
   * useprefix     - whether or not the plugin prefix should be prepended; defaults to true (optional).
   *
   *
   * returns an option value
   */

  function get_option($option,$prefix=true) {
    if ($prefix) {
      $option_name = $this->conf->forminput_prefix . '-' . $option;
    }

    return get_option($option_name);
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

  /*
   * Checks for the presence of the form submit tocken
   *
   * returns a boolean
   */

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
    $options=OkfnUtils::filter_by_regexp("/^{$prefix}-/", $params);

    foreach($options as $option => $value) {
      print_r($option, $value);
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
     $stored_value = get_option("{$prefix}-{$optname}");
     $options[$optname] = empty($stored_value) ? $value : $stored_value ;
   }

   //unescape backslashes automatically added by php for string sanitation
   $options['url_pattern'] = stripslashes($options['url_pattern']);

   $mustache = new Mustache;
   $template = OkfnUtils::get_template('settings.html');
   print $mustache->render($template, $options);
 }

 /*
  * Public:
  *
  * Logical switch determining whether to render or to process the setting form.
  *
  *
  * params - the request parameters (defaults to $_POST if not provided).
  *
  *
  * returns nothing
  */

 function process_request($params=array()) {

   if (empty($params)) {
      $params = $_POST;
    }


   ( $this->form_is_submitted($params)) ?
     $this->process_settings_form($params) :
     $this->render_settings_form() ;
  }

}
?>
