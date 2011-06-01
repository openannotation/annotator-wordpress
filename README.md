# Annotator plugin for Wordpress

Adds inline annotations to Wordpress using the 
[Annotator](http://github.com/okfn/annotator) widget (by the Open Knowledge Foundation).

## Features

- Includes the Annotator JavaScript code and its third party
  party dependencies (i.e. `jquery.js`, and `json2.js`) into the currently active theme (no HTML editing needed).
- Offers the option to configure the annotable content area from the Wordpress settings page.
- Provides blog administrators with the option to decide whether to display only authenticated users' annotations or also annotations made by anonymous users.
- Provides a rudimentary regular expressions' based mechanism for configuring in what pages/blog sections the Annotator widget should be included.


## Requirements

PHP >= 5.\*.\*

## Install

Just 'git clone' this project into the `wp-content/plugins/`, then
activate the plugin through the Wordpress administration panel
accessible at http://<blogaddress>/wp-admin/plugins.php.

You will also need to sign up at [AnnotateIt](http://annotateti.org) and 
fill  in your account id and authentication token in the Plugin settings
page.


## Demo

A blog post showing the plugin in action be found [here](http://wp-annotator.andreafiore.me/). The plugin settings this specific installation are depicted in the screenshot below:

<img src="https://github.com/okfn/annotator-wordpress/raw/master/screenshot.png" width="638" height="431" alt="wp-annotator settings screenshot" />


### Bugs and feature requests

You are welcome to submit bug reports as well as ideas and feature
requests using the [GitHub issue tracker]().

### Running the unit tests

The plugin comes with fairly decent test suite. To run the tests you will need [PEAR](http://pear.php.net/), the PHP package manager.
Once installed PEAR, you can then install the latest version of PHPUnit package by issuing the following commands:

    pear channel-discover pear.phpunit.de
    pear channel-discover components.ez.no
    pear channel-discover pear.symfony-project.com
    pear install phpunit/PHPUnit

Finally the test suite can be run from within the project root
directory by simply issuing the phpunit executable:

    phpunit

The test suite can also be run automatically whenever one of the project
files change. This is desirable while developing, as it allows to spot
regressions and to update the tests sooner rather than later. In order
to automate the test runner you will need to install and run
[guard](https://github.com/guard/guard), a Ruby tool that allows to
capture file system events (such as file changes) and to bind custom
commands to them. The 'Guardfile' contains a few configuration directive
necessary for doing this with PHPUnit.
