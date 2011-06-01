<?php
/*
 * Handles user defined policies about what content should be annotable.
 *
 * The only user setting currently available to define the Annotator content policy
 * is the the "Url inclusion pattern" regular expression. In the future we might want 
 * to provide a more user friendly and fine grained mechanism.
 *
 */
class OkfnAnnotContentPolicy extends OkfnBase {
  private $settings;
  private $url_pattern;

  /*
   * Public:
   * initialises the instance.
   *
   * settings - an instance of the OkfnAnnotSettings class.
   *
   *
   */
  public function __construct($settings) {
    $this->settings = $settings;
    $pattern = $settings->get_option('url_pattern');
    $this->url_pattern = empty($pattern) ?  '.*' : preg_quote($pattern);
  }

  /*
   * Checks if a URL is annotable.
   *
   * url - a URL string; defaults to current url (optional).
   *
   * returns whether or not the annotator should be injected in this url.
   *
   */
  function url_is_annotable($url=null) {
    $url or $url = OkfnBase::current_url();
    return preg_match("/" . $this->url_pattern . "/", $url);
  }

}
?>
