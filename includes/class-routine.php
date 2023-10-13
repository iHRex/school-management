<?php
class Class_routine
{
	public $route_id;
	public $subject_id;
	public $teacher_id;
	public $class_id;
	public $week_day;
	public $start_time;
	public $end_time;
	public $table_name = 'smgt_time_table';
	public $day_list = array('1'=>'Monday',
	                         '2' => 'Tuesday',
							 '3' => 'Wednesday',
							 '4' => 'Thursday',
							 '5' => 'Friday',
							 '6' => 'Saturday',
							 '7' => 'Sunday');
	
	function __cunstuctor($route_id = null)
	{
		if($route_id)
		{}
	}
	public function save_route($route_data)
	{
		
		$table_name = "smgt_time_table";
		//echo $table_name;
		insert_record($table_name,$route_data);	
	}
	public function update_route($route_data,$route_id)
	{
		$table_name = "smgt_time_table";
		update_record($table_name,$route_data,$route_id);
	}
	public function is_route_exist($route_data)
	{
		$subject_id = $route_data['subject_id'];
		$teacher_id = $route_data['teacher_id'];
		$class_id = $route_data['class_id'];
		$weekday = $route_data['weekday'];
		$start_time = $route_data['start_time'];
		$end_time = $route_data['end_time'];
		global $wpdb;
		$table_name = $wpdb->prefix . $this->table_name;
		$route =$wpdb->get_row("SELECT * FROM $table_name WHERE subject_id=".$route_data['subject_id']." AND teacher_id=".$route_data['teacher_id']." 
		AND class_id=".$route_data['class_id']." AND start_time='".$route_data['start_time']."' AND end_time='".$route_data['end_time']."' AND weekday=".$route_data['weekday']);
		
		$route2 = $wpdb->get_row("SELECT * FROM $table_name WHERE  teacher_id=".$route_data['teacher_id']." 
		 AND start_time='".$route_data['start_time']."' AND end_time='".$route_data['end_time']."' AND weekday=".$route_data['weekday']);

		// $route3 = $wpdb->get_row("SELECT * FROM $table_name WHERE subject_id = $subject_id AND teacher_id = $teacher_id AND class_id = $class_id AND weekday = $weekday AND start_time between '$start_time' and '$end_time'");
		// $route3 = $wpdb->get_row("SELECT * FROM $table_name WHERE  subject_id=".$route_data['subject_id']." AND teacher_id=".$route_data['teacher_id']." 
		// AND class_id=".$route_data['class_id']." AND weekday=".$route_data['weekday']." AND start_time between ".$route_data['start_time']."and".$route_data['end_time']);
		if(empty($route) && empty($route2))
			return 'success';
		else
		{
			if(count($route) > 0)
				return 'duplicate';
			if(count($route2) > 0)
				return 'teacher_duplicate';
		}
			
	}
	
	public function get_periad($class_id,$section,$week_day)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_name;
        $table_subject = $wpdb->prefix . 'subject';
        
        $route =$wpdb->get_results("
            SELECT * FROM $table_name as route,$table_subject as sb 
            WHERE route.class_id=".$class_id." 
            AND route.section_name=".$section." 
            AND route.subject_id = sb.subid 
            AND route.weekday=".$week_day."
            GROUP BY route.class_id,route.subject_id,route.weekday,route.start_time,route.end_time,route.section_name ORDER BY route.route_id ASC");
			
        if(empty($route))
        {
            $route =$wpdb->get_results("
                SELECT * FROM $table_name as route,$table_subject as sb 
                WHERE route.class_id=".$class_id."
				AND route.section_name=".$section."
                AND route.subject_id = sb.subid 
                AND route.weekday=".$week_day."
                GROUP BY route.class_id,route.subject_id,route.weekday,route.start_time,route.end_time,route.section_name ORDER BY route.route_id ASC");
		}
        return $route;
    }
    
    public function get_periad_by_teacher($teacher_id,$week_day)
    {
        global $wpdb;
        $t1 = $wpdb->prefix . $this->table_name; /*smgt_time_table*/
        $t2 = $wpdb->prefix . 'smgt_teacher_class'; 
        $t3 = $wpdb->prefix . 'teacher_subject'; 
		 
		global $wpdb;
		$table = $wpdb->prefix . 'smgt_teacher_class';
		$result = $wpdb->get_results('SELECT * FROM '.$table.' where teacher_id ='.$teacher_id);
		
		$return_r = array();
		$classes = array();
		if(!empty($result))
		{
			foreach($result as $retrive_data)
			{
				$classes[] = $retrive_data->class_id;
			}
		}
		
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
		$classes = implode(",",$classes);
		if(!empty($subjects))
		{
			$subjects = implode(",",$subjects);
			$tbl = $wpdb->prefix . $this->table_name;
		
			$route = $wpdb->get_results("
                SELECT * FROM $t1 
                WHERE weekday={$week_day}
				AND class_id IN ({$classes})
				AND subject_id IN ({$subjects})                
                ");
		}
		else
		{
			$route ="";
		}
		
        return $route;
    }
	
}
?>