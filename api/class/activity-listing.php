<?php 
class ActivityListing{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			
			//error_reporting(0);
			
			if($_REQUEST["smgt-json-api"]=='activity-listing')
			{
				
				if(isset($_REQUEST["current_user"]))
				{
					
					$response=$this->activity_listing($_REQUEST["current_user"]);	 
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
	public function activity_listing($userid=0)
	{
		
		if($userid!=0){
			$school_obj = new School_Management($userid);
			$activity_obj = new SmgtActivity;
			
			if($school_obj->role=='student' ){
				$retrieve_class =$activity_obj->smgt_get_student_activities($userid);
			}
			if($school_obj->role=='admin' || $school_obj->role=='teacher' || $school_obj->role=='parent'){
				$retrieve_class = $activity_obj->get_all_activities();
			}
		}
	
		//var_dump($retrieve_class);
		
		$response=array();
		
		if(!empty($retrieve_class)){
			
			$i=0;
				foreach ($retrieve_class as $retrieved_data){
						
					
						$classname=get_class_name($retrieved_data->class_id);
						
						if(isset($retrieved_data->section_id) && $retrieved_data->section_id!=0){
								$section=smgt_get_section_name($retrieved_data->section_id); 
						}
						else
						{
							$section=__('No Section','school-mgt');;
						}
						
						$result[$i]['activity_id']=$retrieved_data->id;
						$result[$i]['activity_title']=$retrieved_data->activity_title;
						$result[$i]['class']=$classname;
						$result[$i]['section']=$section;
						$result[$i]['start_date']=$retrieved_data->start_date;
						$result[$i]['end_date']=$retrieved_data->end_date;
						$result[$i]['starting_time']=$retrieved_data->starting_time;
						$result[$i]['ending_time']=$retrieved_data->ending_time;
						$result[$i]['activity_type']=$retrieved_data->activity_type;
						$result[$i]['fee_amount']=$retrieved_data->activity_fees;
						$result[$i]['description']=$retrieved_data->activity_description;
						
						$i++;
			}
			$response['status']=1;
			$response['resource']=$result;
			
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