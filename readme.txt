=== Annotator ===
Contributors: a-fiore
Tags: annotation, okf, annotate.it
Requires at least: 3.2.0
Tested up to: 3.2.0
Stable tag: 0.4

Adds inline annotations to Wordpress using the Open Knowledge
Foundation's Annotator tool.

== Description ==


## Features

- Automatically includes the Annotator JavaScript code and its third party
  party dependencies (i.e. `jquery.js`, and `json2.js`) into the currently active theme (no HTML editing needed).
- Offers the option to configure the annotable content area from the Wordpress settings page.
- Provides blog administrators with the option to decide whether to display only authenticated users' annotations or also annotations made by anonymous users.
- Provides a rudimentary regular expressions' based mechanism for configuring in what pages/blog sections the Annotator widget should be included.


== Installation ==

1. Upload the 'okfn-annotator' folder and place it into into `/wp-content/plugins/`.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Finally, sign up at [AnnotateIt](http://annotateti.org) and 
fill your _Account ID_ and _Auth Token_ details in the Plugin settings
form.
