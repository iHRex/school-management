<?php 
class TeacherRoutine{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
			if($_REQUEST["smgt-json-api"]=='teachers-routin')
			{
				$response=$this->teacherRoutine();	 
				if(is_array($response)){
					echo json_encode($response);
				}
				else
				{
					header("HTTP/1.1 401 Unauthorized");
				}
				die();
			}
			if($_REQUEST["smgt-json-api"]=='single-teachers-routin')
			{
				$response=$this->singleteacherRoutine($_REQUEST);	 
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
	
	public function teacherRoutine()
	{
		$response=array();
		$i=0;
		$obj_route = new Class_routine ();
		$teacherdata=get_usersdata('teacher');
		if(!empty($teacherdata))
		{	
						
				foreach($teacherdata as $retrieved_data)
				{	
						
						$teacher_array=array('teacher_name'=>$retrieved_data->display_name);	
						foreach(sgmt_day_list() as $daykey => $dayname ) {
										
							$period = $obj_route->get_periad_by_teacher($retrieved_data->ID,$daykey);
								if (! empty ( $period )){
									//$periods[$dayname]=array();
									$periods=array();
									foreach ( $period as $period_data ) {
										
										$subject=get_single_subject_name ( $period_data->subject_id );
										$start_time=$period_data->start_time;
										$end_time=$period_data->end_time;
									
										$periods[]=array(
														'class'=>get_class_name($period_data->class_id),
														'section'=>smgt_get_section_name($period_data->section_name),
														'day'=>$dayname,
														'subject'=>$subject,
														'start_time'=>$start_time,
														'end_time'=>$end_time,
													);					
											}
										}
										else
										{
											$periods=array();					
										}
										$new_array[$dayname]=$periods;
					}
					$periods_array[]=array_merge($teacher_array,$new_array);
				}
				$response['status']=1;
				$response['resource']=$periods_array;
				return $response;					
		}
		
	}
	public function singleteacherRoutine($data)
	{
		$response=array();
		$i=0;
		$obj_route = new Class_routine ();
		
		if($data['teacher_id']!="" || $data['teacher_id']!=0)
		{	
			$school_obj = new School_Management($data['teacher_id']);
			if($school_obj->role=='teacher'){
				$retrieved_data=get_userdata($data['teacher_id']);		
				
						
						$teacher_array=array('teacher_name'=>$retrieved_data->display_name);	
						foreach(sgmt_day_list() as $daykey => $dayname ) {
										
							$period = $obj_route->get_periad_by_teacher($retrieved_data->ID,$daykey);
								if (! empty ( $period )){
									//$periods[$dayname]=array();
									$periods=array();
									foreach ( $period as $period_data ) {
										
										$subject=get_single_subject_name ( $period_data->subject_id );
										$start_time=$period_data->start_time;
										$end_time=$period_data->end_time;
									
										$periods[]=array(
														'class'=>get_class_name($period_data->class_id),
														'section'=>smgt_get_section_name($period_data->section_name),
														'day'=>$dayname,
														'subject'=>$subject,
														'start_time'=>$start_time,
														'end_time'=>$end_time,
													);					
											}
										}
										else
										{
											$periods=array();					
										}
										$new_array[$dayname]=$periods;
					}
				$periods_array=array_merge($teacher_array,$new_array);
				$response['status']=1;
				$response['resource']=$periods_array;
				return $response;	
			}
			else
			{
				$error['message']=__("Record empty",'school-mgt');
				$response['status']=0;
				$response['resource']=$error;
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