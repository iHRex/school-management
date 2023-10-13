<?php 
class HomeworkDelete{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);

			if($_REQUEST['smgt-json-api']=='delete-homework')
			{	
				if(isset($_REQUEST["current_user"]))
				{
					$school_obj = new School_Management($_REQUEST["current_user"]);
					if($school_obj->role=='teacher' || $school_obj->role=='admin'){
						$response=$this->homework_delete($_REQUEST);	 
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
	public function homework_delete($data)
	{		
		
		$response=array();
		
		$homework_obj = new Smgt_Homework;
		
		if($data['homework_id']!=0){
			$result=$homework_obj->smgt_delete_homework($data['homework_id']);
			if($result)
			{
				$message['message']=__("Records Deleted Successfully!","school-mgt");
				$response['status']=1;
				$response['resource']=$message;
				
			}
				
		}
		else
			{
				$message['message']=__("Please Fill All Fields","school-mgt");
				$response['status']=0;
				$response['error']=$message;
			}
		return $response;
	}
} ?>