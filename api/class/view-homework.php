<?php 
class HomeworkView{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			
			//error_reporting(0);
			
			if($_REQUEST["smgt-json-api"]=='view-homework')
			{
				
				if(isset($_REQUEST["homework_id"]))
				{
					$response=$this->view_homework($_REQUEST["homework_id"]);	 
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
	public function view_homework($homework_id)
	{
		
		if($homework_id!=0){
			$homework_obj = new Smgt_Homework;
			$homework = $homework_obj->get_homework_by_id($homework_id); 
		}
		
		if(!empty($homework)){
			
			
					
						$classname=get_class_name($homework['class_id']);
						$subjectname=get_single_subject_name($homework['subject_id']);
						
						if(isset($homework['section_id']) && $homework['section_id']!=0){
								$section=smgt_get_section_name($homework['section_id']); 
						}
						else
						{
							$section=__('No Section','school-mgt');;
						}
						
						$result['homework_id']=$homework['homework_id'];
						$result['homework_title']=$homework['homework_title'];
						$result['class']=$classname;
						$result['section']=$section;
						$result['subject_name']=$subjectname;
						$result['description']=$homework['description'];
						$result['to_date']=$homework['to_date'];
						
		
			$response['status']=1;
			$response['resource']=$result;
			//return $response;
		}
		else
		{
			$error['message']=__("Records Not Found",'school-mgt');
			$response['status']=0;
			$response['error']=$error;
			
		}
		return $response;
	}
} ?>