<?php 
class ExamList{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		if($_REQUEST["smgt-json-api"]=='examlist')
		{			
			if(isset($_REQUEST['current_user']))
			{				
				$response=$this->examlist($_REQUEST);	 
			}
							
			
			if(is_array($response))
			{
				echo json_encode($response);
			}
			else
			{
				header("HTTP/1.1 401 Unauthorized");
			}
			die();
		}
			
	}
	public function examlist($data)
	{
		
		global $wpdb;
		$tablename="exam";
		$response	=	array();
		$role= smgt_get_user_role($data["current_user"]);
		$menu_access_data=smgt_get_userrole_wise_access_right_array_in_api($data['current_user'],'exam');
		
		if($role=='student'){			
			if($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 1 )
			{
				$class_id 	= 	get_user_meta($data['current_user'],'class_name',true);			
				$section_id 	= 	get_user_meta($data['current_user'],'class_section',true);	
				
				if(isset($class_id) && $section_id =='')
				{
					$all_exam	= get_all_exam_by_class_id($class_id);
				}
				else
				{
					$all_exam	= get_all_exam_by_class_id_and_section_id_array($class_id,$section_id);
				}
			}
			elseif($menu_access_data['view'] == '1' && $menu_access_data['own_data'] == 0 )
			{
				$all_exam	= get_all_data($tablename);		
			}
			else
			{
				$all_exam="";
			}
		}
		if($role=='student')
		{				
			if(!empty($all_exam))
			{				
				foreach ($all_exam as $exam)
				{					
					$exam_id =$exam->exam_id;
					$exam_array	=	array(
						'exam_id'	=>$exam->exam_id,
						'exam_name'	=>$exam->exam_name,
						'exam_start_date'=>smgt_getdate_in_input_box($exam->exam_start_date),
						'exam_end_date'=>smgt_getdate_in_input_box($exam->exam_end_date),
						'exam_comment'=>$exam->exam_comment,
					);
					$result_array[]	=	$exam_array;		
				}
				$response['status']	=	1;								$response['date_formate']	= get_option('smgt_datepicker_format');
				$response['resource']	=	$result_array;
			}
			else
			{
				//$error['message']=__("Please Fill All Fields",'school-mgt');
				$response['status']	=	0;
				$response['message']	=__("Please Fill All Fields",'school-mgt');
			}
			
		}
		else
		{
			//$error['message']=__("No Record Found",'school-mgt');
			$response['status']=0;
			$response['message']=__("No Record Found",'school-mgt');
		}
		return $response;	
	}
} ?>