=== Super Recent Posts Widget === 

Contributors: matstars  
Tags: post, widget  
Requires at least: 3.6  
Tested up to: 3.8  
version: 0.2.3
Stable tag: 0.2.3
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

A prettier, filterable and more functional recent posts widget that allows you to choose a custom post type or specific taxonomy.

== Description ==

Drag and drop the widget and fill out the appropriate fields. Some notes:

To display posts from a specific post type leave Taxonomy as "-- No Specific Taxonomy --"  

If you leave order by and/or order as "-- Choose order parameter --" and/or "-- Choose orderby parameter --" it will go with WordPress' default(s), [see here](http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters) for more information.  

The following filters are available: 

*    **srpw_get_args** to override arguments of main query for the widget.  
*    **srpw_template** to override the output template for the widget, see below for more information.  
*    **srpw_WIDGET_NAME_template** to override the output template for the widget on a widget by widget basis, the WIDGET_NAME appears on the back-end in the widgets window see below for more information.  
*    **widget_title** this is a WordPress core filter [see here](http://codex.wordpress.org/Plugin_API/Filter_Reference) for more information.  
*    **srpw_post_types** to override the post types available for this widget.  
*    **srpw_taxonomies** to override the taxonomies available for this widget.  

#### Usage of srpw_template filter

Add a "views" directory and file named "custom-srpw.php" to your template directory. The "custom-srpw.php" file will be your custom template for this example.

#### Example of using a custom template from within your theme pre-PHP 5.3



    `<?php

    function customize_srpw_template_filter( $template ){
        $template_dir = get_template_directory();
        return $template_dir . '/views/custom-srpw.php';    
    }
    add_filter( 'srpw_template', 'customize_srpw_template_filter' );
    ?>`


#### Example of using a custom template from within your theme PHP 5.3+ which allows anonymous functions

    `<?php

    add_filter( 'srpw_template', function ( $template ){
        $template_dir = get_template_directory();
        return $template_dir . '/views/custom-srpw.php';    
    } );
    ?>`

#### Grunt

This plugin takes advantage of Grunt for validating JavaScript, SASS compilation and minification. To take advantage of Grunt you have to have both [npm](https://npmjs.org/) and [Grunt](http://gruntjs.com/) installed. Visit the respective sites for the applications and make sure they are installed. Once installed, if you want to edit/fork this plugin, it will be helpful to be familiar with these two tools.


== Installation ==

1. If installing manually, unzip and copy the resulting directory to your plugin directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add the widget to any widgetized area/sidebar and configure as desired.

== Frequently Asked Questions ==

= This isn't working! =

Are you using WordPress 3.6+?

== Screenshots ==

1. Screenshot of widget

== Changelog ==

= 0.2.3 =
* Bugfixes

= 0.2.2 =
* cleaned up javascript
* added widget by widget templating

= 0.1.4 =
* Updated transient logic to be more efficient
* Minor helper/guide text updated

= 0.1.3 =
* Readme edits

= 0.1.1 =
* Initial release
