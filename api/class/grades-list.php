<?php 
class GradesList{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='grades-list')
			{					
				$response=$this->grade_list($_REQUEST);	
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
	public function grade_list($data)
	{		
		$created_date = date("Y-m-d H:i:s");
		
		
		
		$response=array();
		global $wpdb;
		$table_name = "grade";
		$retrieve_class = get_all_data($table_name);
		if(!empty($retrieve_class)){
			foreach($retrieve_class as $retrieved_data){ 
				$grades[]=array('grade_name'=>$retrieved_data->grade_name,
								'grade_point'=>$retrieved_data->grade_point,
								'mark_from'=>$retrieved_data->mark_from,
								'mark_upto'=>$retrieved_data->mark_upto,
								'grade_comment'=>$retrieved_data->grade_comment);		
			}
			$response['status']=1;
			$response['resource']=$grades;
			return $response;
		}
		else
		{
			$message['message']=__("Please Fill All Fields","school-mgt");
			$response['status']=0;
			$response['error']=$message;
			return $response;
		}
		
	
	}
} ?>