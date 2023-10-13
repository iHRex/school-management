<?php 
class ActivityStudentListing{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			
			//error_reporting(0);
			if($_REQUEST["smgt-json-api"]=='activity-student-listing')
			{
				if(isset($_REQUEST["current_user"]))
				{
					
					$response=$this->activity_student_listing($_REQUEST);	 
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
	public function activity_student_listing($data)
	{
		if($data['current_user']!=0){
			$school_obj = new School_Management($data['current_user']);
			$activity_obj = new SmgtActivity;
			$retrieve_class =$activity_obj->smgt_view_activity_students($data['activity_id']);
			
		}
	
		//var_dump($retrieve_class);
		
		$response=array();
		
		if(!empty($retrieve_class)){
			
			$i=0;
			$c=1;
				foreach ($retrieve_class as $retrieved_data){
						
					
						$classname=get_class_name($retrieved_data->class_id);
						$student = get_userdata($retrieved_data->student_id);
						
							
						
						if(isset($retrieved_data->section_id) && $retrieved_data->section_id!=0){
								$section=smgt_get_section_name($retrieved_data->section_id); 
						}
						else
						{
							$section=__('No Section','school-mgt');;
						}
						if($school_obj->role == "parent" && in_array($retrieved_data->student_id,$school_obj->child_list)){
							
						$result[$i]['child']=$c;
						$result[$i]['id']=$retrieved_data->id;
						$result[$i]['activity_id']=$data['activity_id'];
						$result[$i]['activity_title']=$retrieved_data->activity_title;
						$result[$i]['student_name']=$student->display_name;
						$result[$i]['class']=$classname;
						$result[$i]['section']=$section;
						$result[$i]['start_date']=$retrieved_data->start_date;
						$result[$i]['end_date']=$retrieved_data->end_date;
						$result[$i]['starting_time']=$retrieved_data->starting_time;
						$result[$i]['ending_time']=$retrieved_data->ending_time;
						$result[$i]['authorise_status']=$retrieved_data->authorize_status;
						$c++;
						}
						else
						{
							$result[$i]['id']=$retrieved_data->id;
							$result[$i]['activity_id']=$data['activity_id'];
							$result[$i]['activity_title']=$retrieved_data->activity_title;
							$result[$i]['student_name']=$student->display_name;
							$result[$i]['class']=$classname;
							$result[$i]['section']=$section;
							$result[$i]['start_date']=$retrieved_data->start_date;
							$result[$i]['end_date']=$retrieved_data->end_date;
							$result[$i]['starting_time']=$retrieved_data->starting_time;
							$result[$i]['ending_time']=$retrieved_data->ending_time;
							$result[$i]['authorise_status']=$retrieved_data->authorize_status;
						}
						$i++;
						
						
			}
			$response['status']=1;
			$response['resource']=$result;
			return $response;
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