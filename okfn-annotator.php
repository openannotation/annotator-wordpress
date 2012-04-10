<?php

/**
 * @package OkfnAnnotator
 * @author Andrea Fiore
 * @author Nick Stenning
 *
 * Main plugin controller
 *
 */


/*
Plugin Name: Annotator
Plugin URI: https://github.com/okfn/annotator-wordpress
Description: Adds inline annotations to Wordpress using the amazing <a href="http://annotateit.org">Annotator</a> widget (by the Open Knowledge Foundation).
Version: 0.4
Author: Open Knowledge Foundation
Author URI: http://okfn.org/projects/annotator/
License: GPLv2 or later
*/


foreach(array(
  'lib/wp-pluggable',
  'vendor/Mustache',
  'lib/okfn-utils',
  'lib/okfn-base',
  'lib/okfn-annot-settings',
  'lib/okfn-annot-content-policy',
  'lib/okfn-annot-injector',
  'lib/okfn-annot-factory',
) as $lib) require_once("${lib}.php");

$settings = new OkfnAnnotSettings;

if (!is_admin()) {
  $factory  = new OkfnAnnotFactory($settings);
  $content_policy  = new OkfnAnnotContentPolicy($settings);
  $injector = new OkfnAnnotInjector($factory, $content_policy);
  $injector->inject();
}

?>
