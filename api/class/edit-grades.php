<?php 
class EditGrades{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='edit-grades')
			{					
				$response=$this->edit_grade($_REQUEST);	 
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
	public function edit_grade($data)
	{		
		$created_date = date("Y-m-d H:i:s");
		if($data['grade_id']!=0){
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
		$table_name = "grade";
		$grade_id=array('grade_id'=>$data['grade_id']);
		$result=update_record($table_name,$gradedata,$grade_id);
		
		if($result!=0){
				$message['message']=__("Record successfully Updated","school-mgt");
				$response['status']=1;
				$response['resource']=$message;
			}	
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