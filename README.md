# Docs update in progress ...

# Annotator plugin for Wordpress

Adds inline annotations to Wordpress using the amazing 
[Annotator](http://github.com/okfn/annotator) widget (by the Open Knowledge Foundation).

## Features

- Includes the Annotator JavaScript code and its third party
  party dependencies (i.e. `jquery.js`, and `json2.js`) into the currently active theme (no HTML editing needed).
- Offers the option to configure the annotable content area from the Wordpress settings page.
- Provides blog administrators with the option to decide whether to display only authenticated users' annotations or also annotations made by anonymous users.
- Provides a rudimentary regular expressions' based mechanism for configuring in what pages/blog sections the Annotator widget should be included.


## Requirements

PHP >= 5.3.\*

## Install

Just `git clone` this project into the `wp-content/plugins/` directory, then
activate the plugin through the Wordpress administration panel accessible at `http://<blogaddress>/wp-admin/plugins.php`.

You will also need to sign up at [AnnotateIt](http://annotateti.org) and 
fill your _key_ and _secret_ details in the Plugin settings form.


## Demo

A blog post showing the plugin in action can be found [here](http://wp-annotator.andreafiore.me/2011/05/26/hello-world/). The plugin settings for this specific installation are depicted in the screenshot below:

<img src="https://github.com/okfn/annotator-wordpress/raw/master/screenshot.png" alt="wp-annotator settings screenshot" />


### Bugs and feature requests

You are welcome to submit bug reports as well as ideas and feature
requests using the [GitHub issue tracker](https://github.com/okfn/annotator-wordpress/issues).

### Running the unit tests

The plugin comes with a fairly decent test suite. To run the tests you will need [PEAR](http://pear.php.net/), the PHP package manager.
Once installed PEAR, you will also need to install the latest version of the PHPUnit package. This can be done by issuing the following commands:

    pear channel-discover pear.phpunit.de
    pear channel-discover components.ez.no
    pear channel-discover pear.symfony-project.com
    pear install phpunit/PHPUnit

The test suite has to be run from within the project root
directory by executing the phpunit command with no options or
arguments.

    phpunit

The test suite can also be configured to run automatically whenever the library code changes. This is desirable while developing, as it allows to spot
regressions sooner rather than later, and to keep tests up to date. In order
to automate the execution of the tests you will need to install and run
[guard](https://github.com/guard/guard), a Ruby tool that allows to bind custom
commands to file system events. The 'Guardfile' provided here contains a few useful configuration directives that allow doing this with PHPUnit tests.

