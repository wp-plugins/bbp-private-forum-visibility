<?php

//This plugin adds visibility for private forums (and descriptions) to non-logged in
/*
Plugin Name: bbp Private Forums Visibility
Plugin URI: http://www.rewweb.co.uk/Private Forums Visibility/
Description: For bbPress - displays private forums titles and optional descriptions to non-logged in users in main index, and optionally hides the prefix 'private'
Author: Robin Wilson
Version: 2.0
Author URI: http://www.rewweb.co.uk
License: GPL2
*/
/*  Copyright 2013  PLUGIN_AUTHOR_NAME  (email : wilsonrobine@btinternet.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/


/*******************************************
* global variables
*******************************************/

// load the plugin options
$pfv_options = get_option( 'pfv_settings' );

if(!defined('PFV_PLUGIN_DIR'))
	define('PFV_PLUGIN_DIR', dirname(__FILE__));




/*******************************************
* file includes
*******************************************/
include(PFV_PLUGIN_DIR . '/includes/settings.php');
include(PFV_PLUGIN_DIR . '/includes/functions.php');


