<?php 
class Smgt_Teacher
{
	public function smgt_add_muli_class($classes,$name)
	{
		global $wpdb;
		$table = $wpdb->prefix . 'smgt_teacher_class';
		$teacher = get_user_by('login',$name);
		$created_by = get_current_user_id();
		$created_date = date('Y-m-d H:i:s');
		
		if(!empty($classes) && !empty($teacher))
		{
			foreach($classes as $class)
			{
				$success = $wpdb->insert($table,array('teacher_id'=>$teacher->ID,
											'class_id'=>$class,
											'created_by'=>$created_by,
											'created_date'=>$created_date));
			}
		}
		else{
			return false;
		}
		return $success;
		
	}
	public function get_teacher_class($teacher_id)
	{
		global $wpdb;
		$table = $wpdb->prefix . 'smgt_teacher_class';
		$result = $wpdb->get_results('SELECT * FROM '.$table.' where teacher_id ='.$teacher_id);
		$return_r = array();
		foreach($result as $retrive_data)
		{
			$return_r[] = $retrive_data->class_id;
		}
		return $return_r;
	}
	public function get_class_teacher($class_id)
	{
		global $wpdb;
		$table = $wpdb->prefix . 'smgt_teacher_class';
		$result = $wpdb->get_results('SELECT * FROM '.$table.' where class_id ='.$class_id,ARRAY_A);
		
		return $result;
	}
	public function get_singal_class_teacher($class_id)
	{
		global $wpdb;
		$table = $wpdb->prefix . 'smgt_teacher_class';
		$result = $wpdb->get_row('SELECT * FROM '.$table.' where class_id ='.$class_id);
		
		return $result;
	}
	public function smgt_update_multi_class($classes,$teacher_id)
	{
		global $wpdb;
		$table = $wpdb->prefix . 'smgt_teacher_class';
		$created_by = get_current_user_id();
		$created_date = date('Y-m-d H:i:s');
		$post_classes = $classes;
		$old_class = $this->get_teacher_class($teacher_id);
		$new_insert = array_diff($post_classes,$old_class);
		$delete_class = array_diff($old_class,$post_classes);
		$success = 1;
		if(!empty($new_insert))
		{
			foreach($new_insert as $class_id)
			{
				$success = $wpdb->insert($table,array('teacher_id'=>$teacher_id,
												'class_id'=>$class_id,
												'created_by'=>$created_by,
												'created_date'=>$created_date));
			}
		}
		if(!empty($delete_class))
		{
			foreach($delete_class as $class_id){
				$wpdb->delete($table,array('teacher_id'=>$teacher_id,'class_id'=>$class_id));		
			}
			
		}
		return $success;
	}
	
	
	public function smgt_get_class_by_teacher($teacher_id){
		global $wpdb;
		$table = $wpdb->prefix . 'smgt_teacher_class';
		$data = $wpdb->get_results("SELECT class_id FROM {$table} WHERE teacher_id = {$teacher_id}",ARRAY_A);
		return $data;
	}
	
	public function smgt_get_class_by_teacher_notification($teacher_id){
		global $wpdb;
		$classes = array();
		$table = $wpdb->prefix . 'smgt_teacher_class';
		$data = $wpdb->get_results("SELECT class_id FROM {$table} WHERE teacher_id = {$teacher_id}",ARRAY_A);
		foreach($data as $key=>$value)
		{
			foreach($value as $class)
			{
				$classes[] = $class;				
			}			
		}		
		return $classes;
	}
	
	function in_array_r($needle, $haystack, $strict = false) {
		foreach ($haystack as $item) {
			if (($strict ? $item === $needle : $item == $needle) || ( is_array($item) && $this->in_array_r($needle, $item, $strict))) {
				return true;
			}
		}

		return false;
	}
	
	function smgt_get_teacher_by_class($class_id = null)
	{
		global $wpdb;
		$table = $wpdb->prefix . 'smgt_teacher_class';
		if($class_id != null)
		{
			$results = $wpdb->get_results("SELECT teacher_id FROM {$table} WHERE class_id = {$class_id}",ARRAY_A);
			return $results;
		}else
		{ return false;}
	}
	
	function get_teacher_subjects($teacher_id)
	{
		$table = $wpdb->prefix . 'teacher_subject';
		$result = $wpdb->get_results('SELECT * FROM '.$table.' where teacher_id ='.$teacher_id);
		$return_r = array();
		if(!empty($result))
		{
			foreach($result as $retrive_data)
			{
				$subjects[] = $retrive_data->subject_id;
			}
		}
		return $subjects;
	}

}
?>