<?php 
class ActivityStudentAuthorise{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			
			//error_reporting(0);
			if($_REQUEST["smgt-json-api"]=='activity-student-authorise')
			{
				if(isset($_REQUEST["current_user"]))
				{
					
					$response=$this->activity_student_authorise($_REQUEST);	 
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
	public function activity_student_authorise($data)
	{
		if($data['current_user']!=0){
			$school_obj = new School_Management($data['current_user']);
			$activity_obj = new SmgtActivity;
			if($school_obj->role=='admin' || $school_obj->role=='parent'){
			$retrieved_data =$activity_obj->smgt_view_single_student_activity($data['id']);
			}
			
		}
		
		//var_dump($retrieve_class);
		
		$response=array();
		
		if(!empty($retrieved_data)){
			
			$i=0;
						$classname=get_class_name($retrieved_data->class_id);
						$student = get_userdata($retrieved_data->student_id);
						if(isset($retrieved_data->section_id) && $retrieved_data->section_id!=0){
								$section=smgt_get_section_name($retrieved_data->section_id); 
						}
						else
						{
							$section=__('No Section','school-mgt');;
						}
			if($school_obj->role == "admin" && $retrieved_data->authorize_status=='pending'){
				
				if($data['status']==1){
					$res=$activity_obj->smgt_allow_activity($data['id']);
				}
				if($data['status']==0){
					$res=$activity_obj->smgt_reject_activity($data['id']);
				}
					if($res){
						$retrieved_data =$activity_obj->smgt_view_single_student_activity($data['id']);
						$result['id']=$retrieved_data->id;
						$result['activity_id']=$retrieved_data->activity_id;
						$result['activity_title']=$retrieved_data->activity_title;
						$result['student_name']=$student->display_name;
						$result['class']=$classname;
						$result['section']=$section;
						$result['start_date']=$retrieved_data->start_date;
						$result['end_date']=$retrieved_data->end_date;
						$result['starting_time']=$retrieved_data->starting_time;
						$result['ending_time']=$retrieved_data->ending_time;
						$result['authorise_status']=$retrieved_data->authorize_status;
					}
					$response['status']=1;	
					$response['resource']=$result;
					//return $response;
			}
			
			if($school_obj->role == "parent" && in_array($retrieved_data->student_id,$school_obj->child_list) && $retrieved_data->authorize_status=='pending'){
					
					if($data['status']==1){
						$res=$activity_obj->smgt_allow_activity($data['id']);
					}
					if($data['status']==0){
						$res=$activity_obj->smgt_reject_activity($data['id']);
					}
					if($res){
						$retrieved_data =$activity_obj->smgt_view_single_student_activity($data['id']);
						
						$result['id']=$retrieved_data->id;
						$result['activity_id']=$retrieved_data->activity_id;
						$result['activity_title']=$retrieved_data->activity_title;
						$result['student_name']=$student->display_name;
						$result['class']=$classname;
						$result['section']=$section;
						$result['start_date']=$retrieved_data->start_date;
						$result['end_date']=$retrieved_data->end_date;
						$result['starting_time']=$retrieved_data->starting_time;
						$result['ending_time']=$retrieved_data->ending_time;
						$result['authorise_status']=$retrieved_data->authorize_status;
					}
					$response['status']=1;
					$response['resource']=$result;
					//return $response;
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