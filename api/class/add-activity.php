<?php 
class AddActivity{
	public function __construct() {
		add_action('template_redirect', array($this,'redirectMethod'), 1);
		
	}
	public function redirectMethod()
	{
		
		//error_reporting(0);
			if($_REQUEST['smgt-json-api']=='add-activity')
			{

				if(isset($_REQUEST["activity_added_by"]))
				{
					$school_obj = new School_Management($_REQUEST["activity_added_by"]);
					if($school_obj->role=='teacher' || $school_obj->role=='admin'){
					$response=$this->activity_insert($_REQUEST);	
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
	public function activity_insert($data)
	{	
		//var_dump($data);
		//exit;
		$created_date = date("Y-m-d H:i:s");
		
		if($data['class_id']!="" && $data['activity_title']!="" && $data['start_date']!="" && $data['end_date']!="" && $data['activity_description']!=""){		
				global $wpdb;
				$table_name=$wpdb->prefix.'smgt_activity';
				$table_activity_student=$wpdb->prefix.'smgt_activity_student';
				$activitydata['activity_title']=$data['activity_title'];
				if(isset($data['class_id']))
				$activitydata['class_id']=$data['class_id'];
				if(isset($data['class_section']))
				$activitydata['section_id']=$data['class_section'];
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
				
						$result=$wpdb->insert( $table_name,$activitydata);
						$activityid=$wpdb->insert_id;
							$class_section=0;
							$class_id=$data['class_id'];
							
							if(isset($data['class_section']) && $data['class_section'] !=0){
								$class_section=$data['class_section'];
								
								$exlude_id = smgt_approve_student_list();
								$studentsdata = get_users(array('meta_key' => 'class_section', 'meta_value' =>$class_section,
								 'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student','exclude'=>$exlude_id));	
								
							}
							else
							{ 
							  $exlude_id = smgt_approve_student_list();
							  $studentsdata = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
							} 
							
							foreach($studentsdata as $student){
								
								$studentactivity['activity_id']=$activityid;
								$studentactivity['student_id']=$student->ID;
								$studentactivity['authorize_status']='pending';
								$result=$wpdb->insert( $table_activity_student,$studentactivity);
							}
		
		if($result!=0){
			
				$message['message']=__("Record successfully Inserted",'school-mgt');
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