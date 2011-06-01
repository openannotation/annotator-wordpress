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

  /*
   * Converts a multi dimensional array into a multi dimensional object
   * (source: http://www.if-not-true-then-false.com/2009/php-tip-convert-stdclass-object-to-multidimensional-array-and-convert-multidimensional-array-to-stdclass-object/)
   *
   * $array - the input array
   *
   * examples:
   *   $object = OkfnUtils::objectify(array(
   *      'a' => array(
   *         'a1' => array(
   *            'a1a' => 'hi!'
   *          )
   *       ),
   *       'b'
   *   ));
   *
   *   echo $object->a->a1->a1a //=> hi!
   *
   * returns a multi-dimensional object
   */

  static function objectify($array) {

    if (is_array($array)) {
      return (object) array_map(array(__CLASS__, __FUNCTION__), $array);
    } else {
      return $array;
    }
  }

  /*
   * Generates a unique identifier by combining a prefix and an autoincremental integer
   *
   * prefix - a string to be prepended to the numeric id (optional).
   *
   * returns the unique identifer string.
   *
   */
  static function unique_id($prefix='id_') {
    static $id;
    $id = isset($id) ? $id + 1 : 0;
    return "{$prefix}{$id}";
  }

  /*
   * Gets the current page URL.
   *
   *
   * Returns a URL string.
   *
   */

  static function current_url() {
    return 'http://' . preg_replace('/\/$/', '', $_SERVER['HTTP_HOST']) .
      $_SERVER['REQUEST_URI'];
  }

}

?>
