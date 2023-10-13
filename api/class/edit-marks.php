<?php 
class EditMarks{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='edit-marks')
			{	
				$school_obj = new School_Management($_REQUEST['student_id']);
				if($school_obj->role=='student'){
					$response=$this->marks_edit($_REQUEST);	 
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
	public function marks_edit($data)
	{		
		$created_date = date("Y-m-d H:i:s");
		
		if($data['exam_id']!="" && $data['class_id']!="" && $data['student_id']!="" && $data['subject_id']!="" && $data['marks']!=""  && $data['marks_id']!=""){		
		$marksdata=array('exam_id'=>$data['exam_id'],	
		'class_id'=>$data['class_id'],
		'section_id'=>$data['section_id'],
		'student_id'=>$data['student_id'],
		'subject_id'=>$data['subject_id'],
		'marks'=>$data['marks'],
		'marks_comment'=>$data['marks_comment'],
		'created_by'=>$data['current_user_id'],	
		'modified_date'=>$created_date);	
		
		$response=array();
		global $wpdb;
		$table_name =$wpdb->prefix . "marks";
		$whereid['mark_id']=$data['marks_id'];
		$result=$wpdb->update( $table_name, $marksdata,$whereid);
		
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
}  ?>