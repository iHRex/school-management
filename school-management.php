<?php
/*
Plugin Name: School Management Wordpress Plugin
Plugin URI: https://github.com/iiHR5/sms-wordpress
Description: School Management System Plugin for wordpress is ideal way to manage complete school operation. 
The system has different access rights for Admin, Teacher, Student and Parent.
Version: 4A.5.0 (10-01-2023)
Author: iHRex(iiHR5)
Author URI: https://profile.hrserv.in
Text Domain: school-mgt
Domain Path: /languages
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Copyright 2015  iHRex(iiHR5)  (email : harsh@hrsev.in)
*/
 
define( 'SMS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

define( 'SMS_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );

define( 'SMS_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );
define( 'SMS_CONTENT_URL',  content_url( ));

require_once SMS_PLUGIN_DIR . '/settings.php';
require_once SMS_PLUGIN_DIR . '/api/school-api-files.php';
if (isset($_REQUEST['page']))
{
	if($_REQUEST['page'] == 'callback')
	{
	   require_once SMS_PLUGIN_DIR. '/callback.php';
	}
}
?>