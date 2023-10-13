<?php

class Attendence_Manage
{
	
	public $class_id;
	public $status;
	public $attendance;
	public $student_id;
	public $attend_by;
	public $attendence_date;
	public $curr_date;
	public $table_name;
	public $result;
	public $role;
	public $savedata=0;
	
	
	public function __construct( $marks = null ) 
	{
		
			global $wpdb;
			$table_name = $wpdb->prefix . "attendence";
			
			//$this-> today_presents();
		
	}
	
	public function insert_student_attendance($curr_date,$class_id,$user_id,$attend_by,$status,$comment)
	{
	
		global $wpdb;
		$table_name = $wpdb->prefix . "attendence";
		$curr_date=date('Y-m-d',strtotime($curr_date));
		$check_insrt_or_update =$this->check_has_attendace($user_id,$class_id,$curr_date);
		
		if(empty($check_insrt_or_update))
		{
		$savedata =$wpdb->insert($table_name,array('attendence_date' =>$curr_date,
				'attend_by' =>$attend_by,
				'class_id' =>$class_id, 'user_id' =>$user_id,'status' =>$status,'role_name'=>'student','comment'=>$comment));
		}
		else 
		{
			$savedata =$wpdb->update($table_name,
					array('attend_by' =>$attend_by,'status' =>$status,'comment'=>$comment),
					array('attendence_date' =>$curr_date,'class_id' =>$class_id,'user_id' =>$user_id));
		}
	}
	public function insert_subject_wise_attendance($curr_date,$class_id,$user_id,$attend_by,$status,$sub_id,$comment)
	{
		
		global $wpdb;
		$table_name = $wpdb->prefix . "smgt_sub_attendance";
		$curr_date=date('Y-m-d',strtotime($curr_date));
		$check_insrt_or_update =$this->check_has_subject_attendace($user_id,$class_id,$curr_date,$sub_id);
		if(empty($check_insrt_or_update))
		{
		$savedata =$wpdb->insert($table_name,array('attendance_date' =>$curr_date,
				'attend_by' =>$attend_by,
				'class_id' =>$class_id,'sub_id'=>$sub_id, 'user_id' =>$user_id,'status' =>$status,'role_name'=>'student','comment'=>$comment));
		}
		else 
		{
			$savedata =$wpdb->update($table_name,
					array('attend_by' =>$attend_by,'status' =>$status,'comment'=>$comment),
					array('attendance_date' =>$curr_date,'class_id' =>$class_id,'sub_id'=>$sub_id,'user_id' =>$user_id,'sub_id'=>$sub_id));
		}
	}
	public function check_has_attendace($user_id,$class_id,$attendace_date)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "attendence";
		return $results=$wpdb->get_row("SELECT * FROM $table_name WHERE attendence_date='$attendace_date' and class_id=$class_id and user_id =".$user_id);
	}
	public function check_has_subject_attendace($user_id,$class_id,$attendace_date,$sub_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "smgt_sub_attendance";
		return $results=$wpdb->get_row("SELECT * FROM $table_name WHERE attendance_date='$attendace_date' and class_id=$class_id and sub_id=$sub_id and user_id =".$user_id);
	}
	public function insert_teacher_attendance($curr_date,$user_id,$attend_by,$status,$comment)
	{
		//$class_id=get_user_meta($user_id, 'class_name', true);
		$class_id=0;
		global $wpdb;
		$table_name = $wpdb->prefix . "attendence";
		$check_insrt_or_update =$this->check_has_attendace($user_id,$class_id,$curr_date);
	
		if(empty($check_insrt_or_update))
		{
			$savedata =$wpdb->insert($table_name,array('attendence_date' =>$curr_date,
					'attend_by' =>$attend_by,
					'class_id' =>$class_id, 'user_id' =>$user_id,'status' =>$status,'role_name'=>'teacher','comment'=>$comment));		
		}
		else
		{
			$savedata =$wpdb->update($table_name,
					array('attend_by' =>$attend_by,'status' =>$status,'comment'=>$comment),
					array('attendence_date' =>$curr_date,'class_id' =>$class_id,'user_id' =>$user_id));
		}
	}
	public function save_attendence($curr_date,$class_id,$attendence,$attend_by,$status)
	{
		
		global $wpdb;
		$role='student';
		$table_name = $wpdb->prefix . "attendence";
		
		$exlude_id = smgt_approve_student_list();
		$students = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		if($status=='Present')
			$new_status='Absent';
		else
			$new_status='Present';
		$record_status="";
		$check_today_attendence=$this->show_today_attendence($class_id,$role);
		$record_status="";
		//print_r($check_today_attendence);
		 $curr_date=date("Y-m-d");;
		foreach($check_today_attendence as $today_data)
		{
			/*echo "stored class_id".$today_data['class_id'];
			echo "new class_id".$class_id;
			echo "stored date".$today_data['attendence_date'];
			echo "current date=".$curr_date;*/
			if($today_data['class_id']==$class_id && $today_data['attendence_date']==$curr_date)
				$record_status="update";
			
				
				
		}
		if($record_status=="update")
		{
			//echo "in update";
			
			return $savedata=$this->update_attendence($students,$curr_date,$class_id,$attendence,$attend_by,$status,$table_name);
		}
		else
		{
			
			foreach($students as $stud)
			{
				if(in_array($stud->ID ,$attendence))
				{
					
					 $savedata=$wpdb->insert($table_name,array('attendence_date' =>$curr_date,'attend_by' =>$attend_by,'class_id' =>$class_id, 'user_id' =>$stud->ID,'status' =>$status,'role_name'=>$role));
				}
				else
				{
					 $savedata=$wpdb->insert($table_name,array('attendence_date' =>$curr_date,'attend_by' =>$attend_by,'class_id' =>$class_id, 'user_id' =>$stud->ID,'status' =>$new_status,'role_name'=>$role));
				}
			}
			if($savedata)
				return $savedata;
		}
		

			
	}
	public function update_attendence($students,$curr_date,$class_id,$attendence,$attend_by,$status,$table_name)
	{
		 global $wpdb;
		
		 if($status=='Present')
			$new_status='Absent';
		else
			$new_status='Present';
		 	foreach($students as $stud)
			{
				if(in_array($stud->ID ,$attendence))
				{
					
					
					 $result=$wpdb->update($table_name,array('attend_by' =>$attend_by,'status' =>$status),array('attendence_date' =>$curr_date,'class_id' =>$class_id,'user_id' =>$stud->ID));
				}
				else
				{
					  $result=$wpdb->update($table_name,array('attend_by' =>$attend_by,'status' =>$new_status),array('attendence_date' =>$curr_date,'class_id' =>$class_id,'user_id' =>$stud->ID));
				}
			}
	
		
			return $result;
	}
	
	
	public function save_teacher_attendence($curr_date,$attendence,$attend_by,$status)
	{
		
		
		$role='teacher';
		global $wpdb;
		$table_name = $wpdb->prefix . "attendence";
		//$students = get_users(array('meta_key' => 'wp_capabilities', 'meta_value' => $role));
		if($status=='Present')
			$new_status='Absent';
		else
			$new_status='Present';	
		$record_status="";
		$check_today_attendence=$this->show_today_teacher_attendence($role);
		$record_status="";
		
		 $curr_date=$curr_date;
		foreach($check_today_attendence as $today_data)
		{
			
			if($today_data['attendence_date']==$curr_date)
			{
					
				$record_status="update";
				
			}
				
				
		}
		if($record_status=="update")
		{
			//echo "in update";
			
			return $savedata=$this->update_teacher_attendence($curr_date,$attendence,$attend_by,$status,$table_name);
			
		}
		else
		{
			
			foreach(get_usersdata('teacher') as $stud)
			{
				
				//exit;
				if(in_array($stud->ID ,$attendence))
				{
					$class_id=get_user_meta($stud->ID, 'class_name', true);
					$result=$wpdb->insert($table_name,array('attendence_date' =>$curr_date,'attend_by' =>$attend_by, 'user_id' =>$stud->ID,'status' =>$status,'role_name'=>$role,'class_id'=>$class_id));
				}
				else
				{
					$result=$wpdb->insert($table_name,array('attendence_date' =>$curr_date,'attend_by' =>$attend_by, 'user_id' =>$stud->ID,'status' =>$new_status,'role_name'=>$role,'class_id'=>$class_id));
				}
			}
			return $result;
		}
		
	}

	public function update_teacher_attendence($curr_date,$attendence,$attend_by,$status,$table_name)
	{
		 global $wpdb;
		
		 if($status=='Present')
			$new_status='Absent';
		else
			$new_status='Present';
		 	foreach(get_usersdata('teacher') as $stud)
			{
				
				if(in_array($stud->ID ,$attendence))
				{
					
					$result=$wpdb->update($table_name,array('attend_by' =>$attend_by,'status' =>$status),array('attendence_date' =>$curr_date,'user_id' =>$stud->ID));
				}
				else
				{
					$result=$wpdb->update($table_name,array('attend_by' =>$attend_by,'status' =>$new_status),array('attendence_date' =>$curr_date,'user_id' =>$stud->ID));
				}
			}
			return $result;
		
	}
	public function show_today_attendence($class_id,$role)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "attendence";
		$curr_date=date("Y-m-d");
		return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE attendence_date='$curr_date' and class_id=$class_id and role_name='$role'",ARRAY_A);
		
		
	}
	public function show_today_teacher_attendence($role)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "attendence";
		$curr_date=date("Y-m-d");
		return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE attendence_date='$curr_date' and role_name='$role'",ARRAY_A);
		
		
	}
	public function get_attendence($userid,$class_id,$date)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "attendence";
		$curr_date=$date;
		$result=$wpdb->get_var("SELECT * FROM $table_name WHERE attendence_date='$curr_date' and class_id='$class_id' and user_id='$userid' and status='Present'");
		if($result)
		{	
			return $value='true';
		}
		else
		{ 
			return $value='false';
		}
		
	}
	public function get_all_attendence()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "attendence";
		
		$result=$wpdb->get_results("SELECT * FROM $table_name");
		
		return $result;		
	}
	public function check_attendence($userid,$class_id,$date)
	{
		global $wpdb;
		
		$table_name = $wpdb->prefix . "attendence";
		$curr_date=date('Y-m-d',strtotime($date));
		$result=$wpdb->get_row("SELECT * FROM $table_name WHERE attendence_date='$curr_date' and class_id='$class_id' and user_id=".$userid);
		return $result;
	
	}
	public function check_sub_attendence($userid,$class_id,$date,$sub_id)
	{
		
		global $wpdb;
		$table_name = $wpdb->prefix . "smgt_sub_attendance";
		
		$curr_date=date('Y-m-d',strtotime($date));
		$result=$wpdb->get_row("SELECT * FROM $table_name WHERE attendance_date='$curr_date' and class_id='$class_id' and sub_id='$sub_id' and user_id=".$userid);
		
		return $result;
	
	}
	public function get_teacher_attendence($userid,$date)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "attendence";
		$curr_date=$date;
		$result=$wpdb->get_var("SELECT * FROM $table_name WHERE attendence_date='$curr_date' and  user_id='$userid' and status='Present'");
		if($result)
		{	
			return $value='true';
		}
		else
		{
			return $value='false';
		}
		
	}
	public function today_presents()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "attendence";
		$curr_date=date("Y-m-d");
		return $result=$wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE attendence_date='$curr_date' and status='Present'");
		
	}
}
?>