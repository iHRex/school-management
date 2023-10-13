<?php 
class HomeworkSubmissionListing{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			
			//error_reporting(0);
			
			if($_REQUEST["smgt-json-api"]=='homework-submission-listing')
			{
				
				if(isset($_REQUEST["homework_id"]))
				{
					$response=$this->homework_submission_listing($_REQUEST["homework_id"]);	 
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
	public function homework_submission_listing($homework_id)
	{
		
			if($homework_id!=0){
				$homework_obj = new Smgt_Homework;
				$homework_data = $homework_obj->get_homework_by_id($homework_id);
				$assigned_data = $homework_obj->smgt_view_submissions($homework_id,$homework_data['subject_id']);
			}
		$response=array();
		
		if(!empty($assigned_data)){
			
			$i=0;
				foreach ($assigned_data as $retrieved_data){
						
					
						$classname=get_class_name($retrieved_data['class_id']);
						$subjectname=get_single_subject_name($retrieved_data['subject_id']);
						$student = get_userdata($retrieved_data['student_id']);
						$status = ($retrieved_data['submitted'] == 0)?'Pending':'Submited';
						$submited_date = ($homework['submitted'] == 1)?$homework['submission_date']:'None';
						
						$fileurl="";
						if($retrieved_data['file']!=""){
							$filepath=explode('wp-content',$retrieved_data['file']);
							$fileurl=get_site_url()."/wp-content".$filepath[1];
						}
						if(isset($retrieved_data['section_id']) && $retrieved_data['section_id']!=0){
								$section=smgt_get_section_name($retrieved_data['section_id']); 
						}
						else
						{
							$section=__('No Section','school-mgt');;
						}
						
						$result[$i]['homework_assigned_id']=$retrieved_data['assigned_id'];
						$result[$i]['homework_id']=$retrieved_data['homework_id'];
						$result[$i]['homework_title']=$retrieved_data['homework_title'];
						$result[$i]['class']=$classname;
						$result[$i]['section']=$section;
						$result[$i]['subject_name']=$subjectname;
						$result[$i]['student']=$student->display_name;
						$result[$i]['status']=$status;
						$result[$i]['submited_date']=$submited_date;
						$result[$i]['to_date']=$retrieved_data['to_date'];
						$result[$i]['fileurl']=$fileurl;
						$i++;
			}
			$response['status']=1;
			$response['resource']=$result;
			
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