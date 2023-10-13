<?php
class smgt_exam
{
	public function smgt_get_subject_by_section_id($class_id,$section_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "subject";
		return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE  class_id='$class_id' and section_id='$section_id' ");
	}
	public function smgt_get_subject_by_class_id($class_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "subject";
		return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE  class_id='$class_id'");
	}
	public function insert_sub_wise_time_table($class_id,$exam_id,$subject_id,$exam_date,$start_time,$start_min,$sam,$end_time,$end_min,$eam)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "smgt_exam_time_table";
		$curr_date=date('Y-m-d');
		$curren_user= get_current_user_id();
		$exam_date_new=date('Y-m-d',strtotime($exam_date));
		$start_time_new=$start_time.':'.$start_min.':'.$sam;
		$end_time_new=$end_time.':'.$end_min.':'.$eam;
		$check_insrt_or_update =$this->check_subject_data($exam_id,$subject_id);
		 
		if(empty($check_insrt_or_update))
		{
			$save_data =$wpdb->insert($table_name,array('class_id' =>$class_id,
				'exam_id' =>$exam_id,
				'subject_id' =>$subject_id, 'exam_date' =>$exam_date_new,'start_time' =>$start_time_new,'end_time'=>$end_time_new,'created_date'=>$curr_date,'created_by'=>$curren_user));
		}
		else 
		{
			$save_data =$wpdb->update($table_name,
					array('exam_date' =>$exam_date_new,'start_time' =>$start_time_new,'end_time'=>$end_time_new,'created_date'=>$curr_date,'created_by'=>$curren_user),
					array('class_id' =>$class_id,'exam_id' =>$exam_id,'subject_id' =>$subject_id));
		}  
	 
		return $save_data;
		
	}
	public function check_subject_data($exam_id,$subject_id)
	{
		
		global $wpdb;
		$table_name = $wpdb->prefix . "smgt_exam_time_table";
		$results=$wpdb->get_results("SELECT * FROM $table_name WHERE exam_id=$exam_id and  subject_id=$subject_id");
		
		return $results;
	}
	public function check_exam_time_table($class_id,$exam_id,$sub_id)
	{
		global $wpdb;
		
		$table_name = $wpdb->prefix . "smgt_exam_time_table";
		$result=$wpdb->get_row("SELECT * FROM $table_name WHERE class_id=$class_id and exam_id=$exam_id and subject_id=$sub_id");
		//$result=$wpdb->get_row("SELECT * FROM $table_name WHERE class_id=$class_id and subject_id=$sub_id");
		return $result;
	
	}
	public function get_exam_time_table_by_exam($exam_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "smgt_exam_time_table";
		$results=$wpdb->get_results("SELECT * FROM $table_name WHERE exam_id=$exam_id");
		return $results;
	}
	public function get_all_exam_by_class_id_created_by($class_id,$user_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "exam";
		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id IN (".implode(',', $class_id).") OR exam_creater_id=".$user_id);
		return $results;
	}
	public function get_all_exam_created_by($user_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "exam";
		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE exam_creater_id=".$user_id);
		return $results;
	}
	function get_all_exam_by_class_id_dashboard($class_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "exam";
		return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id =$class_id and section_id='0' ORDER BY exam_id DESC limit 3");
	
	}
	function get_all_exam_by_class_id_and_section_id_array_dashboard($class_id,$section_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "exam";
		return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id=".$class_id." and section_id=$section_id ORDER BY exam_id DESC limit 3");
		
	}
	public function get_all_exam_by_class_id_created_by_dashboard($class_id,$user_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "exam";
		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id IN (".implode(',', $class_id).") OR exam_creater_id=$user_id ORDER BY exam_id DESC limit 3");
		return $results;
	}
	function get_all_exam_by_class_id_array_dashboard($class_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "exam";
		return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id IN (".implode(',',$class_id).") and section_id='0' ORDER BY exam_id DESC limit 3");
		
	}
	public function get_all_exam_created_by_dashboard($user_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "exam";
		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE exam_creater_id=$user_id ORDER BY exam_id DESC limit 3");
		return $results;
	}
}
?>