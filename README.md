# UCF Document Plugin #

Provides a custom post type and taxonomies for managing documents.


## Description ##

The UCF Document plugin provides the `document` custom post type and the `document_category` and `document_tag` taxonomies for managing and displaying documents.


## Documentation ##

Head over to the [UCF Document Plugin wiki](https://github.com/UCF/UCF-Document-Plugin/wiki) for detailed information about this plugin, installation instructions, and more.


## Changelog ##

### 0.2.6 ###
Bug Fixes:
* Added extra check to ensure `get_plugin_data` is defined.

### 0.2.5 ###
Enhancements:
* Added composer file.

### 0.2.4 ###
Bug Fixes:
* Suppressed a potential namespacing-related error.

### 0.2.3 ###
Enhancements:
* Added `ucf_document_acf_pro_path` and `ucf_document_acf_free_path` filter hooks to allow custom ACF install paths to be specified when checking if ACF is activated.

Bug Fixes:
* Fixed a bug where checks to determine if ACF is active weren't firing at the correct time, causing Document fields to not register
* Added plugin dir path to required files in main plugin file

### 0.2.2 ###
Bug Fixes:
* Updated ACF check from an `is_plugin_active` to a `class_exists` check. #15 Thank you @TheMarkBennett

### 0.2.1 ###
Documentation:
* Updated contributing doc to reflect the switch from slack to teams.

### 0.2.0 ###
Enhancements:
* Added configuration option for determining default behavior when clicking a document link.

### 0.1.0 ###
* Initial pre-release


## Upgrade Notice ##

n/a


## Development ##

Note that compiled, minified css and js files are included within the repo.  Changes to these files should be tracked via git (so that users installing the plugin using traditional installation methods will have a working plugin out-of-the-box.)

[Enabling debug mode](https://codex.wordpress.org/Debugging_in_WordPress) in your `wp-config.php` file is recommended during development to help catch warnings and bugs.

### Requirements ###
* node
* gulp-cli

### Plugin Depedenecies ###
* [Advance Custom Fields Pro](https://www.advancedcustomfields.com/pro/)

### Instructions ###
1. Clone the UCF-Document-Plugin repo into your local development environment, within your WordPress installation's `plugins/` directory: `git clone https://github.com/UCF/UCF-Document-Plugin.git`
2. `cd` into the new UCF-Document-Plugin directory, and run `npm install` to install required packages for development into `node_modules/` within the repo
3. Optional: If you'd like to enable [BrowserSync](https://browsersync.io) for local development, or make other changes to this project's default gulp configuration, copy `gulp-config.template.json`, make any desired changes, and save as `gulp-config.json`.

    To enable BrowserSync, set `sync` to `true` and assign `syncTarget` the base URL of a site on your local WordPress instance that will use this plugin, such as `http://localhost/wordpress/my-site/`.  Your `syncTarget` value will vary depending on your local host setup.

    The full list of modifiable config values can be viewed in `gulpfile.js` (see `config` variable).
3. Run `gulp default` to process front-end assets.
4. If you haven't already done so, create a new WordPress site on your development environment to test this plugin against, and [install and activate all plugin dependencies](https://github.com/UCF/UCF-Document-Plugin/wiki/Installation#installation-requirements).
5. Activate this plugin on your development WordPress site.
6. Configure plugin settings from the WordPress admin under "UCF Documents".
7. Run `gulp watch` to continuously watch changes to scss and js files. If you enabled BrowserSync in `gulp-config.json`, it will also reload your browser when plugin files change.

### Other Notes ###
* This plugin's README.md file is automatically generated. Please only make modifications to the README.txt file, and make sure the `gulp readme` command has been run before committing README changes.  See the [contributing guidelines](https://github.com/UCF/UCF-Document-Plugin/blob/master/CONTRIBUTING.md) for more information.


## Contributing ##

Want to submit a bug report or feature request?  Check out our [contributing guidelines](https://github.com/UCF/UCF-Document-Plugin/blob/master/CONTRIBUTING.md) for more information.  We'd love to hear from you!
