<?php 
class EditActivity{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='edit-activity')
			{

				if(isset($_REQUEST["activity_added_by"]))
				{
					$school_obj = new School_Management($_REQUEST["activity_added_by"]);
					if($school_obj->role=='teacher' || $school_obj->role=='admin'){
					$response=$this->activity_edit($_REQUEST);	
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
	public function activity_edit($data)
	{	
		//var_dump($data);
		//exit;
		$created_date = date("Y-m-d H:i:s");
		
		if($data['activity_title']!="" && $data['start_date']!="" && $data['end_date']!="" && $data['activity_description']!=""){	
				global $wpdb;
				$table_name=$wpdb->prefix.'smgt_activity';
				$activitydata['activity_title']=$data['activity_title'];
				$activitydata['start_date']=$data['start_date'];
				$activitydata['end_date']=$data['end_date'];
				if(isset($data['start_time']) && $data['start_time']!="")
				  $activitydata['starting_time']=$data['start_time'];
				if(isset($data['end_time']) && $data['end_time']!="")
				  $activitydata['ending_time']=$data['end_time'];
				$activitydata['activity_description']=$data['activity_description'];
				$activitydata['activity_type']=$data['activity_type'];
				if(isset($data['activity_fee']))
					$activitydata['activity_fees']=$data['activity_fee'];
				else
					$activitydata['activity_fees']=0;
				$activitydata['created_by']=$data['activity_added_by'];
				$whereid['id']=$data['activity_id'];
				
					$result=$wpdb->update( $table_name, $activitydata ,$whereid);	
		
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
} ?>