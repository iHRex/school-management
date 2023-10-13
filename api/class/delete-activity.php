<?php 
class ActivityDelete{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			
			//error_reporting(0);
			if($_REQUEST["smgt-json-api"]=='delete-activity')
			{
				if(isset($_REQUEST["activity_delete_by"]))
				{
					$school_obj = new School_Management($_REQUEST["activity_delete_by"]);
					if($school_obj->role=='teacher' || $school_obj->role=='admin'){
						$response=$this->activity_delete($_REQUEST);	 
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
	public function activity_delete($data)
	{
		
			$activity_obj = new SmgtActivity;
			$result=$activity_obj->smgt_delete_activity($data['activity_id']);
			if($result)
			{
				$message['message']=__("Records Deleted Successfully!","school-mgt");
				$response['status']=1;
				$response['resource']=$message;
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