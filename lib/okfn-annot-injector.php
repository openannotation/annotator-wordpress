<?php

/*
 *
 * Appends the Annotator JavaScript and CSS files (with their respective dependencies)
 * to the document leveraging the appropriate Wordpress hooks.
 *
 *
 */

class OkfnAnnotInjector extends OkfnBase {
  public $conf = array(
    'assets_basepath' => '/vendor/',

    // In the sake of semplicity for now we only support the full minified version
    // of the annotator (A more fine grained control through the settings can be implemented later).

    'javascripts' => array(
      array(
        'file' => 'javascripts/json2.min.js'
      ),
      array(
        'file' => 'javascripts/jquery.min.js'
      ),
      array(
        'file' => 'javascripts/annotator/annotator-full.min.js',
        'dependencies' => array('json2','jquery'),
      ),
    ),

    'stylesheets' => array(
      array(
        'file' => 'stylesheets/annotator.min.css'
      )
    )
  );

  function __construct(){
    parent::__construct();
  }

  /*
   * Enqueues the Annotator's dependencies (i.e. JSON2, and jQuery).
   *
   * returns nothing
   *
   */
  function load_javascript_dependencies(){
    wp_enqueue_style('json2');
    wp_enqueue_style('jquery');
  }

  /*
   * Public:
   *
   * Enqueues the Annotator javascript files
   *
   * returns nothing
   *
   */
  public function load_javascripts() {
    $this->load_javascript_dependencies();
    $this->load_assets('javascripts');
  }

  /*
   * Public:
   *
   * Enqueues the Annotator stylesheet/s
   *
   * returns nothing
   *
   */
  function load_stylesheets() {
    $this->load_assets('stylesheets');
  }


  /*
   * Ensures that libraries are registered with the '.{js|css}' and not the '.min.{js|css}' prefix
   * prefix
   *
   * path - a relative path to an asset
   *
   */
  function library_id($path) {
    return preg_replace('/(\.min)\.(js|css)$/','.$2', basename($path) );
  }

  /*
   * Registers the annotator assets (as specified in $conf) and enqueues them using
   * the wordpress loading functions
   *
   * javascripts_or_stylesheets - Whether it should load javascripts or stylesheets.
   *
   * returns nothing
   */

  private function load_assets($javascripts_or_stylesheets) {

    foreach($this->conf->$javascripts_or_stylesheets as $asset) {

      $in_footer = isset($asset->in_footer) && $asset->in_footer;

      $loader_function = ($javascripts_or_stylesheets === 'javascripts') ?
        'wp_enqueue_script' :
        'wp_enqueue_style';


      call_user_func_array($loader_function, array(
        $this->library_id($asset->file),
        plugins_url("{$this->conf->assets_basepath}/{$asset->file}" , dirname(__FILE__)),
        $asset->dependencies,
        //optional version number
        false,

        // note: in 'wp_enqueue_style' this last argument indicates the stylesheet media type (i.e. screen, handled, etc)
        // we can safely pass the value of $in_footer here, as long as this is false, in which case the value of the media attribute will just default to screen.
        $in_footer
      ));

    }
  }

  function inject() {
    //TODO: implement the annotator inclusion logic here ; design a simple mechanism whereby the
    //      user can specify in what URL patterns or content types the annotator should be included.

    add_action('wp_print_styles', array($this,'load_stylesheets'));
    add_action('wp_print_scripts', array($this,'load_javascripts'));
  }
}
?>
