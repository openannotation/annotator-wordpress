<?php

/**
 * @package OkfnAnnotator
 * @author Andrea Fiore
 *
 * Collection of utility functions
 *
 */

class OkfnUtils {

  /*
   * Extracts from an array the key values pairs matching a certain regular expression.
   * Optionally, also strips the matched string from the extracted keys.
   *
   * regexp          - A regular expression string (within delimiters).
   * array           - The array to be filtered (is supposed to be an associative array).
   * remove_matches   - Whether the matched string should be removed or not (defaults to false).
   *
   * examples
   *
   *   $annotator_options = OkfnUtils::filter_by_regexp('/^okfn-annotator/', $_POST, $remove_matches=true);
   *
   * returns the filtered key-value collection
   */

  static function filter_by_regexp($regexp, $array, $remove_matches=false) {
    $filter_lambda = create_function('$item, $reg="' . $regexp .'"' , 'return preg_match($reg, $item); ');
    $replace_lambda = create_function('$item, $reg="' . $regexp .'"', 'return preg_replace($reg, "", $item);');


    list($filtered_keys,$filtered_array) = array(
      array_filter(array_keys($array), $filter_lambda),
      null
    );

    foreach($filtered_keys as $key) {
      $new_key = ($remove_matches)? $replace_lambda($key) : $key;
      $filtered_array[$new_key] = $array[$key];
    }

    return $filtered_array;
  }

  /*
   * Simple utility method for retrieving templates
   *
   * template  - the template name
   * directory - the template directory (defaults to 'templates')
   *
   * return the template content
   *
   *
   */
  static function get_template($file, $directory='templates') {
    $plugin_path = dirname(dirname(__FILE__));
    return file_get_contents("{$plugin_path}/{$directory}/{$file}");
  }


}
?>
