<?php
/**
 * @package OkfnAnnotator 
 * @author Andrea Fiore
 *
 *
 */
class OkfnUtils {

  /**
   * Extracts from an array the list key values matching a certain regular expression.
   * Optionally, also removes the regexp string from the extracted keys
   *
   * @param $regexp String A regular expression string (within delimiters)
   * @param $array Array The collection to be filtered
   * @param $remove_prefix Boolean (defaults to false) 
   *
   * @return Array the filtered key-value collection
   *
   * @example:
   *
   *   $annotator_options = OkfnUtils::filter_by_regexp('/^okfn-annotator/', $_POST, $remove_match=true);
   *
   */
  static function filter_by_regexp($regexp, $array, $remove_match=false) {
    $lambda = create_function('&$regex, $item', 'return preg_match($regex, $item);');
    $filtered_array = array_filter($array, $lambda);

    if ($remove_match) {
      foreach ($filtered_array as $key => $value) {
        unset($filtered_array[$key]);
        $filtered_array[ preg_replace($regexp, '')] = $value;
      }
    }
  }

  /**
   * Simple utility method for retrieving templates' content
   *
   * @template String the template name
   * @directory String the template directory (defaults to 'templates')
   *
   * @return String the template content
   *
   *
   */
  static function get_template($file, $directory='templates') {
    return file_get_contents("${directory}/${file}");
  }


}
?>
