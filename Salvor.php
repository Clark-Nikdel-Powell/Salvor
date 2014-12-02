<?php

/*
  Plugin Name: Salvor
  Plugin URI: http://clarknikdelpowell.com
  Description: Test PHP code from wordpress control panel tools.
  Author: Samuel Mello
  Author URI: http://clarknikdelpowell.com/agency/people/sam/
  Version: 1.2


  Copyright 2013+ Clark/Nikdel/Powell (email : sam@clarknikdelpowell.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2 (or later),
  as published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// set global variable
$code = '';


function salvor_print_page() {
	global $code;
?>
<style>
#content {
	margin-top:50px;
}
#code {
	width:90%;
	height:300px;
}
#submit {
	display:block;
}
#results {
	margin-top:20px;
}
</style>
<h2>Salvor</h2>
<em>Inline PHP Testing</em>
<div id="content">
<?php
	if (is_super_admin()) {
?>
<form id="salvorform" action="tools.php?page=salvor" method="post">
<textarea name="code" id="code">
<?php
	if (isset($code) && $code) echo $code;
	else {
?>/*
*	Enter your PHP code in here.
*
*	You can use this to test wordpress functions like "get_post", "wp_uploads_dir", etc.
*/<?php
	}
?>
</textarea>
<input id="submit" class="button button-primary" type="submit" value="Execute Code" />
</form>
</div>
<div id="results">
<?php if(isset($code) && $code) echo '<h2><em>Results:</em></h2>' ?>
<?php 
	if(isset($code) && $code) {
		try {
			eval($code); 
		}
		catch (Exception $e) {
			echo $e; 
		}
	}
}
else {
	echo '<span style="color:#f00;">You must be a super-admin to use this tool.</span>';
}
?>
</div>
<?php
}


function salvor_create_page() {
  add_management_page('Salvor','Salvor','manage_options','salvor','salvor_print_page');
}
add_action('admin_menu','salvor_create_page');


function salvor_intercept_post() {
	global $code;
	if (isset($_POST['code']) && $_POST['code']) {
		$code = stripslashes($_POST['code']);
	}
}
add_action('wp_loaded','salvor_intercept_post');
?>