<?php 
class Smgt_dashboard
{
	public function get_signle_notification_by_id($id)
	
	{
		global $wpdb;
		
		$smgt_notification=$wpdb->prefix. 'smgt_notification';
		
		$result= $wpdb->get_row("SELECT * FROM $smgt_notification WHERE notification_id=$id");
		
		return $result;
	}
}
?>