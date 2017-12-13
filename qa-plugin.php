<?php

/*
	Plugin Name: q2apro Change Post Owner
	Plugin URI: http://www.q2apro.com/plugins/
	Plugin Description: Change the owner of a post
	Plugin Version: 0.1
	Plugin Date: 2016-03-18
	Plugin Author: q2apro.com
	Plugin Author URI: http://www.q2apro.com/
	Plugin License: GPLv3
	Plugin Minimum Question2Answer Version: 1.6
	Plugin Update Check URI: 

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.gnu.org/licenses/gpl.html
	
*/

	if ( !defined('QA_VERSION') ) { // don't allow this page to be requested directly from browser
		header('Location: ../../');
		exit;
	}

	// page
	qa_register_plugin_module('page', 'q2apro-post-owner-page.php', 'q2apro_post_owner_page', 'Post Owner Page');

	// language file
	qa_register_plugin_phrases('q2apro-post-owner-lang-*.php', 'q2apro_post_owner_lang');


	
	function q2apro_get_parentid_from_postid($postid)
	{
		return qa_db_read_one_value( 
				qa_db_query_sub('SELECT parentid FROM `^posts` 
									WHERE `postid` = # 
									', $postid) 
									);
	}

	function q2apro_get_type_from_postid($postid)
	{
		return qa_db_read_one_value( 
				qa_db_query_sub('SELECT type FROM `^posts` 
									WHERE `postid` = # 
									', $postid) 
									);
	}

/*
	Omit PHP closing tag to help avoid accidental output
*/
