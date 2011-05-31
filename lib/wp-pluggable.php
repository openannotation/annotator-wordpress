<?php

/*
 * Implement pluggable wordpress functions
 * if these are not available yet
 *
 */


if ( !function_exists('wp_get_current_user') ) {
  function wp_get_current_user() {
    // Insert pluggable.php before calling get_currentuserinfo()
    require_once(ABSPATH . WPINC . '/pluggable.php');
    global $current_user;
    get_currentuserinfo();
    return $current_user;
  }
}
?>
