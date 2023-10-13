<?php 
class AddMarks{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='add-marks')
			{	
				$school_obj = new School_Management($_REQUEST['student_id']);
				if($school_obj->role=='student'){
					$response=$this->marks_insert($_REQUEST);	
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
	public function marks_insert($data)
	{		
		$created_date = date("Y-m-d H:i:s");
		
		if($data['exam_id']!="" && $data['class_id']!="" && $data['student_id']!="" && $data['subject_id']!="" && $data['marks']!=""  ){		
		$marksdata=array('exam_id'=>$data['exam_id'],	
		'class_id'=>$data['class_id'],
		'section_id'=>$data['section_id'],
		'student_id'=>$data['student_id'],
		'subject_id'=>$data['subject_id'],
		'marks'=>$data['marks'],
		'marks_comment'=>$data['marks_comment'],
		'created_by'=>$data['current_user_id'],	
		'created_date'=>$created_date);	
		
		$response=array();
		global $wpdb;
		$table_name =$wpdb->prefix . "marks";
		$result=$wpdb->insert( $table_name, $marksdata);
		
		if($result!=0){
				
				$message['message']=__("Record successfully Inserted",'school-mgt');
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
}  ?>