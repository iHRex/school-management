<?php 
class GradesDelete{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='delete-grade')
			{	
				
				$response=$this->grade_delete($_REQUEST);	 
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
	public function grade_delete($data)
	{		
		
		$response=array();
		global $wpdb;
		$table_name = "grade";
		if($data['grade_id']!=0){
			$result=delete_grade($table_name,$data['grade_id']);
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