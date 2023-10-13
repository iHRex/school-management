<?php 
class AddSubject{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='add-subject')
			{
				$school_obj = new School_Management($_REQUEST['current_user']);
				if($school_obj->role=='admin'){
					$response=$this->subject_insert($_REQUEST);	
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
			if($_REQUEST['smgt-json-api']=='edit-subject')
			{
				$response=$this->edit_subject($_REQUEST);	
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST['smgt-json-api']=='delete-subject')
			{
				$school_obj = new School_Management($_REQUEST['current_user']);
				if($school_obj->role=='admin'){
					$response=$this->api_delete_subject($_REQUEST);	 
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
	public function subject_insert($data)
	{	
		
		if($data['class_id']!="" && $data['subject_title']!="" && $data['teacher_id']!=""){		
		$subjectdata=array('sub_name'=>$data['subject_title'],	
		'class_id'=>$data['class_id'],
		'section_id'=>$data['section_id'],
		'teacher_id'=>$data['teacher_id'],
		'edition'=>$data['subject_edition'],
		'author_name'=>$data['author_name']);	
		
		$response=array();
		global $wpdb;
		$table_name = $wpdb->prefix ."subject";
		$result=$wpdb->insert( $table_name, $subjectdata);
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
	public function edit_subject($data)
	{	
		
		if($data['class_id']!="" && $data['subject_title']!="" && $data['teacher_id']!=""){		
		$subjectdata=array('sub_name'=>$data['subject_title'],	
		'class_id'=>$data['class_id'],
		'section_id'=>$data['section_id'],
		'teacher_id'=>$data['teacher_id'],
		'edition'=>$data['subject_edition'],
		'author_name'=>$data['author_name']);	
		
		$response=array();
		global $wpdb;
		$table_name = $wpdb->prefix ."subject";
		$whereid['subid']=$data['subject_id'];
		$result=$wpdb->update( $table_name, $subjectdata,$whereid);
		if($result!=0){
				$message['message']=__("Record successfully Updated",'school-mgt');
				$response['status']=1;
				$response['resource']=$message;
			}	
		}
		else
		{
			$message['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$message;
		}
		return $response;
	}
	function api_delete_subject($data)
	{		
		$response=array();
		global $wpdb;
		$table_name=$wpdb->prefix.'subject';
		if($data['subject_id']!=0){
			$result = $wpdb->query("DELETE FROM $table_name where subid= ".$data['subject_id']);
			if($result)
			{
				$message['message']=__("Records Deleted Successfully!",'school-mgt');
				$response['status']=1;
				$response['resource']=$message;
			}
			else
			{
				$message['message']=__("Records Not Delete","school-mgt");
				$response['status']=0;
				$response['resource']=$message;
			}
			return $response;
		}
		else
		{
			$message['message']=__("Please Fill All Fields",'school-mgt');
			$response['status']=0;
			$response['resource']=$message;
		}
			return $response;
	}
} ?>