<?php
/*
	#Plugin Name: Mockingbird Plugin
	#Plugin URI: http://www.carmichaelize.co.uk
	#Description: Content relator plugin.
	#Author: Scott Carmichael
	#Version: 1.0
	#Author URI: http://www.scarmichael.co.uk
	#Licence: GPL2

	Copyright 2013  Scott Carmichael  (email : hello@scottcarmichael.co.uk)

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

define("MOCKINGBIRD_URL", TEMPLATE_PATH."/inc/classes/mockingbird");

include('inc/mockingbird.php');

if( is_admin() ){

	//Load Admin Classes
	//include('inc/mockingbird_settings.php');
	include('inc/mockingbird_admin.php');

	//Build Settings Page
	//new Mockingbird_settings();

	//Build Post Type Widget
	//new Mockingbird_admin( 'sc_related_pages', array( 'display_on' => array('page'), 'types_to_display'=>array('post', 'page')) );

}