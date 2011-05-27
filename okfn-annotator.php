<?php

/**
 * @package OkfnAnnotator
 * @author Andrea Fiore
 *
 * Main plugin controller
 *
 */


/*
Plugin Name: Open Knowledge Foundation's Annotator
Plugin URI: https://github.com/okfn/annotator-wordpress
Description: Adds inline annotations to your blog through the <a href="http://annotateit.org">OKNF Annotator</a>.
Version: 0.1
Author: Open Knowledge Foundation
Author URI: http://okfn.org/projects/annotator/
License: GPLv2 or later
*/

foreach(array(
  'vendor/Mustache',
  'lib/okfn-utils',
  'lib/okfn-annot-settings',

) as $lib) require("${lib}.php");

?>
