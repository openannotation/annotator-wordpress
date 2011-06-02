<?php
/**
 * test/lib/test-helpers.php
 *
 * Collection test helper functions
 *
 *
 */


/*
 * Mocks wordpress' hook registration function
 * and just runs the registred callback
 *
 *
 * $action   - string identifying the wordpress hook
 * $callback - a function name of an array containing the instance object as the first element and the method to be called as the second one.
 *
 *
 * returns nothing.
 */

function add_action($action, $callback) {
  call_user_func($callback);
}




/*
 * Mocks wordpress' internal function for fetching user data.
 *
 * returns the value of the global variable okfn_test_user;
 */

function wp_get_current_user() {
  global $okfn_fixtures;
  return $okfn_fixtures->current_user;
}

?>
