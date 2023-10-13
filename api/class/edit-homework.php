<?php 
class EditHomework{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='edit-homework')
			{		
				if(isset($_REQUEST["homework_added_by"]))
				{
					$school_obj = new School_Management($_REQUEST["homework_added_by"]);
					if($school_obj->role=='teacher' || $school_obj->role=='admin'){
						$response=$this->edit_homework($_REQUEST);	 
					}
				}
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			
	}
	public function edit_homework($data)
	{		
		$homework_obj = new Smgt_Homework;
		$selected_students = $homework_obj->smgt_get_assigned_students_by_homework($data['homework_id']);
		foreach($selected_students as $student){
			$old_students[]=$student['student_id'];
		}
		$created_date = date("Y-m-d H:i:s");
		if($data['homework_title']!="" && $data['description']!="" && $data['homework_date']!="" && $data['homework_added_by']!=""){		
		$homeworkdata=array(
		//'class_id'=>$data['class_id'],	
		//'section_id'=>$data['section_id'],
		//'subject_id'=>$data['subject_id'],
		'homework_title'=>$data['homework_title'],
		'description'=>$data['description'],
		'to_date'=>date('Y-m-d',strtotime($data['homework_date'])),
		'created_by'=>$data['homework_added_by'],	
		'created_date'=>$created_date);	
		
		$response=array();
		global $wpdb;
		$table_name = $wpdb->prefix ."smgt_homework";
			$table1 = $wpdb->prefix."smgt_homework_assigned";
		$whereid['homework_id']=$data['homework_id'];
		$homework_id =$data['homework_id'];
		$result=$wpdb->update( $table_name, $homeworkdata,$whereid);
		/*if($data['student_ids']=='ALL'){
			$flag=1;
			if(isset($data['section_id']) && $data['section_id']!=""){
						$class_id =$data['class_id'];
						$class_section =$data['section_id'];
						 $student_list = get_users(array('meta_key' => 'class_section', 'meta_value' =>$class_section,'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student'));	
					}
					elseif(isset($data['class_id'])){
						
						$class_id =$data['class_id'];
						 $student_list = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student'));	
				   }
				foreach($student_list as $stud)
				{
					$new_students[]=$stud->ID;
				}
				
		}
		else
		{
			$new_students=explode(',',$data['student_ids']);
		}
		
		
		$different_insert = array_diff($new_students,$old_students);
		$different_delete = array_diff($old_students,$new_students);
		
		foreach($different_insert as $stu_id)
		{	
			$args1 = array(
						"homework_id" => $homework_id,
						"class_id" => $data['class_id'],
						"section_id" =>$data['section_id'],		
						"student_id" => $stu_id,
						"subject_id" =>$data['subject_id'],
						"status" => 1,					
						"created_by" =>$data['homework_added_by'],
						"created_date" => date('Y-m-d h:i:s')
						);			
				
				$chk = $wpdb->insert($table1,$args1);	
		}
		foreach($different_delete as $stu_id)
		{
			$chk = $wpdb->delete($table1,array("homework_id"=>$homework_id, "student_id"=>$stu_id));
		}*/
		if($result!=0){
				$message['message']=__("Record successfully Updated",'school-mgt');
				$response['status']=1;
				$response['resource']=$message;
			}	
		}
		else
		{
			$error['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$error;
		} 
		return $response;
		
	}
} ?>