<?php
/**
Plugin Name: Developer images
Plugin URI: https://thewpcrowd.com
Description: For those times that you need the images from the site but you don't want to change the db when working with the production db locally
Author: Andrew killen
Version: 1.0
**/

require('developerimagesMain.php');
$main = developerimagesMain::get_instance();