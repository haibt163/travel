<?php
/*
  Plugin Name: Super Recent Posts Widget  
  Description: A prettier, filterable and more functional recent posts widget that allows you to choose a custom post type or specific taxonomy.  
  Version: 0.2.3  
  Author: Mat Gargano  
  Author URI: http://www.matgargano.com
*/

require_once('lib/Class-super-recent-posts-widget.php');
require_once('lib/Class-srpw-helper.php');
require_once('lib/Class-srpw-ajax.php');
Super_recent_posts_widget::init();
