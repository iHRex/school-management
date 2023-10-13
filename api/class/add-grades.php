<?php 
class AddGrades{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='add-grades')
			{					
				$response=$this->grade_insert($_REQUEST);	 
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
	public function grade_insert($data)
	{		
		$created_date = date("Y-m-d H:i:s");
		
		if($data['grade_name']!="" && $data['grade_point']!="" && $data['mark_from']!="" && $data['mark_upto']!=""){		
		$gradedata=array('grade_name'=>$data['grade_name'],	
		'grade_point'=>$data['grade_point'],
		'mark_from'=>$data['mark_from'],
		'mark_upto'=>$data['mark_upto'],
		'grade_comment'=>$data['grade_comment'],
		'creater_id'=>1,	
		'created_date'=>$created_date);	
		
		$response=array();
		global $wpdb;
		$table_name = $wpdb->prefix ."grade";
		$result=$wpdb->insert( $table_name, $gradedata);
		
		if($result!=0){
				$message['message']=__("Record successfully Inserted",'school-mgt');
				$response['status']=1;
				$response['resource']=$message;
			}
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